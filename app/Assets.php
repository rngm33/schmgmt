<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AssetsLiabilities;

class Assets extends Model
{
    protected $fillable = [

        'category',
        'type'
    ];

    public  function getAssetsLiabititiesTypeMany(){
        return $this->hasMany(AssetsLiabilities::class,'assets_type');
    }

    
    public  function getAssetsStockTypeMany(){
        return $this->hasMany(AssetStock::class,'assets_id','id');
    }

}
