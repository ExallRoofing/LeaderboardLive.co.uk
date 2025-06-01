<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;

class ScoreSubmissionController extends Controller
{
    public function create(Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }

        $entry->load('clubCompetition.course');
        $competition = $entry->clubCompetition;
        $course = $competition->course;

        return view('scores.submit', compact('entry', 'competition', 'course'));
    }

    public function store(Request $request, Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'scores' => 'required|array|size:18',
            'scores.*' => 'required|integer|min:1|max:15',
        ]);

        $entry->hole_by_hole_scores = $validated['scores'];
        $entry->played_at = now();
        $entry->save();

        // Optional: trigger notification to attester

        return redirect()->route('competitions.index')->with('success', 'Score submitted and pending verification.');
    }

    public function view(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $competition = $entry->clubCompetition;
        $course = $competition->course; // adjust if relationship is named differently

        return view('scores.view', [
            'entry' => $entry,
            'competition' => $competition,
            'course' => $course,
        ]);
    }

}
