<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 17:44
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Testing if registration is valid
     */
    public function testValidRegistration()
    {
        User::where('email', 'serdiuk@test.test')
            ->delete();

        $this->visit('/register')
            ->type('Oleksandr', 'f_name')
            ->type('Serdiuk', 'l_name')
            ->type('serdiuk@test1.test', 'email')
            ->type('380950948261', 'phone')
            ->type('testPassword', 'password')
            ->type('testPassword', 'password_confirmation')
            ->select('Male', 'gender')
            ->check('confirmation')
            ->press('Register')
            ->seePageIs('/home');
    }

    /**
     * Test if authorization fails by email ( existence )
     */
    public function testFailUserRegistrationByEmail()
    {
        $this->visit('/register')
            ->type('Oleksandr', 'f_name')
            ->type('Serdiuk', 'l_name')
            ->type('serdiuk@test.test', 'email') // fail
            ->type('380950948268', 'phone')
            ->type('testPassword', 'password')
            ->type('testPassword', 'password_confirmation')
            ->select('Male', 'gender')
            ->check('confirmation')
            ->press('Register')
            ->seePageIs('/register');
    }

    /**
     * Test if authorization fails by not
     * matching passwords
     */
    public function testFailUserRegistrationByIncorrectPasswords()
    {
        $this->visit('/register')
            ->type('Oleksandr', 'f_name')
            ->type('Serdiuk', 'l_name')
            ->type('serdiuk@test.test', 'email')
            ->type('380950948268', 'phone')
            ->type('testPassword1', 'password') // hereby fails
            ->type('testPassword2', 'password_confirmation') // hereby fails
            ->select('Male', 'gender')
            ->check('confirmation')
            ->press('Register')
            ->seePageIs('/register');
    }

    /**
     * Testing if user does not
     * confirm Confirmation
     * and authorization fails
     */
    public function testFailUserRegistrationByConfirmation()
    {
        // no confirmation
        $this->visit('/register')
            ->type('Oleksandr', 'f_name')
            ->type('Serdiuk', 'l_name')
            ->type('serdiuk@test.test', 'email')
            ->type('380950948268', 'phone')
            ->type('testPassword', 'password')
            ->type('testPassword', 'password_confirmation')
            ->select('Male', 'gender')
            ->press('Register')
            ->seePageIs('/register');
    }

    /**
     * Testing if user already
     * registered in the database
     */
    public function testIfUserExists()
    {
        $this->seeInDatabase('users', [
            'email' => 'serdiuk@test.test'
        ]);
    }

}