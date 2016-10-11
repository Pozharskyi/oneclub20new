<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:31
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesCoincidenceLogModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_coincidence_log';

    public function partiesFileAllocation()
    {
        return $this->belongsTo(ImportPartiesFileAllocationModel::class, 'file_allocation_id');
    }

    public function coincidenceStatus()
    {
        return $this->belongsTo(ImportPartiesCoincidenceStatusesModel::class, 'coincidence_status_id');
    }

}