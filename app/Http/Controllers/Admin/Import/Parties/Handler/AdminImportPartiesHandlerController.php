<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 20:54
 */

namespace App\Http\Controllers\Admin\Import\Parties\Handler;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesWorkerInterface;
use Illuminate\Http\Request;

/**
 * Getting manager for handle requests
 * From description of Parties
 * Includes Confirmation of products,
 * Switching with another one,
 * Send for a work to another department,
 * And fixing an new product instance
 * Class AdminImportPartiesHandlerController
 * @package App\Http\Controllers\Admin\Import\Parties\Handler
 */
class AdminImportPartiesHandlerController extends Controller implements AdminImportPartiesWorkerInterface
{
    /**
     * Fat status instance
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Initializing new Fat status instance
     * AdminImportPartiesHandlerController constructor.
     */
    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController();
    }

    /**
     * Based on request type
     * Handle product changing
     * Factory method
     * @param Request $request
     * @return string
     */
    public function actionIndex( Request $request )
    {
        // getting request type
        $type = $request->input( 'type' );

        // based on type getting worker
        switch( $type )
        {
            // if type Confirm product
            case 'confirm':
                $worker = new AdminImportPartiesConfirmController( $this->fat );
                $result = $worker->actionHandleProduct( $request );
                break;

            // if type Switch with another item
            case 'switch':
                $worker = new AdminImportPartiesSwitchController( $this->fat );
                $result = $worker->actionHandleProduct( $request );
                break;

            // if type Sending to another departments
            case 'work':
                $worker = new AdminImportPartiesWorkController( $this->fat );
                $result = $worker->actionHandleProduct( $request );
                break;

            // if type Fixing bad request from parties parses
            case 'fix':
                $worker = new AdminImportPartiesFixController( $this->fat );
                $result = $worker->actionHandleProduct( $request );
                break;

            // else make bad request result
            default:
                $result = false;
        }

        // if request is ok
        if( $result === true )
        {
            return 'true';
        } else
        {
            // else return bad request result
            return 'false';
        }
    }

}