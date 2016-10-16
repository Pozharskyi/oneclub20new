<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.10.2016
 * Time: 2:36
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesStatusController;
use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesCoincidenceController;
use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesWorkController as WorkController;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexPartiesModel;
use Illuminate\Http\Request;

class AdminImportProdValidationController extends Controller
{
    private $coincidenceStatus;
    private $partiesStatus;

    public function __construct()
    {
        $this->coincidenceStatus = new AdminImportStatusesCoincidenceController;
        $this->partiesStatus = new AdminImportPartiesStatusController;
    }

    public final function actionValidateProd(Request $request)
    {
        $allocationId = $request->input('allocationId');
        $partyId = $request->input('partyId');

        try
        {
            $coincidenceLogs = $this->coincidenceStatus->actionGetLogsForAllocation( $allocationId );
            $workLogs = WorkController::actionGetLogsForAllocation( $allocationId );

            $parsedLogs = array();
            $needleLogs = array();

            foreach( $workLogs as $workLog )
            {
                array_push($parsedLogs, $workLog->file_line);
            }

            foreach( $coincidenceLogs as $coincidenceLog )
            {
                $line = $coincidenceLog->file_line;

                if( !in_array( $line, $parsedLogs ) )
                {
                    array_push( $needleLogs, $line );
                }
            }

            $count = count( $needleLogs );

            if( $count == 0 )
            {
                $prodStatus = $this->partiesStatus->actionGetStatusIdByPhrase('PROCESSING');

                $party = ImportIndexPartiesModel::findOrFail($partyId);
                $party->import_parties_status_id = $prodStatus;
                $party->save();

                $message = 'Вы успешно отправили в продашкн ТП';

                return view('admin.import.alert', [
                    'message' => $message,
                ]);
            } else
            {
                $i = 0;
                $result = '';

                while( $i < $count )
                {
                    if( $i != 0 )
                    {
                        $result .= ',';
                    }

                    $result .= $needleLogs[$i];

                    $i++;
                }

                return $result;
            }

        } catch( \Exception $e )
        {
            echo $e->getMessage();
            $message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.alert_error', [
            'message' => $message,
        ]);
    }

}