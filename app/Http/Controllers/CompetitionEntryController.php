<?php

namespace App\Http\Controllers;

use App\Models\ClubCompetition;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditTransaction;

class CompetitionEntryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Open competitions the user has NOT entered
        $openCompetitions = \App\Models\ClubCompetition::with('entries')
            ->where('club_id', $user->club_id)
            ->where('is_open', true)
            ->where('registration_deadline', '>', now())
            ->whereDoesntHave('entries', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('competition_date')
            ->get();

        // All competitions the user has entered
        $userCompetitions = $user->entries()
            ->with('clubCompetition')
            ->latest()
            ->get();

        return view('competitions.index', compact('openCompetitions', 'userCompetitions'));
    }

    public function enter($id)
    {
        $user = Auth::user();
        $competition = ClubCompetition::findOrFail($id);

        $alreadyEntered = Entry::where('user_id', $user->id)
            ->where('club_competition_id', $id)
            ->exists();

        if ($alreadyEntered) {
            return back()->with('error', 'You have already entered this competition.');
        }

        // Deduct from credit if available
        if ($user->credit_balance >= 2.50) {
            $user->credit_balance -= 2.50;
            $user->save();

            CreditTransaction::create([
                'user_id' => $user->id,
                'club_competition_id' => $competition->id,
                'amount' => -2.50,
                'type' => 'Entry Fee',
                'description' => 'Entry Fee Paid with Credit - ' . $competition->competition_name,
            ]);

        } else {
            // In the future, hook in Stripe here
            // For now, assume they paid
        }

        Entry::create([
            'user_id' => $user->id,
            'club_competition_id' => $id,
            'paid' => true,
            'net_score' => 0,
            'gross_score' => 0,
            'playing_handicap' => 0,
        ]);

        return back()->with('success', 'You have been entered into the competition.');
    }

    public function unregister($id)
    {
        $user = Auth::user();

        $entry = Entry::where('user_id', $user->id)
            ->where('club_competition_id', $id)
            ->first();

        if ($entry && now()->lt($entry->clubCompetition->registration_deadline)) {
            if ($entry->paid) {
                // Refund credit
                $user->credit_balance += 2.50;
                $user->save();

                // Save transaction
                CreditTransaction::create([
                    'user_id' => $user->id,
                    'club_competition_id' => $entry->clubCompetition->id,
                    'amount' => 2.50,
                    'type' => 'Refund',
                    'description' => 'Entry Fee Refunded - ' . $entry->clubCompetition->competition_name,
                ]);
            }

            $entry->delete();

            return back()->with('success', 'You have been unregistered and your entry fee has been credited.');
        }

        return back()->with('error', 'Unregistration not allowed.');
    }

}
