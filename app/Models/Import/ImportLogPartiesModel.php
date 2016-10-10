<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 18:43
 */

namespace App\Models\Import;

use App\Models\Product\ProductModel;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ImportLogPartiesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_log_parties';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'party_id', 'modify_type',
        'product_id', 'made_by',
    ];

    public function party()
    {
        $this->hasOne(ImportPartiesModel::class, 'id', 'party_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function user()
    {
        $this->hasOne(User::class, 'id', 'made_by');
    }

}