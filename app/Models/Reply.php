<?php

namespace Forum\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo('Forum\User', 'user_id');
    }
}
