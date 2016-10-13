<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 0:32
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AdminImportUploadingPrepareValidationController extends Controller
{
    const VALIDATION_LINE = 0;

    protected $import_fields = [
        'sku', 'barcode', 'supplier_product_name',
        'cat1', 'cat2', 'cat3', 'product_name', 'size',
        'quantity', 'purchase_price', 'provider_price',
        'final_price', 'special_price', 'discount',
        'brand', 'gender', 'color', 'material', 'description',
        'comment_admin', 'comment_frontend', 'country_manufacturer',
        'test',
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

    abstract public function actionParse(Request $request);

}