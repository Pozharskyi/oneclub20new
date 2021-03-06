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

class ImportPartiesCoincidenceStatusesModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_coincidence_statuses';

    protected $fillable = [];

    public function partiesCoincidenceLog()
    {
        return $this->hasMany(ImportPartiesCoincidenceLogModel::class, 'id', 'coincidence_status_id');
    }

    public function scopeFindStatus(Builder $query, $prepareStatus)
    {
        $query->where('short_phrase', $prepareStatus);

        return $query;
    }

}