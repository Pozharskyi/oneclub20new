<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\SupplierModel;

class ProductSupplierModel extends Model
{
    protected $table = 'dev_product_supplier';

    protected $fillable = ['sub_product_id', 'supplier_id', 'qty', 'purshace_price'];

    public function supplier(){
        return $this->belongsTo(SupplierModel::class, 'id');
    }

    public function subProduct(){
        return $this->belongsTo(SubProductModel::class, 'id');
    }
}
