<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 14:29
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImportFatAssociationStatusModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_fat_association_status';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [];

    protected $hidden = [
        'short_phrase'
    ];

    public function fatAllocation()
    {
        return $this->hasMany(ImportFatAllocationStatusModel::class, 'fat_association_id');
    }

    public function scopeSearch( Builder $query, $phrase )
    {
        $query->where( 'short_phrase', 'LIKE', '%' . $phrase . '%');
    }
}