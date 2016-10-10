<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 15:19
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderEncryptionController;

class OrderEncryptionTest extends TestCase
{
    public function testEncryptionFails()
    {
        $result = true;

        try {
            $encrypt = new OrderEncryptionController;

            $hash = $encrypt->actionGetData('1');

            $this->assertNotEquals( 'Z', substr( $hash, 0, 1 ) );
            $this->assertNotEquals( 19, strlen( $hash ) );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testEncryptionSucceed()
    {
        $encrypt = new OrderEncryptionController;

        $hash = $encrypt->actionGetData( '380950948268' );

        $this->assertEquals( 'Z', substr( $hash, 0, 1 ) );
        $this->assertEquals( 19, strlen( $hash ) );
    }

}