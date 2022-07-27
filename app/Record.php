<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
            'title','amount','description','created_by','updated_by','is_active','date_np','date','time'
    ];


    public  function getUserName(){
        return $this->belongsTo(User::class,'created_by');
    }

}
