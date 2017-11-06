<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{


    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     */
    public function store(Reply $reply)
    {
        return $reply->favorite();
    }

}
