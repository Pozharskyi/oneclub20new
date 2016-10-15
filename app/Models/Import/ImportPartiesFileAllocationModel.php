<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:30
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Scope;

class ImportPartiesFileAllocationModel extends Model
{
    use SoftDeletes;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'dev_import_parties_file_allocation';

    protected $guarded = ['id'];

    protected $fillable = [
        'import_index_party_id', 'import_file_path',
        'file_lines_processed', 'file_lines_total',
        'made_by', 'allocation_status',
    ];

    public function parties()
    {
        return $this->belongsTo(ImportIndexPartiesModel::class, 'import_index_party_id');
    }

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    public function partiesCoincidenceLog()
    {
        return $this->hasMany(ImportPartiesCoincidenceLogModel::class, 'id', 'file_allocation_id');
    }

    public function partiesPrepareLog()
    {
        return $this->hasMany(ImportPartiesPrepareLogModel::class, 'id', 'file_allocation_id');
    }

    public function partiesWorkLog()
    {
        return $this->hasMany(ImportPartiesWorkLogModel::class, 'id', 'file_allocation_id');
    }

    public function partiesPhotosFounds()
    {
        return $this->hasMany(ImportPartiesPhotosFoundsModel::class, 'id', 'file_allocation_id');
    }

    public function scopeFilterParties(Builder $query, $party_id)
    {
        $query->where( 'import_index_party_id', $party_id );

        return $query;
    }
}