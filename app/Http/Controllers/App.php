<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maio;
use App\Models\Mapp;
use App\Models\Mauth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
        $holiday = Maio::get_holiday_table();     // untuk tabel

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

        // Get all tasks from all projects
        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->id);
            $allTasks = $allTasks->merge($projectTasks);
        }

        // Get all resources
        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->npk);
        });

        // Process all data
        $initialData = $this->processResourceData($allTasks, $resources);

        $data = [
            'title' => 'Resource Workload',
            'content' => 'pm.resource',
            'projects' => $projects,
            'initialData' => $initialData,
            'totalProjects' => $totalProjects // Tambahkan total projects ke view
        ];
        return view('template.wrapper', $data);
    }

    public function getAllResourcesData()
    {
        try {
            $projects = Maio::get_projects();
            $totalProjects = count($projects);

            // Get all tasks from all projects
            $allTasks = collect();
            foreach ($projects as $project) {
                $projectTasks = Maio::get_project_task($project->id);
                $allTasks = $allTasks->merge($projectTasks);
            }

            // Get all resources
            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->npk);
            });

            // Process all data
            $resourceData = $this->processResourceData($allTasks, $resources);

            return response()->json([
                'success' => true,
                'data' => $resourceData,
                'stats' => [
                    'total_resources' => count($resourceData),
                    'total_projects' => $totalProjects, // Kirim total projects
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

        // Initialize with all resources from RESOURCE_MGMT
        foreach ($resources as $resource) {
            $resourceData[$resource->emp_name] = [
                'tasks' => 0,
                'plan_hours' => 0,
                'milestones' => 0,
                'projects' => [] // Track unique projects
            ];
        }

        // Process all task data
        foreach ($tasks as $task) {
            $responsibleName = $task->responsible_name ?: 'Unassigned';

            // Skip task dengan STATUS = 3 (jangan dihitung task dan plan hours nya)
            if (isset($task->status) && $task->status == '3') {
                continue;
            }

            // Skip milestone 70 dari perhitungan
            $isMilestone70 = (isset($task->is_milestone) && $task->is_milestone == '70');
            if ($isMilestone70) {
                continue;
            }

            // Only process if the responsible exists in our resource data
            if (isset($resourceData[$responsibleName])) {
                // Task sudah tidak perlu dicek milestone 70 lagi karena sudah di-skip di atas
                $resourceData[$responsibleName]['tasks']++;

                $resourceData[$responsibleName]['plan_hours'] += floatval($task->plan_hour ?: 0);

                // Track unique projects
                if ($task->project_name && !in_array($task->project_name, $resourceData[$responsibleName]['projects'])) {
                    $resourceData[$responsibleName]['projects'][] = $task->project_name;
                }

                // Count milestones (hanya milestone dengan nilai '1')
                if (isset($task->is_milestone) && $task->is_milestone == '1') {
                    $resourceData[$responsibleName]['milestones']++;
                }
            } else {
                // If resource not in resource management, add to Unassigned
                if (!isset($resourceData['Unassigned'])) {
                    $resourceData['Unassigned'] = [
                        'tasks' => 0,
                        'plan_hours' => 0,
                        'milestones' => 0,
                        'projects' => []
                    ];
                }

                // Task sudah tidak perlu dicek milestone 70 lagi karena sudah di-skip di atas
                $resourceData['Unassigned']['tasks']++;
                $resourceData['Unassigned']['plan_hours'] += floatval($task->plan_hour ?: 0);

                // Count milestones untuk Unassigned juga
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

        // Get holiday
        $holidays = Maio::get_holiday();

        // Get all tasks
        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->id);
            $allTasks = $allTasks->merge($projectTasks);
        }

        // Get year range from tasks
        $yearRange = $this->getYearRangeFromTasks($allTasks);

        // Jika tidak ada data, gunakan tahun saat ini ±1
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
            'yearRange' => $yearRange // <-- Tambahkan ini
        ];

        return view('template.wrapper', $data);
    }

    /**
     * Get minimum and maximum year from tasks
     */
    private function getYearRangeFromTasks($tasks)
    {
        $years = [];

        foreach ($tasks as $task) {
            // Skip jika STATUS = 3 (Canceled/Closed)
            if (isset($task->status) && $task->status == '3') {
                continue;
            }

            // Skip jika milestone 70
            if (isset($task->is_milestone) && $task->is_milestone == '70') {
                continue;
            }

            // Cek semua tanggal yang relevan
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

            // Get all tasks
            $allTasks = collect();
            foreach ($projects as $project) {
                $projectTasks = Maio::get_project_task($project->id);
                $allTasks = $allTasks->merge($projectTasks);
            }

            // Filter by person
            if (!empty($person)) {
                $allTasks = $allTasks->filter(function ($task) use ($person) {
                    return $task->responsible == $person;
                });
            }

            // Get year range dari tasks yang sudah difilter
            $yearRange = $this->getYearRangeFromTasks($allTasks);

            // Jika tidak ada data, gunakan tahun request ±1
            if (empty($yearRange)) {
                $yearRange = [
                    'min' => $year - 1,
                    'max' => $year + 1
                ];
            }

            // Process heatmap data
            $heatmapData = $this->processHeatmapData($allTasks, $timeframe, $person);

            // Get resources
            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->npk);
            });

            // Get holiday
            $holidays = Maio::get_holiday();

            return response()->json([
                'success' => true,
                'data' => $heatmapData,
                'resources' => $resources,
                'holidays' => $holidays,
                'yearRange' => $yearRange, // <-- Kirim juga yearRange
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
        // Initialize arrays for hours and tasks count
        $hoursData = [];
        $tasksData = [];

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize all years dari 2023 ke 2030
        for ($year = 2023; $year <= 2030; $year++) {
            for ($day = 1; $day <= 31; $day++) {
                $hoursData[$year][$day] = array_fill_keys($months, 0);
                $tasksData[$year][$day] = array_fill_keys($months, 0);
            }
        }

        foreach ($tasks as $task) {
            // Skip jika STATUS = 3 (Canceled/Closed)
            if (isset($task->status) && $task->status == '3') {
                continue;
            }

            // Skip jika milestone 70
            if (isset($task->is_milestone) && $task->is_milestone == '70') {
                continue;
            }

            // Tentukan tanggal dan nilai berdasarkan timeframe
            if ($timeframe === 'actual') {
                // Tentukan tanggal berdasarkan actual dates
                $startDateField = 'actual_start';
                $endDateField = 'actual_end';

                // Gunakan actual_hour jika ada, jika tidak gunakan heat_task, jika tidak gunakan plan_hour
                // FULL VALUE setiap hari untuk actual juga
                $heatValue = !empty($task->actual_hour) ? floatval($task->actual_hour) :
                    (!empty($task->heat_task) ? floatval($task->heat_task) :
                        (!empty($task->plan_hour) ? floatval($task->plan_hour) : 0));
            } else {
                // Tentukan tanggal berdasarkan plan dates
                $startDateField = 'plan_start';
                $endDateField = 'plan_end';

                // Gunakan heat_task jika ada, jika tidak gunakan plan_hour
                // FULL VALUE setiap hari
                $heatValue = !empty($task->heat_task) ? floatval($task->heat_task) :
                    (!empty($task->plan_hour) ? floatval($task->plan_hour) : 0);
            }

            // Check jika ada tanggal
            if (!empty($task->$startDateField) && !empty($task->$endDateField)) {
                try {
                    $startDate = Carbon::parse($task->$startDateField);
                    $endDate = Carbon::parse($task->$endDateField);

                    // Pastikan startDate <= endDate
                    if ($startDate->gt($endDate)) {
                        continue;
                    }

                    // Jika tidak ada nilai, skip
                    if ($heatValue <= 0) {
                        continue;
                    }

                    // Loop melalui setiap hari dalam rentang tanggal
                    $currentDate = $startDate->copy();

                    while ($currentDate->lte($endDate)) {
                        $year = $currentDate->year;
                        $month = $months[$currentDate->month - 1];
                        $day = $currentDate->day;

                        // Pastikan year, day, month valid
                        if ($year >= 2023 && $year <= 2030 && $day >= 1 && $day <= 31) {
                            // ==================== HOURS DATA ====================
                            // FULL VALUE setiap hari, TIDAK dibagi!
                            $hoursData[$year][$day][$month] += $heatValue;

                            // ==================== TASK COUNT DATA ====================
                            // Tambah ke jumlah task (hitung 1 task per hari)
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
        // Ambil semua data dari sistem (analogi dengan heatmap)
        $projects = Maio::get_projects();

        // Ambil semua tasks
        $allTasks = collect();
        foreach ($projects as $project) {
            $projectTasks = Maio::get_project_task($project->id);
            $allTasks = $allTasks->merge($projectTasks);
        }

        // Ambil resources (untuk dropdown)
        $resources = Maio::get_resource_mgmt()->filter(function ($r) {
            return !empty($r->npk);
        });

        // Format resources untuk dropdown
        $resourceList = $resources->map(function ($resource) {
            return [
                'id' => $resource->npk,
                'name' => $resource->emp_name ?? $resource->name ?? $resource->npk
            ];
        })->unique('id');

        // Urutkan berdasarkan nama
        $resourceList = $resourceList->sortBy('name')->values();

        // Default value untuk "All"
        $defaultResource = 'all';

        // Hitung statistik untuk "All" (semua resources)
        $stats = $this->calculateResourceProgress($allTasks, 'all');

        // Get chart data untuk "All"
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
        // Filter tasks berdasarkan resource
        if ($resourceId !== 'all') {
            $filteredTasks = $allTasks->filter(function ($task) use ($resourceId) {
                return isset($task->responsible) && $task->responsible == $resourceId;
            });
        } else {
            // Jika "all", gunakan semua tasks
            $filteredTasks = $allTasks;
        }

        // Hitung berdasarkan status
        $statusCounts = [
            'Open' => 0,
            'InProgress' => 0,
            'Completed' => 0,
            'OnHold' => 0,
            'Cancelled' => 0,
            'OTHER' => 0
        ];

        // Mapping status: 1=Open, 2=InProgress, 3=Completed, 4=OnHold, 5=Cancelled
        $statusMapping = [
            '1' => 'Open',
            '2' => 'InProgress',
            '3' => 'Completed',
            '4' => 'OnHold',
            '5' => 'Cancelled'
        ];

        // Hitung bulan ini dan tahun ini
        $currentMonth = date('n');
        $currentYear = date('Y');
        $nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
        $nextMonthYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;
        $nextYear = $currentYear + 1;

        // Inisialisasi counters
        $dueThisMonth = 0;
        $dueNextMonth = 0;
        $dueThisYear = 0;
        $dueNextYear = 0;

        foreach ($filteredTasks as $task) {
            // Hitung berdasarkan status
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

            // Hitung due dates jika ada plan_end
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

        // Hitung total tasks
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

        // Filter tasks
        if ($resourceId !== 'all') {
            $filteredTasks = $allTasks->filter(function ($task) use ($resourceId) {
                return isset($task->responsible) && $task->responsible == $resourceId;
            });
        } else {
            // Jika "all", gunakan semua tasks
            $filteredTasks = $allTasks;
        }

        foreach ($filteredTasks as $task) {
            if (isset($task->status)) {
                $statusKey = (string) $task->status;

                // Cari index dalam chartData
                $index = false;
                if (array_key_exists($statusKey, $statusMapping)) {
                    $statusName = $statusMapping[$statusKey];
                    $index = array_search($statusName, array_column($chartData, 'name'));
                }

                if ($index !== false) {
                    $chartData[$index]['y']++;
                } else {
                    // Cari OTHER
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

            // Ambil resources
            $resources = Maio::get_resource_mgmt()->filter(function ($r) {
                return !empty($r->npk);
            });

            $resourceList = $resources->map(function ($resource) {
                return [
                    'id' => $resource->npk,
                    'name' => $resource->emp_name ?? $resource->name ?? $resource->npk
                ];
            })->unique('id');

            // Urutkan berdasarkan nama
            $resourceList = $resourceList->sortBy('name')->values();

            // Hitung statistik
            $stats = $this->calculateResourceProgress($allTasks, $person);

            // Ambil data chart
            $chartData = $this->getChartData($allTasks, $person);

            // Hitung overall progress (Completed / Total)
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
        // Ambil semua projects untuk dropdown filter
        $projects = Maio::get_projects();

        // Inisialisasi allTasks sebagai collection kosong
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
            'all_tasks' => $allTasks, // Kosong dulu
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

            // Tambahkan project_id dan project_name ke setiap task
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

        // ===========================
        // REMAINING BUDGET
        // ===========================
        $remainingBudget = $budget - $invoiceAmount;

        // ===========================
        // OVERALL PROGRESS (MS = 21)
        // ===========================
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

        // ================================
        // PROJECT MILESTONE (MS = 20)
        // ================================
        $milestoneTotal = $tasks->filter(function ($t) {
            return $t->is_milestone == 20;
        })->count();

        $milestoneFinish = $tasks->filter(function ($t) {
            return $t->is_milestone == 20 && $t->status == 3;
        })->count();

        $milestoneProgress = ($milestoneTotal > 0)
            ? round(($milestoneFinish / $milestoneTotal) * 100)
            : 0;

        // ==========================
        // TASK COMPLETE (MS = 21)
        // ==========================
        $taskTotal = $tasks->filter(function ($t) {
            return $t->is_milestone == 21;
        })->count();

        $taskFinish = $tasks->filter(function ($t) {
            return $t->is_milestone == 21 && $t->status == 3;
        })->count();

        $taskComplete = ($taskTotal > 0)
            ? round(($taskFinish / $taskTotal) * 100)
            : 0;

        // ============================
        // PLAN HOURS & HOURS SPENT
        // ============================
        $planHours = $tasks->sum('plan_hour');
        $hoursSpent = $tasks->sum('actual_hour');

        // ============================
        // TASK BY STATUS
        // ============================
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

        // ============================
        // KELOMPOKKAN TASK BERDASARKAN STRUKTUR 3 LEVEL
        // ============================
        $groupedTasks = [];

        // 1. LEVEL 1: Milestone utama (is_milestone = 20, parent_task = NULL)
        foreach ($tasks as $task) {
            if ($task->is_milestone == 20 && empty($task->parent_task)) {
                $taskId = $task->task_id ?? $task->id;
                $groupedTasks[$taskId] = [
                    'parent' => $task,
                    'activities' => [] // Level 2 activities
                ];
            }
        }

        // 2. LEVEL 2: Activities (is_milestone = 21) yang punya parent di Level 1
        foreach ($tasks as $task) {
            if ($task->is_milestone == 21 && !empty($task->parent_task)) {
                $parentId = $task->parent_task;
                if (isset($groupedTasks[$parentId])) {
                    $activityId = $task->task_id ?? $task->id;
                    $groupedTasks[$parentId]['activities'][$activityId] = [
                        'activity' => $task,
                        'subactivities' => [] // Level 3 subactivities
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
        $process = $lov->where('init', 'process');

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

        $data = Maio::get_trial_rr($project_id, $process_id);

        return response()->json($data);
    }


    public function trial_store(Request $req)
    {
        try {
            Mapp::insert_trial($req);

            return response()->json([
                'status' => true,
                'message' => 'Trial berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
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

    


    public function problem()
    {
        $data = [
            'title' => 'Problem History',
            'content' => 'pm.problem'
        ];
        return view('template.wrapper', $data);
    }

}

// public function zzz_updateStatus(Request $request)
// {
//     $update = Mapp::updateStatus($request);

//     if ($update['success']) {
//         return response()->json([
//             'success' => true,
//             'message' => 'Status berhasil diperbarui!'
//         ]);
//     } else {
//         return response()->json([
//             'success' => false,
//             'message' => $update['message']
//         ]);
//     }
// }