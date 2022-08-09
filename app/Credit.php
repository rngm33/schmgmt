<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [

        'category',
        'type'
    ];

    public  function getCreditsTypeMany(){
        return $this->hasMany(Purchase::class,'credit_type');
    }
}
