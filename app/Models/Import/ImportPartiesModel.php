<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 17:07
 */

namespace App\Models\Import;

use App\Models\Product\SubProductModel;
use App\Models\Supplier\SupplierModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesModel extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'party_name', 'supplier_id', 'party_category_id',
        'recommended_start', 'recommended_end',
        'made_by',
    ];

    protected $dates = [
        'recommended_start', 'recommended_end',
    ];

    public function supplier()
    {
        return $this->hasOne(SupplierModel::class, 'id', 'supplier_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'made_by');
    }

    public function salesAssociation()
    {
        return $this->hasMany(ImportSalesAssociationModel::class, 'id', 'party_id');
    }

    public function partiesProcess()
    {
        return $this->hasOne(ImportPartiesProcessModel::class, 'party_id');
    }

    public function logPartiesModel()
    {
        return $this->hasMany(ImportLogPartiesProcessModel::class, 'id', 'party_id');
    }

    public function logParties()
    {
        return $this->hasMany(ImportLogPartiesModel::class, 'id', 'party_id');
    }

    public function partiesCategory()
    {
        return $this->hasOne(ImportPartiesCategoriesModel::class, 'id', 'party_category_id');
    }

    public function subProduct()
    {
        return $this->hasMany(SubProductModel::class, 'dev_import_parties_id');
    }

    public function scopeSearch( $query, $fields )
    {
        foreach( $fields as $row => $field )
        {
            $query->where( $row, $field );
        }
    }

    public function scopeActive( Builder $query )
    {
        $query->where( 'recommended_start', '<=', Carbon::now() )
            ->where( 'recommended_end', '>=', Carbon::now() );

        return $query;
    }
}