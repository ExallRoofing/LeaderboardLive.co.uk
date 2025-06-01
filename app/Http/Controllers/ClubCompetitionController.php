<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClubCompetition;
use App\Models\Course;
use App\Models\TournamentWeek;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class ClubCompetitionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display list of competitions.
     * Roles: player / club_admin
     */
    public function index()
    {
        if (auth()->user()->hasRole('club_admin')) {
            $competitions = ClubCompetition::withCount('entries')->where('club_id', auth()->user()->club_id)->latest()->get();

            return view('club.competitions.index', compact('competitions'));
        }

        $competitions = ClubCompetition::where('is_open', true)->get();
        return view('competitions.index', compact('competitions'));
    }

    /**
     * Show competition details
     * Roles: player
     */
    public function show($id)
    {
        $competition = ClubCompetition::findOrFail($id);

        return view('competitions.show', [
            'competition' => $competition,
            'entries' => $competition->entries()->with('user')->get(),
            'userHasEntered' => $competition->entries()->where('user_id', auth()->id())->exists(),
        ]);
    }

    /**
     * Download iCal calendar.
     * Roles: player
     */
    public function calendar(ClubCompetition $competition)
    {
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "BEGIN:VEVENT\r\n";
        $ical .= "SUMMARY:" . $competition->competition_name . "\r\n";
        $ical .= "DTSTART:" . $competition->competition_date->format('Ymd\THis\Z') . "\r\n";
        $ical .= "DTEND:" . $competition->competition_date->addHours(5)->format('Ymd\THis\Z') . "\r\n";
        $ical .= "DESCRIPTION:Join us at " . $competition->club->name . "\r\n";
        $ical .= "END:VEVENT\r\n";
        $ical .= "END:VCALENDAR\r\n";

        return Response::make($ical, 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="competition.ics"',
        ]);
    }

    /**
     * Display competition results.
     * Roles: player / club_admin
     */
    public function results()
    {
        $user = auth()->user();

        if ($user->hasRole('club_admin')) {
            $results = ClubCompetition::with(['entries.user'])
                ->where('club_id', $user->club_id)
                ->whereNotNull('results_published_at')
                ->orderByDesc('competition_date')
                ->get();

            return view('club.competitions.results', compact('results'));
        }

        $competitions = ClubCompetition::with(['entries.user'])
            ->whereNotNull('results_published_at')
            ->orderByDesc('competition_date')
            ->get();

        return view('results.index', compact('competitions'));
    }

    /**
     * Publish competition results.
     * Roles: club_admin
     */
    public function publishResults(ClubCompetition $competition)
    {
        $user = auth()->user();

        if (!$user->isClubAdminOf($competition->club_id)) {
            abort(403);
        }

        $competition->results_published_at = now();
        $competition->save();

        return back()->with('success', 'Results published successfully.');
    }

    /**
     * Show new competition form.
     * Roles: club_admin
     */
    public function create()
    {
        $courses = auth()->user()->club->courses()->orderBy('name')->get();
        return view('club.competitions.create', compact('courses'));
    }

    /**
     * Save the new competition.
     * Roles: club_admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'competition_name' => 'required|string|max:255',
            'competition_date' => 'required|date',
            'registration_deadline' => 'required|date|before_or_equal:competition_date',
        ]);

        $tournamentWeek = TournamentWeek::whereDate('start_date', '<=', $validated['competition_date'])
            ->whereDate('end_date', '>=', $validated['competition_date'])
            ->first();

        $competition = new ClubCompetition($validated);
        $competition->club_id = auth()->user()->club_id;
        $competition->tournament_week_id = optional($tournamentWeek)->id;
        $competition->save();

        return redirect()->route('club.competitions')->with('success', 'Competition created successfully.');
    }

    /**
     * Delete the competition.
     * Roles: club_admin
     */
    public function destroy($id)
    {
        $competition = ClubCompetition::withCount('entries')->findOrFail($id);

        // Ensure this competition belongs to the logged-in admin's club
        if ($competition->club_id !== auth()->user()->club_id) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent deletion if there are any entries
        if ($competition->entries_count > 0) {
            return redirect()->back()->with('error', 'Cannot delete a competition with player entries.');
        }

        $competition->delete();

        return redirect()->route('club.competitions')->with('success', 'Competition deleted successfully.');
    }

    /**
     * Toggle the competition status.
     * Roles: club_admin
     */
    public function toggleStatus($id)
    {
        $competition = ClubCompetition::findOrFail($id);

        $this->authorize('update', $competition);

        $competition->is_open = !$competition->is_open;
        $competition->save();

        return redirect()->back()->with('success', 'Competition status updated.');
    }

    /**
     * Show the edit competition form.
     * Roles: club_admin
     */
    public function edit($id)
    {
        $competition = ClubCompetition::findOrFail($id);

        $this->authorize('update', $competition);

        $courses = auth()->user()->club->courses()->orderBy('name')->get();

        return view('club.competitions.edit', compact('competition', 'courses'));
    }

    /**
     * Save the competition data.
     * Roles: club_admin
     */
    public function update(Request $request, ClubCompetition $competition)
    {
        // Authorization: ensure the user is allowed to update this competition
        $this->authorize('update', $competition);

        // Validation
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'competition_name' => 'required|string|max:255',
            'competition_date' => 'required|date',
            'registration_deadline' => 'required|date|before_or_equal:competition_date',
        ]);

        // Determine the correct tournament week
        $tournamentWeek = TournamentWeek::whereDate('start_date', '<=', $validated['competition_date'])
            ->whereDate('end_date', '>=', $validated['competition_date'])
            ->first();

        // Update competition
        $competition->update([
            'course_id' => $validated['course_id'],
            'competition_name' => $validated['competition_name'],
            'competition_date' => $validated['competition_date'],
            'registration_deadline' => $validated['registration_deadline'],
            'tournament_week_id' => optional($tournamentWeek)->id,
        ]);

        return redirect()
            ->route('club.competitions')
            ->with('success', 'Competition updated successfully.');
    }

}
