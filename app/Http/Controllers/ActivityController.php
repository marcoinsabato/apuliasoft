<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class ActivityController extends Controller
{
    /**
     * Get the activities with the given aggregations.
     * 
     * @param Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
{
    // The activities to be filtered
    $activities = collect([
        [
            "project" => ["id" => 1, "name" => "Mars Rover"],
            "employee" => ["id" => 1, "name" => "Mario"],
            "date" => "2021-08-26T22:00:00.000Z",
            "hours" => 5
        ],
        [
            "project" => ["id" => 2, "name" => "Manhattan"],
            "employee" => ["id" => 2, "name" => "Giovanni"],
            "date" => "2021-08-30T22:00:00.000Z",
            "hours" => 3
        ],
        [
            "project" => ["id" => 1, "name" => "Mars Rover"],
            "employee" => ["id" => 1, "name" => "Mario"],
            "date" => "2021-08-31T22:00:00.000Z",
            "hours" => 3
        ],
        [
            "project" => ["id" => 1, "name" => "Mars Rover"],
            "employee" => ["id" => 3, "name" => "Lucia"],
            "date" => "2021-08-31T22:00:00.000Z",
            "hours" => 3
        ],
        [
            "project" => ["id" => 2, "name" => "Manhattan"],
            "employee" => ["id" => 1, "name" => "Mario"],
            "date" => "2021-08-26T22:00:00.000Z",
            "hours" => 2
        ],
        [
            "project" => ["id" => 2, "name" => "Manhattan"],
            "employee" => ["id" => 2, "name" => "Giovanni"],
            "date" => "2021-08-31T22:00:00.000Z",
            "hours" => 4
        ]
    ]);



    // The aggregations to be used
    $aggregations = collect($request->query('aggregations'));

    // Check if any aggregations are selected
    $result = $aggregations->isEmpty() ? $activities : collect($activities->reduce(function ($carry, $activity) use ($aggregations) {
        // The key of the aggregation
        $key = $aggregations->map(function ($aggregation) use ($activity) {
            // Get the name of the aggregation
            return $activity[$aggregation]["name"] ?? $activity[$aggregation];
        })->join("_");

        // The purified activity with only the selected aggregations keys
        $purifiedActivity = collect($activity)->only($aggregations->toArray());

        // Add the activity to the result and update the hours
        $carry[$key] = [
            ...$purifiedActivity,
            "hours" => ($carry[$key]["hours"] ?? 0) + $activity["hours"]
        ];

        return $carry;
    }, []))->values();

    // The available aggregations
    $avaiableAggregations = [
        "project",
        "employee", 
        "date"
    ];

    // Return the result to the view
    return Inertia::render('Welcome', [
        'activities' => $result,
        'avaiableAggregations' => $avaiableAggregations
    ]);
}
}
