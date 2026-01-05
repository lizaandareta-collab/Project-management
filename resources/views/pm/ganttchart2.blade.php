<div class="p-3">
    {{-- LOAD HIGHCHARTS --}}
    <script src="{{ asset('assets/js/highcharts-gantt.js') }}"></script>
    <script src="{{ asset('assets/js/pattern-fill.js') }}"></script>
    <script src="{{ asset('assets/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets/js/adaptive.js') }}"></script>
    
    {{-- TAMBAHKAN MODULE EXPORT --}}
    <script src="{{ asset('assets/js/exporting.js') }}"></script>
    <script src="{{ asset('assets/js/export-data.js') }}"></script>
    <script src="{{ asset('assets/js/full-screen.js') }}"></script>
    <script src="{{ asset('assets/js/offline-exporting.js') }}"></script>

    <style>
        body {
            background: var(--highcharts-background-color);
            color: var(--highcharts-neutral-color-100);
        }

        #container {
            width: 100%;
            max-width: 100%;
            margin: 0;
            height: 80vh;
            overflow: auto;
        }

        .highcharts-label-icon {
            opacity: 0.5;
        }

        /* Dashboard Header */
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .dashboard-header h2 {
            margin: 0;
            font-weight: 700;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-card .label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Filter Section - DIKECILKAN */
        .filter-section {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .filter-section h5 {
            color: #495057;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 1rem;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 12px;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #495057;
            font-size: 0.8rem;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 0.8rem;
            background: white;
        }

        .filter-group input[type="date"] {
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            transform: scale(0.9);
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: normal;
            font-size: 0.8rem;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #dee2e6;
        }

        .btn-filter {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-reset {
            background-color: #6c757d;
            color: white;
        }

        .btn-reset:hover {
            background-color: #5c636a;
            transform: translateY(-1px);
        }

        .quick-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn-action {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.85rem;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            background: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
            text-decoration: none;
        }

        /* Fullscreen styles */
        .highcharts-container {
            overflow: auto !important;
        }

        .highcharts-root {
            overflow: visible !important;
        }

        /* Menu Export Styles */
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 0 10px;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .export-menu-container {
            position: relative;
            display: none; /* Hidden by default */
        }

        .export-menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .export-menu-btn:hover {
            background-color: #f0f0f0;
        }

        .export-menu-btn svg {
            width: 24px;
            height: 24px;
            fill: #666;
        }

        .export-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            min-width: 200px;
            display: none;
        }

        .export-menu.show {
            display: block;
        }

        .export-menu-item {
            display: block;
            width: 100%;
            padding: 10px 15px;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            font-size: 0.9rem;
            color: #333;
            transition: background-color 0.2s;
        }

        .export-menu-item:hover {
            background-color: #f5f5f5;
        }

        .export-menu-item:not(:last-child) {
            border-bottom: 1px solid #eee;
        }

        /* Hide default Highcharts export button */
        .highcharts-contextbutton {
            display: none !important;
        }
    </style>

    <div class="dashboard-stats" id="statsContainer">
        <div class="stat-card">
            <div class="number">0</div>
            <div class="label">Total Tasks</div>
        </div>
        <div class="stat-card">
            <div class="number">0</div>
            <div class="label">In Progress</div>
        </div>
        <div class="stat-card">
            <div class="number">0%</div>
            <div class="label">Completed Tasks</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-row">
            <div class="filter-group">
                <label for="projectNameFilter">Project Name</label>
                <select id="projectNameFilter">
                    <option value="">Select Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="responsibleFilter">Responsible</label>
                <select id="responsibleFilter" disabled>
                    <option value="">All Responsible</option>
                    @foreach($responsible as $res)
                        <option value="{{ $res->npk }}">{{ $res->emp_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="statusFilter">Status</label>
                <select id="statusFilter" disabled>
                    <option value="">All Status</option>
                    @foreach($lov_status as $status)
                        <option value="{{ $status->lov_id }}">{{ $status->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="complexityFilter">Complexity</label>
                <select id="complexityFilter" disabled>
                    <option value="">All Complexity</option>
                    @foreach($lov_complexity as $complexity)
                        <option value="{{ $complexity->lov_id }}">{{ $complexity->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="filter-row">
            <div class="filter-group">
                <label for="priorityFilter">Priority</label>
                <select id="priorityFilter" disabled>
                    <option value="">All Priority</option>
                    @foreach($lov_priority as $priority)
                        <option value="{{ $priority->lov_id }}">{{ $priority->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="categoryFilter">Category</label>
                <select id="categoryFilter" disabled>
                    <option value="">All Category</option>
                    @foreach($lov_is_milestone as $category)
                        <option value="{{ $category->lov_id }}">{{ $category->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="timeFrameFilter">Time Frame Based On</label>
                <select id="timeFrameFilter" disabled>
                    <option value="">All Frame</option>
                    <option value="plan">Plan Dates Only</option>
                    <option value="actual">Actual Dates Only</option>
                    <option value="both">Plan & Actual</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="overdueFilter">Overdue Tasks</label>
                <select id="overdueFilter" disabled>
                    <option value="">All Tasks</option>
                    <option value="overdue">Overdue Tasks</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="ganttViewFilter">Gantt Chart View</label>
                <select id="ganttViewFilter" disabled>
                    <option value="day">Daily</option>
                    <option value="week">Weekly</option>
                    <option value="month" selected>Monthly</option>
                    <option value="year">Yearly</option>
                </select>
            </div>
        </div>
        <div class="filter-row">
            <div class="filter-group">
                <label for="startDateFilter">Start Date</label>
                <input type="date" id="startDateFilter" disabled>
            </div>
            <div class="filter-group">
                <label for="endDateFilter">End Date</label>
                <input type="date" id="endDateFilter" disabled>
            </div>
        </div>
        <div class="filter-actions">
            <button class="btn-filter btn-reset" id="reset_filters" disabled>Reset Filters</button>
        </div>
    </div>

    <!-- Chart Header with Export Menu -->
    <div class="chart-header">
        <h2 class="chart-title" id="chartTitle" style="display: none;">Project Gantt Chart</h2>
        <div class="export-menu-container" id="exportMenuContainer">
            <button class="export-menu-btn" id="exportMenuBtn">
                <svg viewBox="0 0 24 24">
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
            </button>
            <div class="export-menu" id="exportMenu">
                <button class="export-menu-item" id="fullscreenBtn">View in full screen</button>
                <button class="export-menu-item" id="printChartBtn">Print chart</button>
                <button class="export-menu-item" id="downloadPNGBtn">Download PNG image</button>
                <button class="export-menu-item" id="downloadJPGBtn">Download JPEG image</button>
            </div>
        </div>
    </div>

    <div id="container">
        <div style="text-align: center; padding: 50px; color: #6c757d;">
            Please select a project to view tasks
        </div>
    </div>

    <script>
        const day = 24 * 36e5,
            today = Math.floor(Date.now() / day) * day;

        // Data dari PHP
        const projectsData = @json($projects);
        const lovStatus = @json($lov_status);
        const lovComplexity = @json($lov_complexity);
        const lovPriority = @json($lov_priority);
        const responsible = @json($responsible);

        // Variabel global untuk menyimpan data tasks
        let currentTasks = [];
        let currentTimeFrame = '';
        let currentGanttView = 'month';
        let chart;
        let currentOverdueFilter = '';

        // Fungsi untuk mengambil tasks berdasarkan project
        async function load_project_tasks(projectId) {
            try {
                document.getElementById('container').innerHTML = '<div style="text-align: center; padding: 50px;">Loading tasks...</div>';
                document.getElementById('chartTitle').style.display = 'none';

                const response = await fetch(`/api/project-tasks/${projectId}`);
                const tasks = await response.json();

                currentTasks = tasks;

                console.log('Loaded tasks:', tasks);

                enable_filters();
                update_static_tasks();
                render_ganttChart();

            } catch (error) {
                console.error('Error loading tasks:', error);
                document.getElementById('container').innerHTML = '<div style="text-align: center; padding: 50px; color: red;">Error loading tasks</div>';
                document.getElementById('chartTitle').style.display = 'none';
            }
        }

        // Fungsi untuk enable filter controls
        function enable_filters() {
            document.getElementById('responsibleFilter').disabled = false;
            document.getElementById('statusFilter').disabled = false;
            document.getElementById('complexityFilter').disabled = false;
            document.getElementById('priorityFilter').disabled = false;
            document.getElementById('categoryFilter').disabled = false;
            document.getElementById('timeFrameFilter').disabled = false;
            document.getElementById('ganttViewFilter').disabled = false;
            document.getElementById('startDateFilter').disabled = false;
            document.getElementById('endDateFilter').disabled = false;
            document.getElementById('reset_filters').disabled = false;
            document.getElementById('overdueFilter').disabled = false;
        }

        // Fungsi untuk disable filter controls
        function disable_filters() {
            document.getElementById('responsibleFilter').disabled = true;
            document.getElementById('statusFilter').disabled = true;
            document.getElementById('complexityFilter').disabled = true;
            document.getElementById('priorityFilter').disabled = true;
            document.getElementById('categoryFilter').disabled = true;
            document.getElementById('timeFrameFilter').disabled = true;
            document.getElementById('ganttViewFilter').disabled = true;
            document.getElementById('startDateFilter').disabled = true;
            document.getElementById('endDateFilter').disabled = true;
            document.getElementById('reset_filters').disabled = true;
            document.getElementById('overdueFilter').disabled = true;
        }

        // Fungsi untuk menghitung statistics
        function calculate_static_tasks(tasks) {
            const totalTasks = tasks.length;

            const completedTasks = tasks.filter(task =>
                task.status === 'COMPLETED' ||
                (task.status_name && task.status_name.toUpperCase().includes('COMPLETED'))
            ).length;

            const inProgressTasks = tasks.filter(task =>
                task.status == 2
            ).length;

            const overdueTasks = tasks.filter(task => {
                if (!task.plan_end) return false;
                const planEnd = new Date(task.plan_end);
                const today = new Date();
                return planEnd < today &&
                    task.status !== 'COMPLETED' &&
                    !(task.status_name && task.status_name.toUpperCase().includes('COMPLETED'));
            }).length;

            return {
                totalTasks,
                completedTasks,
                inProgressTasks,
                overdueTasks,
                completionRate: totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0
            };
        }

        // Fungsi untuk update statistics cards
        function update_static_tasks() {
            const stats = calculate_static_tasks(currentTasks);
            const statsContainer = document.getElementById('statsContainer');
            statsContainer.innerHTML = `
            <div class="stat-card">
                <div class="number">${stats.totalTasks}</div>
                <div class="label">Total Tasks</div>
            </div>
            <div class="stat-card">
                <div class="number">${stats.inProgressTasks}</div>
                <div class="label">In Progress</div>
            </div>
            <div class="stat-card">
                <div class="number">${stats.completionRate}%</div>
                <div class="label">Completed Tasks</div>
            </div>
        `;
        }

        // Fungsi untuk mendapatkan rentang tanggal berdasarkan view dan filter
        function getDateRangeByView(view, startDateFilter = null, endDateFilter = null) {
            let startDate, endDate;
            const now = new Date();

            // Jika ada filter tanggal manual, gunakan itu
            if (startDateFilter && endDateFilter) {
                startDate = new Date(startDateFilter);
                endDate = new Date(endDateFilter);
            } else {
                // Jika tidak ada filter, gunakan rentang default berdasarkan view
                switch (view) {
                    case 'day':
                        // Default: bulan ini
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                        break;

                    case 'week':
                        // Default: 3 bulan
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        endDate = new Date(now.getFullYear(), now.getMonth() + 3, 0);
                        break;

                    case 'month':
                        // Default: 1 tahun
                        startDate = new Date(now.getFullYear(), 0, 1);
                        endDate = new Date(now.getFullYear(), 11, 31);
                        break;

                    case 'year':
                        // Default: 3 tahun
                        startDate = new Date(now.getFullYear(), 0, 1);
                        endDate = new Date(now.getFullYear() + 2, 11, 31);
                        break;

                    default:
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                }
            }

            return {
                min: Date.UTC(
                    startDate.getFullYear(),
                    startDate.getMonth(),
                    startDate.getDate(),
                    0, 0, 0, 0
                ),
                max: Date.UTC(
                    endDate.getFullYear(),
                    endDate.getMonth(),
                    endDate.getDate(),
                    23, 59, 59, 999
                )
            };
        }

        // Fungsi untuk mendapatkan konfigurasi xAxis berdasarkan view
        function get_xaxis_config(view, minDate, maxDate) {
            const dateRange = maxDate - minDate;
            const daysRange = dateRange / day;
            
            let tickInterval, units, dateTimeLabelFormats;

            switch (view) {
                case 'day':
                    // Untuk view daily, tampilkan per hari
                    tickInterval = day;
                    units = [['day', [1]]];
                    dateTimeLabelFormats = {
                        day: '%e %b',
                        week: '%e %b',
                        month: '%b %Y'
                    };
                    break;

                case 'week':
                    // Untuk view weekly, tampilkan per minggu
                    tickInterval = 7 * day;
                    units = [['week', [1]]];
                    dateTimeLabelFormats = {
                        day: '%e %b',
                        week: 'Week %W<br>%e %b',
                        month: '%b %Y'
                    };
                    break;

                case 'month':
                    // Untuk view monthly, tampilkan per bulan (hanya bulan dan tahun)
                    tickInterval = 30 * day;
                    units = [['month', [1]]];
                    dateTimeLabelFormats = {
                        day: '', // Sembunyikan format hari
                        week: '', // Sembunyikan format minggu
                        month: '%b %Y', // Hanya tampilkan bulan dan tahun
                        year: '%Y'
                    };
                    break;

                case 'year':
                    // Untuk view yearly, tampilkan per tahun
                    tickInterval = 365 * day;
                    units = [['year', [1]]];
                    dateTimeLabelFormats = {
                        day: '%e %b',
                        week: '%e %b',
                        month: '%b',
                        year: '%Y'
                    };
                    break;

                default:
                    tickInterval = 30 * day;
                    units = [['month', [1]]];
                    dateTimeLabelFormats = {
                        day: '%e %b',
                        week: '%e %b',
                        month: '%b %Y'
                    };
            }

            return {
                tickInterval: tickInterval,
                units: units,
                dateTimeLabelFormats: dateTimeLabelFormats
            };
        }

        // Fungsi untuk mengecek apakah task overdue
        function isTaskOverdue(task) {
            const isNotCompleted = !(task.status === 'COMPLETED' ||
                (task.status_name && task.status_name.toUpperCase().includes('COMPLETED')));

            if (!isNotCompleted) return false;

            const today = new Date();

            if (task.plan_end) {
                const planEnd = new Date(task.plan_end);
                if (planEnd < today) return true;
            }

            if (task.actual_end) {
                const actualEnd = new Date(task.actual_end);
                if (actualEnd < today) return true;
            }

            return false;
        }

        // Fungsi untuk mengonversi data task ke format Highcharts Gantt
        function data_task_to_ganttChart(tasks, timeFrame = '') {
            if (!tasks || tasks.length === 0) {
                return [{
                    name: 'No Tasks Available',
                    data: [{
                        name: 'No tasks found with current filters',
                        id: 'no_data',
                        start: today,
                        end: today + day
                    }]
                }];
            }

            const seriesData = [];
            const projectMap = new Map();

            function convertToTimestamp(dateString) {
                if (!dateString) return null;
                try {
                    const date = new Date(dateString);
                    return Date.UTC(
                        date.getFullYear(),
                        date.getMonth(),
                        date.getDate(),
                        12, 0, 0, 0
                    );
                } catch (error) {
                    console.error('Error converting date:', dateString, error);
                    return null;
                }
            }

            tasks.forEach(task => {
                const projectId = task.project_id;
                if (!projectMap.has(projectId)) {
                    projectMap.set(projectId, {
                        projectName: task.project_name,
                        tasks: []
                    });
                }
                projectMap.get(projectId).tasks.push(task);
            });

            projectMap.forEach((projectData, projectId) => {
                const projectTasks = [];

                projectTasks.push({
                    name: projectData.projectName,
                    id: `project_${projectId}`,
                    responsible: projectData.tasks[0]?.responsible_name || 'Unassigned',
                    color: get_project_color(projectId)
                });

                projectData.tasks.forEach((task, index) => {
                    const taskId = `task_${projectId}_${index}`;
                    const taskName = task.milestone_task ||
                        (task.is_milestone_name ? `Milestone ${index + 1}` : `Task ${index + 1}`);

                    const planStart = convertToTimestamp(task.plan_start);
                    const planEnd = convertToTimestamp(task.plan_end);
                    const actualStart = convertToTimestamp(task.actual_start);
                    const actualEnd = convertToTimestamp(task.actual_end);

                    switch (timeFrame) {
                        case 'plan':
                            if (planStart && planEnd) {
                                projectTasks.push({
                                    name: taskName,
                                    id: taskId + "_plan",
                                    parent: `project_${projectId}`,
                                    start: planStart,
                                    end: planEnd,
                                    color: '#f7e463',
                                    borderColor: '#e0c74f',
                                    opacity: 0.9,
                                    responsible: task.responsible_name,
                                    type: 'plan',
                                    plan_start: task.plan_start,
                                    plan_end: task.plan_end,
                                    actual_start: task.actual_start,
                                    actual_end: task.actual_end
                                });
                            }
                            break;

                        case 'actual':
                            if (actualStart && actualEnd) {
                                projectTasks.push({
                                    name: taskName,
                                    id: taskId + "_actual",
                                    parent: `project_${projectId}`,
                                    start: actualStart,
                                    end: actualEnd,
                                    color: '#7bd67b',
                                    borderColor: '#5cb85c',
                                    opacity: 0.9,
                                    responsible: task.responsible_name,
                                    type: 'actual',
                                    plan_start: task.plan_start,
                                    plan_end: task.plan_end,
                                    actual_start: task.actual_start,
                                    actual_end: task.actual_end
                                });
                            }
                            break;

                        case 'both':
                            if (planStart && planEnd) {
                                projectTasks.push({
                                    name: taskName + " (Plan)",
                                    id: taskId + "_plan",
                                    parent: `project_${projectId}`,
                                    start: planStart,
                                    end: planEnd,
                                    color: '#f7e463',
                                    borderColor: '#e0c74f',
                                    opacity: 0.9,
                                    responsible: task.responsible_name,
                                    type: 'plan',
                                    plan_start: task.plan_start,
                                    plan_end: task.plan_end,
                                    actual_start: task.actual_start,
                                    actual_end: task.actual_end
                                });
                            }
                            if (actualStart && actualEnd) {
                                projectTasks.push({
                                    name: taskName + " (Actual)",
                                    id: taskId + "_actual",
                                    parent: `project_${projectId}`,
                                    start: actualStart,
                                    end: actualEnd,
                                    color: '#7bd67b',
                                    borderColor: '#5cb85c',
                                    opacity: 0.9,
                                    responsible: task.responsible_name,
                                    type: 'actual',
                                    plan_start: task.plan_start,
                                    plan_end: task.plan_end,
                                    actual_start: task.actual_start,
                                    actual_end: task.actual_end
                                });
                            }
                            break;

                        case '':
                        default:
                            if (planStart && planEnd) {
                                projectTasks.push({
                                    name: taskName + " (Plan)",
                                    id: taskId + "_plan",
                                    parent: `project_${projectId}`,
                                    start: planStart,
                                    end: planEnd,
                                    color: '#f7e463',
                                    borderColor: '#e0c74f',
                                    opacity: 0.9,
                                    responsible: task.responsible_name,
                                    type: 'plan',
                                    plan_start: task.plan_start,
                                    plan_end: task.plan_end,
                                    actual_start: task.actual_start,
                                    actual_end: task.actual_end
                                });
                            }
                            if (actualStart && actualEnd) {
                                projectTasks.push({
                                    name: taskName + " (Actual)",
                                    id: taskId + "_actual",
                                    parent: `project_${projectId}`,
                                    start: actualStart,
                                    end: actualEnd,
                                    color: '#7bd67b',
                                    borderColor: '#5cb85c',
                                    opacity: 0.9,
                                    responsible: task.responsible_name,
                                    type: 'actual',
                                    plan_start: task.plan_start,
                                    plan_end: task.plan_end,
                                    actual_start: task.actual_start,
                                    actual_end: task.actual_end
                                });
                            }
                            if (!planStart && !planEnd && !actualStart && !actualEnd) {
                                projectTasks.push({
                                    name: taskName + " (No Dates)",
                                    id: taskId + "_nodate",
                                    parent: `project_${projectId}`,
                                    color: '#cccccc',
                                    borderColor: '#999999',
                                    opacity: 0.7,
                                    responsible: task.responsible_name,
                                    type: 'nodate',
                                    plan_start: null,
                                    plan_end: null,
                                    actual_start: null,
                                    actual_end: null
                                });
                            }
                            break;
                    }
                });

                seriesData.push({
                    name: projectData.projectName,
                    data: projectTasks
                });
            });

            return seriesData;
        }

        // Fungsi untuk generate warna unik untuk setiap project
        function get_project_color(projectId) {
            const colors = [
                '#fac70fff'
            ];
            return colors[projectId % colors.length];
        }

        // Fungsi untuk mendapatkan holiday plot bands
        function getHolidayPlotBands(holidays) {
            const plotBands = [];
            
            if (!holidays || holidays.length === 0) {
                return plotBands;
            }

            holidays.forEach(holiday => {
                try {
                    const holidayDate = new Date(holiday);
                    const startDate = Date.UTC(
                        holidayDate.getFullYear(),
                        holidayDate.getMonth(),
                        holidayDate.getDate(),
                        0, 0, 0, 0
                    );
                    const endDate = Date.UTC(
                        holidayDate.getFullYear(),
                        holidayDate.getMonth(),
                        holidayDate.getDate(),
                        23, 59, 59, 999
                    );

                    plotBands.push({
                        from: startDate,
                        to: endDate,
                        color: 'rgba(255, 0, 0, 0.2)',
                        label: {
                            text: 'Holiday',
                            style: {
                                color: '#ff0000',
                                fontSize: '10px',
                                fontWeight: 'bold'
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error processing holiday date:', holiday, error);
                }
            });

            return plotBands;
        }

        // Fungsi untuk render chart
        function render_ganttChart() {
            if (!currentTasks || currentTasks.length === 0) {
                document.getElementById('container').innerHTML = '<div style="text-align: center; padding: 50px; color: #6c757d;">No tasks available for the selected project</div>';
                document.getElementById('chartTitle').style.display = 'none';
                document.getElementById('exportMenuContainer').style.display = 'none';
                return;
            }

            const ganttData = data_task_to_ganttChart(currentTasks, currentTimeFrame);

            const startDateFilter = document.getElementById('startDateFilter').value;
            const endDateFilter = document.getElementById('endDateFilter').value;

            const dateRange = getDateRangeByView(currentGanttView, startDateFilter, endDateFilter);
            
            // Dapatkan konfigurasi xAxis berdasarkan view dan rentang tanggal
            const xAxisConfig = get_xaxis_config(currentGanttView, dateRange.min, dateRange.max);

            const holidayPlotBands = getHolidayPlotBands(@json($holidays));

            const options = {
                chart: {
                    plotBackgroundColor: 'rgba(128,128,128,0.02)',
                    plotBorderColor: 'rgba(128,128,128,0.1)',
                    plotBorderWidth: 1,
                    scrollablePlotArea: {
                        minWidth: 2000,
                        scrollPositionX: 0
                    },
                    height: '100%',
                    events: {
                        load: function() {
                            // Show export menu when chart is loaded
                            document.getElementById('exportMenuContainer').style.display = 'block';
                            document.getElementById('chartTitle').style.display = 'block';
                        }
                    }
                },

                plotOptions: {
                    series: {
                        borderRadius: '50%',
                        connectors: {
                            dashStyle: 'ShortDot',
                            lineWidth: 2,
                            radius: 5,
                            startMarker: { enabled: false }
                        },
                        groupPadding: 0,
                        dataLabels: [{
                            enabled: true,
                            align: 'left',
                            format: '{point.name}',
                            padding: 10,
                            style: { fontWeight: 'normal', textOutline: 'none' }
                        }, {
                            enabled: true,
                            align: 'right',
                            format: '{#if point.completed}{(multiply point.completed.amount 100):.0f}%{/if}',
                            padding: 10,
                            style: {
                                fontWeight: 'normal',
                                textOutline: 'none',
                                opacity: 0.6
                            }
                        }]
                    }
                },

                series: ganttData,

                tooltip: {
                    pointFormat:
                        '<span style="font-weight: bold">{point.name}</span><br>' +
                        'Project: <b>{point.projectName}</b><br>' +
                        '{#if point.plan_start}Plan Start: {point.plan_start:%e %b %Y}<br>{/if}' +
                        '{#if point.plan_end}Plan End: {point.plan_end:%e %b %Y}<br>{/if}' +
                        '{#if point.actual_start}Actual Start: {point.actual_start:%e %b %Y}<br>{/if}' +
                        '{#if point.actual_end}Actual End: {point.actual_end:%e %b %Y}<br>{/if}' +
                        'Bar Start: {point.start:%e %b %Y}<br>' +
                        'Bar End: {point.end:%e %b %Y}<br>' +
                        'Responsible: {point.responsible}<br>' +
                        '{#if point.status}Status: {point.status}<br>{/if}' +
                        '{#if point.complexity}Complexity: {point.complexity}<br>{/if}' +
                        '{#if point.priority}Priority: {point.priority}{/if}' +
                        '{#if point.isOverdue}<br><span style="color: red; font-weight: bold">⚠ OVERDUE</span>{/if}'
                },

                title: {
                    text: '' // Remove title from chart as we have it in the header
                },

                xAxis: [{
                    currentDateIndicator: {
                        color: '#2caffe',
                        dashStyle: 'ShortDot',
                        width: 2,
                        label: { format: 'Today' }
                    },
                    dateTimeLabelFormats: xAxisConfig.dateTimeLabelFormats,
                    grid: { borderWidth: 0 },
                    gridLineWidth: 1,
                    min: dateRange.min,
                    max: dateRange.max,
                    tickInterval: xAxisConfig.tickInterval,
                    units: xAxisConfig.units,
                    plotBands: holidayPlotBands,
                    custom: { today, weekendPlotBands: true }
                }],

                yAxis: {
                    grid: { borderWidth: 0 },
                    gridLineWidth: 0,
                    labels: {
                        symbol: { width: 8, height: 6, x: -4, y: -2 }
                    },
                    staticScale: 35
                },

                // Export configuration
                exporting: {
                    enabled: true,
                    sourceWidth: 1200,
                    sourceHeight: 800,
                    chartOptions: {
                        chart: {
                            backgroundColor: '#ffffff'
                        }
                    }
                }
            };

            if (chart) {
                chart.destroy();
            }

            chart = Highcharts.ganttChart('container', options);
            
            // Update chart title in header
            document.getElementById('chartTitle').textContent = `Project Gantt Chart - ${currentTasks[0]?.project_name ?? 'Project'}`;
        }

        // FUNGSI APPLY FILTERS
        function apply_filters() {
            const responsibleFilter = document.getElementById('responsibleFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const complexityFilter = document.getElementById('complexityFilter').value;
            const priorityFilter = document.getElementById('priorityFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            currentTimeFrame = document.getElementById('timeFrameFilter').value;
            currentGanttView = document.getElementById('ganttViewFilter').value;
            currentOverdueFilter = document.getElementById('overdueFilter').value;

            let filteredTasks = currentTasks.filter(task => {
                if (responsibleFilter && task.responsible !== responsibleFilter) return false;
                if (statusFilter && task.status !== statusFilter) return false;
                if (complexityFilter && task.complexity !== complexityFilter) return false;
                if (priorityFilter && task.priority !== priorityFilter) return false;
                if (categoryFilter && task.is_milestone !== categoryFilter) return false;
                if (currentOverdueFilter === 'overdue' && !isTaskOverdue(task)) return false;
                return true;
            });

            const stats = calculate_static_tasks(filteredTasks);
            const statsContainer = document.getElementById('statsContainer');
            statsContainer.innerHTML = `
            <div class="stat-card">
                <div class="number">${stats.totalTasks}</div>
                <div class="label">Total Tasks</div>
            </div>
            <div class="stat-card">
                <div class="number">${stats.inProgressTasks}</div>
                <div class="label">In Progress</div>
            </div>
            <div class="stat-card">
                <div class="number">${stats.completionRate}%</div>
                <div class="label">Completed Tasks</div>
            </div>
            `;

            render_ganttChart();
        }

        // Fungsi untuk mereset filter
        function reset_filters() {
            document.getElementById('responsibleFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('complexityFilter').value = '';
            document.getElementById('priorityFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('timeFrameFilter').value = '';
            document.getElementById('overdueFilter').value = '';
            document.getElementById('startDateFilter').value = '';
            document.getElementById('endDateFilter').value = '';
            document.getElementById('ganttViewFilter').value = 'month';

            currentTimeFrame = '';
            currentGanttView = 'month';
            currentOverdueFilter = '';

            update_static_tasks();
            render_ganttChart();
        }

        // Export menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const exportMenuBtn = document.getElementById('exportMenuBtn');
            const exportMenu = document.getElementById('exportMenu');
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            const printChartBtn = document.getElementById('printChartBtn');
            const downloadPNGBtn = document.getElementById('downloadPNGBtn');
            const downloadJPGBtn = document.getElementById('downloadJPGBtn');

            // Toggle export menu
            exportMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                exportMenu.classList.toggle('show');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function() {
                exportMenu.classList.remove('show');
            });

            // Fullscreen functionality
            fullscreenBtn.addEventListener('click', function() {
                if (chart) {
                    chart.fullscreen.toggle();
                }
                exportMenu.classList.remove('show');
            });

            // Print chart functionality
            printChartBtn.addEventListener('click', function() {
                if (chart) {
                    chart.print();
                }
                exportMenu.classList.remove('show');
            });

            // Download PNG functionality
            downloadPNGBtn.addEventListener('click', function() {
                if (chart) {
                    chart.exportChart({
                        type: 'image/png',
                        filename: 'gantt-chart-' + new Date().toISOString().slice(0, 10)
                    });
                }
                exportMenu.classList.remove('show');
            });

            // Download JPEG functionality
            downloadJPGBtn.addEventListener('click', function() {
                if (chart) {
                    chart.exportChart({
                        type: 'image/jpeg',
                        filename: 'gantt-chart-' + new Date().toISOString().slice(0, 10)
                    });
                }
                exportMenu.classList.remove('show');
            });
        });

        // Weekend plot bands plugin
        Highcharts.addEvent(Highcharts.Axis, 'foundExtremes', e => {
            if (e.target.options.custom && e.target.options.custom.weekendPlotBands) {
                const axis = e.target,
                    chart = axis.chart,
                    day = 24 * 36e5,
                    isWeekend = t => /[06]/.test(chart.time.dateFormat('%w', t)),
                    weekendPlotBands = [];

                let inWeekend = false;

                for (
                    let x = Math.floor(axis.min / day) * day;
                    x <= Math.ceil(axis.max / day) * day;
                    x += day
                ) {
                    const last = weekendPlotBands.at(-1);
                    if (isWeekend(x) && !inWeekend) {
                        weekendPlotBands.push({
                            from: x,
                            color: {
                                pattern: {
                                    path: 'M 0 10 L 10 0 M -1 1 L 1 -1 M 9 11 L 11 9',
                                    width: 10, height: 10,
                                    color: 'rgba(128,128,128,0.15)'
                                }
                            }
                        });
                        inWeekend = true;
                    }

                    if (!isWeekend(x) && inWeekend && last) {
                        last.to = x;
                        inWeekend = false;
                    }
                }

                // Combine weekend plot bands with holiday plot bands
                const holidayPlotBands = getHolidayPlotBands(@json($holidays));
                axis.options.plotBands = [...weekendPlotBands, ...holidayPlotBands];
            }
        });

        // Event listeners
        document.getElementById('projectNameFilter').addEventListener('change', function () {
            const projectId = this.value;
            if (projectId) {
                load_project_tasks(projectId);
            } else {
                currentTasks = [];
                document.getElementById('container').innerHTML = '<div style="text-align: center; padding: 50px; color: #6c757d;">Please select a project to view tasks</div>';
                disable_filters();
                document.getElementById('exportMenuContainer').style.display = 'none';
                document.getElementById('chartTitle').style.display = 'none';

                document.getElementById('statsContainer').innerHTML = `
                <div class="stat-card">
                    <div class="number">0</div>
                    <div class="label">Total Tasks</div>
                </div>
                <div class="stat-card">
                    <div class="number">0</div>
                    <div class="label">In Progress</div>
                </div>
                <div class="stat-card">
                    <div class="number">0%</div>
                    <div class="label">Completed Tasks</div>
                </div>
            `;
            }
        });

        document.getElementById('reset_filters').addEventListener('click', reset_filters);
        
        // Update filters when view changes
        document.getElementById('ganttViewFilter').addEventListener('change', function () {
            currentGanttView = this.value;
            apply_filters();
        });

        // Update filters when date filters change
        document.getElementById('startDateFilter').addEventListener('change', apply_filters);
        document.getElementById('endDateFilter').addEventListener('change', apply_filters);

        document.getElementById('responsibleFilter').addEventListener('change', apply_filters);
        document.getElementById('statusFilter').addEventListener('change', apply_filters);
        document.getElementById('complexityFilter').addEventListener('change', apply_filters);
        document.getElementById('priorityFilter').addEventListener('change', apply_filters);
        document.getElementById('categoryFilter').addEventListener('change', apply_filters);
        document.getElementById('timeFrameFilter').addEventListener('change', apply_filters);
        document.getElementById('overdueFilter').addEventListener('change', apply_filters);

        disable_filters();
    </script>
</div>