<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 11/2/17
 * Time: 7:47 PM
 */

namespace App\Models\Filters;


use App\User;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular'];

    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular thread
     * @return mixed
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

}