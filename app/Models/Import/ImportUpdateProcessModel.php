<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 20:04
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportUpdateProcessModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_update_process';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'update_id', 'in_process_atm',
        'in_process_total', 'file_base_path',
        'fat_status_id',
    ];

    public function importUpdate()
    {
        return $this->hasOne(ImportUpdateModel::class, 'id', 'update_id');
    }

    public function scopeFirstImport( $query )
    {
        $query->where('fat_status', 'В процессе')
            ->orderBy('id');
    }

}