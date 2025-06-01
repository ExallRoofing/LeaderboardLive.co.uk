<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\ClubCompetition;

class DashboardController extends Controller
{
    public function index()
    {
        $recentEntries = Entry::with('clubCompetition')
            ->where('user_id', auth()->id())
            ->where('verified', true)
            ->where('paid', true)
            ->latest('played_at')
            ->take(5)
            ->get();

        $upcomingCompetitions = ClubCompetition::where('competition_date', '>=', now())
            ->orderBy('competition_date')
            ->take(5)
            ->get();

        $topPlayers = Entry::where('verified', true)
            ->orderBy('net_score', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact('recentEntries', 'upcomingCompetitions', 'topPlayers'));
    }
}
