<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UserInfoControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testUserCabinetViewUserInfo(){
        $this->call('GET', '/cabinet/my_info');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('login');

        $auth = User::find(3);

        $this->be($auth);

        $this->visit('/cabinet/my_info')
            ->assertResponseStatus(200)
            ->see('Dmitry')
            ->type('Dmitry', 'f_name')
            ->press('Сохранить');
    }

    public function testUpdateUserInfo(){
        $post_data = [
            'f_name'       =>  'Dmitro',
            'l_name'        =>  'Wulf',
            'email'         =>  'wulf@gmail.com',
            'gender'        =>  'Male',
            'date_of_birth' =>  '1982-03-30',
            'phone'         =>  '0993829874'
        ];

        $post_bad_data = [
            'f_name'       =>  'D',
            'email'         =>  'serdiuk.oleksandr@gmail.com',
            'date_of_birth' =>  '1982099999930',
            'phone'         =>  ''
        ];

        $auth = User::find(3);

        $this->be($auth);

        $this->call('PUT', '/cabinet/my_info', $post_data);
        $this->assertResponseOk();
        $this->assertResponseStatus(200);

        $this->seeInDatabase('users', $post_data);

        $this->call('PUT', '/cabinet/my_info', $post_bad_data);
        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->see('The f name must be at least 2 characters.');
        $this->see('The email has already been taken.');
        $this->see('The date of birth does not match the format Y-m-d.');
        $this->see('The phone field is required.');

        $this->notSeeInDatabase('users', $post_bad_data);
    }
}
