<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 16:08
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesPhotosFoundsModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_photos_founds';

    protected $fillable = [
        'file_allocation_id', 'file_line',
        'photo_uri',
    ];

    public function partiesAllocation()
    {
        return $this->belongsTo(ImportPartiesFileAllocationModel::class, 'file_allocation_id');
    }

    public function scopeTotalMatch(Builder $query, $allocationId, $fileLine)
    {
        $query->where( 'file_allocation_id', $allocationId )
            ->where( 'file_line', $fileLine );

        return $query;
    }

}