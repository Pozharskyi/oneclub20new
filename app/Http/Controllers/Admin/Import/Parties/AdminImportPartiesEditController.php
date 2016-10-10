<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 16:45
 */

namespace App\Http\Controllers\Admin\Import\Parties;


use App\Http\Controllers\Admin\Import\Core\AdminImportCategoriesTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Admin\Import\Core\AdminImportSupplierTrait;
use App\Models\Import\ImportLogPartiesProcessModel;
use App\Models\Import\ImportPartiesModel;
use App\Models\Import\ImportPartiesProcessModel;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

/**
 * Getting parties edit source for parties
 * based on party identity or request
 * Includes getting View, confirmation of party,
 * Getting categories, edit party
 * Class AdminImportPartiesEditController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesEditController extends AdminImportPartiesDescriptionController
{
    use AdminImportSupplierTrait;
    use AdminImportCategoriesTrait;
    /**
     * Getting edit View
     * by party identify
     * @param $party_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetEditView( $party_id, Request $request )
    {
        // getting info about party
        $info = $this->actionGetPartyInfo( $party_id );

        // getting suppliers
        $suppliers = $this->actionGetSuppliers();

        // getting categories
        $categories = $this->actionGetCategories();

        $message = $request->input('success');

        // if no alert success messages
        if( !isset( $message ) )
        {
            $message = null;
        }

        // getting view
        return view('admin.import.parties.edit', [
            'info' => $info,
            'suppliers' => $suppliers,
            'categories' => $categories,
            'party_id' => $party_id,
            'message' => $message,
        ]);
    }

    /**
     * Confirm party items in the end of approve
     * in Party controller parser
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionConfirmParty( Request $request )
    {
        // new fat instance
        $fat = new AdminImportFatStatusController();

        $party_id = $request->input('party_id');

        // getting approved identify
        $approved = $fat->actionSearchStatusByPhrase( 'APPROVED' );

        // getting switched identify
        $switched = $fat->actionSearchStatusByPhrase( 'SWITCHED' );

        // confirm party processed
        $this->actionConfirmPartyProcess( $party_id );

        // getting products information
        $products = ImportLogPartiesProcessModel::where( 'party_id', $party_id )
            ->where( function( $query ) use ( $approved, $switched )
            {
                $query->where('fat_status_id', $approved )
                    ->orWhere( 'fat_status_id', $switched );
            })->get(['sub_product_id']);

        // foreach product make as approved
        foreach( $products as $product )
        {
            try
            {
                $item = SubProductModel::findOrFail( $product->sub_product_id );
                $item->is_approved = '1';
                $item->save();
            } catch (\Exception $e) {
                return redirect('/admin/import/parties');
            }
        }

        // return redirect to main page of parties
        return redirect('/admin/import/parties');
    }

    /**
     * Getting party processed
     * If buyer clicks on submit button
     * in confirmation of party
     * @param $party_id
     */
    protected function actionConfirmPartyProcess( $party_id )
    {
        $party = ImportPartiesProcessModel::find( $party_id );
        $party->is_processed = '1';

        $party->save();
    }

    /**
     * Getting edit party Form Handler
     * Based on party identity
     * and Request
     * @param Request $request
     * @param $party_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionEditParty( Request $request, $party_id )
    {
        $party_name = $request->input('party_name');
        $supplier = $request->input('suppliers');
        $recommended_start = $request->input('recommended_start');
        $recommended_end = $request->input('recommended_end');
        $category_id = $request->input('category');

        try
        {
            // trying to update
            $party = ImportPartiesModel::findOrFail( $party_id );

            $party->party_name = $party_name;
            $party->supplier_id = $supplier;
            $party->recommended_start = $recommended_start;
            $party->recommended_end = $recommended_end;
            $party->party_category_id = $category_id;

            $party->save();

            // if success return nice response
            return redirect('/admin/import/parties/edit/' . $party_id . '?success=true');
        } catch( \Exception $e )
        {
            // if error return bad response
            return redirect('/admin/import/parties/edit/' . $party_id . '?success=false');
        }
    }

}