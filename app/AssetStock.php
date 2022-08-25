<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetStock extends Model
{
    protected $fillable = [

        'asset_id',
        'sub_type'
    ];

}
