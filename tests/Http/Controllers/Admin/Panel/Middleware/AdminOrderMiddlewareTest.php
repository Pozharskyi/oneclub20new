<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminOrderMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/users/{user}/orders/{order}
     * success access for Маркетинг
     */
    public function testReadOrderAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', 'СуперАдмин')->first();    //get Маркетинг роль
        $user->roles()->attach($role);
        $this->be($user);

        //SECTION PREPARE ALL ORDER PARAMETERS
        $order = factory(\App\Models\Order\OrderModel::class)->make();
        $order->user()->associate($user);
        $orderDelivery = \App\Models\Order\OrderDeliveryModel::firstOrFail();
        $order->save();
        $orderDelivery->order()->associate($order);
        $orderDelivery->save();
        $orderContactDetails = \App\Models\Order\OrderContactDetailsModel::findOrFail(1);
        $orderContactDetails->order()->associate($order);
        $orderContactDetails->save();
        //SECTION PREPARE ALL ORDER PARAMETERS

        $this->call('get', '/admin/users/'.$user->id.'/orders/'.$order->id);
        $this->seePageIs(url('/admin/users/'.$user->id.'/orders/'.$order->id));
    }

    /**
     * url /admin/manage/brands
     * failed access for Логист
     */
    public function testReadBrandsAuthFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', 'Логист')->first();    //get Маркетинг роль
        $user->roles()->attach($role);
        $this->be($user);

        //SECTION PREPARE ALL ORDER PARAMETERS
        $order = factory(\App\Models\Order\OrderModel::class)->make();
        $order->user()->associate($user);
        $orderDelivery = \App\Models\Order\OrderDeliveryModel::firstOrFail();
        $order->save();
        $orderDelivery->order()->associate($order);
        $orderDelivery->save();
        $orderContactDetails = \App\Models\Order\OrderContactDetailsModel::findOrFail(1);
        $orderContactDetails->order()->associate($order);
        $orderContactDetails->save();
        //SECTION PREPARE ALL ORDER PARAMETERS

        $this->call('get', '/admin/users/'.$user->id.'/orders/'.$order->id);

        $this->assertSessionHas('message','Нет прав доступа');
    }
}
