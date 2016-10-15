<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:32
 */

namespace App\Models\Import;

use App\Models\Product\ProductModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesWorkLogModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_work_log';

    protected $fillable = [
        'file_allocation_id', 'dev_product_index_id',
        'file_line', 'work_status_id',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'dev_product_index_id');
    }

    public function partiesFileAllocation()
    {
        return $this->belongsTo(ImportPartiesFileAllocationModel::class, 'file_allocation_id');
    }

    public function workStatus()
    {
        return $this->belongsTo(ImportPartiesWorkStatusesModel::class, 'work_status_id');
    }

    public function scopeFilterByAllocation(Builder $query, $allocationId)
    {
        $query->where('file_allocation_id', $allocationId);

        return $query;
    }

}