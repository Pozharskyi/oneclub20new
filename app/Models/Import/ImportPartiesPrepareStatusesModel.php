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

class ImportPartiesPrepareStatusesModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_prepare_statuses';

    protected $fillable = [];

    public function partiesPrepareLog()
    {
        return $this->hasMany(ImportPartiesPrepareLogModel::class, 'id', 'prepare_status_id');
    }

}