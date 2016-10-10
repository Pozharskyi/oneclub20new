<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 01.09.2016
 * Time: 15:42
 */

namespace App\Http\Controllers\Shop\Order;

use App\Http\Controllers\Controller;

class OrderEncryptionController extends Controller
{
    private $hash = 'Z';

    /**
     * Last four digits from UNIX timestamp
     * @var
     */
    private $unix;

    /**
     * Date in format md ( month - date )
     * @var
     */
    private $date;

    /**
     * Last four digits from phone
     * @var
     */
    private $phone;

    /**
     * Random 4 bytes
     * @var
     */
    private $random_bytes;

    /**
     * With what digit are we starting
     * @var
     */
    private $start = 0;

    private $order_digits;

    /**
     * Collecting data for order
     * @param $phone
     */
    private function actionCollectData( $phone ) {

        $now = strtotime('now');
        $this->unix = substr( $now, -4 );

        $this->date = date('md');

        $this->phone = substr( $phone, -4 );

        $this->random_bytes = (string) rand(1000, 9999);

    }

    /**
     * Generating an hash
     * Using Unix timestamp
     * Using Date and month
     * Using Phone
     * Using Random bytes
     */
    private function actionGenerateHash()
    {
        $this->actionGroupHash( $this->unix );
        $this->actionGroupHash( $this->date );
        $this->actionGroupHash( $this->phone );
        $this->actionGroupHash( $this->random_bytes );

        $i = 0;
        $count = count( $this->order_digits );

        /**
         * From array to string
         */
        while( $i < $count )
        {
            $this->hash .= $this->order_digits[$i];

            $i++;
        }

        // removing last string due to inserting an 'Z' to the start
        $this->hash = substr( $this->hash, 0, -1);
    }

    /**
     * Grouping an hash
     * together
     * @param $string
     */
    private function actionGroupHash( $string )
    {
        $i = 0;
        $count = 4;

        $start = $this->start;

        $end = $start;

        while( $i < $count )
        {
            $this->order_digits[$end] = (string)$string[$i];

            $end += 4;

            $i++;
        }

        $this->start++;
    }

    /**
     * Generating slashes
     * for Hash
     */
    private function actionGenerateSlashes() {

        $i = 0;
        $count = 3;

        $pos = 4;

        while( $i < $count )
        {
            $this->hash = substr_replace( $this->hash, '-', $pos, 0);

            $pos += 5;

            $i++;
        }
    }

    /**
     * Getting an hash
     * @param $phone
     * @return string
     */
    public function actionGetData( $phone ) {

        $this->actionCollectData( $phone );
        $this->actionGenerateHash();
        $this->actionGenerateSlashes();

        return $this->hash;

    }

}