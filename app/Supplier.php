<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
     protected $fillable = [
          'name','address','phone','created_by','updated_by','is_active','date_np','date','time'
          ];
}
