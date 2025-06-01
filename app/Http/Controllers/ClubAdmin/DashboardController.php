<?php

namespace App\Http\Controllers\ClubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClubCompetition;
use App\Models\Entry;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $competitionCount = ClubCompetition::count();
        $entryCount = Entry::count();
        $playerCount = User::count();

        $recentEntries = Entry::with('clubCompetition', 'user')->latest()->take(5)->get();

        return view('club.dashboard', compact('competitionCount', 'entryCount', 'playerCount', 'recentEntries'));
    }
}
