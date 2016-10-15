<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:32
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class ImportPartiesWorkStatusesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_file_allocation';

    protected $fillable = [];

    public function partiesWorkLog()
    {
        return $this->hasMany(ImportPartiesWorkLogModel::class, 'id', 'work_status_id');
    }

}