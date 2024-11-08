<?php

namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function all()
    {
        return Activity::query()
            ->join('projects', 'activities.project_id', '=', 'projects.id')
            ->join('employees', 'activities.employee_id', '=', 'employees.id')
            ->select(
                'projects.name as project',
                'employees.name as employee',
                'activities.date',
                'activities.hours'
            )
            ->get();
    }

    public function aggregate(array $aggregations)
    {
        $query = Activity::query()
            ->join('projects', 'activities.project_id', '=', 'projects.id')
            ->join('employees', 'activities.employee_id', '=', 'employees.id');

        foreach ($aggregations as $aggregation) {
            switch ($aggregation) {
                case 'project':
                    $query->addSelect('projects.name as project');
                    break;
                case 'employee':
                    $query->addSelect('employees.name as employee');
                    break;
                case 'date':
                    $query->addSelect('activities.date');
                    break;
            }
        }

        $query->addSelect(
            DB::raw('SUM(activities.hours) as "total hours"'),
        );

        foreach ($aggregations as $aggregation) {
            switch ($aggregation) {
                case 'project':
                    $query->groupBy('projects.name');
                    break;
                case 'employee':
                    $query->groupBy('employees.name');
                    break;
                case 'date':
                    $query->groupBy('activities.date');
                    break;
            }
        }

        return $query->get();
    }
}