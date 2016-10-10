<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 27.09.2016
 * Time: 13:44
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportLogTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportProductColorsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportProductsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportSupplierTrait;
use App\Models\Import\ImportFatStatusModel;
use App\Models\Import\ImportLogPartiesProcessModel;

/**
 * Parties Fat status handler
 * Getting statuses view, getting search,
 * getting fat results, getting matches with products,
 * getting distinct statuses, csv parser
 * Class AdminImportPartiesFatStatusController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesFatStatusController extends AdminImportPartiesDescriptionController
{
    use AdminImportLogTrait;
    use AdminImportProductsTrait;
    use AdminImportProductColorsTrait;
    use AdminImportSupplierTrait;

    use AdminImportPartiesFileParserTrait;

    /**
     * Getting view for fat status
     * Based on party identifier
     * @param $party_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetFatStatusView( $party_id )
    {
        // getting party info
        $info = $this->actionGetPartyInfo( $party_id );

        // getting distinct fat statuses
        $fat_statuses = $this->actionGetDistinctFatStatus();

        // searching fat statuses
        $results = $this->actionSearchFatStatus( $party_id, 0, 'fat' );

        // getting view
        return view('admin.import.parties.fat', [
            'info' => $info,
            'fat_statuses' => $fat_statuses,

            'results' => $results,
            'count' => count( $results ),
        ]);
    }

    /**
     * Getting search by fat status
     * based on current fat status or as Array
     * based on For statement
     * by party identifies
     * @param $party_id
     * @param null $fat_status_id
     * @param null $for
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearchFatStatus( $party_id, $fat_status_id = null, $for = null )
    {
        // if basic search
        if( $fat_status_id == 0 )
        {
            $this->fat->actionSetStatuses( 'SEARCH' );
            $this->fat->actionPushErrorStatus();
        } else
        {
            // if needle for results
            $this->fat->actionSetStatuses( 'RESULT' );
        }

        // getting statuses list
        $fat_status_id = $this->fat->actionGetStatuses();

        // getting data with fat status
        $fat = $this->actionGetDataByFatStatus( $party_id, $fat_status_id );

        // getting csv file
        $file = $this->actionGetCsvFile( $party_id );

        // getting results of search
        $results = $this->actionGetItemsResult( $fat, $file, $party_id );

        // destroying statuses
        $this->fat->actionResetStatuses();

        if( is_null( $for ) )
        {
            // getting results view
            return view( 'admin.import.parties.fat_resolve', [
                'results' => $results,
                'count' => count( $results ),
            ]);
        } else
        {
            // getting results
            return $results;
        }
    }

    /**
     * Getting items result based on fat
     * file line and party identifier
     * Searching for matches
     * Searching for status errors
     * @param $fat
     * @param $file
     * @param $party_id
     * @return array
     */
    protected function actionGetItemsResult( $fat, $file, $party_id )
    {
        $result = array();

        // getting supplier by party identifier
        $supplier_id = $this->actionSearchSupplierByParty( $party_id );

        // foreach file line
        foreach( $fat as $line )
        {
            // getting errors
            $errors = $this->actionSearchErrorsByLineAndParty( $line->file_line, $party_id );

            // getting file data
            $data = $file[$line->file_line];

            // searching for matches
            $matches = $this->actionSearchMatches( $data['sku'], $data['barcode'], $data['color'], $supplier_id );

            // if any matches
            if( isset( $matches ) )
            {
                $data['uri'] = $matches;
            }

            // if any errors
            if( $errors != 0 )
            {
                $data['fat_status_id'] = $this->fat->actionSearchStatusByPhrase( 'ERROR' );
            } else
            {
                // else get current status
                $data['fat_status_id'] = $line->fat_status_id;
            }

            $newStatus = $this->fat->actionSearchStatusByPhrase('NEW');

            if ($data['fat_status_id'] == $newStatus) {
                $data['uri'] = $this->actionFindSubProductByLine($party_id, $line->file_line);
            }

            // getting fat status by PHRASE
            $data['fat'] = $this->fat->actionGetFullStatusById( $data['fat_status_id'] );

            // parse file line
            $data['file_line'] = $line->file_line;

            // push to results
            $result[] = $data;
        }

        // getting results
        return $result;
    }

    /**
     * Searching for matches with another or self
     * usage of products
     * @param $sku
     * @param $barcode
     * @param $color
     * @param $supplier_id
     * @return string
     */
    public function actionSearchMatches( $sku, $barcode, $color, $supplier_id )
    {
        // getting parent id
        $product = $this->actionFindProductBySku( $sku );

        // getting color id
        $color_id = $this->actionFindColorByName( $color );

        // if any products
        if( isset( $product->id ) )
        {
            // getting matches with sub product
            $matches = $this->actionLogSubProduct( $product->id, $color_id, $barcode, $supplier_id );

            // getting match uri
            return $matches->uri;
        }

        // else return nothing
        return '';
    }

    /**
     * Searching for errors by line
     * and party identifier
     * Getting count of errors
     * @param $file_line
     * @param $party_id
     * @return mixed
     */
    protected function actionSearchErrorsByLineAndParty( $file_line, $party_id )
    {
        // restrict statuses
        $error = $this->fat->actionSearchStatusByPhrase( 'ERROR' );

        // getting errors
        $errors = ImportLogPartiesProcessModel::where( 'file_line', $file_line )
            ->where( 'party_id', $party_id )
            ->where( 'fat_status_id', $error )
            ->count();

        // getting errors count
        return $errors;
    }

    /**
     * Getting data about fat status
     * if no fat status selected
     * make search by Every status
     * @param $party_id
     * @param null $fat_status_id
     * @return mixed
     */
    protected function actionGetDataByFatStatus( $party_id, $fat_status_id = null )
    {
        if( $fat_status_id == 0 )
        {
            $fat_status_id = null;
        }

        // make search
        $fat = ImportLogPartiesProcessModel::status( $party_id, $fat_status_id )
            ->groupBy('file_line')
            ->get(['file_line', 'fat_status_id']);

        return $fat;
    }

    /**
     * Getting distinct fat statuses
     * @return mixed
     */
    protected function actionGetDistinctFatStatus()
    {
        // restrict statuses
        $new_item = $this->fat->actionSearchStatusByPhrase( 'NEW' );

        $fat = ImportFatStatusModel::where( 'id', $new_item )
            ->get();

        return $fat;
    }

}