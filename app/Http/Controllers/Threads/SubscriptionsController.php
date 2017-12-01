<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Models\Thread;

class SubscriptionsController extends Controller
{

    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

}
