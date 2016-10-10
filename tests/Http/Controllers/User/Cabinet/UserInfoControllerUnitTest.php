<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\User\Cabinet\UserInfoController;
use App\User;

class UserInfoControllerUnitTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testGetUserInfo(){
        $auth = User::find(3);

        $this->be($auth);

        $user = new UserInfoController;
        $data = $user->getUserInfo();

        $this->assertEquals($data['email'], 'wolf@gmail.com');
        $this->assertNotEquals($data['email'], 'qqq@gmail.com');
    }

    public function testUpdateUserInfo(){
        $old_data = [
            'f_name'       =>  'Dmitry',
            'l_name'        =>  'Wolf',
            'email'         =>  'wolf@gmail.com',
            'gender'        =>  'Male',
            'date_of_birth' =>  '1982-03-31',
            'phone'         =>  ''
        ];

        $data = [
            'f_name'       =>  'Dmitro',
            'l_name'        =>  'Wulf',
            'email'         =>  'wulf@gmail.com',
            'gender'        =>  'Male',
            'date_of_birth' =>  '1982-03-30',
            'phone'         =>  '0993829874'
        ];

        $auth = User::find(3);

        $this->be($auth);

        $user = new UserInfoController;

        $this->seeInDatabase('users', $old_data);

        $user->updateUserInfoToDB($data);

        $this->seeInDatabase('users', $data);

        $this->notSeeInDatabase('users', $old_data);
    }
}
