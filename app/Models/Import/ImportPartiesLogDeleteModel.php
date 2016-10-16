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
use Illuminate\Database\Eloquent\Model;

class ImportPartiesLogDeleteModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_log_delete';

    protected $fillable = [
        'import_index_party_id', 'comment',
        'made_by',
    ];

    public function parties()
    {
        return $this->belongsTo(ImportIndexPartiesModel::class, 'import_index_party_id');
    }

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

}