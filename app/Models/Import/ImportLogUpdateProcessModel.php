<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 20:11
 */

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportLogUpdateProcessModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_log_update_process';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'update_id', 'file_line',
        'fat_status_id', 'sub_product_id',
        'message'
    ];

    public function importUpdate()
    {
        return $this->hasOne(ImportUpdateModel::class, 'id', 'update_id');
    }

    public function importUpdateFatStatus()
    {
        return $this->hasOne(ImportUpdateFatStatusModel::class, 'id', 'update_fat_status_id');
    }

    public function scopeStatus( $query, $update_id, $fat_status_id )
    {
        if( !is_null( $update_id ) )
        {
            $query->where( 'update_id', $update_id );
        }

        if( is_array( $fat_status_id ) )
        {
            $query->where( function( $query )  use ( $fat_status_id  )
            {
                $i = 0;

                foreach( $fat_status_id as $status )
                {
                    if( $i == 0 )
                    {
                        $query->where( 'fat_status_id', $status );
                    } else
                    {
                        $query->orWhere( 'fat_status_id', $status );
                    }

                    $i++;
                }
            });
        } elseif( !is_null( $fat_status_id ) )
        {
            $query->where( 'fat_status_id', $fat_status_id );
        }
    }

    public function scopeSearch( Builder $query, $update_id, $file_line, $statuses )
    {
        $query->where( 'update_id', $update_id )
            ->where( 'file_line', $file_line )
            ->where( function( $query )  use ( $statuses )
            {
                $i = 0;

                foreach( $statuses as $status )
                {
                    if( $i == 0 )
                    {
                        $query->where( 'fat_status_id', $status );
                    } else
                    {
                        $query->orWhere( 'fat_status_id', $status );
                    }

                    $i++;
                }
            });
    }


}