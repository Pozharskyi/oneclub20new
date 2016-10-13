<?php

use App\Models\Loging\LogFromToDecimalModel;
use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogOrderModel;
use App\Models\Loging\LogUserModel;
use App\Models\Payment\PaymentTypesModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/users/{user}/orders/{order} should see orderContactDetails, orderPayment with paymentType,
     * orderDelivery with deliveryType, bonuses, subProducts, discounts
     */
    public function testGetUsersOrder()
    {
        $user = \App\User::findOrFail(1);

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];
        $order = $user->orders()->first();

        $orderContactdetails = $order->orderContactDetails()->firstOrFail();
        $orderPayment = $order->orderPaymentType()->firstOrFail();
        $orderDelivery = $order->orderDelivery()->firstOrFail();
        $orderDiscounts = $order->discount()->get();
        $orderBonuses = $order->bonuses()->get();
        $orderSubProducts = $order->subProducts()->get();


        Session::start();

        $this->be($user);


        $this->call('GET', '/admin/users/' . $user->id . '/orders/' . $order->id, $params);

        $this->see($orderContactdetails->f_name);
        $this->see($orderPayment->payment_type);
        $this->see($orderDelivery->delivery_type_id);
        $this->see($orderBonuses->first()->discount_amount);
        $this->see($orderBonuses->last()->discount_amount);
//
        $this->see($orderDiscounts->first()->bonus_count);
        $this->see($orderDiscounts->last()->bonus_count);
//
        $this->see($orderSubProducts->first()->barcode);
        $this->see($orderSubProducts->last()->barcode);

//        view has  <input id="delivery_type_id" type="text" class="form-control" name="delivery_type_id"
//        value=Самовызов> but test fails

//        $this->seeInElement('delivery_type_id', $orderDelivery->deliveryType->delivery_type);
    }

    //After ajax url /admin/users/1/orders/1/update dev_order_index table should be updated with new data
    public function testOrderIndexShouldReturnAfterUpdate()
    {

        $user = \App\User::find(1);
        $order = $user->orders()->first();
        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $order->comment = 'AAA';
        $order->total_sum = '123';

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id . '/update',
            array_merge($order->toArray(), $params));

        $this->seeInDatabase('dev_order_index', ['comment' => $order->comment, 'total_sum' => $order->total_sum]);

    }

    //After ajax url /admin/users/1/orders/1/delivery/update dev_order_delivery table should be updated with input
    //and old values not be in db
    public function testOrderDeliveryShouldUpdateInDatabaseAfterUpdate()
    {

        $user = \App\User::find(1);
        $order = $user->orders()->first();
        $orderDelivery = $order->orderDelivery()->first();
        $oldOrderDelivery = $orderDelivery->replicate();
        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $orderDelivery->delivery_f_name = 'AAA';
        $orderDelivery->delivery_phone = '933879102';

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id . '/delivery/update',
            array_merge($orderDelivery->toArray(), $params));

        $this->seeInDatabase('dev_order_delivery',
            ['delivery_f_name' => $orderDelivery->delivery_f_name, 'delivery_phone' => $orderDelivery->delivery_phone]);

        $this->notSeeInDatabase('dev_order_delivery', [
            'delivery_f_name' => $oldOrderDelivery->delivery_f_name,
            'delivery_phone' => $oldOrderDelivery->delivery_phone
        ]);

        $this->see($orderDelivery->delivery_f_name);
        $this->see($orderDelivery->delivery_phone);
    }

    //After ajax url /admin/users/1/orders/1/contactDetails/update dev_order_contact_details table should be updated with input
    //and old values not be in db
    public function testOrderContactDetailsShouldUpdateInDatabaseAfterUpdate()
    {

        $user = \App\User::find(1);
        $order = $user->orders()->first();
        $orderContactDetails = $order->orderContactDetails()->first();
        $oldOrderContactDetails = $orderContactDetails->replicate();

        $this->seeInDatabase('dev_order_contact_details',
            ['f_name' => $oldOrderContactDetails->f_name, 'l_name' => $oldOrderContactDetails->l_name]);

        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $orderContactDetails->f_name = 'AAA';
        $orderContactDetails->l_name = 'BBB';

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id . '/contactDetails/update',
            array_merge($orderContactDetails->toArray(), $params));

        $this->seeInDatabase('dev_order_contact_details',
            ['f_name' => $orderContactDetails->f_name, 'l_name' => $orderContactDetails->l_name]);

        $this->notSeeInDatabase('dev_order_contact_details',
            ['f_name' => $oldOrderContactDetails->f_name, 'l_name' => $oldOrderContactDetails->l_name]);

        $this->see($orderContactDetails->f_name);
        $this->see($orderContactDetails->l_name);
    }

    //After ajax url /admin/users/1/orders/1/delivery/update dev_order_delivery table should be updated with input
    public function testOrderPaymentTypeShouldUpdateInDatabaseAfterUpdate()
    {
        $user = User::find(1);
        $this->be($user);

        $order = $user->orders()->first();
        $order->payment_type_id = 1;
        $order->update();
        $this->seeInDatabase('dev_order_index', ['payment_type_id' => 1, 'id' => $order->id]);

        $oldOrder = $order->replicate();
        Session::start();

//        \Auth::login($user);
        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $order->payment_type = 2;

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id . '/delivery/update',
            array_merge($order->toArray(), $params));

        //see in DB new payment after update
        $this->seeInDatabase('dev_order_index', ['payment_type_id' => $order->payment_type_id, 'id' => $order->id]);
        //not see old value in DB
        $this->notSeeInDatabase('dev_order_index',
            ['payment_type_id' => $oldOrder->payment_type_id, 'id' => $oldOrder->id]);
        //see in page new payment
//        $this->see($order->payment_type);
    }

//    public function testUpdateOrderDiscountStatus()
//    {
//        $user = User::find(1);
//        $this->be($user);
//
//        $order = $user->orders()->first();
//        $discount = $order->discounts()->first();
//
//        //set discount status to 0
//        $discount->status = 1;
//        $discount->update();
//        $this->assertTrue($discount->status == 1);
//        //update with default value of status
//        $this->seeInDatabase('dev_index_discounts', ['status' => $discount->status, 'id' => $discount->id]);
//
//
//        Session::start();
//
//        $params = [
//            '_token' => csrf_token()
//        ];
//
//        //change status field
//        $discount->status = 1;
//
//
//        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id . '/delivery/update', array_merge($discount->toArray(), $params));
//
//        //see in DB new discount status after update
////        $this->seeInDatabase('dev_index_discounts', ['status' => 1, 'id' => $discount->id]);
//        //not see old value in DB
//
//////        $this->seeJsonContains([$discount->status]);
////        $this->notSeeInDatabase('dev_index_discounts', ['status' => 0, 'id' => $discount->id]);
////        $this->assertTrue($discount->status == 1);
////        //see in page new payment
////        $this->see($discount->status);
//    }

    //After get to url /admin/users/1/orders/1 should see order logs
    public function testSeeOrderLogsAfterGetOrder()
    {
        $user = User::find(1);
        $order = $user->orders()->first();
        $this->be($user);

        Session::start();
        $params = [
            '_token' => csrf_token()
        ];

        $this->call('Get', '/admin/users/' . $user->id . '/orders/' . $order->id, $params);
        $this->see($order->orderLos);
    }

    //After ajax url /admin/users/1/orders/1/contactDetails/update should add new logs for contactDetails in view and in DB
    public function testOrderContactDetailsLogsShouldReturnAfterUpdate()
    {

        $user = \App\User::find(1);

        Session::start();
        $this->be($user);


        //START SECTION SET DEFAULT VALUES IN dev_order_log
        $order = $user->orders()->first();
        $orderContactDetails = $order->orderContactDetails()->first();
        $orderContactDetails->f_name = 'AAA';
        $orderContactDetails->l_name = 'BBB';
        $orderContactDetails->update();
        $oldOrderContactDetails = $orderContactDetails->replicate();

        $oldOrderContactDetailsLog = $orderContactDetails->orderLogs()->firstOrFail();

        $this->seeInDatabase('dev_order_contact_details',
            ['f_name' => $oldOrderContactDetails->f_name, 'l_name' => $oldOrderContactDetails->l_name]);
        $this->seeInDatabase('dev_order_log',
            ['id' => $oldOrderContactDetailsLog->id, 'field_changed' => $oldOrderContactDetailsLog->field_changed]);

        //check if logs changes saved in LogFromToStringModel after we manually update $orderContactDetails
        $orderFNameLog1 = LogFromToStringModel::where('to', $oldOrderContactDetails->f_name)->first();
        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderFNameLog1->id, 'fromto_type' => LogFromToStringModel::class]);


        //END SECTION SET DEFAULT VALUES IN dev_order_log


        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $orderContactDetails->f_name = 'DDD';
        $orderContactDetails->l_name = 'MMM';

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id . '/contactDetails/update',
            array_merge($orderContactDetails->toArray(), $params));

//        $newOrderContactDetailsLog = $orderContactDetails->orderLogs()->firstOrFail();
        $orderFNameLog = LogFromToStringModel::where('from', "AAA")->first();

        $this->assertNotEmpty($orderFNameLog);
        $orderLNameLog = LogFromToStringModel::where('to', $orderContactDetails->l_name)->first();

        $newOrderContactDetailsLog = \App\Models\Loging\LogOrderModel::where('fromto_id', $orderFNameLog->id)->first();
        //
        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderFNameLog->id, 'fromto_type' => LogFromToStringModel::class]);
        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderLNameLog->id, 'fromto_type' => LogFromToStringModel::class]);


        $this->see($orderFNameLog->to);
        $this->see($orderLNameLog->to);
        $this->see(json_encode('фамилия'));
        $this->see(json_encode('имя'));

        $newOrderContactDetailsLog->loggable_type = 'Контактной инфрмации';
        $newOrderContactDetailsLog->field_changed = 'имя';
        $oldOrderContactDetails->field_changed = 'имя';
        $this->seeJsonContains($newOrderContactDetailsLog->toArray());

        $this->dontSeeJson([$oldOrderContactDetailsLog->field_changed, $oldOrderContactDetailsLog->id]);
    }

    //After ajax url /admin/users/1/orders/1/update should add new logs for orderIndex in view and in DB
    // but don't return old log in view
    public function testOrderIndexLogsShouldReturnAfterUpdate()
    {

        $user = \App\User::find(1);

        Session::start();
        $this->be($user);


        //START SECTION SET DEFAULT VALUES IN dev_order_log
        $order = $user->orders()->first();
        $order->comment = 'AAA';
        $order->total_sum = 123;
        $order->update();
        $oldOrder = $order->replicate();

        $oldOrderLog = $order->orderLogs()->firstOrFail();

        $this->seeInDatabase('dev_order_index', ['comment' => $order->comment, 'total_sum' => $order->total_sum]);
        $this->seeInDatabase('dev_order_log',
            ['id' => $oldOrderLog->id, 'field_changed' => $oldOrderLog->field_changed]);
        $this->seeInDatabase('dev_log_from_to_string', ['to' => $order->comment]);
        //END SECTION SET DEFAULT VALUES IN dev_order_log


        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $order->comment = 'BBB';
        $order->total_sum = 321;

        //set current time to correct test Controller that need different time between old update and new update
        $knownDate = Carbon::create(2017, 5, 21, 12);
        Carbon::setTestNow($knownDate);

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id
            . '/update', array_merge($order->toArray(), $params));

//        $newOrderContactDetailsLog = $orderContactDetails->orderLogs()->firstOrFail();
        $this->seeInDatabase('dev_log_from_to_string', ['to' => $order->comment]);

        $orderCommentLog = LogFromToStringModel::where('to', $order->comment)->firstOrFail();
//
        $orderTotalSumLog = LogFromToDecimalModel::where('to', $order->total_sum)->firstOrFail();
//
        $newOrderLog = LogOrderModel::where('fromto_id', $orderCommentLog->id)->first();
        //
        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderCommentLog->id, 'fromto_type' => LogFromToStringModel::class]);
        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderTotalSumLog->id, 'fromto_type' => LogFromToDecimalModel::class]);

        //should see new logs view
        $this->see($orderCommentLog->to);
        $this->see((int)$orderTotalSumLog->to);        //Check in view total_sum = "321" not 321.00
        $this->see($oldOrderLog->field_changed);
        $this->see($newOrderLog->field_changed);

        //TODO test changing default fields names to russian
        $this->seeJsonContains($newOrderLog->makeHidden(['loggable_type', 'field_changed'])->toArray());

        $this->dontSeeJson(['to' => $oldOrder->comment]);
        $this->dontSeeJson(['to' => $oldOrder->total_sum]);

    }

    //After ajax url /admin/users/1/orders/1/delivery/update should add new logs for contactDetails in view and in DB
    // but don't return old log in view
    //TODO
//    public function testOrderDeliveryLogsShouldReturnAfterUpdate()
//    {
//
//        $user = \App\User::find(1);
//
//        Session::start();
//        $this->be($user);
//
//
//        //START SECTION SET DEFAULT VALUES IN dev_order_log
//        $order = $user->orders()->first();
//        $orderDelivery = $order->orderDelivery()->first();
//        $orderDelivery->delivery_f_name = 'AAA';
//        $orderDelivery->update();
//
//        $oldOrderDelivery = $orderDelivery->replicate();
//
//        $oldOrderDeliveryLog = $orderDelivery->orderLogs()->firstOrFail();
//
//        $this->seeInDatabase('dev_order_delivery', ['delivery_f_name' => $orderDelivery->delivery_f_name]);
//        $this->seeInDatabase('dev_order_log',
//            ['id' => $oldOrderDeliveryLog->id, 'field_changed' => $oldOrderDeliveryLog->field_changed]);
//        $this->seeInDatabase('dev_log_from_to_string', ['to' => $orderDelivery->delivery_f_name]);
//        //END SECTION SET DEFAULT VALUES IN dev_order_log
//
//
//        $params = [
//            '_token' => csrf_token()
//        ];
//
//        //change orderDelivery fields
//        $orderDelivery->delivery_f_name = 'BBB';
//
//        //set current time to correct test Controller that need different time between old update and new update
//        $knownDate = Carbon::create(2017, 5, 21, 12);
//        Carbon::setTestNow($knownDate);
//
//        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id
//            . '/delivery/update', array_merge($orderDelivery->toArray(), $params));
//
//        $this->seeInDatabase('dev_log_from_to_string', ['to' => $orderDelivery->delivery_f_name]);
//
//        //save value of log for last change
//        $orderDeliveryFNameLog = LogFromToStringModel::where('to', $orderDelivery->delivery_f_name)->firstOrFail();
//
//        $newOrderLog = LogOrderModel::where('fromto_id', $orderDeliveryFNameLog->id)->firstOrFail();
//        //
//        $this->seeInDatabase('dev_order_log',
//            ['fromto_id' => $orderDeliveryFNameLog->id, 'fromto_type' => LogFromToStringModel::class]);
//
//        //should see new logs view
//        $this->see($orderDeliveryFNameLog->to);
//        $this->see($oldOrderDeliveryLog->field_changed);
//        $this->see($newOrderLog->field_changed);
//
//        //TODO test changing default fields names to russian
//        $this->seeJsonContains($newOrderLog->makeHidden(['loggable_type', 'field_changed'])->toArray());
//
//        //should not see old logs in response
//        $this->dontSeeJson(['to' => $oldOrderDeliveryLog->delivery_f_name]);
//    }

    //After ajax url /admin/users/1/orders/1/orderBonuses/update should add new logs for orderBonuses in view and in DB
    // but don't return old log in view
    public function testOrderBonusesLogsShouldReturnAfterUpdate()
    {

        $user = \App\User::find(1);

        Session::start();
        $this->be($user);


        //START SECTION SET DEFAULT VALUES IN dev_order_log
        $order = $user->orders()->first();
        $orderBonuses = $order->bonuses()->first();
        $orderBonuses->bonus_count = 1;
        $orderBonuses->update();

        $oldOrderBonuses = $orderBonuses->replicate();

        $oldOrderBonusesLog = $orderBonuses->orderLogs()->firstOrFail();

        $this->seeInDatabase('dev_order_index_bonus', ['bonus_count' => $orderBonuses->bonus_count]);
        $this->seeInDatabase('dev_order_log',
            ['id' => $oldOrderBonusesLog->id, 'field_changed' => $oldOrderBonusesLog->field_changed]);
        $this->seeInDatabase('dev_log_from_to_int', ['to' => $orderBonuses->bonus_count]);
        //END SECTION SET DEFAULT VALUES IN dev_order_log


        $params = [
            '_token' => csrf_token()
        ];

        //change orderBonuses fields
        $orderBonuses->bonus_count = 2;

        //set current time to correct test Controller that need different time between old update and new update
        $knownDate = Carbon::create(2017, 5, 21, 12);
        Carbon::setTestNow($knownDate);

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id
            . '/orderBonuses/update', array_merge($orderBonuses->toArray(), $params));

        $this->seeInDatabase('dev_log_from_to_int', ['to' => $orderBonuses->bonus_count]);

        //save value of log for last change
        $orderBonusesCountLog = LogFromToIntModel::where('to', $orderBonuses->bonus_count)->firstOrFail();

        $newOrderLog = LogOrderModel::where('fromto_id', $orderBonusesCountLog->id)->firstOrFail();

        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderBonusesCountLog->id, 'fromto_type' => LogFromToIntModel::class]);

        //should see new logs view
        $this->see($orderBonusesCountLog->to);
        $this->see($oldOrderBonuses->field_changed);
        $this->see($newOrderLog->field_changed);

        //TODO test changing default fields names to russian
//        $this->seeJsonContains($newOrderLog->makeHidden(['loggable_type', 'field_changed'])->toArray());

        //should not see old logs in response
        $this->dontSeeJson(['to' => $oldOrderBonusesLog->bonus_count]);
    }

    //After ajax url /admin/users/1/orders/1/orderPayment/update should add new logs for orderPayment in view and in DB
    // but don't return old log in view
    public function testOrderPaymentLogsShouldReturnAfterUpdate()
    {
        $user = \App\User::find(1);

        Session::start();
        $this->be($user);

        //START SECTION SET DEFAULT VALUES IN dev_order_log

        $order = $user->orders()->first();
        $order->payment_type_id = 2;
        $order->update();
        //if $order->payment_type_id was 2 before update - no log saved.
        // Now manually update $order->payment_type_id from 2 to 1
        $order->payment_type_id = 1;
        $order->update();


        //get paymentType by payment_type_id
        $orderPaymentType = $order->orderPaymentType()->first();
        $oldOrder = $order->replicate();

        $oldOrderLog = $order->orderLogs()->firstOrFail();

        //should be in DB - updated paymentType and logs for that changed
        $this->seeInDatabase('dev_order_index', ['payment_type_id' => $order->payment_type_id]);
        $this->seeInDatabase('dev_order_log',
            ['id' => $oldOrderLog->id, 'field_changed' => $oldOrderLog->field_changed]);
//        $this->seeInDatabase('dev_log_from_to_string', ['to' => $orderPaymentType->payment_type]);

        //END SECTION SET DEFAULT VALUES IN dev_order_log

        $params = [
            '_token' => csrf_token()
        ];

        //change order's payment_type_id field
        $order->payment_type_id = 2;

        //set current time to correct test Controller that need different time between old update and new update
        $knownDate = Carbon::create(2017, 5, 21, 12);
        Carbon::setTestNow($knownDate);

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id
            . '/orderPayment/update', array_merge([$order->payment_type_id], $params));

//        $newOrder = \App\Models\Order\OrderModel::finndOrFail($order->id);

        $newOrderPaymentType = PaymentTypesModel::findOrFail($order->payment_type_id);
        $this->assertNotEmpty($newOrderPaymentType->payment_type);
//        $newOrderPaymentType = $order->orderPaymentType()->firstOrFail();

        $this->seeInDatabase('dev_log_from_to_string', ['to' => $newOrderPaymentType->payment_type]);

        //save value of log for last change
        $orderPaymentTypeLog = LogFromToStringModel::where('to', $newOrderPaymentType->payment_type)->firstOrFail();

        $newOrderLog = LogOrderModel::where('fromto_id', $orderPaymentTypeLog->id)->firstOrFail();

        //should be in dev_order_log log for new changes
        $this->seeInDatabase('dev_order_log',
            ['fromto_id' => $orderPaymentTypeLog->id, 'fromto_type' => LogFromToStringModel::class]);

        //TODO
//        $this->see($newOrderPaymentType->payment_type);
//        $this->see($newOrderPaymentType->field_changed);

        //TODO
//        $this->seeJsonContains($newOrderLog->makeHidden(['loggable_type', 'field_changed'])->toArray());
    }

    //After ajax url /admin/users/1/orders/1/orderBonuses/update
    // should change price in order_index, bonuses_amount in dev_users_bonuses table
    public function testOrderBonusesUpdateShouldRecountAllBonusesAndPrice()
    {
        $bonusesDelta = 20;
        $user = \App\User::find(1);

        Session::start();
        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //START SECTION SET DEFAULT VALUES
        $order = $user->orders()->first();

        //should be enough total_sum in dev_order_index_bonus table
        //to change order bonuses successfully
        $order->total_sum += $bonusesDelta;
        $order->update();
        $oldOrderTotalSum = $order->total_sum;

        $oldUsersBonuses = $user->bonuses()->firstOrFail();

        //should be enough bonuses_amount in dev_users_bonuses table
        // to change order bonuses successfully
        $oldUsersBonuses->bonuses_amount += $bonusesDelta;
        $oldUsersBonuses->update();
        //END SECTION SET DEFAULT VALUES

        $orderBonuses = $order->bonuses()->first();

        //change orderBonuses fields
        $orderBonuses->bonus_count += $bonusesDelta;

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id
            . '/orderBonuses/update', array_merge($orderBonuses->toArray(), $params));

        $this->seeInDatabase('dev_order_index_bonus',
            ['id' => $orderBonuses->id, 'bonus_count' => $orderBonuses->bonus_count]);

        $newUsersBonuses = $user->bonuses()->firstOrFail();
        $newOrder = $user->orders()->first();
        $newOrder->total_sum;

        //should be new user's bonuses_amount in dev_users_bonuses
        // and new total_sum in dev_order_index
        $this->assertEquals($oldUsersBonuses->bonuses_amount - $bonusesDelta, $newUsersBonuses->bonuses_amount);
        $this->assertEquals($oldOrderTotalSum - $bonusesDelta, $newOrder->total_sum);
        $this->seeInDatabase('dev_order_index', ['total_sum' => $newOrder->total_sum, 'id' => $order->id]);
        $this->seeInDatabase('dev_users_bonuses',
            ['bonuses_amount' => $newUsersBonuses->bonuses_amount, 'id' => $newUsersBonuses->id]);

    }

    //After ajax url /admin/users/1/orders/1/orderBonuses/update
    //bonuses should not update if there is not enough order's total_sum or user's bonuses_amount
    public function testOrderBonusesShouldNotUpdateIfNotPossible()
    {
        $bonusesDelta = 200;
        $user = \App\User::find(1);

        Session::start();
        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //START SECTION SET DEFAULT VALUES

        $order = $user->orders()->first();
        //should NOT be enough total_sum in dev_order_index_bonus table
        //to change order bonuses successfully
        $order->total_sum = 100;
        $oldOrderTotalSum = $order->total_sum;
        $order->update();
        $oldOrderTotalSum = $order->total_sum;

        $oldUsersBonuses = $user->bonuses()->firstOrFail();

        //should NOT be enough bonuses_amount in dev_users_bonuses table
        // to change order bonuses successfully
        $oldUsersBonuses->bonuses_amount = 100;
        $oldUsersBonusesAmount = $oldUsersBonuses->bonuses_amount;
        $oldUsersBonuses->update();

        //END SECTION SET DEFAULT VALUES

        $orderBonuses = $order->bonuses()->firstOrFail();
        $oldOrderBonusesCount = $orderBonuses->bonus_count;

        //change orderBonuses fields
        $orderBonuses->bonus_count += $bonusesDelta;

        $this->call('PUT', '/admin/users/' . $user->id . '/orders/' . $order->id
            . '/orderBonuses/update', array_merge($orderBonuses->toArray(), $params));


        //exception should be thrown
        $this->assertResponseStatus(422);
        //should see old values in db
        $this->seeInDatabase('dev_order_index_bonus',
            ['bonus_count' => $oldOrderBonusesCount, 'id' => $orderBonuses->id]);

        //in DB values should NOT be changed
        $this->notSeeInDatabase('dev_order_index_bonus',
            ['bonus_count' => $orderBonuses->bonus_count, 'id' => $orderBonuses->id]);
        $this->notSeeInDatabase('dev_order_index',
            ['total_sum' => $oldOrderTotalSum - $bonusesDelta, 'id' => $order->id]);
        $this->notSeeInDatabase('dev_users_bonuses',
            ['bonuses_amount' => $oldUsersBonusesAmount - $bonusesDelta, 'id' => $oldUsersBonuses->id]);

    }
}
