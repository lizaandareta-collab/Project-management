<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maio;
use App\Models\Mapp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class App extends Controller
{
    public function inresponsible()
    {
        $resource = Maio::get_resource_mgmt();
        $lov = Maio::get_lov();

        $lov_emptype = $lov->where('INIT', 'emptype');
        $lov_empdept = $lov->where('INIT', 'empdept');

        foreach ($resource as $r) {
            $r->EMP_TYPE_ID = $r->EMP_TYPE;
            $r->DEPARTMENT_ID = $r->DEPARTMENT;
        }

        return view('template.wrapper', [
            'title' => 'Resource Management',
            'content' => 'pm.inresponsible',
            'resource' => $resource,
            'lov_emptype' => $lov_emptype,
            'lov_empdept' => $lov_empdept,
            'employees' => [],
        ]);
    }

    public function insert_resource(Request $request)
    {
        $insert = Mapp::insert_resource($request);

        if ($insert['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Resource berhasil disimpan!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $insert['message']
            ]);
        }
    }

    public function update_resource(Request $request)
    {
        $update = Mapp::update_resource($request);

        if ($update['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Resource berhasil diupdate!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $update['message']
            ]);
        }
    }

    public function delete_resource(Request $request)
    {
        $delete = Mapp::delete_resource($request);

        if ($delete['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Resource berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $delete['message']
            ]);
        }
    }

    public function inholiday()
    {
        $holiday = Maio::get_holiday_table();

        $data = [
            'title' => 'Input Holiday',
            'content' => 'pm.inholiday',
            'holiday' => $holiday
        ];

        return view('template.wrapper', $data);
    }

    public function holiday_save(Request $req)
    {
        $save = Mapp::insert_inholiday($req);
        return response()->json($save);
    }

    public function holiday_update(Request $req)
    {
        $update = Mapp::update_inholiday($req);
        return response()->json($update);
    }

    public function holiday_delete(Request $req)
    {
        $delete = Mapp::delete_inholiday($req->id);
        return response()->json($delete);
    }

    public function inclient()
    {
        $client = Maio::get_client_table();

        $data = [
            'title' => 'Input Client',
            'content' => 'pm.inclient',
            'client' => $client
        ];

        return view('template.wrapper', $data);
    }

    public function client_save(Request $req)
    {
        $save = Mapp::insert_inclient($req);
        return response()->json($save);
    }

    public function client_update(Request $req)
    {
        $update = Mapp::update_inclient($req);
        return response()->json($update);
    }

    public function client_delete(Request $req)
    {
        $delete = Mapp::delete_inclient($req->id);
        return response()->json($delete);
    }

    public function resource()
    {
        $projects = Maio::get_projects();
        $totalProjects = count($projects);

        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->ID);
            $allTasks = $allTasks->merge($projectTasks);
        }

        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->NPK);
        });

        $initialData = $this->processResourceData($allTasks, $resources);

        $data = [
            'title' => 'Resource Workload',
            'content' => 'pm.resource',
            'projects' => $projects,
            'initialData' => $initialData,
            'totalProjects' => $totalProjects
        ];
        return view('template.wrapper', $data);
    }

    public function getAllResourcesData()
    {
        try {
            $projects = Maio::get_projects();
            $totalProjects = count($projects);

            $allTasks = collect();
            foreach ($projects as $project) {
                $projectTasks = Maio::get_project_task($project->ID);
                $allTasks = $allTasks->merge($projectTasks);
            }

            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->NPK);
            });

            $resourceData = $this->processResourceData($allTasks, $resources);

            return response()->json([
                'success' => true,
                'data' => $resourceData,
                'stats' => [
                    'total_resources' => count($resourceData),
                    'total_projects' => $totalProjects,
                    'total_tasks' => $allTasks->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load resource data: ' . $e->getMessage()
            ]);
        }
    }

    private function processResourceData($tasks, $resources)
    {
        $resourceData = [];

        foreach ($resources as $resource) {
            $resourceData[$resource->EMP_NAME] = [
                'tasks' => 0,
                'plan_hours' => 0,
                'milestones' => 0,
                'projects' => []
            ];
        }

        foreach ($tasks as $task) {
            $responsibleName = $task->RESPONSIBLE_NAME ?: 'Unassigned';

            if (isset($task->STATUS) && $task->STATUS == '3') {
                continue;
            }

            $isMilestone70 = (isset($task->IS_MILESTONE) && $task->IS_MILESTONE == '70');
            if ($isMilestone70) {
                continue;
            }

            if (isset($resourceData[$responsibleName])) {
                $resourceData[$responsibleName]['tasks']++;
                $resourceData[$responsibleName]['plan_hours'] += floatval($task->PLAN_HOUR ?: 0);

                if ($task->PROJECT_NAME && !in_array($task->PROJECT_NAME, $resourceData[$responsibleName]['projects'])) {
                    $resourceData[$responsibleName]['projects'][] = $task->PROJECT_NAME;
                }

                if (isset($task->IS_MILESTONE) && $task->IS_MILESTONE == '1') {
                    $resourceData[$responsibleName]['milestones']++;
                }
            } else {

                if (!isset($resourceData['Unassigned'])) {
                    $resourceData['Unassigned'] = [
                        'tasks' => 0,
                        'plan_hours' => 0,
                        'milestones' => 0,
                        'projects' => []
                    ];
                }

                $resourceData['Unassigned']['tasks']++;
                $resourceData['Unassigned']['plan_hours'] += floatval($task->PLAN_HOUR ?: 0);

                if (isset($task->IS_MILESTONE) && $task->IS_MILESTONE == '1') {
                    $resourceData['Unassigned']['milestones']++;
                }
            }
        }

        return $resourceData;
    }

    public function heatmap()
    {
        $projects = Maio::get_projects();
        $totalProjects = count($projects);

        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->NPK);
        })->map(function ($r) {
            $r->npk = $r->NPK;
            $r->emp_name = $r->EMP_NAME;
            return $r;
        });

        $holidays = Maio::get_holiday();

        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->ID);
            $allTasks = $allTasks->merge($projectTasks);
        }

        $yearRange = $this->getYearRangeFromTasks($allTasks);

        if (empty($yearRange)) {
            $currentYear = date('Y');
            $yearRange = [
                'min' => $currentYear - 1,
                'max' => $currentYear + 1
            ];
        }

        $heatmapData = $this->processHeatmapData($allTasks, 'planned', '');

        $data = [
            'title' => 'Tasks Heatmap',
            'content' => 'pm.heatmap',
            'totalProjects' => $totalProjects,
            'initialHeatmapData' => $heatmapData,
            'resources' => $resources,
            'holidays' => $holidays,
            'yearRange' => $yearRange
        ];

        return view('template.wrapper', $data);
    }
    private function getYearRangeFromTasks($tasks)
{
    $years = [];

    foreach ($tasks as $task) {
        if (isset($task->IS_MILESTONE) && $task->IS_MILESTONE == '70') {
            continue;
        }

        // Cek semua date fields termasuk actual agar year range lengkap
        $dateFields = ['PLAN_START', 'PLAN_END', 'ACTUAL_START', 'ACTUAL_END'];

        foreach ($dateFields as $field) {
            if (!empty($task->$field)) {
                try {
                    $date    = Carbon::parse($task->$field);
                    $years[] = $date->year;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
    }

    if (empty($years)) {
        return null;
    }

    return [
        'min' => min($years),
        'max' => max($years)
    ];
}

    public function getHeatmapData(Request $request)
    {
        try {
            $timeframe = $request->get('timeframe', 'planned');
            $person = $request->get('person', '');
            $year = $request->get('year', date('Y'));

            $projects = Maio::get_projects();
            $totalProjects = count($projects);

            $allTasks = collect();
            foreach ($projects as $project) {
                $projectTasks = Maio::get_project_task($project->ID);
                $allTasks = $allTasks->merge($projectTasks);
            }

            if (!empty($person)) {
                $allTasks = $allTasks->filter(function ($task) use ($person) {
                    return $task->RESPONSIBLE == $person;
                });
            }

            $yearRange = $this->getYearRangeFromTasks($allTasks);

            if (empty($yearRange)) {
                $yearRange = [
                    'min' => $year - 1,
                    'max' => $year + 1
                ];
            }

            $heatmapData = $this->processHeatmapData($allTasks, $timeframe, $person);

            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->NPK);
            })->map(function ($r) {
                $r->npk = $r->NPK;
                $r->emp_name = $r->EMP_NAME;
                return $r;
            });

            $holidays = Maio::get_holiday();

            return response()->json([
                'success' => true,
                'data' => $heatmapData,
                'resources' => $resources,
                'holidays' => $holidays,
                'yearRange' => $yearRange,
                'stats' => [
                    'total_projects' => $totalProjects,
                    'total_tasks' => $allTasks->count(),
                    'filtered_tasks' => $allTasks->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load heatmap data: ' . $e->getMessage()
            ]);
        }
    }

private function processHeatmapData($tasks, $timeframe = 'planned', $person = '')
{
    $hoursData = [];
    $tasksData = [];

    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    for ($year = 2023; $year <= 2030; $year++) {
        for ($day = 1; $day <= 31; $day++) {
            $hoursData[$year][$day] = array_fill_keys($months, 0);
            $tasksData[$year][$day] = array_fill_keys($months, 0);
        }
    }

    foreach ($tasks as $task) {
        if (isset($task->STATUS) && $task->STATUS == '3') {
            continue;
        }

        if (isset($task->IS_MILESTONE) && $task->IS_MILESTONE == '70') {
            continue;
        }

        if ($timeframe === 'actual') {
            if (empty($task->ACTUAL_START) || empty($task->ACTUAL_END)) {
                continue;
            }

            $startDateField = 'ACTUAL_START';
            $endDateField   = 'ACTUAL_END';

            $heatValue = !empty($task->ACTUAL_HOUR) ? floatval($task->ACTUAL_HOUR)
                       : (!empty($task->HEAT_TASK)  ? floatval($task->HEAT_TASK)
                       : (!empty($task->PLAN_HOUR)  ? floatval($task->PLAN_HOUR)
                       : 1));
        } else {
            if (empty($task->PLAN_START) || empty($task->PLAN_END)) {
                continue;
            }

            $startDateField = 'PLAN_START';
            $endDateField   = 'PLAN_END';

            $heatValue = !empty($task->HEAT_TASK)  ? floatval($task->HEAT_TASK)
                       : (!empty($task->PLAN_HOUR) ? floatval($task->PLAN_HOUR)
                       : 1);
        }

        try {
            $startDate = Carbon::parse($task->$startDateField);
            $endDate   = Carbon::parse($task->$endDateField);

            if ($startDate->gt($endDate)) {
                continue;
            }

            if ($heatValue <= 0) {
                continue;
            }

            // Hitung working days (exclude weekend)
            $workingDays = 0;
            $tempDate = $startDate->copy();
            while ($tempDate->lte($endDate)) {
                if (!$tempDate->isWeekend()) {
                    $workingDays++;
                }
                $tempDate->addDay();
            }

            $dailyHeat = $workingDays > 0 ? $heatValue / $workingDays : $heatValue;

            // Spread per hari, skip weekend
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                if (!$currentDate->isWeekend()) {
                    $year  = $currentDate->year;
                    $month = $months[$currentDate->month - 1];
                    $day   = $currentDate->day;

                    if ($year >= 2023 && $year <= 2030 && $day >= 1 && $day <= 31) {
                        $hoursData[$year][$day][$month] += $dailyHeat;
                        $tasksData[$year][$day][$month] += 1;
                    }
                }

                $currentDate->addDay();
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    return [
        'hours' => $hoursData,
        'tasks' => $tasksData
    ];
}
    public function progress()
    {
        $projects = Maio::get_projects();

        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->ID);
            $allTasks = $allTasks->merge($projectTasks);
        }

        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->NPK);
        });

        $resourceList = $resources->map(function ($resource) {
            return [
                'id' => $resource->NPK,
                'name' => $resource->EMP_NAME ?? $resource->NAME ?? $resource->NPK
            ];
        })->unique('id');

        $resourceList = $resourceList->sortBy('name')->values();
        $defaultResource = 'all';
        $stats = $this->calculateResourceProgress($allTasks, 'all');
        $chartData = $this->getChartData($allTasks, 'all');

        $data = [
            'title' => 'Resource Workload',
            'content' => 'pm.progress',
            'resources' => $resourceList,
            'defaultResource' => $defaultResource,
            'stats' => $stats,
            'initialData' => $chartData
        ];
        return view('template.wrapper', $data);
    }

    private function calculateResourceProgress($allTasks, $resourceId)
    {
        if ($resourceId !== 'all') {
            $filteredTasks = $allTasks->filter(function ($task) use ($resourceId) {
                return isset($task->RESPONSIBLE) && $task->RESPONSIBLE == $resourceId;
            });
        } else {
            $filteredTasks = $allTasks;
        }

        $statusCounts = [
            'Open' => 0,
            'InProgress' => 0,
            'Completed' => 0,
            'OnHold' => 0,
            'Cancelled' => 0,
            'OTHER' => 0
        ];

        $statusMapping = [
            '1' => 'Open',
            '2' => 'InProgress',
            '3' => 'Completed',
            '4' => 'OnHold',
            '5' => 'Cancelled'
        ];

        $currentMonth = date('n');
        $currentYear = date('Y');
        $nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
        $nextMonthYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;
        $nextYear = $currentYear + 1;
        $dueThisMonth = 0;
        $dueNextMonth = 0;
        $dueThisYear = 0;
        $dueNextYear = 0;

        foreach ($filteredTasks as $task) {
            if (isset($task->STATUS)) {
                $statusKey = (string) $task->STATUS;
                if (array_key_exists($statusKey, $statusMapping)) {
                    $statusName = $statusMapping[$statusKey];
                    $statusCounts[$statusName]++;
                } else {
                    $statusCounts['OTHER']++;
                }
            } else {
                $statusCounts['OTHER']++;
            }

            if (!empty($task->PLAN_END)) {
                try {
                    $dueDate = Carbon::parse($task->PLAN_END);
                    $dueMonth = $dueDate->month;
                    $dueYear = $dueDate->year;

                    if ($dueYear == $currentYear && $dueMonth == $currentMonth) {
                        $dueThisMonth++;
                    }

                    if ($dueYear == $nextMonthYear && $dueMonth == $nextMonth) {
                        $dueNextMonth++;
                    }

                    if ($dueYear == $currentYear) {
                        $dueThisYear++;
                    }

                    if ($dueYear == $nextYear) {
                        $dueNextYear++;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        $totalTasks = $filteredTasks->count();
        $completedTasks = $statusCounts['Completed'];

        return [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'due_this_month' => $dueThisMonth,
            'due_next_month' => $dueNextMonth,
            'due_this_year' => $dueThisYear,
            'due_next_year' => $dueNextYear,
            'status_counts' => $statusCounts
        ];
    }

    private function getChartData($allTasks, $resourceId)
    {
        $statusMapping = [
            '1' => 'Open',
            '2' => 'InProgress',
            '3' => 'Completed',
            '4' => 'OnHold',
            '5' => 'Cancelled'
        ];

        $chartData = [
            ['name' => 'Open', 'y' => 0, 'color' => '#1f77b4'],
            ['name' => 'InProgress', 'y' => 0, 'color' => '#00a591'],
            ['name' => 'Completed', 'y' => 0, 'color' => '#9acd32'],
            ['name' => 'OnHold', 'y' => 0, 'color' => '#f0ad4e'],
            ['name' => 'Cancelled', 'y' => 0, 'color' => '#d9534f'],
            ['name' => 'OTHER', 'y' => 0, 'color' => '#34495e']
        ];

        if ($resourceId !== 'all') {
            $filteredTasks = $allTasks->filter(function ($task) use ($resourceId) {
                return isset($task->RESPONSIBLE) && $task->RESPONSIBLE == $resourceId;
            });
        } else {
            $filteredTasks = $allTasks;
        }

        foreach ($filteredTasks as $task) {
            if (isset($task->STATUS)) {
                $statusKey = (string) $task->STATUS;
                $index = false;
                if (array_key_exists($statusKey, $statusMapping)) {
                    $statusName = $statusMapping[$statusKey];
                    $index = array_search($statusName, array_column($chartData, 'name'));
                }

                if ($index !== false) {
                    $chartData[$index]['y']++;
                } else {
                    $otherIndex = array_search('OTHER', array_column($chartData, 'name'));
                    if ($otherIndex !== false) {
                        $chartData[$otherIndex]['y']++;
                    }
                }
            }
        }

        return $chartData;
    }

    public function getProgressData(Request $request)
    {
        try {
            $person = $request->get('person', 'all');

            $projects = Maio::get_projects();
            $allTasks = collect();

            foreach ($projects as $project) {
                $projectTasks = Maio::get_project_task($project->ID);
                $allTasks = $allTasks->merge($projectTasks);
            }

            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->NPK);
            });

            $resourceList = $resources->map(function ($resource) {
                return [
                    'id' => $resource->NPK,
                    'name' => $resource->EMP_NAME ?? $resource->NAME ?? $resource->NPK
                ];
            })->unique('id');

            $resourceList = $resourceList->sortBy('name')->values();

            $stats = $this->calculateResourceProgress($allTasks, $person);
            $chartData = $this->getChartData($allTasks, $person);
            $totalTasks = $stats['total_tasks'];
            $completedTasks = $stats['completed_tasks'];
            $overallProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'chartData' => $chartData,
                'resources' => $resourceList,
                'overallProgress' => $overallProgress,
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load progress data: ' . $e->getMessage()
            ]);
        }
    }

    public function ganttchart()
    {
        $projects = Maio::get_projects();
        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->ID);
            $allTasks = $allTasks->merge($projectTasks);
        }

        $lov = Maio::get_lov();
        $responsible = Maio::get_resource_mgmt();

        $lov_status = $lov->where('INIT', 'status');
        $lov_complexity = $lov->where('INIT', 'complexity');
        $lov_priority = $lov->where('INIT', 'priority');
        $lov_is_milestone = $lov->where('INIT', 'category');
        $lov_actual_progress = $lov->where('INIT', 'progress');

        $holidays = Maio::get_holiday();

        $data = [
            'title' => 'Gantt Chart Dashboard',
            'content' => 'pm.ganttchart',
            'projects' => $projects,
            'all_tasks' => $allTasks,
            'lov_status' => $lov_status,
            'lov_complexity' => $lov_complexity,
            'lov_priority' => $lov_priority,
            'lov_is_milestone' => $lov_is_milestone,
            'lov_actual_progress' => $lov_actual_progress,
            'responsible' => $responsible,
            'holidays' => $holidays
        ];

        return view('template.wrapper', $data);
    }
    public function getProjectTasks($projectId)
    {
        try {
            $projectTasks = Maio::get_project_task($projectId);

            if ($projectTasks->isEmpty()) {
                return response()->json([]);
            }

            $project = Maio::get_projects()->where('ID', $projectId)->first();

            $projectTasks = $projectTasks->map(function ($task) use ($project, $projectId) {

                $task->PROJECT_ID = $project->ID ?? $projectId;
                $task->PROJECT_NAME = $project->PROJECT_NAME ?? 'Unknown';
                $task->project_id = $task->PROJECT_ID;
                $task->project_name = $task->PROJECT_NAME;
                $task->task_id = $task->TASK_ID;
                $task->milestone_task = $task->MILESTONE_TASK;
                $task->responsible = $task->RESPONSIBLE;
                $task->responsible_name = $task->RESPONSIBLE_NAME;
                $task->plan_start = $task->PLAN_START;
                $task->plan_end = $task->PLAN_END;
                $task->plan_duration = $task->PLAN_DURATION;
                $task->actual_start = $task->ACTUAL_START;
                $task->actual_end = $task->ACTUAL_END;
                $task->actual_duration = $task->ACTUAL_DURATION;
                $task->status = $task->STATUS;
                $task->status_name = $task->STATUS_NAME;
                $task->complexity = $task->COMPLEXITY;
                $task->complexity_name = $task->COMPLEXITY_NAME;
                $task->priority = $task->PRIORITY;
                $task->priority_name = $task->PRIORITY_NAME;
                $task->is_milestone = $task->IS_MILESTONE;
                $task->is_milestone_name = $task->IS_MILESTONE_NAME;
                $task->plan_hour = $task->PLAN_HOUR;
                $task->actual_hour = $task->ACTUAL_HOUR;
                $task->heat_task = $task->HEAT_TASK;
                $task->order1 = $task->ORDER1;
                $task->parent_task = $task->PARENT_TASK;
                $task->remark = $task->REMARK;

                return $task;
            });

            return response()->json($projectTasks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load tasks: ' . $e->getMessage()], 500);
        }
    }

    public function project()
    {
        $projects = Maio::get_projects();
        $lov = Maio::get_lov();
        $client = Maio::get_client();
        $responsible = Maio::get_resource_mgmt();
        $holiday = Maio::get_holiday();

        $lov_status = $lov->where('INIT', 'status');
        $lov_complexity = $lov->where('INIT', 'complexity');
        $lov_priority = $lov->where('INIT', 'priority');
        $lov_process = $lov->where('INIT', 'process');
        $lov_stdproc = $lov->where('INIT', 'stdproc');

        $data = [
            'title' => 'Project Management',
            'content' => 'pm.project',
            'projects' => $projects,
            'lov_status' => $lov_status,
            'lov_complexity' => $lov_complexity,
            'lov_priority' => $lov_priority,
            'lov_process' => $lov_process,
            'lov_stdproc' => $lov_stdproc,
            'client' => $client,
            'responsible' => $responsible,
            'holiday' => $holiday
        ];

        return view('template.wrapper', $data);
    }

    public function zzz_project(Request $request)
    {
        $insert = Mapp::insert_project($request);

        if ($insert['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Project berhasil disimpan!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $insert['message']
            ]);
        }
    }

    public function zzz_save_process_temp(Request $request)
    {
        $result = Mapp::save_process_temp($request);

        if ($result['success']) {
            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ]);
    }

    public function task($id)
    {
        $tasks = Maio::get_project_task($id);
        $lov = Maio::get_lov();
        $responsible = Maio::get_resource_mgmt();

        $lov_status = $lov->where('INIT', 'status');
        $lov_complexity = $lov->where('INIT', 'complexity');
        $lov_priority = $lov->where('INIT', 'priority');
        $lov_is_milestone = $lov->where('INIT', 'category');
        $lov_actual_progress = $lov->where('INIT', 'progress');

        $holidays = Maio::get_holiday();
        $project = Maio::get_project_by_id($id);
        $projectName = $project ? $project->PROJECT_NAME : 'Unknown Project';

        $data = [
            'title' => 'Task Management',
            'content' => 'pm.task',
            'tasks' => $tasks,
            'projectName' => $projectName,
            'lov_status' => $lov_status,
            'lov_complexity' => $lov_complexity,
            'lov_priority' => $lov_priority,
            'lov_is_milestone' => $lov_is_milestone,
            'lov_actual_progress' => $lov_actual_progress,
            'responsible' => $responsible,
            'holidays' => $holidays,
        ];

        return view('template.wrapper', $data);
    }

    public function activityHistory($projectId, $taskId)
    {
        $rows = Maio::get_activity_log($projectId, $taskId);

        $result = [];

        foreach ($rows as $row) {
            $pictures = json_decode($row->PICTURE, true);
            $files = [];

            if (is_array($pictures)) {
                foreach ($pictures as $p) {
                    if (is_numeric($p)) {
                        $file = DB::connection('mysql')->table('SOFTCOPY')
                            ->select('ID', 'FULL_PATH', 'CLIENT_NAME')
                            ->where('ID', $p)
                            ->first();

                        if ($file) {
                            $files[] = $file;
                        }
                    } else {
                        $files[] = [
                            'ID' => null,
                            'FULL_PATH' => '/storage/softcopy/' . $p,
                            'CLIENT_NAME' => $p
                        ];
                    }
                }
            }

            $result[] = [
                'sysdate1' => $row->SYSDATE1,
                'inputby' => $row->INPUTBY,
                'task_det' => $row->TASK_DET,
                'activity' => $row->ACTIVITY,
                'picture' => $pictures,
                'docs' => $files
            ];
        }

        return response()->json($result);
    }

    public function zzz_task_add(Request $request)
    {
        try {
            $request->merge(['project_id' => $request->input('project_id')]);

            $result = Mapp::insert_task($request);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'heat_task' => $result['heat_task'] ?? null,
                    'plan_end' => $result['plan_end'] ?? null,
                    'actual_end' => $result['actual_end'] ?? null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function zzz_task_delete($id)
    {
        try {
            $deleted = Mapp::delete_task($id);

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Task not found or failed to delete.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function zzz_task_add_milestone(Request $request)
    {
        try {
            $result = Mapp::insert_milestone_task($request);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function zzz_activity_add(Request $request)
    {
        try {
            $request->validate([
                'project_id' => 'required',
                'task_id' => 'required',
                'task_det' => 'required',
                'inputby' => 'required',
            ]);

            $result = Mapp::insert_activity_log($request);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'data' => [
                        'files' => $result['files']
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function projectdash($id)
    {
        $tasks = Maio::get_project_task($id);
        $project = Maio::get_project_by_id($id);
        $budget = $project ? $project->BUDGET : 0;
        $invoiceAmount = Maio::get_invoice_amount_by_project($id);
        $invoices = Maio::get_invoices_by_project($id);

        $lov = Maio::get_lov();
        $processAll = $lov->where('INIT', 'process');

        $process = $processAll->filter(function ($p) use ($id) {
            return Maio::has_standard_target($id, $p->LOV_ID);
        });

        $remainingBudget = $budget - $invoiceAmount;

        $totalActivity = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 21;
        })->count();

        $finishActivity = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 21 && $t->STATUS == 3;
        })->count();

        $finishMilestone = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 20 && $t->STATUS == 3;
        })->count();

        $overall = ($totalActivity > 0)
            ? round((($finishMilestone + $finishActivity) / $totalActivity) * 100)
            : 0;

        $milestoneTotal = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 20;
        })->count();

        $milestoneFinish = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 20 && $t->STATUS == 3;
        })->count();

        $milestoneProgress = ($milestoneTotal > 0)
            ? round(($milestoneFinish / $milestoneTotal) * 100)
            : 0;

        $taskTotal = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 21;
        })->count();

        $taskFinish = $tasks->filter(function ($t) {
            return $t->IS_MILESTONE == 21 && $t->STATUS == 3;
        })->count();

        $taskComplete = ($taskTotal > 0)
            ? round(($taskFinish / $taskTotal) * 100)
            : 0;

        $planHours = $tasks->sum('PLAN_HOUR');
        $hoursSpent = $tasks->sum('ACTUAL_HOUR');

        $statusCount = [
            'open' => $tasks->where('STATUS', 1)->count(),
            'inProgress' => $tasks->where('STATUS', 2)->count(),
            'completed' => $tasks->where('STATUS', 3)->count(),
            'onHold' => $tasks->where('STATUS', 4)->count(),
            'cancelled' => $tasks->where('STATUS', 5)->count(),
            'noStatus' => $tasks->filter(function ($task) {
                $status = $task->STATUS ?? null;
                return is_null($status) || $status === '' || $status == 0 || !is_numeric($status);
            })->count()
        ];

        $statusChart = [
            'open' => $tasks->where('STATUS', 1)->count(),
            'inProgress' => $tasks->where('STATUS', 2)->count(),
            'completed' => $tasks->where('STATUS', 3)->count(),
            'onHold' => $tasks->where('STATUS', 4)->count(),
            'cancelled' => $tasks->where('STATUS', 5)->count(),
        ];

        $groupedTasks = [];

        foreach ($tasks as $task) {
            if ($task->IS_MILESTONE == 20 && empty($task->PARENT_TASK)) {
                $taskId = $task->TASK_ID ?? $task->ID;
                $groupedTasks[$taskId] = [
                    'parent' => $task,
                    'activities' => []
                ];
            }
        }

        foreach ($tasks as $task) {
            if ($task->IS_MILESTONE == 21 && !empty($task->PARENT_TASK)) {
                $parentId = $task->PARENT_TASK;
                if (isset($groupedTasks[$parentId])) {
                    $activityId = $task->TASK_ID ?? $task->ID;
                    $groupedTasks[$parentId]['activities'][$activityId] = [
                        'activity' => $task,
                        'subactivities' => []
                    ];
                }
            }
        }

        foreach ($tasks as $task) {
            if ($task->IS_MILESTONE == 70 && !empty($task->PARENT_TASK)) {
                $parentId = $task->PARENT_TASK;
                foreach ($groupedTasks as $milestoneId => $milestoneData) {
                    if (isset($milestoneData['activities'][$parentId])) {
                        $groupedTasks[$milestoneId]['activities'][$parentId]['subactivities'][] = $task;
                        break;
                    }
                }
            }
        }

        foreach ($tasks as $task) {
            if ($task->IS_MILESTONE == 21 && empty($task->PARENT_TASK)) {
                $taskId = $task->TASK_ID ?? $task->ID;
                if (!isset($groupedTasks[$taskId])) {
                    $groupedTasks[$taskId] = [
                        'parent' => $task,
                        'activities' => []
                    ];
                }
            }
        }

        foreach ($tasks as $task) {
            if ($task->IS_MILESTONE == 70 && empty($task->PARENT_TASK)) {
                $taskId = $task->TASK_ID ?? $task->ID;
                if (!isset($groupedTasks[$taskId])) {
                    $groupedTasks[$taskId] = [
                        'parent' => $task,
                        'activities' => []
                    ];
                }
            }
        }

        $projectName = isset($project->PROJECT_NAME) ? $project->PROJECT_NAME : 'Unknown Project';
        $title = 'Project Dashboard - ' . $projectName;

        $data = [
            'title' => $title,
            'content' => 'pm.projectdash',
            'overall' => $overall,
            'milestoneProgress' => $milestoneProgress,
            'projectId' => $id,
            'tasks' => $tasks,
            'groupedTasks' => $groupedTasks,
            'taskComplete' => $taskComplete,
            'planHours' => $planHours,
            'hoursSpent' => $hoursSpent,
            'budget' => $budget,
            'invoiceAmount' => $invoiceAmount,
            'invoices' => $invoices,
            'remainingBudget' => $remainingBudget,
            'statusCount' => $statusCount,
            'statusChart' => $statusChart,
            'project' => $project,
            'process' => $process,
            'hasTrialProcess' => count($process) > 0,
        ];

        return view('template.wrapper', $data);
    }
    public function addInvoice(Request $request)
    {
        $projectId = $request->input('project_id');
        $amount = $request->input('amount');
        $remarks = $request->input('remarks');

        $result = Mapp::add_invoice($projectId, $amount, $remarks);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil ditambahkan!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ]);
        }
    }
    public function trial($id)
    {
        $project = Maio::get_project_by_id($id);
        if (!$project)
            abort(404);

        $lov = Maio::get_lov();
        $processAll = $lov->where('INIT', 'process');

        $process = $processAll->filter(function ($p) use ($id) {
            return Maio::has_standard_target($id, $p->LOV_ID);
        });

        $data = [
            'title' => 'Trial Record',
            'content' => 'pm.trial',
            'project' => $project,
            'process' => $process
        ];

        return view('template.wrapper', $data);
    }

    public function trial_data(Request $request)
    {
        $project_id = $request->project_id;
        $process_id = $request->process_id;

        $trials = Maio::get_trial_rr($project_id, $process_id);

        $allSoftIds = [];

        foreach ($trials as $row) {
            if (!empty($row->SOFTCOPY_ID)) {
                $ids = json_decode($row->SOFTCOPY_ID, true);
                if (is_array($ids)) {
                    $allSoftIds = array_merge($allSoftIds, $ids);
                }
            }
        }

        $allSoftIds = array_unique($allSoftIds);

        $softcopies = $allSoftIds
            ? Maio::get_softcopy_by_ids($allSoftIds)
            : collect();

        foreach ($trials as $row) {
            $row->files = [];

            if (!empty($row->SOFTCOPY_ID)) {
                $ids = json_decode($row->SOFTCOPY_ID, true);

                if (is_array($ids)) {
                    foreach ($ids as $id) {
                        $sc = $softcopies->firstWhere('ID', $id);
                        if ($sc) {
                            $row->files[] = [
                                'name' => $sc->CLIENT_NAME,
                                'url' => url($sc->FULL_PATH)
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($trials);
    }

    public function trial_store(Request $req)
    {
        try {
            $user = session('user');
            $userName = is_array($user)
                ? ($user['NAME'] ?? $user['name'] ?? 'Guest')
                : ($user->NAME ?? $user->name ?? 'Guest');

            $req->merge(['pic' => $userName]);

            $validator = Validator::make($req->all(), [
                'project_id' => 'required',
                'process_id' => 'required',
                'trial_no' => 'required',
                'trial_stat' => 'required',
                'trial_machine' => 'required',
                'trial_date' => 'required|date',
                'picture' => 'required',
                'picture.*' => 'file'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $result = Mapp::insert_trial($req);

            if ($result['success']) {
                return response()->json([
                    'status' => true,
                    'message' => 'Trial berhasil disimpan',
                    'files_count' => count($result['files'] ?? [])
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => $result['message'] ?? 'Insert failed'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function trial_standard(Request $request)
    {
        $project_id = $request->project_id;
        $process_id = $request->process_id;

        $standards = Maio::get_standard_by_project_process($project_id, $process_id);

        $result = [
            'target' => null,
            'ct_target' => null,
            'berat_target' => null
        ];

        foreach ($standards as $std) {
            if ($std->STDPROC_ID == 77) {
                $result['target'] = $std->VALUE;
            } elseif ($std->STDPROC_ID == 78) {
                $result['ct_target'] = $std->VALUE;
            } elseif ($std->STDPROC_ID == 79) {
                $result['berat_target'] = $std->VALUE;
            }
        }

        return response()->json($result);
    }

    public function trial_next_no(Request $request)
    {
        $project_id = $request->project_id;
        $process_id = $request->process_id;

        $last = Maio::get_last_trial_no($project_id, $process_id);

        $nextNo = 1;

        if ($last) {
            preg_match('/(\d+)/', $last, $match);
            $nextNo = isset($match[1]) ? ((int) $match[1] + 1) : 1;
        }

        return response()->json([
            'trial_no' => 'TRIAL ' . $nextNo
        ]);
    }

    public function trial_report_multi(Request $request)
    {
        $project_id = $request->project_id;
        $process_id = $request->process_id;

        $trials = Maio::get_trial_rr($project_id, $process_id)->reverse()->values();

        if ($trials->isEmpty()) {
            return response()->json([
                'columns' => [],
                'targets' => [],
                'trials' => [],
                'categories' => [],
                'data' => []
            ]);
        }

        $report = [];
        $categories = [];
        $trialInfo = [];

        foreach ($trials as $trial) {
            $trialKey = $trial->TRIAL_NO . ' ' . $trial->TRIAL_STAT;

            $trialInfo[$trialKey] = [
                'id' => $trial->ID,
                'att1' => $trial->ATT1 ?? null,
                'defectIds' => []
            ];

            $okQuant = (float) ($trial->OK ?? 0);
            $okPercent = (float) ($trial->PERCT ?? 0);

            $report['OK']['OK'][$trialKey] = [
                'quant' => $okQuant,
                'percent' => $okPercent
            ];

            $totalQuant = $okQuant;
            $totalPercent = $okPercent;

            $details = Maio::get_trial_rr_det($project_id, $process_id, $trial->ID);

            foreach ($details as $det) {
                $category = $det->TRANS_TYPE;
                $defectKey = $det->DEFECT_ID;
                $defectLbl = $det->DEFECT_NAME;

                $trialInfo[$trialKey]['defectIds'][$defectKey] = $defectKey;

                if (!isset($report[$category])) {
                    $report[$category] = [];
                    $categories[] = $category;
                }

                if (!isset($report[$category][$defectKey])) {
                    $report[$category][$defectKey] = [
                        '_label' => $defectLbl
                    ];
                }

                $ngQuant = (float) ($det->NG ?? 0);
                $ngPercent = (float) ($det->PERCT ?? 0);

                $totalQuant += $ngQuant;
                $totalPercent += $ngPercent;

                $report[$category][$defectKey][$trialKey] = [
                    'quant' => $ngQuant,
                    'percent' => $ngPercent,
                    'actual' => $trial->ACTUAL
                ];
            }

            $actualQty = (float) ($trial->ACTUAL ?? 0);
            $totalPercentCalc = $actualQty > 0 ? ($totalQuant / $actualQty) * 100 : $totalPercent;

            $report['Jumlah']['Jumlah'][$trialKey] = [
                'quant' => $totalQuant,
                'percent' => round($totalPercentCalc, 2)
            ];
        }

        $targets = [];
        foreach ($trials as $trial) {
            $targets[$trial->TRIAL_NO . ' ' . $trial->TRIAL_STAT] = (float) $trial->TARGET;
        }

        return response()->json([
            'columns' => $trials->map(fn($t) => $t->TRIAL_NO . ' ' . $t->TRIAL_STAT)->toArray(),
            'targets' => $targets,
            'trials' => $trialInfo,
            'categories' => array_values(array_unique($categories)),
            'data' => $report
        ]);
    }

    public function trial_report_detail(Request $request)
    {
        $project_id = $request->project_id;
        $process_id = $request->process_id;
        $trial_id = $request->trial_id;

        $details = Maio::get_trial_rr_det_all($project_id, $process_id, $trial_id);

        return response()->json([
            'success' => true,
            'data' => $details
        ]);
    }

    public function trial_update_detail(Request $request)
    {
        try {
            $rules = [
                'project_id' => 'required',
                'process_id' => 'required',
                'trial_id' => 'required',
                'defect_id' => 'required',
                'ng' => 'required|numeric|min:0',
                'perct' => 'required|numeric|min:0|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $allTrials = Maio::get_trial_rr($request->project_id, $request->process_id);

            $trial = null;
            foreach ($allTrials as $t) {
                if ($t->ID == $request->trial_id) {
                    $trial = $t;
                    break;
                }
            }

            if (!$trial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trial not found'
                ], 404);
            }

            $actualQty = (float) ($trial->ACTUAL ?? 0);

            if ($actualQty <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Actual quantity must be greater than 0'
                ], 422);
            }

            $existingDetails = Maio::get_trial_rr_det($request->project_id, $request->process_id, $request->trial_id);

            $totalQuantWithoutCurrent = (float) ($trial->OK ?? 0);
            foreach ($existingDetails as $detail) {
                if ($detail->DEFECT_ID == $request->defect_id) {
                    continue;
                }
                $totalQuantWithoutCurrent += (float) ($detail->NG ?? 0);
            }

            $totalPercentWithoutCurrent = (float) ($trial->PERCT ?? 0);
            foreach ($existingDetails as $detail) {
                if ($detail->DEFECT_ID == $request->defect_id) {
                    continue;
                }
                $totalPercentWithoutCurrent += (float) ($detail->PERCT ?? 0);
            }

            $newNg = (float) $request->ng;
            $newPercent = (float) $request->perct;

            $finalTotalQuant = $totalQuantWithoutCurrent + $newNg;
            $finalTotalPercent = $totalPercentWithoutCurrent + $newPercent;

            if ($finalTotalQuant > $actualQty) {
                $maxAllowed = $actualQty - $totalQuantWithoutCurrent;
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity (' . $finalTotalQuant . ') exceeds actual quantity (' . $actualQty . '). Maximum allowed: ' . $maxAllowed . ' pcs',
                    'max_allowed' => $maxAllowed
                ], 422);
            }

            if ($finalTotalPercent > 100.01) {
                $maxPercentAllowed = 100 - $totalPercentWithoutCurrent;
                return response()->json([
                    'success' => false,
                    'message' => 'Total percentage (' . round($finalTotalPercent, 2) . '%) exceeds 100%. Maximum allowed: ' . round($maxPercentAllowed, 2) . '%',
                    'max_percent' => $maxPercentAllowed
                ], 422);
            }

            $updated = Mapp::update_trial_detail($request);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diperbarui'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function trailreport($project, $process, $id)
    {
        $data = [
            'title' => 'Trail Report',
            'content' => 'pm.trailreport',
            'project_id' => $project,
            'process_id' => $process,
            'trial_id' => $id,
        ];

        return view('template.wrapper', $data);
    }

    public function problem()
    {
        $data = [
            'title' => 'Problem History',
            'content' => 'pm.problem'
        ];
        return view('template.wrapper', $data);
    }
}
