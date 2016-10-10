<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 17:25
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

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'party_id', 'share_id',
        'made_by',
    ];

    public function party()
    {
        return $this->hasOne(ImportPartiesModel::class, 'id', 'party_id');
    }

    public function share()
    {
        return $this->hasOne(ImportSalesShareModel::class, 'id', 'share_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'made_by');
    }

}