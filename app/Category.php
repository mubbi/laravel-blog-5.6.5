<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The category that belong to the blogs.
     */
    public function blogs()
    {
        return $this->belongsToMany('App\Blog');
    }
}
