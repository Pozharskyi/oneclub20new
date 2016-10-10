<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 20.09.2016
 * Time: 18:16
 */

namespace App\Models\Import;

use App\Models\Product\SubProductModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImportLogPartiesProcessModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_import_log_parties_process';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'party_id', 'file_line',
        'fat_status_id', 'message',
        'sub_product_id',
    ];

    public function party()
    {
        return $this->hasOne(ImportPartiesModel::class, 'id', 'party_id');
    }

    public function fat()
    {
        return $this->hasOne(ImportFatStatusModel::class, 'id', 'fat_status_id');
    }

    public function subProduct()
    {
        return $this->hasOne(SubProductModel::class, 'id', 'sub_product_id');
    }

    public function scopeStatus( $query, $party_id, $fat_status_id )
    {
        if( !is_null( $party_id ) )
        {
            $query->where( 'party_id', $party_id );
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

    public function scopeSearch( Builder $query, $party_id, $file_line, $statuses )
    {
        $query->where( 'party_id', $party_id )
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

    public function scopeExactStatus( Builder $query, $status )
    {
        return $query->where( 'fat_status_id', $status );
    }

    public function scopeFindSubProduct( Builder $query, $subProductId )
    {
        return $query->where('sub_product_id', $subProductId);
    }

    public function scopeConfirmationUpdate( Builder $query, $party_id, $file_line, $fat_status_id )
    {
        $query->where( 'party_id', $party_id )
            ->where( 'file_line', $file_line )
            ->where( 'fat_status_id', $fat_status_id );
    }

}