<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 12:13
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportStageController;
use App\Models\Import\ImportPartiesProcessModel;
use App\Http\Controllers\Admin\Import\Core\AdminImportBrandsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportCategoriesTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportCsvParserController as CsvParser;
use App\Http\Controllers\Admin\Import\Core\AdminImportDescriptionTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportLogTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportPhotosTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportPricesTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportProductsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportSubProductTrait;
use DB;

define('LIMIT', 50);

/**
 * Main index of parsing parties import
 * Includes validation process, fat status controller,
 * stage validation with errors, creation of new products
 * Class AdminImportPartiesParserController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesParserController extends AdminImportPartiesValidateController
{
    use AdminImportBrandsTrait;
    use AdminImportCategoriesTrait;
    use AdminImportProductsTrait;
    use AdminImportDescriptionTrait;
    use AdminImportSubProductTrait;
    use AdminImportPricesTrait;
    use AdminImportPhotosTrait;
    use AdminImportPartiesSuppliersTrait;

    use AdminImportLogTrait;

    // if every item is parsed
    private $limitUsed = false;

    /**
     * Stage Instance
     * @var AdminImportStageController
     */
    private $stage;

    /**
     * Main index to make import
     * For parties
     * @return string
     */
    public function actionMakeImport()
    {
        // getting first import
        $import = ImportPartiesProcessModel::firstImport()
            ->first();

        if( !isset( $this->stage ) )
        {
            $this->stage = new AdminImportStageController();
        }

        // if any exists
        if( isset( $import->party_id ) )
        {
            $party_id = $import->party_id;

            // getting party supplier
            $supplier = $this->actionGetPartySupplier( $party_id );

            // full file path
            $file_path = base_path() . '/public/' . $import->file_base_path;

            // parsing CSV to Array
            $data = CsvParser::actionParseCsvToArray( $file_path );

            // validate the CSV file
            $fileValidation = $this->actionValidateImportRules( $this->stage, $data );

            // if validation is ok
            if( $fileValidation )
            {
                $i = $import->in_process_atm;
                $end = $i + LIMIT;

                $max = $import->in_process_total;
                if( $max <= $end )
                {
                    $end = $max;

                    // max is used
                    $this->limitUsed = true;
                }

                while( $i < $end )
                {
                    // validate required fields
                    $this->actionValidateFields( $this->stage, $data, $i, 'required' );

                    // validate warning fields
                    $this->actionValidateFields( $this->stage, $data, $i, 'warning' );

                    // if no errors found
                    if( $this->stage->actionCountStages() == 0 )
                    {
                        // clear line logs
                        $this->actionClearLogs( $i, $party_id );

                        $line = $data[$i];

                        // Trying to make import
                        $this->actionTryMakeImport( $line, $i, $party_id, $supplier );
                    }

                    // clearing stages
                    $this->stage->actionClearStages();

                    $i++;
                }

                // updating process model
                $this->actionUpdatePartyLog( $import, $this->limitUsed, $end );
            }
        }

        return '|';
    }

    public function actionTryMakeImport( $line, $i, $party_id, $supplier, $for = null )
    {
        // begin database transaction
        DB::beginTransaction();

        if( !isset( $this->stage ) )
        {
            $this->stage = new AdminImportStageController();
        }

        // logging for which line
        if( !is_null( $for ) )
        {
            $log_line = $for;
        } else
        {
            $log_line = $i;
        }

        try
        {
            // getting brand
            $brand = $this->actionValidateBrandExistence( $this->stage, $line['brand']);

            // getting category
            $category = $this->actionHandleCategories( $this->stage, $line['cat1'], $line['cat2'], $line['cat3']);

            // getting product
            $product = $this->actionGetProduct( $this->stage, $line['sku'], $brand, $category, $line['gender'] );

            // getting color
            $color_id = $this->actionFindColorByName( $line['color'], $this->stage );

            // getting size
            $size_id = $this->actionFindSizeByName( $line['size'], $this->stage );

            $descriptionArray = array(
                'product_id' => $product['product_id'],
                'product_name' => $line['product_name'],
                'product_description' => $line['description'],
                'product_composition' => $line['material'],
                'supplier_product_name' => $line['supplier_product_name'],
                'comment_admin' => $line['comment_admin'],
                'comment_frontend' => $line['comment_frontend'],
                'country_manufacturer' => $line['country_manufacturer'],
            );

            $found = $product['found'];

            // inserting description
            $this->actionHandleDescription($this->stage, $found, $descriptionArray);

            $subProductArray = array(
                'dev_product_index_id' => $product['product_id'],
                'dev_import_parties_id' => $party_id,
                'barcode' => $line['barcode'],
                'dev_product_color_id' => $color_id,
                'dev_product_size_id' => $size_id,
                'quantity' => $line['quantity'],
                'supplier_id' => $supplier,
            );

            // make log
            $this->actionLogImportLine(
                $this->stage, $log_line, $party_id, $product['product_id'],
                $color_id, $supplier, $line['barcode']
            );

            // inserting sub product
            $subProduct = $this->actionCreateSubProduct($this->stage, $subProductArray);

            //if ($subProduct->found == 0) {
            if ($subProduct !== false) {
                $this->actionLogProductIfNew($log_line, $party_id, $subProduct->id);
            }
            //}

            $pricesArray = array(
                'sub_product_id' => $subProduct->id,
                'index_price' => $line['purchase_price'],
                'retail_price' => $line['retail_price'],
                'final_price' => $line['top_price'],
                'special_price' => $line['special_price'],
                'sale_percent' => $line['discount'],
            );

            // creating prices for product
            $this->actionCreatePriceForSubProduct($this->stage, $pricesArray);

            // images
            $images = array(
                $line['img1'], $line['img2'], $line['img3'],
                $line['img4'], $line['img5'], $line['img6']
            );

            // inserting photos
            $this->actionInsertPhotos($this->stage, $subProduct->id, $images);

            // inserting product popularity
            $this->actionInsertPopularity($this->stage, $subProduct->id);

            // count errors
            $failures = $this->stage->actionCountStages();

            if( $failures == 0 )
            {
                // if no errors make transaction
                DB::commit();
            } else
            {
                // if errors deny transaction
                DB::rollBack();
            }

        } catch ( \Exception $e )
        {
            // if errors deny transaction
            DB::rollBack();

            // log transaction errors
            $this->actionLogError( $party_id, $log_line );
        }

        // logging import parties
        $this->actionLogImport( $this->stage, $log_line, $party_id );
    }

}