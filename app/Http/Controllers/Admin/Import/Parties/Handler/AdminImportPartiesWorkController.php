<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 23:43
 */

namespace App\Http\Controllers\Admin\Import\Parties\Handler;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesHandleInterface;
use App\Models\Import\ImportLogPartiesProcessModel;
use Illuminate\Http\Request;

/**
 * Handler to send product
 * for a work into another department
 * with a comment
 * Class AdminImportPartiesWorkController
 * @package App\Http\Controllers\Admin\Import\Parties\Handler
 */
class AdminImportPartiesWorkController extends Controller implements AdminImportPartiesHandleInterface
{
    /**
     * Fat status instance
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Initialize new fat instance
     * AdminImportPartiesWorkController constructor.
     * @param AdminImportFatStatusController $fat
     */
    public function __construct( AdminImportFatStatusController $fat )
    {
        $this->fat = $fat;
    }

    /**
     * Getting View for edit a product ( line )
     * from CSV to work with
     * comment and statuses
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetWorkView( Request $request )
    {
        $party_id = $request->input( 'party_id' );
        $file_line = $request->input( 'file_line' );
        $fat_status_id = $request->input( 'fat_status_id' );

        // getting view
        return view('admin.import.parties.fat_work', [
            'party_id' => $party_id,
            'file_line' => $file_line,
            'fat_status_id' => $fat_status_id,
        ]);
    }

    /**
     * Handling product sending for a work
     * Updating exists statuses
     * If statuses more than one insert them
     * @param Request $request
     * @return bool
     */
    public function actionHandleProduct( Request $request )
    {
        $work_types = $request->input('work_type');
        $comment = $request->input('comment');

        $party_id = $request->input( 'party_id' );
        $file_line = $request->input( 'file_line' );
        $fat_status_id = $request->input( 'fat_status_id' );

        $i = 0;

        // work result
        $result = true;

        // result of update
        // new Fat status
        $status = 0;

        // foreach type
        foreach( $work_types as $work_type )
        {
            // searching for id
            $fat = $this->fat->actionSearchStatusByPhrase( $work_type );

            if( $fat === false )
            {
                // else trigger error
                $fat = $this->fat->actionSearchStatusByPhrase( 'SYSTEM_ERROR' );
            }

            try
            {
                // if first foreach cycle
                if( $i == 0 )
                {
                    // update logs
                    ImportLogPartiesProcessModel::confirmationUpdate( $party_id, $file_line, $fat_status_id )
                        ->update([
                            'fat_status_id' => $fat,
                            'message' => $comment,
                        ]);

                    // set new status
                    $status = $fat;
                } else
                {
                    // getting sub product for update
                    $info = ImportLogPartiesProcessModel::confirmationUpdate( $party_id, $file_line, $status )
                        ->first(['sub_product_id']);

                    // creating new logs line
                    ImportLogPartiesProcessModel::create([
                        'party_id' => $party_id,
                        'file_line' => $file_line,
                        'fat_status_id' => $fat,
                        'message' => $comment,
                        'sub_product_id' => $info->sub_product_id,
                    ]);
                }

            } catch( \Exception $e )
            {
                // if something went wrong
                $result = false;
            }

            $i++;
        }

        // return request status
        return $result;
    }

}