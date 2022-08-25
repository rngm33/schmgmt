<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table='voucher';

    public  function getAgentDetail(){
        return $this->belongsTo(Agent::class,'agent_id');
    }
    public  function getKistaDetail(){
        return $this->belongsTo(Kista::class,'kista_id');
    }
    public  function getClientDetail(){
        return $this->belongsTo(Client::class,'client_id');
    }
    public  function getClientInfo(){
        return $this->belongsTo(Client::class,'client_id')->select('id','name','address','phone','serial_no','is_leave');
    }
    public function getVoucherInfo(){
        return $this->belongsTo(Voucher::class,'voucher_id')->select('id','amt_to_be_paid','amount_paid','payment_type');
    }
}
