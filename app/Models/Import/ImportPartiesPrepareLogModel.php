<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:31
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesPrepareLogModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_prepare_log';

    protected $fillable = [
        'file_allocation_id', 'file_line',
        'prepare_status_id',
    ];

    public function partiesFileAllocation()
    {
        return $this->belongsTo(ImportPartiesFileAllocationModel::class, 'file_allocation_id');
    }

    public function prepareStatus()
    {
        return $this->belongsTo(ImportPartiesPrepareStatusesModel::class, 'prepare_status_id');
    }

    public function scopeFilterByAllocationErrors(Builder $query, $fileAllocation, $okStatus)
    {
        $query->where('file_allocation_id', $fileAllocation)
            ->where('prepare_status_id', '<>', $okStatus);

        return $query;
    }

    public function scopeFilterByAllocation(Builder $query, $fileAllocation)
    {
        $query->where('file_allocation_id', $fileAllocation);

        return $query;
    }
}