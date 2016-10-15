<?php

namespace App\Models\Category;

use App\Models\Product\ProductModel;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_index_categories';

    protected $fillable = [
        'category_name', 'parent_id', 'made_by'
    ];

    public function parent()
    {
        return $this->belongsTo(CategoryModel::class, 'parent_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    public function scopeParents( Builder $query )
    {
        $query->where('parent_id', '0');
    }

    public function scopeSearch( Builder $query, $category_name, $priority_level )
    {
        if( $priority_level == 0 )
        {
            $query->where( 'category_name', 'LIKE', '%' . $category_name . '%' );
        } else
        {
            $query->where( 'category_name', $category_name );
        }

        $query->where( 'parent_id', $priority_level );
    }

    public function scopeSearchLastCategory( Builder $query, $category )
    {
        $query->where( 'category_name', $category );

        return $query;
    }
}
