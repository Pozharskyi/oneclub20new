<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:29
 */

namespace App\Models\Import;

use App\Models\Product\SubProductModel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportIndexSuppliersModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_index_suppliers';

    protected $guarded = ['id'];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function parties()
    {
        return $this->hasMany(ImportIndexPartiesModel::class, 'id', 'import_supplier_id');
    }

    public function subProduct()
    {
        return $this->hasMany(SubProductModel::class, 'supplier_id');
    }

    public function scopeSearch($query, $search)
    {
        if ($search != '') {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('shop', 'LIKE', '%' . $search . '%')
                ->orWhere('brands', 'LIKE', '%' . $search . '%')
                ->orWhere('phones', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('address_sending', 'LIKE', '%' . $search . '%')
                ->orWhere('address_return', 'LIKE', '%' . $search . '%')
                ->orWhere('products_category', 'LIKE', '%' . $search . '%')
                ->orWhere('id', $search);
        }
    }
}