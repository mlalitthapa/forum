<?php

namespace App\Models;

use App\Models\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable;

    protected $guarded = [];
    protected $with = ['owner', 'favorites'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
