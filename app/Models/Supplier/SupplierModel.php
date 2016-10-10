<?php

namespace App\Models\Supplier;

use App\Models\Import\ImportPartiesModel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductSupplierModel;

class SupplierModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_supplier';

    protected $fillable = [
        'name', 'shop', 'brands', 'phones', 'email',
        'coefficient', 'product_marga', 'time_of_returns',
        'work_status', 'work_comment', 'agreement', 'start_working',
        'payment_form', 'payment_postpone', 'ecommerce_comment',
        'address_sending', 'logistic_comment', 'address_return',
        'products_category', 'buyer_id', 'made_by',
    ];

    public function subProduct(){
        return $this->hasMany(ProductSupplierModel::class, 'supplier_id');
    }

    public function importParties()
    {
        return $this->hasMany(ImportPartiesModel::class, 'supplier_id');
    }

    public function buyer()
    {
        return $this->hasOne(User::class, 'id', 'buyer_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'made_by');
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
