<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Http\Controllers\User\Cabinet\UserSubscribationController;

class UserSubscriberTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnitGetAllSubscribation()
    {
        $subscribation = new UserSubscribationController;
        $data = $subscribation->getAllSubscribations();

        $this->assertEquals($data[0]->name, 'Ежедненвые');
        $this->assertNotEquals($data[0]->name, 'Ежеднен');
    }

    public function testUnitGetUserSubscribations(){
        $auth = User::find(3);

        $this->be($auth);

        $subscribation = new UserSubscribationController;

        $data = $subscribation->getUserSubscribations();

        $this->assertEquals($data[0]->subscribation_id, '8');
        $this->assertNotEquals($data[0]->subscribation_id, '1');
    }
}
