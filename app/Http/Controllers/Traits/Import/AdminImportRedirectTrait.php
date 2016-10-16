<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 16:06
 */

namespace App\Http\Controllers\Traits\Import;

use Illuminate\Support\Facades\Auth;

trait AdminImportRedirectTrait
{
    public function actionGetUserOrFail()
    {
        if( Auth::guest() )
        {
            return redirect('/login');
        }
    }

}