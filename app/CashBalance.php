<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashBalance extends Model
{

    public  function getLuckyDraw(){
        return $this->belongsTo(LuckyDraw::class,'luckydraw_id')->select('id','name');
     }
     public  function getKista(){
        return $this->belongsTo(Kista::class,'kista_id')->select('id','name');
     }
     public function getDetail(){
        return $this->belongsTo(Detail::class,'detail_id')->select('id','payment_type','amount'); 
     }
    public  function getUserName(){
        return $this->belongsTo(User::class,'created_by');
     }
      
}
