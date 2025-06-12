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

    public function hourlySummary(Request $request)
    {
        $date = $request->query('date', Carbon::now()->toDateString());

        $results = Mood::selectRaw("
                EXTRACT(HOUR FROM created_at) as hour,
                COUNT(CASE WHEN emoji = 'happy' THEN 1 END) as happy,
                COUNT(CASE WHEN emoji = 'neutral' THEN 1 END) as neutral,
                COUNT(CASE WHEN emoji = 'sad' THEN 1 END) as sad
            ")
            ->whereDate('created_at', $date)
            ->groupByRaw("EXTRACT(HOUR FROM created_at)")
            ->orderByRaw("EXTRACT(HOUR FROM created_at)")
            ->get();

        $data = $results->map(function ($row) {
            return [
                'time' => Carbon::createFromTime((int) $row->hour)->format('g:00 A'),
                'happy' => (int) $row->happy,
                'neutral' => (int) $row->neutral,
                'sad' => (int) $row->sad,
            ];
        });

        return response()->json(['data' => $data]);
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
