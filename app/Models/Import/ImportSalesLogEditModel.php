<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:33
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ImportSalesLogEditModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_log_edit';

    public function sales()
    {
        return $this->belongsTo(ImportIndexSalesModel::class, 'import_index_sale_id');
    }

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }


}