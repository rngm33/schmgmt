<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DigitalBalance extends Model
{
    protected $fillable = [
        'type','wallet_name','wallet_id','amount','created_by','updated_by','is_active','date_np','date','time'
      ];

      public  function getUserName(){
         return $this->belongsTo(User::class,'created_by');
      }
}
