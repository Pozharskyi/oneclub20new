<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 27.09.2016
 * Time: 18:09
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Admin\Import\Core\AdminImportBrandsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportCategoriesTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportCsvParserController as CsvParser;
use App\Http\Controllers\Admin\Import\Core\AdminImportDescriptionTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportLogTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportPhotosTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportPricesTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportProductsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportStageController;
use App\Http\Controllers\Admin\Import\Core\AdminImportSubProductTrait;

use App\Http\Controllers\Admin\Import\Core\AdminImportSupplierTrait;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesValidateController;
use App\Models\Import\ImportUpdateProcessModel;
use DB;

/**
 * Main handler for import update parties
 * Includes validation, csv parsing,
 * updating Traits to manage update settings
 * Includes fat managers in order to control stage
 * Class AdminImportUpdateParserController
 * @package App\Http\Controllers\Admin\Import\Update
 */
class AdminImportUpdateParserController extends AdminImportPartiesValidateController
{
    use AdminImportCategoriesTrait;
    use AdminImportProductsTrait;
    use AdminImportDescriptionTrait;
    use AdminImportSubProductTrait;
    use AdminImportPricesTrait;
    use AdminImportPhotosTrait;

    use AdminImportLogTrait;
    use AdminImportSupplierTrait;
    use AdminImportBrandsTrait;

    protected $import_fields = [
        'sku', 'barcode', 'supplier_product_name', 'cat1', 'cat2', 'cat3',
        'product_name', 'size', 'quantity', 'purchase_price', 'retail_price', 'top_price',
        'special_price', 'discount', 'brand', 'gender', 'color',
        'material', 'description', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6',
        'comment_admin', 'comment_frontend', 'country_manufacturer'
    ];

    protected $required_fields = [
        'sku', 'barcode', 'color', 'size',
    ];

    /**
     * Validating if limit of Import Party was used
     * True if no items in import party haystack
     * @var bool
     */
    private $limitUsed = false;

    /**
     * Import Status Instance
     * @var
     */
    private $importStatus;

    /**
     * Stage instance
     * @var
     */
    private $stage;

    /**
     * Main index of parsing update parties
     * @return string
     */
    public function actionMakeImport()
    {
        // getting first line of import
        $import = ImportUpdateProcessModel::firstImport()
            ->first();

        // if found any
        if( isset( $import->update_id ) )
        {
            $update_id = $import->update_id;

            // create new stage instance
            $this->stage = new AdminImportStageController();

            // full file path
            $file_path = base_path() . '/public/' . $import->file_base_path;

            $data = CsvParser::actionParseCsvToArray( $file_path );
            $fileValidation = $this->actionValidateImportRules( $this->stage, $data);

            // if file is valid
            if ( $fileValidation )
            {
                $i = $import->in_process_atm;
                $end = $i + LIMIT;

                $max = $import->in_process_total;
                if( $max <= $end )
                {
                    $end = $max;
                    // if all items will be done
                    $this->limitUsed = true;
                }

                while( $i < $end )
                {
                    // validate required fields
                    $this->actionValidateFields( $this->stage, $data, $i, 'required' );

                    // validate warning fields
                    $this->actionValidateFields( $this->stage, $data, $i, 'warning' );

                    $line = $data[$i];

                    // if no errors found
                    if( $this->stage->actionCountStages() == 0 )
                    {
                        // clear line logs
                        $this->actionClearUpdateLogs($i, $update_id);

                        $line = $data[$i];
                    }

                    // search for parent id
                    $product_id = $this->actionSearchProduct( $this->stage, $line['sku'] );

                    // if found parent id
                    if( $product_id !== false )
                    {
                        // getting sub product
                        $sub_product = $this->actionSearchSubProduct(
                            $this->stage,
                            $product_id, $line['barcode'],
                            $line['color'], $line['size']
                        );

                        // array to update
                        $description = array(
                            'product_name' => $line['product_name'],
                            'supplier_product_name' => $line['supplier_product_name'],
                            'product_description' => $line['description'],
                            'product_composition' => $line['material'],
                            'comment_admin' => $line['comment_admin'],
                            'comment_frontend' => $line['comment_frontend'],
                            'country_manufacturer' => $line['country_manufacturer']
                        );

                        // array to update
                        $prices = array(
                            'index_price' => $line['purchase_price'],
                            'retail_price' => $line['retail_price'],
                            'final_price' => $line['top_price'],
                            'special_price' => $line['special_price'],
                            'sale_percent' => $line['discount'],
                        );

                        // array to update
                        $sub_product_data = array(
                            'quantity' => $line['quantity'],
                        );

                        // array to update
                        $photos = [
                            $line['img1'], $line['img2'], $line['img3'], $line['img4'],
                            $line['img5'], $line['img6'],
                        ];

                        // getting brand
                        $brand = $this->actionUpdateBrand( $this->stage, $line['brand'] );

                        // if all categories are fulfilled
                        if( $line['gender'] == '' && $line['category'] && $line['subcategory'] == '' )
                        {
                            // make empty category
                            $category = '';
                        } else
                        {
                            // else get latest category
                            $category = $this->actionHandleCategories(
                                $this->stage, $line['cat1'],
                                $line['cat2'], $line['cat3']
                            );
                        }

                        // getting update for parent product
                        $product_update = [
                            'brand_id' => $brand,
                            'category_id' => $category,
                        ];

                        // if sub product exists
                        if( $sub_product !== false )
                        {
                            // make transaction
                            DB::beginTransaction();

                            try
                            {
                                // update description of parent_id
                                $this->actionUpdateDescription( $product_id, $description );

                                // update sub product
                                $this->actionUpdateSubProduct( $sub_product, $sub_product_data );

                                // update prices for sub product
                                $this->actionUpdatePrices( $sub_product, $prices );

                                // update parent_id information
                                $this->actionUpdateProduct( $product_id, $product_update );

                                // insert photos for parent id
                                $this->actionUpdateProductPhotos( $sub_product, $photos );

                                // restrict fat statuses only for UPDATED
                                $this->importStatus = $this->fat->actionSearchStatusByPhrase( 'UPDATED' );

                                // get failures count
                                $failures = $this->stage->actionCountStages();

                                if( $failures == 0 )
                                {
                                    // if no failures commit
                                    DB::commit();
                                } else
                                {
                                    // else deny transaction
                                    DB::rollBack();
                                }

                            } catch( \Exception $e )
                            {
                                // if any error SET AS NOT UPDATED
                                $this->importStatus = $this->fat->actionSearchStatusByPhrase( 'NOT_UPDATED' );

                                // deny transaction
                                DB::rollBack();
                            }
                        } else
                        {
                            // if sub product does not found set AS NOT FOUND
                            $this->importStatus = $this->fat->actionSearchStatusByPhrase( 'NOT_FOUND' );

                            // make ERROR alert
                            $this->stage->actionPushStage( 'ERROR', 'Продукта не найдено.' );
                        }

                    } else
                    {
                        // if parent id does not exists set AS NOT FOUND
                        $this->importStatus = $this->fat->actionSearchStatusByPhrase( 'NOT_FOUND' );

                        // make ERROR alert
                        $this->stage->actionPushStage( 'ERROR', 'Продукта не найдено.' );
                    }

                    // if isset sub product
                    if( !isset( $sub_product ) )
                    {
                        $sub_product = null;
                    }

                    // log import update
                    $this->actionLogUpdateImport( $this->fat, $update_id, $i, $this->importStatus, $sub_product );

                    // log all stages from transaction
                    $this->actionLogUpdateStagesImport( $this->stage, $i, $update_id );

                    // clear all stages
                    $this->stage->actionClearStages();

                    $i++;
                }

                // update process list for Import Update
                $this->actionLogUpdate( $import, $this->limitUsed, $end );
            }

        }

        // return any
        return '|';
    }
}