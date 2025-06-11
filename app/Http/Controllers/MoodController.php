<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mood;
use Carbon\Carbon;

class MoodController extends Controller
{
    public function store (Request $request)
    {
        $validated = $request->validate([
            'emoji' => 'required|in:happy,neutral,sad,angry,excited,bored',
        ]);

        Mood::create([
            'emoji' => $validated['emoji'],
            'created_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Mood recorded successfully'], 201);
    }


    public function summary(Request $request)
    {
        $date = $request->query('date', Carbon::now()->toDateString());

        $moods = Mood::whereDate('created_at', $date)
            ->selectRaw('emoji, count(*) as total')
            ->groupBy('emoji')
            ->pluck('total', 'emoji');

        return response()->json([
            'happy' => $moods['happy'] ?? 0,
            'neutral' => $moods['neutral'] ?? 0,
            'sad' => $moods['sad'] ?? 0,
        ]);
    }

    public function player(Request $request)
    {
        // $date = $request->query('date', Carbon::now()->toDateString());

        // $moods = Mood::whereDate('created_at', $date)
        //     ->selectRaw('emoji, count(*) as total')
        //     ->groupBy('emoji')
        //     ->pluck('total', 'emoji');

        // return response()->json([
        //     'happy' => $moods['happy'] ?? 0,
        //     'neutral' => $moods['neutral'] ?? 0,
        //     'sad' => $moods['sad'] ?? 0,
        //     'angry' => $moods['angry'] ?? 0,
        //     'excited' => $moods['excited'] ?? 0,
        //     'bored' => $moods['bored'] ?? 0,
        // ]);

        return response()->json([
            'message' => 'Player endpoint is not implemented yet',
        ], 501);
    }
}
