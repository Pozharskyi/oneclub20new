<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 12:33
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportStageController;
use App\Http\Controllers\Controller;

/**
 * Import Parties Validator
 * Includes validation of import,
 * required, import fields
 * Validation of fields, file
 * Class AdminImportPartiesValidateController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
abstract class AdminImportPartiesValidateController extends Controller
{
    /**
     * getting first validation line
     */
    const validationLine = 0;

    /**
     * Make index for getting
     * parties import
     * @return mixed
     */
    abstract public function actionMakeImport();

    /**
     * All import fields
     * For CSV file
     * @var array
     */
    protected $import_fields = [
        'sku', 'barcode', 'supplier_product_name', 'cat1', 'cat2', 'cat3',
        'product_name', 'size', 'quantity', 'purchase_price', 'retail_price', 'top_price',
        'special_price', 'discount', 'brand', 'gender', 'color',
        'material', 'description', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6',
        'comment_admin', 'comment_frontend', 'country_manufacturer'
    ];

    /**
     * All required import fields
     * For CSV file
     * @var array
     */
    protected  $required_fields = [
        'sku', 'barcode', 'cat1', 'cat2', 'cat3', 'product_name',
        'size', 'quantity', 'purchase_price', 'top_price', 'special_price',
        'brand', 'gender', 'color', 'country_manufacturer',
    ];

    /**
     * Validate import rules
     * For each row existence and no more rows
     * @param AdminImportStageController $stage
     * @param $import
     * @return bool
     */
    protected function actionValidateImportRules( AdminImportStageController $stage, $import )
    {
        // get line
        $validation_line = $import[self::validationLine];

        // foreach row
        foreach( $this->import_fields as $import_field )
        {
            /**
             * If all lines exists in file
             */
            if( !isset( $validation_line[$import_field] ) )
            {
                $stage->actionPushStage(
                    'ERROR', 'Не правельный формат файла. Столбец не найден: ' . $import_field
                );
                return false;
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
            return true;
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

            // push Error message
            $stage->actionPushStage( 'ERROR', $error_message );
            return false;
        }
    }

    /**
     * Validate fields by param
     * and type required | waring
     * @param AdminImportStageController $stage
     * @param $import
     * @param $line
     * @param $type
     */
    protected function actionValidateFields( AdminImportStageController $stage, $import, $line, $type )
    {
        // getting line
        $validation_line = $import[$line];

        // based on type get params
        switch( $type )
        {
            case 'required':
                $fields = $this->required_fields;
                $message = 'Обязательный параметр не заполнен: ';

                // fat status
                $validation = 'ERROR';
                break;

            case 'warning':
                $fields = array_diff( $this->required_fields, $this->import_fields );
                $message = 'Параметр не заполнен: ';

                // fat status
                $validation = 'WARNING';
                break;

            default:

                // push validation error
                $stage->actionPushStage(
                    'ERROR', 'Не известный параметр проверки: ' . $type
                );
                die();
        }

        // foreach field validate for empty
        // if empty push message
        foreach( $fields as $import_field )
        {
            /**
             * If all lines exists in file
             */
            if ( $validation_line[$import_field] == '' )
            {
                // generate message
                // by Type and Text
                $stage->actionPushStage(
                    $validation, $message . $import_field
                );
            }
        }
    }

}