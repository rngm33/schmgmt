<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankBalance extends Model
{
      protected $fillable = [
        'type','bank_name','account_no','address','phone','description','amount','created_by','updated_by','is_active','date_np','date','time'
      ];

      public  function getUserName(){
         return $this->belongsTo(User::class,'created_by');
      }

}
