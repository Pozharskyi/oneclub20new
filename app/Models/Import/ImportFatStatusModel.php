<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 17:44
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImportFatStatusModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_fat_status';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'fat_status', 'short_phrase',
    ];

    public function logSalesAssociation()
    {
        return $this->hasMany(ImportLogSalesAssociationModel::class, 'id', 'fat_status_id');
    }

    public function logPartiesProcess()
    {
        return $this->hasMany(ImportFatStatusModel::class, 'id', 'fat_status_id');
    }

    public function fatAllocation()
    {
        return $this->hasMany(ImportFatAllocationStatusModel::class, 'id', 'fat_status_id');
    }

    public function scopeFindStatus( $query, $find )
    {
        $query->where( 'short_phrase', 'LIKE', $find );
    }
}