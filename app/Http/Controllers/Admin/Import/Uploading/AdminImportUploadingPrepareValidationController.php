<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 0:32
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesPrepareController;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Basic\BasicBrandsTrait;
use App\Http\Controllers\Traits\Basic\BasicColorsTrait;
use App\Http\Controllers\Traits\Basic\BasicSizesTrait;
use Illuminate\Http\Request;

abstract class AdminImportUploadingPrepareValidationController extends Controller
{
    use BasicBrandsTrait;
    use BasicColorsTrait;
    use BasicSizesTrait;

    const VALIDATION_LINE = 0;

    protected $import_fields = [
        'sku', 'barcode', 'supplier_product_name',
        'cat1', 'cat2', 'cat3', 'product_name', 'size',
        'quantity', 'purchase_price', 'provider_price',
        'final_price', 'special_price', 'discount',
        'brand', 'gender', 'color', 'material', 'description',
        'comment_admin', 'comment_frontend', 'country_manufacturer',
    ];

    protected $required_fields = [
        'sku', 'product_name', 'color',
        'size', 'brand',
    ];

    protected function actionValidateFile( $import )
    {
        // get line
        $validation_line = $import[self::VALIDATION_LINE];
        $validation = array(
            'valid' => true,
            'message' => '',
        );

        // foreach row
        foreach( $this->import_fields as $import_field )
        {
            /**
             * If all lines exists in file
             */
            if( !isset( $validation_line[$import_field] ) )
            {

                $validation['valid'] = false;
                $validation['message'] = 'Не правельный формат файла. Столбец не найден: ' . $import_field;
                return $validation;
            } else
            {
                /**
                 * Deleting from import field
                 * In order to validate if no other fields are
                 * present in import
                 */
                unset( $validation_line[$import_field] );
            }
        }

        /**
         * If array is empty
         * due to we deleted all fields
         * return validation ok
         */
        if( count( $validation_line ) == 0 || empty( $validation_line ) )
        {
            // if no more rows in CSV file
            return $validation;
        } else
        {
            // generate error message
            $error_message = 'Не правельный формат файла. Кличество столбцов перевышает нужно количество. Данные столбцы лишние: ';

            $i = 0;

            // getting error rows
            foreach( $validation_line as $data => $value )
            {
                if( $i != 0 )
                {
                    $error_message .= ',';
                }

                $error_message .= $data;

                $i++;
            }

            $validation['valid'] = false;
            $validation['message'] = $error_message;
            return $validation;
        }
    }

    protected function actionValidateFileRules( AdminImportStatusesPrepareController $status, $import, $allocationId )
    {
        $i = 0;
        $count = count( $import );

        $brands = $this->actionGetBrands();
        $colors = $this->actionGetColors();
        $sizes = $this->actionGetSizes();

        $brand_error = $status->actionFindStatusIdByPhrase('BRAND_NOT_FOUND');
        $color_error = $status->actionFindStatusIdByPhrase('COLOR_NOT_FOUND');
        $size_error = $status->actionFindStatusIdByPhrase('SIZE_NOT_FOUND');
        $okStatus = $status->actionFindStatusIdByPhrase('OK');

        while( $i < $count )
        {
            $workLine = $import[$i];
            $validation = true;
            $errorStatuses = [];

            if ( !in_array( $workLine['brand'], $brands ) )
            {
                $validation = false;
                array_push($errorStatuses, $brand_error);
            }

            if ( !in_array( $workLine['color'], $colors ) )
            {
                $validation = false;
                array_push($errorStatuses, $color_error);
            }

            if( $workLine['size'] != '' )
            {
                if ( !in_array( $workLine['size'], $sizes ) )
                {
                    $validation = false;
                    array_push($errorStatuses, $size_error);
                }
            }

            if ($validation)
            {
                $status->actionLogPrepareStatus($allocationId, $i, $okStatus);
            } else
            {
                foreach( $errorStatuses as $errorStatus )
                {
                    $status->actionLogPrepareStatus($allocationId, $i, $errorStatus);
                }
            }

            $i++;
        }

        Allocation::actionUpdateAllocation($allocationId, $count);
        $errors = $status->actionValidateErrorsForAllocation( $allocationId );

        return $errors;
    }

    abstract public function actionParse(Request $request);

}