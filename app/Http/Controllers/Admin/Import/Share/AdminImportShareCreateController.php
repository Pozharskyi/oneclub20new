<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 21:46
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Controller;

use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\Import\ImportSalesShareModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Getting creation of shares
 * with getting View
 * Class AdminImportShareCreateController
 * @package App\Http\Controllers\Admin\Import\Share
 */
class AdminImportShareCreateController extends Controller implements AdminImportCreateInterface
{
    /**
     * Getting shares create View
     * to fulfill
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetCreateView( Request $request )
    {
        $message = $request->input('success');

        if( !isset( $message ) )
        {
            $message = null;
        }

        // return view
        return view('admin.import.share.create', [
            'message' => $message,
        ]);
    }

    /**
     * Handler for creating shares
     * If no user sets return redirect
     * for Auth page
     * else create share
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionCreate( Request $request )
    {
        // if no user
        if( !isset( Auth::user()->id ) )
        {
            return redirect('/login');
        }

        $share_name = $request->input('share_name');
        $recommended_start = $request->input('recommended_start');
        $recommended_end = $request->input('recommended_end');

        $first_header = $request->input('first_header');
        $second_header = $request->input('second_header');

        try {
            ImportSalesShareModel::create([
                'sales_share_name' => $share_name,
                'sales_share_start' => $recommended_start,
                'sales_share_end' => $recommended_end,
                'first_header' => $first_header,
                'second_header' => $second_header,
                'made_by' => Auth::user()->id,
            ]);

            // return ok response
            return redirect( '/admin/import/share/?success=true' );

        } catch( \Exception $e )
        {
            // return bad response
            return redirect('/admin/import/share/create?success=false');
        }
    }

}