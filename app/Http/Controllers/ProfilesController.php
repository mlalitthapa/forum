<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\User;

class ProfilesController extends Controller
{

    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user),
        ]);
    }

}
