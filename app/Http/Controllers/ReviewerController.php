<?php

namespace App\Http\Controllers;

use App\Models\User;

class ReviewerController extends Controller
{
    public function show(User $user)
    {
        $reviews = $user->reviews()
            ->with('eatery')
            ->latest()
            ->get();

        return view('reviewers.show', compact('user', 'reviews'));
    }
}