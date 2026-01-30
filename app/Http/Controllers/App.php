<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maio;
use App\Models\Mapp;
// use App\Models\Mauth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class App extends Controller
{
    // public function homepage()
    // {
    //     return view('pm.homepage');
    // }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'pm.dashboard'
        ];
        return view('template.wrapper', $data);
    }

    public function data()
    {
        $data = [
            'title' => 'Data',
            'content' => 'pm.data'
        ];
        return view('template.wrapper', $data);
    }

    public function inresponsible()
    {
        $resource = Maio::get_resource_mgmt();
        $lov = Maio::get_lov();

        $lov_emptype = $lov->where('init', 'emptype');
        $lov_empdept = $lov->where('init', 'empdept');

        // ===== Mapping DESCRIPTION => LOV_ID =====
        $empTypeMapping = [];
        foreach ($lov_emptype as $et) {
            $empTypeMapping[$et->description] = $et->lov_id;
        }

        $deptMapping = [];
        foreach ($lov_empdept as $dept) {
            $deptMapping[$dept->description] = $dept->lov_id;
        }

        // ===== Inject emp_type_id & department_id =====
        foreach ($resource as $r) {
            $r->emp_type_id = $empTypeMapping[$r->emp_type] ?? null;
            $r->department_id = $deptMapping[$r->department] ?? null;
        }

        // ===== CALL API MASTERDATA =====
        $query = "
        SELECT a.NPK, a.NAME
        FROM euclid.masterdata a
        WHERE a.TERMINATION IS NULL
        AND a.DIV_NAME = '4W ALLOY ENGINEERING'
        ORDER BY a.NAME
    ";

        $payload = [
            'db' => 'euclid',
            'table' => 'euclid.masterdata',
            'column' => 'id',
            'param' => 'select',
            'query' => $query,
            'datas' => '',
            'rowres' => 'result',
        ];

        $response = Http::post('http://192.168.10.49/40-api/Apiaio/aiocrud', $payload);
        $employees = $response->json();

        return view('template.wrapper', [
            'title' => 'Resource Management',
            'content' => 'pm.inresponsible',
            'resource' => $resource,
            'lov_emptype' => $lov_emptype,
            'lov_empdept' => $lov_empdept,
            'employees' => $employees,
        ]);
        //         $response = Http::post('http://192.168.10.49/40-api/Apiaio/aiocrud', $payload);

        // // Cetak persis response API
// return response()->json(
//     $response->json(),
//     200,
//     [],
//     JSON_PRETTY_PRINT
// );

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

    // public function calendar()
    // {
    //     $data = [
    //         'title' => 'Calendar',
    //         'content' => 'pm.calendar'
    //     ];
    //     return view('template.wrapper', $data);
    // }

    public function resource()
    {
        $projects = Maio::get_projects();
        $totalProjects = count($projects);

        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->id);
            $allTasks = $allTasks->merge($projectTasks);
        }

        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->npk);
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
                $projectTasks = Maio::get_project_task($project->id);
                $allTasks = $allTasks->merge($projectTasks);
            }

            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->npk);
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
            $resourceData[$resource->emp_name] = [
                'tasks' => 0,
                'plan_hours' => 0,
                'milestones' => 0,
                'projects' => []
            ];
        }

        foreach ($tasks as $task) {
            $responsibleName = $task->responsible_name ?: 'Unassigned';

            if (isset($task->status) && $task->status == '3') {
                continue;
            }

            $isMilestone70 = (isset($task->is_milestone) && $task->is_milestone == '70');
            if ($isMilestone70) {
                continue;
            }

            if (isset($resourceData[$responsibleName])) {
                $resourceData[$responsibleName]['tasks']++;
                $resourceData[$responsibleName]['plan_hours'] += floatval($task->plan_hour ?: 0);

                if ($task->project_name && !in_array($task->project_name, $resourceData[$responsibleName]['projects'])) {
                    $resourceData[$responsibleName]['projects'][] = $task->project_name;
                }

                if (isset($task->is_milestone) && $task->is_milestone == '1') {
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
                $resourceData['Unassigned']['plan_hours'] += floatval($task->plan_hour ?: 0);

                if (isset($task->is_milestone) && $task->is_milestone == '1') {
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
            return !empty($r->npk);
        });

        $holidays = Maio::get_holiday();

        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->id);
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
            if (isset($task->status) && $task->status == '3') {
                continue;
            }

            if (isset($task->is_milestone) && $task->is_milestone == '70') {
                continue;
            }

            $dateFields = ['plan_start', 'plan_end', 'actual_start', 'actual_end'];

            foreach ($dateFields as $field) {
                if (!empty($task->$field)) {
                    try {
                        $date = Carbon::parse($task->$field);
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
                $projectTasks = Maio::get_project_task($project->id);
                $allTasks = $allTasks->merge($projectTasks);
            }

            if (!empty($person)) {
                $allTasks = $allTasks->filter(function ($task) use ($person) {
                    return $task->responsible == $person;
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
                return !empty($r->npk);
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
            if (isset($task->status) && $task->status == '3') {
                continue;
            }

            if (isset($task->is_milestone) && $task->is_milestone == '70') {
                continue;
            }

            if ($timeframe === 'actual') {
                $startDateField = 'actual_start';
                $endDateField = 'actual_end';

                $heatValue = !empty($task->actual_hour) ? floatval($task->actual_hour) :
                    (!empty($task->heat_task) ? floatval($task->heat_task) :
                        (!empty($task->plan_hour) ? floatval($task->plan_hour) : 0));
            } else {
                $startDateField = 'plan_start';
                $endDateField = 'plan_end';

                $heatValue = !empty($task->heat_task) ? floatval($task->heat_task) :
                    (!empty($task->plan_hour) ? floatval($task->plan_hour) : 0);
            }

            if (!empty($task->$startDateField) && !empty($task->$endDateField)) {
                try {
                    $startDate = Carbon::parse($task->$startDateField);
                    $endDate = Carbon::parse($task->$endDateField);

                    if ($startDate->gt($endDate)) {
                        continue;
                    }

                    if ($heatValue <= 0) {
                        continue;
                    }

                    $currentDate = $startDate->copy();

                    while ($currentDate->lte($endDate)) {
                        $year = $currentDate->year;
                        $month = $months[$currentDate->month - 1];
                        $day = $currentDate->day;

                        if ($year >= 2023 && $year <= 2030 && $day >= 1 && $day <= 31) {

                            $hoursData[$year][$day][$month] += $heatValue;
                            $tasksData[$year][$day][$month] += 1;
                        }

                        $currentDate->addDay();
                    }
                } catch (\Exception $e) {
                    \Log::error('Error parsing date in heatmap: ' . $e->getMessage());
                    continue;
                }
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
            $projectTasks = Maio::get_project_task($project->id);
            $allTasks = $allTasks->merge($projectTasks);
        }

        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->npk);
        });

        $resourceList = $resources->map(function ($resource) {
            return [
                'id' => $resource->npk,
                'name' => $resource->emp_name ?? $resource->name ?? $resource->npk
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
                return isset($task->responsible) && $task->responsible == $resourceId;
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
            if (isset($task->status)) {
                $statusKey = (string) $task->status;
                if (array_key_exists($statusKey, $statusMapping)) {
                    $statusName = $statusMapping[$statusKey];
                    $statusCounts[$statusName]++;
                } else {
                    $statusCounts['OTHER']++;
                }
            } else {
                $statusCounts['OTHER']++;
            }

            if (!empty($task->plan_end)) {
                try {
                    $dueDate = Carbon::parse($task->plan_end);
                    $dueMonth = $dueDate->month;
                    $dueYear = $dueDate->year;

                    // DUE THIS MONTH
                    if ($dueYear == $currentYear && $dueMonth == $currentMonth) {
                        $dueThisMonth++;
                    }

                    // DUE NEXT MONTH
                    if ($dueYear == $nextMonthYear && $dueMonth == $nextMonth) {
                        $dueNextMonth++;
                    }

                    // DUE THIS YEAR (SEMUA DI TAHUN INI)
                    if ($dueYear == $currentYear) {
                        $dueThisYear++;
                    }

                    // DUE NEXT YEAR
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
                return isset($task->responsible) && $task->responsible == $resourceId;
            });
        } else {
            $filteredTasks = $allTasks;
        }

        foreach ($filteredTasks as $task) {
            if (isset($task->status)) {
                $statusKey = (string) $task->status;
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

        //     foreach ($filteredTasks as $task) {

        // $statusKey = isset($task->status) && $task->status !== ''
        //     ? (string) $task->status
        //     : null;

        // if ($statusKey !== null && array_key_exists($statusKey, $statusMapping)) {
        //     // Status valid
        //     $statusName = $statusMapping[$statusKey];
        //     $index = array_search($statusName, array_column($chartData, 'name'));

        //     if ($index !== false) {
        //         $chartData[$index]['y']++;
        //     }

        // } else {
        //     // STATUS NULL / TIDAK VALID → OTHER
        //     $otherIndex = array_search('OTHER', array_column($chartData, 'name'));
        //     if ($otherIndex !== false) {
        //         $chartData[$otherIndex]['y']++;
        //     }
        // }
// }


        return $chartData;
    }

    public function getProgressData(Request $request)
    {
        try {
            $person = $request->get('person', 'all');

            $projects = Maio::get_projects();
            $allTasks = collect();

            foreach ($projects as $project) {
                $projectTasks = Maio::get_project_task($project->id);
                $allTasks = $allTasks->merge($projectTasks);
            }

            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->npk);
            });

            $resourceList = $resources->map(function ($resource) {
                return [
                    'id' => $resource->npk,
                    'name' => $resource->emp_name ?? $resource->name ?? $resource->npk
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

    //     public function ganttchart()
    // {
    //     $data = [
    //         'title' => 'Ganttchart',
    //         'content' => 'pm.ganttchart'
    //     ];
    //     return view('template.wrapper', $data);
    // }

    public function ganttchart()
    {
        $projects = Maio::get_projects();
        $allTasks = collect();

        $lov = Maio::get_lov();
        $responsible = Maio::get_resource_mgmt();

        $lov_status = $lov->where('init', 'status');
        $lov_complexity = $lov->where('init', 'complexity');
        $lov_priority = $lov->where('init', 'priority');
        $lov_is_milestone = $lov->where('init', 'category');
        $lov_actual_progress = $lov->where('init', 'progress');

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
            $project = Maio::get_projects()->where('id', $projectId)->first();
            $projectTasks = $projectTasks->map(function ($task) use ($project) {
                $task->project_id = $project->id;
                $task->project_name = $project->project_name;
                return $task;
            });

            return response()->json($projectTasks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load tasks'], 500);
        }
    }



    public function project()
    {
        $projects = Maio::get_projects();
        $lov = Maio::get_lov();
        $client = Maio::get_client();
        $responsible = Maio::get_resource_mgmt();
        $holiday = Maio::get_holiday();

        $lov_status = $lov->where('init', 'status');
        $lov_complexity = $lov->where('init', 'complexity');
        $lov_priority = $lov->where('init', 'priority');
        $lov_process = $lov->where('init', 'process');
        $lov_stdproc = $lov->where('init', 'stdproc');

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


        $lov_status = $lov->where('init', 'status');
        $lov_complexity = $lov->where('init', 'complexity');
        $lov_priority = $lov->where('init', 'priority');
        $lov_is_milestone = $lov->where('init', 'category');
        $lov_actual_progress = $lov->where('init', 'progress');

        $holidays = Maio::get_holiday();

        $data = [
            'title' => 'Task Management',
            'content' => 'pm.task',
            'tasks' => $tasks,
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

            // decode picture: bisa [3] atau ["file.png"]
            $pictures = json_decode($row->picture, true);

            $files = [];

            if (is_array($pictures)) {
                foreach ($pictures as $p) {

                    // CASE 1: jika numeric -> berarti ID softcopy
                    if (is_numeric($p)) {
                        $file = \DB::table('PROMAN.SOFTCOPY')
                            ->select('ID', 'FULL_PATH', 'CLIENT_NAME')
                            ->where('ID', $p)
                            ->first();

                        if ($file) {
                            $files[] = $file;
                        }

                    } else {
                        // CASE 2: jika string nama file -> langsung push
                        $files[] = [
                            'ID' => null,
                            'FULL_PATH' => '/storage/softcopy/' . $p,
                            'CLIENT_NAME' => $p
                        ];
                    }
                }
            }

            // merge hasil
            $result[] = [
                'sysdate1' => $row->sysdate1,
                'inputby' => $row->inputby,
                'task_det' => $row->task_det,
                'activity' => $row->activity,
                'picture' => $pictures,   // raw picture
                'docs' => $files       // DETAIL dari softcopy
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

            // Validasi minimal agar tidak kosong
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
                    // 'data'    => $result['data']
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

    //    public function projectdash($id)
// {
//     $tasks = Maio::get_project_task($id);
//     $project = Maio::get_project_by_id($id);
//     $budget = $project ? $project->budget : 0;
//     $invoiceAmount = Maio::get_invoice_amount_by_project($id);
//     $invoices = Maio::get_invoices_by_project($id);

    //     // ===========================
//     // REMAINING BUDGET
//     // ===========================
//     $remainingBudget = $budget - $invoiceAmount;

    //     // ===========================
//     // OVERALL PROGRESS (MS = 21)
//     // ===========================
//     $totalOverall = $tasks->filter(function ($t) {
//         return $t->is_milestone == 21;
//     })->count();

    //     $finishOverall = $tasks->filter(function ($t) {
//         return $t->is_milestone == 21 && $t->status == 3;
//     })->count();

    //     $overall = ($totalOverall > 0)
//         ? round(($finishOverall / $totalOverall) * 100)
//         : 0;

    //     // ================================
//     // PROJECT MILESTONE (MS = 20)
//     // ================================
//     $milestoneTotal = $tasks->filter(function ($t) {
//         return $t->is_milestone == 20;
//     })->count();

    //     $milestoneFinish = $tasks->filter(function ($t) {
//         return $t->is_milestone == 20 && $t->status == 3;
//     })->count();

    //     $milestoneProgress = ($milestoneTotal > 0)
//         ? round(($milestoneFinish / $milestoneTotal) * 100)
//         : 0;

    //     // ==========================
//     // TASK COMPLETE (MS = 21)
//     // ==========================
//     $taskTotal = $tasks->filter(function ($t) {
//         return $t->is_milestone == 21;
//     })->count();

    //     $taskFinish = $tasks->filter(function ($t) {
//         return $t->is_milestone == 21 && $t->status == 3;
//     })->count();

    //     $taskComplete = ($taskTotal > 0)
//         ? round(($taskFinish / $taskTotal) * 100)
//         : 0;

    //     // ============================
//     // PLAN HOURS & HOURS SPENT
//     // ============================
//     $planHours = $tasks->sum('plan_hour');
//     $hoursSpent = $tasks->sum('actual_hour');

    //     // ============================
//     // PREPARE TASK DATA FOR CHART
//     // ============================
//     $chartTasks = [];
//     $statusCounts = [
//         1 => 0, // Open
//         2 => 0, // In Progress
//         3 => 0, // Completed
//         4 => 0, // On Hold
//         5 => 0  // Cancelled
//     ];

    //     // Sort tasks: milestones first, then by name
//     $sortedTasks = $tasks->sortBy(function($task) {
//         // Milestones (20) come before tasks (21)
//         $priority = $task->is_milestone == 20 ? 0 : 1;
//         return $priority . '_' . ($task->milestone_task ?? '');
//     });

    //     foreach ($sortedTasks as $task) {
//         $status = $task->status ?? 1;
//         $statusCounts[$status]++;

    //         $chartTasks[] = [
//             'name' => $task->milestone_task ?? ($task->is_milestone_name ?? 'Unnamed Task'),
//             'is_milestone' => $task->is_milestone,
//             'status' => $status,
//             'responsible' => $task->responsible_name ?? 'Not Assigned',
//             'plan_start' => $task->plan_start,
//             'plan_end' => $task->plan_end,
//             'actual_start' => $task->actual_start,
//             'actual_end' => $task->actual_end
//         ];
//     }

    //     // Kirim semua data ke view
//     $data = [
//         'title' => 'Project Dashboard',
//         'content' => 'pm.projectdash',
//         'overall' => $overall,
//         'milestoneProgress' => $milestoneProgress,
//         'projectId' => $id,
//         'tasks' => $tasks,
//         'chartTasks' => $chartTasks, // Data untuk chart
//         'statusCounts' => $statusCounts, // Count per status
//         'taskComplete' => $taskComplete,
//         'planHours' => $planHours,
//         'hoursSpent' => $hoursSpent,
//         'budget' => $budget,
//         'invoiceAmount' => $invoiceAmount,
//         'invoices' => $invoices,
//         'remainingBudget' => $remainingBudget,
//     ];

    //     return view('template.wrapper', $data);
// }

    public function projectdash($id)
    {
        $tasks = Maio::get_project_task($id);
        $project = Maio::get_project_by_id($id);
        $budget = $project ? $project->budget : 0;
        $invoiceAmount = Maio::get_invoice_amount_by_project($id);
        $invoices = Maio::get_invoices_by_project($id);

        $lov = Maio::get_lov();
        $processAll = $lov->where('init', 'process');

        $process = $processAll->filter(function ($p) use ($id) {
            return Maio::has_standard_target($id, $p->lov_id);
        });

        $remainingBudget = $budget - $invoiceAmount;

        $totalActivity = $tasks->filter(function ($t) {
            return $t->is_milestone == 21;
        })->count();

        $finishActivity = $tasks->filter(function ($t) {
            return $t->is_milestone == 21 && $t->status == 3;
        })->count();

        $finishMilestone = $tasks->filter(function ($t) {
            return $t->is_milestone == 20 && $t->status == 3;
        })->count();

        $overall = ($totalActivity > 0)
            ? round((($finishMilestone + $finishActivity) / $totalActivity) * 100)
            : 0;

        $milestoneTotal = $tasks->filter(function ($t) {
            return $t->is_milestone == 20;
        })->count();

        $milestoneFinish = $tasks->filter(function ($t) {
            return $t->is_milestone == 20 && $t->status == 3;
        })->count();

        $milestoneProgress = ($milestoneTotal > 0)
            ? round(($milestoneFinish / $milestoneTotal) * 100)
            : 0;

        $taskTotal = $tasks->filter(function ($t) {
            return $t->is_milestone == 21;
        })->count();

        $taskFinish = $tasks->filter(function ($t) {
            return $t->is_milestone == 21 && $t->status == 3;
        })->count();

        $taskComplete = ($taskTotal > 0)
            ? round(($taskFinish / $taskTotal) * 100)
            : 0;

        $planHours = $tasks->sum('plan_hour');
        $hoursSpent = $tasks->sum('actual_hour');

        $statusCount = [
            'open' => $tasks->where('status', 1)->count(),
            'inProgress' => $tasks->where('status', 2)->count(),
            'completed' => $tasks->where('status', 3)->count(),
            'onHold' => $tasks->where('status', 4)->count(),
            'cancelled' => $tasks->where('status', 5)->count(),
            'noStatus' => $tasks->filter(function ($task) {
                $status = $task->status ?? null;
                return is_null($status) || $status === '' || $status == 0 || !is_numeric($status);
            })->count()
        ];

        $statusChart = [
            'open' => $tasks->where('status', 1)->count(),
            'inProgress' => $tasks->where('status', 2)->count(),
            'completed' => $tasks->where('status', 3)->count(),
            'onHold' => $tasks->where('status', 4)->count(),
            'cancelled' => $tasks->where('status', 5)->count(),
        ];

        $groupedTasks = [];

        foreach ($tasks as $task) {
            if ($task->is_milestone == 20 && empty($task->parent_task)) {
                $taskId = $task->task_id ?? $task->id;
                $groupedTasks[$taskId] = [
                    'parent' => $task,
                    'activities' => []
                ];
            }
        }

        foreach ($tasks as $task) {
            if ($task->is_milestone == 21 && !empty($task->parent_task)) {
                $parentId = $task->parent_task;
                if (isset($groupedTasks[$parentId])) {
                    $activityId = $task->task_id ?? $task->id;
                    $groupedTasks[$parentId]['activities'][$activityId] = [
                        'activity' => $task,
                        'subactivities' => []
                    ];
                }
            }
        }

        // 3. LEVEL 3: Sub-activities (is_milestone = 70) yang punya parent di Level 2
        foreach ($tasks as $task) {
            if ($task->is_milestone == 70 && !empty($task->parent_task)) {
                $parentId = $task->parent_task;

                // Cari parent activity di setiap milestone
                foreach ($groupedTasks as $milestoneId => $milestoneData) {
                    if (isset($milestoneData['activities'][$parentId])) {
                        $groupedTasks[$milestoneId]['activities'][$parentId]['subactivities'][] = $task;
                        break;
                    }
                }
            }
        }

        // 4. Handle task yang tidak punya parent atau struktur tidak lengkap
        // Activities tanpa parent milestone (jadikan milestone sendiri)
        foreach ($tasks as $task) {
            if ($task->is_milestone == 21 && empty($task->parent_task)) {
                $taskId = $task->task_id ?? $task->id;
                if (!isset($groupedTasks[$taskId])) {
                    $groupedTasks[$taskId] = [
                        'parent' => $task,
                        'activities' => []
                    ];
                }
            }
        }

        // Sub-activities tanpa parent activity (jadikan activity sendiri)
        foreach ($tasks as $task) {
            if ($task->is_milestone == 70 && empty($task->parent_task)) {
                $taskId = $task->task_id ?? $task->id;
                if (!isset($groupedTasks[$taskId])) {
                    $groupedTasks[$taskId] = [
                        'parent' => $task,
                        'activities' => []
                    ];
                }
            }
        }

        $projectName = isset($project->project_name) ? $project->project_name : 'Unknown Project';
        $title = 'Project Dashboard - ' . $projectName;

        // Kirim semua data ke view
        $data = [
            'title' => $title,
            'content' => 'pm.projectdash',
            'overall' => $overall,
            'milestoneProgress' => $milestoneProgress,
            'projectId' => $id,
            'tasks' => $tasks,
            'groupedTasks' => $groupedTasks, // Data terkelompok 3 level
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
            'process' => $process, // Kirim hanya process yang ada target
            'hasTrialProcess' => count($process) > 0, // Flag untuk menampilkan section trial
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
        $processAll = $lov->where('init', 'process');

        // FILTER PROCESS YANG PUNYA TARGET
        $process = $processAll->filter(function ($p) use ($id) {
            return Maio::has_standard_target($id, $p->lov_id);
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

        // Kumpulkan semua softcopy_id
        $allSoftIds = [];

        foreach ($trials as $row) {
            if (!empty($row->softcopy_id)) {
                $ids = json_decode($row->softcopy_id, true);
                if (is_array($ids)) {
                    $allSoftIds = array_merge($allSoftIds, $ids);
                }
            }
        }

        $allSoftIds = array_unique($allSoftIds);

        // Ambil data softcopy
        $softcopies = $allSoftIds
            ? Maio::get_softcopy_by_ids($allSoftIds)
            : collect();

        // Inject softcopy ke tiap trial
        foreach ($trials as $row) {
            $row->files = [];

            if (!empty($row->softcopy_id)) {
                $ids = json_decode($row->softcopy_id, true);

                if (is_array($ids)) {
                    foreach ($ids as $id) {
                        if (isset($softcopies[$id])) {
                            $sc = $softcopies[$id];

                            $row->files[] = [
                                'name' => $sc->client_name,
                                'url' => url($sc->full_path)
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
            if ($std->stdproc_id == 77) {
                $result['target'] = $std->value;
            } elseif ($std->stdproc_id == 78) {
                $result['ct_target'] = $std->value;
            } elseif ($std->stdproc_id == 79) {
                $result['berat_target'] = $std->value;
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
            // Ambil angka dari "TRIAL 3"
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

    $report     = [];
    $categories = [];
    $trialInfo  = [];

    foreach ($trials as $trial) {
        $trialKey = $trial->trial_no . ' ' . $trial->trial_stat;

        // info trial
        $trialInfo[$trialKey] = [
    'id' => $trial->id,
    'att1' => $trial->att1 ?? null, // Tambahkan ini
    'defectIds' => []
];

        /* OK */
        $okQuant   = (float) ($trial->ok ?? 0);
        $okPercent = (float) ($trial->perct ?? 0);

        $report['OK']['OK'][$trialKey] = [
            'quant'   => $okQuant,
            'percent' => $okPercent
        ];

        $totalQuant   = $okQuant;
        $totalPercent = $okPercent;

        /* DETAIL NG */
        $details = Maio::get_trial_rr_det(
            $project_id,
            $process_id,
            $trial->id
        );

        foreach ($details as $det) {
            $category  = $det->trans_type;
            $defectKey = $det->defect_id; // ✅ KUNCI PAKAI ID
            $defectLbl = $det->defect_name;

            // simpan mapping defect_id
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

            $ngQuant   = (float) ($det->ng ?? 0);
            $ngPercent = (float) ($det->perct ?? 0);

            $totalQuant   += $ngQuant;
            $totalPercent += $ngPercent;

            $report[$category][$defectKey][$trialKey] = [
                'quant'   => $ngQuant,
                'percent' => $ngPercent,
                'actual'  => $trial->actual
            ];
        }

        /* JUMLAH */
        $actualQty = (float) ($trial->actual ?? 0);

        $totalPercentCalc = $actualQty > 0
            ? ($totalQuant / $actualQty) * 100
            : $totalPercent;

        $report['Jumlah']['Jumlah'][$trialKey] = [
            'quant'   => $totalQuant,
            'percent' => round($totalPercentCalc, 2)
        ];
    }

    /* TARGET */
    $targets = [];
    foreach ($trials as $trial) {
        $targets[$trial->trial_no . ' ' . $trial->trial_stat] = (float) $trial->target;
    }

    return response()->json([
        'columns'    => $trials->map(fn ($t) => $t->trial_no . ' ' . $t->trial_stat)->toArray(),
        'targets'    => $targets,
        'trials'     => $trialInfo,
        'categories' => array_values(array_unique($categories)),
        'data'       => $report
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
            if ($t->id == $request->trial_id) {
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

        $actualQty = (float) ($trial->actual ?? 0);
        
        if ($actualQty <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Actual quantity must be greater than 0'
            ], 422);
        }

        $existingDetails = Maio::get_trial_rr_det(
            $request->project_id,
            $request->process_id,
            $request->trial_id
        );

        $totalQuantWithoutCurrent = (float) ($trial->ok ?? 0); 
        
        foreach ($existingDetails as $detail) {
            if ($detail->defect_id == $request->defect_id) {
                continue;
            }
            $totalQuantWithoutCurrent += (float) ($detail->ng ?? 0);
        }

        $totalPercentWithoutCurrent = (float) ($trial->perct ?? 0); 
        
        foreach ($existingDetails as $detail) {
            if ($detail->defect_id == $request->defect_id) {
                continue;
            }
            $totalPercentWithoutCurrent += (float) ($detail->perct ?? 0);
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
        \Log::error('Error updating trial detail: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

public function markSaveLater(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'process_id' => 'required',
            'trial_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Panggil model untuk update ATT1 = 1 untuk semua row di trial terakhir
        $updated = Mapp::markTrialAsSaveLater(
            $request->project_id,
            $request->process_id,
            $request->trial_id
        );

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Trial marked as "Save Later" successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update trial status'
        ], 500);

    } catch (\Exception $e) {
        \Log::error('Error marking trial as save later: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

public function setAtt1Null(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'process_id' => 'required',
            'trial_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Panggil model untuk set ATT1 = NULL untuk semua row di trial terakhir
        $updated = Mapp::setAtt1NullForTrial(
            $request->project_id,
            $request->process_id,
            $request->trial_id
        );

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'ATT1 set to NULL successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update ATT1'
        ], 500);

    } catch (\Exception $e) {
        \Log::error('Error setting ATT1 to NULL: ' . $e->getMessage());
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


    // public function trailreport($project, $process, $trial)
// {
//     $rows = Maio::get_trial_rr_det_report($project, $process, $trial);

    //     $report = [
//         'category' => '',
//         'ok' => null,
//         'ok_percent' => null,
//         'defects' => []
//     ];

    //     foreach ($rows as $row) {
//         if ($row->trans_type && empty($report['category'])) {
//             $report['category'] = $row->trans_type;
//         }

    //         if (!is_null($row->ok)) {
//             $report['ok'] = $row->ok;
//             $report['ok_percent'] = $row->perct;
//         }

    //         if (!empty($row->defect_name)) {
//             $report['defects'][$row->defect_name] = $row->ng;
//         }
//     }

    //     // Ambil data nama dari request (akan dikirim dari halaman sebelumnya)
//     $project_name = request('project_name', 'Project');
//     $process_name = request('process_name', 'Process');

    //     return view('template.wrapper', [
//         'title' => 'Trail Report',
//         'content' => 'pm.trailreport',
//         'project_id' => $project,
//         'process_id' => $process,
//         'trial' => $trial,
//         'project_name' => $project_name,
//         'process_name' => $process_name,
//         'report' => $report
//     ]);
// }








    public function problem()
    {
        $data = [
            'title' => 'Problem History',
            'content' => 'pm.problem'
        ];
        return view('template.wrapper', $data);
    }

}
