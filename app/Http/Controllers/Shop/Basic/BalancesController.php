<?php

namespace App\Http\Controllers\Shop\Basic;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BalancesController extends Controller
{
    public static function getBalanceForUser()
    {
        $user = Auth::user();
        $balance = $user->balances()->first();

        return $balance;
    }
}
