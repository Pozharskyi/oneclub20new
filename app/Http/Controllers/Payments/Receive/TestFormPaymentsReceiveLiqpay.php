<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 02.09.2016
 * Time: 12:03
 */

namespace App\Http\Controllers\Payments\Receive;


class TestFormPaymentsReceiveLiqpay
{

    public function actionIndex(){
        return view('form_test_liqpay');
    }
}