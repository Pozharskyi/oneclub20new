<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:29
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportIndexPartiesModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_index_parties';

    protected $fillable = [
        'import_supplier_id', 'party_name', 'party_start_date',
        'party_end_date', 'party_days_count', 'made_by', 'buyer_id',
        'support_id', 'import_index_categories_id', 'import_parties_status_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(ImportIndexSuppliersModel::class, 'import_supplier_id');
    }

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function support()
    {
        return $this->belongsTo(User::class, 'support_id');
    }

    public function importCategory()
    {
        return $this->belongsTo(ImportIndexCategoriesModel::class, 'import_index_categories_id');
    }

    public function partiesLogDelete()
    {
        return $this->hasMany(ImportPartiesLogDeleteModel::class, 'id', 'import_index_party_id');
    }

    public function partiesLogEdit()
    {
        return $this->hasMany(ImportPartiesLogEditModel::class, 'id', 'import_index_party_id');
    }

    public function salesAssociation()
    {
        return $this->hasMany(ImportSalesAssociationModel::class, 'id', 'import_index_party_id');
    }

    public function salesAssociationLog()
    {
        return $this->hasMany(ImportSalesAssociationLogModel::class, 'id', 'import_index_party_id');
    }

    public function partiesStatus()
    {
        return $this->belongsTo(ImportPartiesStatusesModel::class, 'import_parties_status_id');
    }

    public function scopeSortByBuyer( Builder $query, $buyer_id )
    {
        if( !is_null( $buyer_id ) )
        {
            $query->where( 'buyer_id', $buyer_id );
        }
    }

}