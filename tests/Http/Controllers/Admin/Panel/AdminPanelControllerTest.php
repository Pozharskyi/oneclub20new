<?php

use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogUserModel;
use App\Models\User\UsersCategoryModel;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminPanelControllerTest extends TestCase
{
    use DatabaseTransactions;

    //if users field did not change, user should not be updated and no new logs should save in db
    public function testUserShouldNotBeUpdated()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $oldUpdatedAt = \App\User::findOrFail($user->id)->pluck('updated_at');
        Session::start();


        $params = [
            '_token' => csrf_token()
        ];


        $this->call('PUT', '/admin/users/update', array_merge($user->toArray(), $params));

        $newUpdatedAt = \App\User::findOrFail($user->id)->pluck('updated_at');

        //before and after method action user should has the same updated_at field
        $this->assertEquals($newUpdatedAt, $oldUpdatedAt);

        //no logs saved for that user
        $this->notSeeInDatabase('dev_user_log', ['field_changed' => 'name', 'user_id' => $user->id]);

    }

    //after submit url /admin/users/update, user should be updated and all changes should be saved in dev_users_log
    public function testUserShouldBeUpdatedAndLogsSavedInBD()
    {
        $user = User::find(1);
        $oldUser = $user->replicate();
        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $user->name = 'AAA';
        $user->phone = '933879106';


        $this->call('PUT', '/admin/users/update', array_merge($user->toArray(), $params));

        $this->seeInDatabase('users', ['name' => $user->name]);
        $this->seeInDatabase('dev_user_log', ['field_changed' => 'name', 'user_id' => $user->id]);
        $this->seeInDatabase('dev_user_log', ['field_changed' => 'phone', 'user_id' => $user->id]);
        $this->seeInDatabase('dev_log_from_to_string', ['from' => $oldUser->name, 'to' => $user->name]);
        $this->seeInDatabase('dev_log_from_to_int', ['to' => $user->phone]);

    }

    //by url /admin/users there should be search user by email. return user's emails and user's names satisfied search
    public function testSearchUserByEmail()
    {
        $user = factory(\App\User::class)->create();

        // prepare Ajax POST request
        $this->be($user);
        $searchString = substr($user->email, 1, 2);
        $params = [
            '_token' => csrf_token(),
            'searchString' => $searchString,
        ];
        $this->call('POST', '/admin/users', $params);

        $this->assertResponseOk();
        $this->see($user->email);
        $this->see($user->name);
    }

    //by url /admin/users there should be search user by name. return user's emails and user's names satisfied search
    public function testSearchUserByName()
    {
        $user = factory(\App\User::class)->create();

        // prepare Ajax POST request
        $this->be($user);
        $searchString = substr($user->name, 1, 2);
        $params = [
            '_token' => csrf_token(),
            'searchString' => $searchString,
        ];
        $this->call('POST', '/admin/users', $params);

        $this->assertResponseOk();
        $this->see($user->email);
        $this->see($user->name);
    }

    // after submit update form (url /admin/users/email) users info should be response
    public function testSeeUserInfoWhenGetUserMethodAction()
    {
        $user = User::find(1);

        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token(),
        ];

        $this->call('GET', '/admin/users/' . $user->id, $params);

        //date_of_birth in laravel has different type from view
//        $this->seeJsonContains($user->makeHidden('date_of_birth')->toArray());

        $this->see($user->name);

        //see user's categories
        $usersCategories = $user->usersCategories()->get();
        foreach ($usersCategories as $category) {
            $this->see($category->name);
        }
        //see user's balance amount
        $userBalance = $user->balances()->first();
        $this->see($userBalance->balance_amount);

        //see user's bonuses
        $this->see($user->bonuses->first()->bonuses_amount);

        //see user's available discounts as link to discount page
        $userDiscounts = $user->discounts()->get();
        foreach ($userDiscounts as $discount) {
            $this->see(url('admin/discounts/' . $discount->id));
        }

        //get discounts from userCategories for current user
        $user->load([
            'usersCategories.discounts' => function ($q) use (&$discountsFromCategory) {
                $discountsFromCategory = $q->get()->unique();
            }
        ]);

        //see available discounts from userCategories for user as a link
        if ($discountsFromCategory) {
            foreach ($discountsFromCategory as $discount) {
                $this->see(url('admin/discounts/' . $discount->id));
            }
        }
    }


    //after update should return only new user's logs
    public function testUpdateUserMethodShouldReturnOnlyNewLogs()
    {
        $user = \App\User::findOrFail(2);
        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        //change users fields
        $user->name = 'AAA';
        $user->phone = '933879106';

        $this->call('PUT', '/admin/users/update', array_merge($user->toArray(), $params));
        $userPhonLog = LogFromToIntModel::where('to', $user->phone)->first();
        $userNameLog = LogFromToStringModel::where('to', $user->name)->first();

        $userAllLogs = LogUserModel::where('user_id', $user->id)->get()->toArray();
        $expectedResponse = array_merge($userPhonLog->toArray(), $userNameLog->toArray());

        //new user's logs should be in response
        $this->seeJsonContains($expectedResponse);

        //all user's logs should not be in response
        $this->dontSeeJson($userAllLogs);

    }

    //user should be deleted from DB after url '/admin/users/delete'
    public function testDeleteUser()
    {
        $user = factory(\App\User::class)->create();

        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        $this->call('DELETE', '/admin/users/delete', array_merge($params, $user->toArray()));
        $this->seeJsonContains(['msg' => 'User has been deleted successfully']);

        //after deleting user should be not null deleted_at field for that user's id
        $this->notSeeInDatabase('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    //after user delete, should save in dev_users_log
    public function testShouldLogWhenDeleteUser()
    {
        $user = factory(\App\User::class)->create();

        Session::start();

        $this->be($user);

        $params = [
            '_token' => csrf_token()
        ];

        $this->call('DELETE', '/admin/users/delete', array_merge($params, $user->toArray()));

        $this->seeInDatabase('dev_user_log', ['user_id' => $user->id, 'action_id' => 3]);
    }

    //after user created, should save in dev_users_log
    public function testShouldLogWhenCreateUser()
    {

        $user = factory(\App\User::class)->create();

        $this->seeInDatabase('dev_user_log', ['user_id' => $user->id, 'action_id' => 1]);
    }
}
