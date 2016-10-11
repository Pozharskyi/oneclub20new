<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 20:32
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportSalesAssociationModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_sales_association';

    public function sales()
    {
        return $this->belongsTo(ImportIndexSalesModel::class, 'import_index_sale_id');
    }

    public function parties()
    {
        return $this->belongsTo(ImportIndexPartiesModel::class, 'import_index_party_id');
    }

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }
}