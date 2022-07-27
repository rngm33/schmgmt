<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsLiabilities extends Model
{
    protected $table='assets_liabilities';
    protected $fillable = [

        'type',
        'topic',
        'description',
        'assets_type',
        'amount',
        'created_by',
        'updated_by',
        'is_active',
        'date_np',
        'date',
        'time'
    ];

    // public  function getAssetsLiabititiesTypeMany(){
    //     return $this->hasMany(AssetsLiabilities::class,'')->select('id','agent_id','booked_serialno','is_active','date_np')->where('is_active','1');
    // }

}
