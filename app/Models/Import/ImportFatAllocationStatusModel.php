<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 14:32
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class ImportFatAllocationStatusModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_fat_allocation_status';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [];

    public function fatAssociation()
    {
        return $this->hasOne(ImportFatAssociationStatusModel::class, 'id', 'fat_association_id');
    }

    public function fatStatus()
    {
        return $this->hasOne(ImportFatStatusModel::class, 'id', 'fat_status_id');
    }

}