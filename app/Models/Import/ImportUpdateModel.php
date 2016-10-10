<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 20:06
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportUpdateModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_update';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'update_name', 'recommended_start',
        'made_by',
    ];

    public function importUpdateProcess()
    {
        return $this->belongsTo(ImportUpdateProcessModel::class, 'id', 'update_id');
    }

    public function importLogUpdateProcess()
    {
        return $this->belongsTo(ImportLogUpdateProcessModel::class, 'id', 'update_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'made_by');
    }

    public function scopeSearch( Builder $query, $fields )
    {
        foreach( $fields as $row => $field )
        {
            $query->where( $row, $field );
        }
    }

}