<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 14:55
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Product\ProductPhotoModel;

/**
 * Main import controller for photos
 * Manage, add, update methods are available
 * based on stage status
 * Class AdminImportPhotosTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportPhotosTrait
{
    /**
     * Handle images array
     * based on sub product
     * If image is empty just skip
     * @param AdminImportStageController $stage
     * @param $subProductId
     * @param $images
     */
    public function actionInsertPhotos(AdminImportStageController $stage, $subProductId, $images)
    {
        // parse every image
        foreach ($images as $image) {
            // if not empty
            if ($image != '') {
                try {
                    // trying create new image
                    ProductPhotoModel::create([
                        'sub_product_id' => $subProductId,
                        'photo' => $image,
                    ]);

                    $file_path = base_path() . '/public' . $image;

                    // if no file or image exists make Stage warning
                    if (!file_exists($file_path)) {
                        $stage->actionPushStage(
                            'WARNING', 'Файл с путем:  <a target="_blank" href="' . $image . '">Файл</a> не найден.'
                        );
                    }

                } catch (\Exception $e) {
                    // if exception throw stage error
                    // warning
                    $stage->actionNotForcePush(
                        'ERROR', 'Проблема с добавлением фотографий для продукта. Фото: 
                        <a target="_blank" href="' . $image . '">Посмотреть</a>'
                    );
                }
            }
        }
    }

    /**
     * Finding sub product photos
     * in order to handle them
     * @param $subProductId
     * @return mixed
     */
    public function actionSearchSubProductPhotos($subProductId)
    {
        $photos = ProductPhotoModel::where('sub_product_id', $subProductId)
            ->get(['photo']);

        return $photos;
    }

    /**
     * Updating photos for product
     * Based on two methods in dependency manager
     * if photos isset make update with previous product
     * In order for SWITCH method of handing Import Parties
     * Another way to use, for inserting array of photos
     * @param $subProductId
     * @param null $photos
     * @param null $previousProduct
     */
    public function actionUpdateProductPhotos($subProductId, $photos = null, $previousProduct = null)
    {
        // deleting all product photos
        ProductPhotoModel::where('sub_product_id', $subProductId)
            ->delete();

        // if no photos, but exists same product
        // get his photos
        if (is_null($photos) && !is_null($previousProduct)) {
            // searching all photos
            $photos = $this->actionSearchSubProductPhotos($previousProduct);

            foreach ($photos as $photo) {
                // inserting new photos
                ProductPhotoModel::create([
                    'sub_product_id' => $subProductId,
                    'photo' => $photo->photo,
                ]);
            }
        } elseif (!is_null($photos)) {
            // parsing all photos
            foreach ($photos as $photo) {
                if ($photo != '') {
                    // inserting new photos
                    ProductPhotoModel::create([
                        'sub_product_id' => $subProductId,
                        'photo' => $photo,
                    ]);
                }
            }
        }
    }

}