<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPaidFirst extends Model
{
    public  function getClientInfo(){
        return $this->belongsTo(Client::class,'client_id')->select('id','name','address','phone','serial_no','is_leave');
    }
}
