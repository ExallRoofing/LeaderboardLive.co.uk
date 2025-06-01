<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class MyEntriesController extends Controller
{
    public function entries()
    {
        $user = auth()->user();

        $entries = Entry::with(['clubCompetition', 'clubCompetition.course'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('entries.index', compact('entries'));
    }
}
