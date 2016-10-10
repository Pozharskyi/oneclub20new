<?php

namespace App\Http\Controllers\Payments\Receive {

use App\Http\Controllers\Controller;
use App\Models\Payment\Receive\PaymentsReceive;

    class PaymentsReceiveController extends Controller
    {
        /*
         * @array
         * data add to database
         */
        private $ar = array();
        /*
         * @string
         * answer to payment system
         */
        private $answer;

        /**
         * Point of entry. Depending on the payment system call internal methods.
         * @incoming $pay_system - name payment system
         */
        public function actionIndex($pay_system)
        {
            switch($pay_system) {
                case'liqpay':
                    $this->parseLiqpayReceive();
                    break;
            }

            if(count($this->ar) > 0){
                $result = PaymentsReceive::create($this->ar);
            }


            return view('payment_receive', ['answer'=>$this->answer]);
        }

        /**
         * The method of processing data received from liqpay.
         *
         * @incoming data - json object base64 encode
         *      order_id - shop unique order number
         *      liqpay_order_id - unique liqpay order number
         *      sender_phone  - payer phone
         *      ip - payer ip addres
         *      amount - payment amount
         *      receiver_commission - liqpay commission
         *      currency - currency payment
         *      description - description payment
         *      type - payment Type
         *      transaction_id - liqpay id transaction
         *      status - status payments
         * @return array to be added to the database
         */

        private function parseLiqpayReceive(){

            if(isset($_POST['data'])){
                $data = json_decode(base64_decode($_POST['data']));
                $this->ar = [
                    'order_id'              =>  $data->order_id,
                    'paytype'			    =>	'liqpay',
                    'pay_system_order_id'   =>	$data->liqpay_order_id,
                    'email'                 =>  '',
                    'phone'                 =>  $data->sender_phone,
                    'ip'				    =>	$data->ip,
                    'amount'                =>  $data->amount,
                    'commission'		    =>	$data->receiver_commission,
                    'currency'              =>  $data->currency,
                    'description'           =>  $data->description,
                    'type'                  =>  $data->type,
                    'transaction_id'        =>  $data->transaction_id,
                    'orderDateTime'         =>  date('Y-m-d H:i:s'),
                    'payment_status'        =>  $data->status
                ];
            }
        }
    }
}