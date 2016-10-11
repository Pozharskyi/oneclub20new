<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 22:46
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;

class ImportPartiesStatusesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_statuses';

    protected $fillable = [];

    public function parties()
    {
        return $this->hasMany(ImportIndexPartiesModel::class, 'id', 'import_parties_status_id');
    }

}