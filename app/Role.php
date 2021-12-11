<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    protected $fillable = [
      'name',
    ];
//Role of specific user
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
