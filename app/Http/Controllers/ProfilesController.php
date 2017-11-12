<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{

    public function show(User $user)
    {

        $activities = $user->activity()->latest()->with('subject')->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y M d, D');
        });

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activities,
        ]);
    }

}
