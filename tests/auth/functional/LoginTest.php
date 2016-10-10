<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 18:19
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * Testing if authorization succeed
     */
    public function testAuthSucceed()
    {
        $this->visit('/login')
            ->type('serdiuk.oleksandr@gmail.com', 'email')
            ->type('test', 'password')
            ->press('Login')
            ->seePageIs('/home');
    }

    /**
     * Testing if authorization fails
     */
    public function testAuthFails()
    {
        $this->visit('/login')
            ->type('serdiuk.oleksandr@gmail.com', 'email')
            ->type('testWrongPassword', 'password')
            ->press('Login')
            ->seePageIs('/login');
    }

    /**
     * Testing if user auth
     * get view
     */
    public function testAuthorizationUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/home')
            ->see('Hello, ' . $user->f_name);
    }

    /**
     * Testing if user auth
     */
    public function testIfUserNotAuth()
    {
        $response = $this->call('GET', '/home');

        $this->assertEquals(302, $response->status());
    }

}