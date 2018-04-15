<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show')->with([
            'profileUser' => $user,
            'activities' => \App\Activity::feed($user),
        ]);
    }
}
