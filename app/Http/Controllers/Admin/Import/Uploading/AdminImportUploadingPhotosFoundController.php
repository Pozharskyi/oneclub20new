<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 23:41
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportPartiesPhotosFoundsModel;

class AdminImportUploadingPhotosFoundController extends Controller
{
    public static function actionGetPhotosForProduct( $allocationId, $fileLine )
    {
        $photos = ImportPartiesPhotosFoundsModel::totalMatch($allocationId, $fileLine)
            ->get(['photo_uri']);

        return $photos;
    }

}