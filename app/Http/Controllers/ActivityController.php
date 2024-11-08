<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class ActivityController extends Controller
{
    public function __construct(
        private ActivityService $activityService
    ){}

    /**
     * Get the activities with the given aggregations.
     * 
     * @param Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
{
    // The aggregations to be used
    $aggregations = collect($request->query('aggregations'));
    
    // The activities to be filtered
    if($aggregations->isEmpty()) {
        $activities = $this->activityService->all();
    } else {
        $activities = $this->activityService->aggregate($aggregations->toArray());
    }

    // The available aggregations
    $avaiableAggregations = [
        "project",
        "employee", 
        "date"
    ];

    // Return the result to the view
    return Inertia::render('Welcome', [
        'activities' => $activities,
        'avaiableAggregations' => $avaiableAggregations
    ]);
}
}
