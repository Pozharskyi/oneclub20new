<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:32
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportIndexSalesModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_index_sales';

    protected $fillable = [
        'sale_name', 'sale_start_date',
        'sale_end_date', 'sale_days_count',
        'made_by', 'buyer_id',
    ];

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function salesLogDelete()
    {
        return $this->hasMany(ImportSalesLogDeleteModel::class, 'id', 'import_index_sale_id');
    }

    public function salesLogEdit()
    {
        return $this->hasMany(ImportSalesLogEditModel::class, 'id', 'import_index_sale_id');
    }

    public function salesAssociation()
    {
        return $this->hasMany(ImportSalesAssociationModel::class, 'id', 'import_index_sale_id');
    }

    public function salesAssociationLog()
    {
        return $this->hasMany(ImportSalesAssociationLogModel::class, 'id', 'import_index_sale_id');
    }
}