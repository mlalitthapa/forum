<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 11/6/17
 * Time: 10:40 PM
 */

namespace App\Models\Traits;


use App\Models\Favorite;

trait Favoritable
{

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorite');
    }

    /**
     * @return bool
     */
    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}