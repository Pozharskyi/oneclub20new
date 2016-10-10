<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 14:39
 */

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Models\Import\ImportLogPartiesProcessModel as ProcessLog;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

trait AdminDepartmentFatStatusTrait
{
    protected $fat;

    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController;
    }

    public function actionHandleFatStatus(Request $request)
    {
        $subProductId = $request->input('subProductId');
        $confirmType = $request->input('confirmType');
        $fatStatusForCheck = $this->fat->actionSearchStatusByPhrase('APPROVED');

        if ($confirmType == 'confirm') {
            $product = SubProductModel::findOrFail($subProductId);

            $product->is_approved = '1';
            $product->save();
        }

        ProcessLog::findSubProduct($subProductId)
            ->update([
                'fat_status_id' => $fatStatusForCheck,
            ]);
    }

}