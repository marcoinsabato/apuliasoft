<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Activity;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $projects = Project::insertOrIgnore([
            ['id' => 1, 'name' => 'Mars Rover'],
            ['id' => 2, 'name' => 'Manhattan']
        ]);

        $employees = Employee::insertOrIgnore([
            ['id' => 1, 'name' => 'Mario'],
            ['id' => 2, 'name' => 'Giovanni'],
            ['id' => 3, 'name' => 'Lucia']
        ]);

        $activities = [];

        foreach ($this->data() as $item) {
            $activities[] = [
                'project_id' => $item['project']['id'],
                'employee_id' => $item['employee']['id'],
                'date' => $item['date'],
                'hours' => $item['hours'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Activity::insert($activities);
    }

    private function data(): array
    {
        return [
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
        ];
    }
}
