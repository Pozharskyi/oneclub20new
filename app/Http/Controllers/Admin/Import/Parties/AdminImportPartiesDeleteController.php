<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 17:07
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexPartiesModel;
use App\Models\Import\ImportPartiesLogDeleteModel;
use Illuminate\Http\Request;

class AdminImportPartiesDeleteController extends Controller
{
    private $message;
    private $partiesStatus;

    public function __construct()
    {
        $this->partiesStatus = new AdminImportPartiesStatusController;
    }

    public function actionGetViewForDelete(Request $request)
    {
        $party_id = $request->input('party_id');

        $party = ImportIndexPartiesModel::findOrFail($party_id);

        return view('admin.import.parties.delete', [
            'party' => $party,
        ]);
    }

    public function actionDelete(Request $request)
    {
        try
        {
            $party_id = $request->input('import_index_party_id');
            $comment = $request->input('comment');

            ImportPartiesLogDeleteModel::create([
                'import_index_party_id' => $party_id,
                'comment' => $comment,
                'made_by' => \Auth::user()->id,
            ]);

            $party = ImportIndexPartiesModel::findOrFail($party_id);
            $party->import_parties_status_id = $this->partiesStatus->actionGetStatusIdByPhrase('ASKED_FOR_DELETION');
            $party->save();

            $this->message = 'Заявка на удаление была подана.';

        } catch( \Exception $e )
        {
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.alert', [
            'message' => $this->message,
        ]);
    }

}