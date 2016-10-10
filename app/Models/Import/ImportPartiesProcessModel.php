<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 17:30
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesProcessModel extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_process';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'party_id', 'in_process_atm',
        'in_process_total', 'fat_status',
        'file_base_path', 'is_confirmed',
    ];

    public function party()
    {
        $this->hasOne(ImportPartiesModel::class, 'party_id');
    }

    public function scopeFirstImport( $query )
    {
        $query->where('fat_status', 'В процессе')
            ->orderBy('id');
    }
}