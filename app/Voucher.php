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
}
