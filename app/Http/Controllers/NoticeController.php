<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function store(Request $request, ClubCompetition $competition)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $competition->notices()->create([
            'title' => $request->title,
            'body' => $request->body,
            'published_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Notice posted.');
    }
}
