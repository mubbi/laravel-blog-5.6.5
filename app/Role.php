<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps  = false;

    /**
     * The Users that belong to the Role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
