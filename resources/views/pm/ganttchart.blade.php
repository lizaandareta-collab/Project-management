<div class="p-3">
    {{-- HIGHCHARTS --}}
    <script src="{{ asset('assets/js/highcharts-gantt.js') }}"></script>
    <script src="{{ asset('assets/js/pattern-fill.js') }}"></script>
    <script src="{{ asset('assets/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets/js/adaptive.js') }}"></script>

    {{-- MODULE EXPORT --}}
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
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 3px solid #667eea;
        }

        .stat-card .number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 4px;
        }

        .stat-card .label {
            font-size: 0.8rem;
            color: #6c757d;
        }

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

        .highcharts-container {
            overflow: auto !important;
        }

        .highcharts-root {
            overflow: visible !important;
        }

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
            display: none;
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        .highcharts-contextbutton {
            display: none !important;
        }

        .gantt-legend {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
        }

        .gantt-legend h5 {
            color: #495057;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 1rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 8px;
        }

        .legend-row {
            display: flex;
            align-items: center;
            gap: 25px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
        }

        .legend-item,
        .timeline-item,
        .today-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .timeline-bar {
            width: 40px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid;
        }

        .timeline-border {
            width: 40px;
            height: 20px;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .legend-text-green {
            color: #28a745;
            font-weight: 600;
        }

        .legend-text-black {
            color: #000000;
            font-weight: 500;
        }

        .legend-text-black-bold {
            color: #000000;
            font-weight: 700;
        }

        .legend-text-grey {
            color: #6c757d;
            font-weight: 500;
        }

        .legend-row {
            display: flex;
            align-items: center;
            gap: 25px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .legend-color {
            width: 25px;
            height: 15px;
            border-radius: 3px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }



        .legend-color-blue {
            background: #3498db !important;
            border-color: #2980b9 !important;
        }

        .legend-color-yellow {
            background: #f39c12 !important;
            border-color: #d68910 !important;
        }

        .legend-color-green {
            background: #2ecc71 !important;
            border-color: #27ae60 !important;
        }

        .legend-color-red {
            background: #e74c3c !important;
            border-color: #c0392b !important;
        }

        .today-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        #print-container {
            position: absolute;
            left: -9999px;
            top: -9999px;
            width: 1200px;
            height: auto;
        }

        #print-container {
            position: absolute;
            left: -9999px;
            top: -9999px;
            width: 2000px;
            height: auto;
        }

        .highcharts-exporting-contextmenu {
            z-index: 10000 !important;
        }

        .highcharts-export-chart {
            overflow: visible !important;
        }

        @media print {
            #print-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 20px !important;
            }

            .highcharts-container {
                width: 100% !important;
                max-width: none !important;
            }
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
        <!-- ROW 1: 5 Filter -->
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
            <div class="filter-group">
                <label for="priorityFilter">Priority</label>
                <select id="priorityFilter" disabled>
                    <option value="">All Priority</option>
                    @foreach($lov_priority as $priority)
                        <option value="{{ $priority->lov_id }}">{{ $priority->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- ROW 2: 5 Filter + 2 Date + Reset -->
        <div class="filter-row">
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
                <label for="timeFrameFilter">Time Frame</label>
                <select id="timeFrameFilter" disabled>
                    <option value="">All Frame</option>
                    <option value="plan">Plan Dates</option>
                    <option value="actual">Actual Dates</option>
                    <option value="both">Plan & Actual</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="overdueFilter">Overdue Tasks</label>
                <select id="overdueFilter" disabled>
                    <option value="">All Tasks</option>
                    <option value="overdue">Overdue Only</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="ganttViewFilter">Chart View</label>
                <select id="ganttViewFilter" disabled>
                    <option value="day">Daily</option>
                    <option value="week">Weekly</option>
                    <option value="month" selected>Monthly</option>
                    <option value="year">Yearly</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="startDateFilter">Start Date</label>
                <input type="date" id="startDateFilter" disabled>
            </div>
            <div class="filter-group">
                <label for="endDateFilter">End Date</label>
                <input type="date" id="endDateFilter" disabled>
            </div>
            <div class="filter-group" style="flex: 0 0 auto; align-self: flex-end;">
                <label style="visibility: hidden;">Reset</label>
                <button class="btn-filter btn-reset" id="reset_filters" disabled
                    style="width: 120px; margin-top: 0;">Reset Filters</button>
            </div>
        </div>
    </div>

    <div class="gantt-legend">
        <h5>Gantt Chart Legend</h5>

        <div class="legend-row">
            <!-- Milestone -->
            <div class="legend-item">
                <div class="legend-color" style="background:#28a745;"></div>
                <div class="legend-label legend-text-green">Milestone</div>
            </div>

            <!-- Activity (Bold) -->
            <div class="legend-item">
                <div class="legend-color"
                    style="background:#000; display:flex; align-items:center; justify-content:center;">
                    <span style="color:white; font-weight:bold; font-size:12px;">B</span>
                </div>
                <div class="legend-label legend-text-black-bold">Activity</div>
            </div>

            <!-- Activity (Regular) -->
            <div class="legend-item">
                <div class="legend-color" style="background:#000;"></div>
                <div class="legend-label legend-text-black">Sub-Activity</div>
            </div>

            <!-- Sub Activity -->
            <div class="legend-item">
                <div class="legend-color" style="background:#6c757d;"></div>
                <div class="legend-label legend-text-grey">Default <span>(Belum diisi)</span>
                </div>
            </div>

            <!-- Plan Timeline  -->
            <div class="legend-item">
                <div class="legend-color" style="background:#3498db; border-color:#2980b9;"></div>
                <div class="legend-label">Plan</div>
            </div>

            <!-- Actual Timeline -->
            <div class="legend-item">
                <div class="legend-color" style="background:#f39c12; border-color:#d68910;"></div>
                <div class="legend-label">In Progress</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background:#2ecc71; border-color:#27ae60;"></div>
                <div class="legend-label">On Time</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background:#e74c3c; border-color:#c0392b;"></div>
                <div class="legend-label">Overdue</div>
            </div>

            <!-- Holiday -->
            <div class="legend-item">
                <div class="legend-color">
                    <div style="width:100%;height:100%;background:repeating-linear-gradient(
            45deg,
            transparent,
            transparent 3px,
            rgba(255,0,0,0.2) 3px,
            rgba(255,0,0,0.2) 6px
            )"></div>
                </div>
                <div class="legend-label">Holiday</div>
            </div>

            <!-- Weekend -->
            <div class="legend-item">
                <div class="legend-color" style="border-color:rgba(128,128,128,0.3);">
                    <div style="width:100%;height:100%;background:repeating-linear-gradient(
            45deg,
            transparent,
            transparent 3px,
            rgba(128,128,128,0.15) 3px,
            rgba(128,128,128,0.15) 6px
            )"></div>
                </div>
                <div class="legend-label">Weekend</div>
            </div>

            <!-- Today's Date Line -->
            <div class="today-item">
                <div style="width:30px; height:2px; background:#2caffe; position:relative;">
                    <div
                        style="position:absolute; top:-4px; width:100%; height:10px; border-bottom:2px dashed #2caffe;">
                    </div>
                </div>
                <div class="timeline-label">Today</div>
            </div>
        </div>
    </div>


    <!-- Chart Header with Export Menu -->
    <div class="chart-header" style="position: relative; display: flex; align-items: center; justify-content: center;">
        <h2 class="chart-title text-center" id="chartTitle" style="display:none; flex:1; margin:0;">
            Project Gantt Chart
        </h2>
        <div class="export-menu-container" id="exportMenuContainer">
            <button class="export-menu-btn" id="exportMenuBtn">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
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

        const projectsData = @json($projects);
        const lovStatus = @json($lov_status);
        const lovComplexity = @json($lov_complexity);
        const lovPriority = @json($lov_priority);
        const responsible = @json($responsible);

        let currentTasks = [];
        let currentTimeFrame = '';
        let currentGanttView = 'month';
        let chart;
        let currentOverdueFilter = '';

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
                render_ganttchart();

            } catch (error) {
                console.error('Error loading tasks:', error);
                document.getElementById('container').innerHTML = '<div style="text-align: center; padding: 50px; color: red;">Error loading tasks</div>';
                document.getElementById('chartTitle').style.display = 'none';
            }
        }

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

        function data_range(view, startDateFilter = null, endDateFilter = null) {
            let startDate, endDate;
            const now = new Date();

            if (startDateFilter && endDateFilter) {
                startDate = new Date(startDateFilter);
                endDate = new Date(endDateFilter);
            } else {

                switch (view) {
                    case 'day':
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                        break;

                    case 'week':
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        endDate = new Date(now.getFullYear(), now.getMonth() + 3, 0);
                        break;

                    case 'month':
                        startDate = new Date(now.getFullYear(), 0, 1);
                        endDate = new Date(now.getFullYear(), 11, 31);
                        break;

                    case 'year':
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

        function get_xaxis_config(view, minDate, maxDate) {
            const dateRange = maxDate - minDate;
            const daysRange = dateRange / day;

            let tickInterval, units, dateTimeLabelFormats;

            switch (view) {
                case 'day':
                    tickInterval = day;
                    units = [['day', [1]]];
                    dateTimeLabelFormats = {
                        day: '%e %b',
                        week: '%e %b',
                        month: '%b %Y'
                    };
                    break;

                case 'week':
                    tickInterval = 7 * day;
                    units = [['week', [1]]];
                    dateTimeLabelFormats = {
                        day: '%e %b',
                        week: '%e %b',
                        month: '%b %Y'
                    };
                    break;

                case 'month':
                    tickInterval = 30 * day;
                    units = [['month', [1]]];
                    dateTimeLabelFormats = {
                        day: '',
                        week: '',
                        month: '%b %Y',
                        year: '%Y'
                    };
                    break;

                case 'year':
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

        function overdue_task(task) {
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

            function convert_time(dateString) {
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

            function get_color_milestone(isMilestone) {
                switch (isMilestone) {
                    case '20':
                        return {
                            color: '#28a745',
                            fontWeight: '600'
                        };
                    case '21':
                        return {
                            color: '#000000',
                            fontWeight: 'bold'
                        };
                    case '70':
                        return {
                            color: '#000000',
                            fontWeight: 'normal'
                        };
                    default:
                        return {
                            color: '#6c757d',
                            fontWeight: 'normal'
                        };
                }
            }

            function get_actual_color(task) {
                const planEnd = task.plan_end ? new Date(task.plan_end) : null;
                const actualStart = task.actual_start ? new Date(task.actual_start) : null;
                const actualEnd = task.actual_end ? new Date(task.actual_end) : null;

                // Jika actual end ada dan melebihi plan end (overdue) -> MERAH
                if (actualEnd && planEnd && actualEnd > planEnd) {
                    return '#e74c3c'; // Red for overdue
                }

                // Jika actual end ada dan tidak melebihi plan end -> HIJAU
                if (actualEnd && planEnd && actualEnd <= planEnd) {
                    return '#2ecc71'; // Green for on time
                }

                // Jika ada actual start tapi tidak ada actual end (in progress) -> KUNING
                if (actualStart && !actualEnd) {
                    return '#f39c12'; 
                }

                // Default 
                return '#95a5a6';
            }

            function get_style_milestone(taskName, isMilestone) {
                const style = get_color_milestone(isMilestone);
                return `<span style="color: ${style.color}; font-weight: ${style.fontWeight}">${taskName}</span>`;
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

                    const planStart = convert_time(task.plan_start);
                    const planEnd = convert_time(task.plan_end);
                    const actualStart = convert_time(task.actual_start);
                    const actualEnd = convert_time(task.actual_end);

                    const formattedName = get_style_milestone(taskName, task.is_milestone);

                    const taskData = {
                        name: formattedName,
                        id: taskId,
                        parent: `project_${projectId}`,
                        responsible: task.responsible_name,
                        status: task.status,
                        complexity: task.complexity,
                        priority: task.priority,
                        is_milestone: task.is_milestone,
                        plan_start: task.plan_start?.split(' ')[0],
                        plan_end: task.plan_end?.split(' ')[0],
                        actual_start: task.actual_start?.split(' ')[0],
                        actual_end: task.actual_end?.split(' ')[0],
                        isOverdue: overdue_task(task),
                        actual_color: get_actual_color(task)
                    };

                    switch (timeFrame) {
                        case 'plan':
                            projectTasks.push({
                                ...taskData,
                                id: taskId + "_plan",
                                start: planStart || null,
                                end: planEnd || null,
                                color: '#3498db', 
                                borderColor: '#2980b9',
                                opacity: 0.9,
                                type: 'plan'
                            });
                            break;

                        case 'actual':
                            projectTasks.push({
                                ...taskData,
                                id: taskId + "_actual",
                                start: actualStart || null,
                                end: actualEnd || null,
                                color: get_actual_color(task),
                                borderColor: get_actual_color(task),
                                opacity: 0.9,
                                type: 'actual'
                            });
                            break;

                        case 'both':
                        default:

                            projectTasks.push({
                                ...taskData,
                                name: get_style_milestone(taskName + " (Plan)", task.is_milestone),
                                id: taskId + "_plan",
                                start: planStart || null,
                                end: planEnd || null,
                                color: '#3498db', 
                                borderColor: '#2980b9',
                                opacity: 0.9,
                                type: 'plan'
                            });

                            if (actualStart || actualEnd) {
                                projectTasks.push({
                                    ...taskData,
                                    name: get_style_milestone(taskName + " (Actual)", task.is_milestone),
                                    id: taskId + "_actual",
                                    start: actualStart || null,
                                    end: actualEnd || null,
                                    color: get_actual_color(task), 
                                    borderColor: get_actual_color(task),
                                    opacity: 0.9,
                                    type: 'actual'
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



        function get_project_color(projectId) {
            const colors = [
                '#fac70fff'
            ];
            return colors[projectId % colors.length];
        }

        function get_holiday(holidays) {
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

        function render_ganttchart() {
            if (!currentTasks || currentTasks.length === 0) {
                document.getElementById('container').innerHTML = '<div style="text-align: center; padding: 50px; color: #6c757d;">No tasks available for the selected project</div>';
                document.getElementById('chartTitle').style.display = 'none';
                document.getElementById('exportMenuContainer').style.display = 'none';
                return;
            }

            const ganttData = data_task_to_ganttChart(currentTasks, currentTimeFrame);

            const startDateFilter = document.getElementById('startDateFilter').value;
            const endDateFilter = document.getElementById('endDateFilter').value;

            const dateRange = data_range(currentGanttView, startDateFilter, endDateFilter);

            const xAxisConfig = get_xaxis_config(currentGanttView, dateRange.min, dateRange.max);

            const holidayPlotBands = get_holiday(@json($holidays));

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
                        load: function () {
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
                            style: {
                                fontWeight: 'normal',
                                textOutline: 'none'
                            },
                            useHTML: true
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
                        'Responsible: {point.responsible}<br>' +
                        '{#if point.priority}Priority: {point.priority}{/if}' +
                        '{#if point.isOverdue}<br><span style="color: red; font-weight: bold">⚠ OVERDUE</span>{/if}'
                },

                title: {
                    text: ''
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

            document.getElementById('chartTitle').textContent = `Project Gantt Chart - ${currentTasks[0]?.project_name ?? 'Project'}`;
        }

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
                if (statusFilter && task.status != statusFilter) return false;
                if (complexityFilter && task.complexity != complexityFilter) return false;
                if (priorityFilter && task.priority != priorityFilter) return false;
                if (categoryFilter && task.is_milestone != categoryFilter) return false;
                if (currentOverdueFilter === 'overdue' && !overdue_task(task)) return false;

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

            const originalTasks = [...currentTasks];
            currentTasks = filteredTasks;
            render_ganttchart();
            currentTasks = originalTasks;
        }

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
            render_ganttchart();
        }

        document.addEventListener('DOMContentLoaded', function () {
            const exportMenuBtn = document.getElementById('exportMenuBtn');
            const exportMenu = document.getElementById('exportMenu');
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            const printChartBtn = document.getElementById('printChartBtn');
            const downloadPNGBtn = document.getElementById('downloadPNGBtn');
            const downloadJPGBtn = document.getElementById('downloadJPGBtn');

            exportMenuBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                exportMenu.classList.toggle('show');
            });

            document.addEventListener('click', function () {
                exportMenu.classList.remove('show');
            });

            fullscreenBtn.addEventListener('click', function () {
                if (chart) {
                    chart.fullscreen.toggle();
                }
                exportMenu.classList.remove('show');
            });

            printChartBtn.addEventListener('click', function () {
                if (chart) {
                    const xAxis = chart.xAxis[0];
                    const dateRange = xAxis.max - xAxis.min;
                    const days = dateRange / (24 * 3600 * 1000);
                    const baseWidth = 1200;
                    const extraWidth = Math.max(0, (days - 30) * 30);
                    const exportWidth = Math.min(baseWidth + extraWidth, 3000); 
                    const dataPoints = chart.series.reduce((sum, series) => sum + series.points.length, 0);
                    const exportHeight = Math.max(600, 150 + (dataPoints * 30));

                    // Dapatkan project name
                    const selectedProject = document.getElementById('projectNameFilter').value;
                    const projectName = selectedProject ?
                        document.getElementById('projectNameFilter').options[document.getElementById('projectNameFilter').selectedIndex].text :
                        'All-Projects';

                    const filename = `Gantt-Chart-${projectName.replace(/\s+/g, '-')}-${new Date().toISOString().slice(0, 10)}`;

                    // Export untuk print dengan width yang disesuaikan
                    chart.exportChart({
                        type: 'application/pdf',
                        filename: filename,
                        sourceWidth: exportWidth,
                        sourceHeight: exportHeight,
                        chartOptions: {
                            chart: {
                                backgroundColor: '#ffffff',
                                spacing: [50, 30, 50, 30], 
                                marginLeft: 250,
                                marginRight: 80  
                            },
                            title: {
                                text: document.getElementById('chartTitle').textContent,
                                style: {
                                    fontSize: '18px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                },
                                margin: 25,
                                y: 20
                            },
                            xAxis: [{
                                labels: {
                                    style: {
                                        color: '#333333',
                                        fontSize: '10px', 
                                        fontWeight: 'normal'
                                    },
                                    y: 15,
                                    step: 1 
                                },
                                tickLength: 15,
                                lineWidth: 1
                            }],
                            yAxis: {
                                labels: {
                                    style: {
                                        color: '#333333',
                                        fontSize: '11px'
                                    },
                                    x: -230, 
                                    align: 'right'
                                }
                            },
                            legend: {
                                enabled: true,
                                itemStyle: {
                                    fontSize: '11px',
                                    color: '#333333'
                                }
                            }
                        }
                    });
                }
                exportMenu.classList.remove('show');
            });

            // Download PNG 
            downloadPNGBtn.addEventListener('click', function () {
                exportChartImage('png');
            });

            // Download JPEG 
            downloadJPGBtn.addEventListener('click', function () {
                exportChartImage('jpeg');
            });

            // Fungsi export chart image
            function exportChartImage(format) {
                if (!chart) return;

                // Dapatkan project name
                const selectedProject = document.getElementById('projectNameFilter').value;
                const projectName = selectedProject ?
                    document.getElementById('projectNameFilter').options[document.getElementById('projectNameFilter').selectedIndex].text :
                    'All-Projects';

                const { exportWidth, exportHeight } = calculate_export_size();

                console.log(`Exporting ${format.toUpperCase()}: ${exportWidth}x${exportHeight}px`);

                // Buat filename
                const timestamp = new Date().toISOString().slice(0, 10);
                const filename = `Gantt-Chart-${projectName.replace(/\s+/g, '-')}-${timestamp}`;

                chart.exportChart({
                    type: format === 'png' ? 'image/png' : 'image/jpeg',
                    filename: filename,
                    sourceWidth: exportWidth,
                    sourceHeight: exportHeight,
                    scale: 1, 
                    chartOptions: get_export_chart()
                });

                exportMenu.classList.remove('show');
            }

            // Fungsi untuk menghitung ukuran export
            function calculate_export_size() {
                const xAxis = chart.xAxis[0];
                const dateRange = xAxis.max - xAxis.min;
                const days = dateRange / (24 * 3600 * 1000);

                let baseWidth = 1800; 
                let extraWidth = 0;

                if (days <= 30) {
                    extraWidth = 0;
                } else if (days <= 60) {
                    extraWidth = (days - 30) * 40; 
                } else if (days <= 90) {
                    extraWidth = 1200 + (days - 60) * 35; 
                } else {
                    extraWidth = 2250 + (days - 90) * 30; 
                }

                const exportWidth = Math.min(baseWidth + extraWidth, 5000); 
                const dataPoints = chart.series.reduce((sum, series) => sum + series.points.length, 0);
                const exportHeight = Math.max(700, 200 + (dataPoints * 18));

                return { exportWidth, exportHeight };
            }

            // Fungsi untuk mendapatkan options export chart
            function get_export_chart() {
                return {
                    chart: {
                        backgroundColor: '#ffffff',
                        spacing: [60, 40, 60, 40], 
                        marginLeft: 280,
                        marginRight: 60,
                        marginTop: 60,
                        marginBottom: 60
                    },
                    title: {
                        text: document.getElementById('chartTitle').textContent,
                        style: {
                            fontSize: '20px',
                            fontWeight: 'bold',
                            color: '#333333'
                        },
                        margin: 30,
                        y: 25
                    },
                    xAxis: [{
                        currentDateIndicator: {
                            color: '#2caffe',
                            dashStyle: 'ShortDot',
                            width: 2,
                            label: {
                                format: 'Today',
                                style: { fontSize: '11px' }
                            }
                        },
                        labels: {
                            style: {
                                color: '#333333',
                                fontSize: '9px', 
                                fontWeight: 'normal'
                            },
                            rotation: 0,
                            y: 20,
                            step: 1, 
                            reserveSpace: true 
                        },
                        tickWidth: 1,
                        tickLength: 12,
                        minorTickLength: 6,
                        gridLineWidth: 1,
                        lineWidth: 1,
                        offset: 10 
                    }],
                    yAxis: {
                        labels: {
                            style: {
                                color: '#333333',
                                fontSize: '11px'
                            },
                            x: -260, 
                            align: 'right',
                            reserveSpace: true
                        },
                        gridLineWidth: 0,
                        lineWidth: 1,
                        offset: 10
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                style: {
                                    fontSize: '11px',
                                    textOutline: 'none'
                                }
                            },
                            pointPadding: 0.02,
                            groupPadding: 0.05
                        }
                    },
                    legend: {
                        enabled: true,
                        itemStyle: {
                            fontSize: '11px',
                            color: '#333333'
                        },
                        itemMarginTop: 8,
                        itemMarginBottom: 8,
                        margin: 25,
                        padding: 15
                    },
                    tooltip: {
                        style: {
                            fontSize: '11px'
                        }
                    }
                };
            }
        });

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

                const holidayPlotBands = get_holiday(@json($holidays));
                axis.options.plotBands = [...weekendPlotBands, ...holidayPlotBands];
            }
        });

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
        document.getElementById('ganttViewFilter').addEventListener('change', function () {
            currentGanttView = this.value;
            apply_filters();
        });

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