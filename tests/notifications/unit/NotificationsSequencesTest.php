<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 21:01
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Admin\Notifications\NotificationsSequencesController;

class NotificationsSequencesTest extends TestCase
{
    /**
     * Testing for getting sequences
     * Failed by incorrect transaction name
     */
    public function testGettingSequencesFail()
    {
        $sequences = new NotificationsSequencesController;

        $all = $sequences->actionGetSequences();

        $sequence_name = $all[0]['name'];
        $sequence_template_name = $all[0]['template_name'];

        $this->assertNotEquals( 'Номер транзакции', $sequence_name );
        $this->assertNotEquals( '%TEMPLATE.transaction_number%', $sequence_template_name );
    }

    /**
     * Testing getting all
     * sequences
     */
    public function testGettingAllSequences()
    {
        $sequences = new NotificationsSequencesController;

        $all = $sequences->actionGetSequences();

        $sequence_name = $all[0]['name'];
        $sequence_template_name = $all[0]['template_name'];

        $this->assertEquals( 'Полное имя пользователя', $sequence_name );
        $this->assertEquals( '%TEMPLATE.full_name%', $sequence_template_name );

    }

    /**
     * Testing for getting notification type
     * by event
     */
    public function testGettingNotificationType()
    {
        $sequences = new NotificationsSequencesController;

        $seq = $sequences->actionGetSequenceName(1);

        $name = $seq[0]->notification_type;

        $this->assertEquals( 'Email', $name );
    }

}