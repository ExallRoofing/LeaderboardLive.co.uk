<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topPlayers = Entry::where('verified', true)
            ->orderBy('net_score', 'asc')
            ->take(100)
            ->get();

        return view('leaderboard.index', compact('topPlayers'));
    }
}
