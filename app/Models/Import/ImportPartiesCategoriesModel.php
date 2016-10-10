<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 19:08
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPartiesCategoriesModel extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_parties_categories';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    public function parties()
    {
        $this->hasMany(ImportPartiesCategoriesModel::class, 'id', 'party_category_id');
    }

}