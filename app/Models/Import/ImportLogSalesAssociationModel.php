<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 18:18
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class ImportLogSalesAssociationModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_log_parties_process';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'party_id', 'file_line',
        'fat_status_id',
    ];

    public function fatStatus()
    {
        $this->hasOne(ImportFatStatusModel::class, 'id', 'fat_status_id');
    }

}