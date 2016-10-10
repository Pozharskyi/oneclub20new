<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 17:20
 */

namespace App\Models\Import;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportSalesShareModel extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_sales_share';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'sales_share_name',
        'sales_share_start', 'sales_share_end',
        'first_header', 'second_header',
        'made_by',
    ];

    protected $dates = [
        'sales_share_start', 'sales_share_end',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'made_by');
    }

    public function salesAssociation()
    {
        return $this->hasMany(ImportSalesAssociationModel::class, 'share_id');
    }

    public function scopeSearch( $query, $search )
    {
        $query->where( 'sales_share_name', 'LIKE', '%' . $search . '%' )
            ->orWhere( 'sales_share_start', 'LIKE', '%' . $search . '%' )
            ->orWhere( 'sales_share_end', 'LIKE', '%' . $search . '%' )
            ->orWhere( 'id', $search );
    }

}