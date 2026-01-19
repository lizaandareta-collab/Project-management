<!-- Highcharts Libraries -->
<script src="{{ asset('assets/js/highcharts-gantt.js') }}"></script>
<script src="{{ asset('assets/js/exporting.js') }}"></script>
<script src="{{ asset('assets/js/export-data.js') }}"></script>
<script src="{{ asset('assets/js/full-screen.js') }}"></script>
<script src="{{ asset('assets/js/chart3.js') }}"></script>
<!-- Highcharts Libraries -->
<script src="{{ asset('assets/js/highcharts-chart.js') }}"></script>
<script src="{{ asset('assets/js/export-data-chart.js') }}"></script>
<script src="{{ asset('assets/js/accessibility-chart.js') }}"></script>
<script src="{{ asset('assets/js/adaptive-chart.js') }}"></script>

<script src="{{ asset('assets/js/drilldown.js') }}"></script>

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, Helvetica, Arial, sans-serif;
        background: var(--highcharts-background-color);
        color: var(--highcharts-neutral-color-100);
    }

    .highcharts-figure {
        min-width: 310px;
        max-width: 900px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-description {
        margin: 0.3rem 10px;
        text-align: center;
    }

    /* GRID 4 CARD */
    .card-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .dash-card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.12);
        border: 1px solid #e5e5e5;
        transition: 0.25s;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .dash-card:hover {
        transform: translateY(-6px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.18);
        border-color: #b5b5b5;
    }

    .card-title {
        font-size: 14px;
        font-weight: bold;
        color: #666;
        margin-bottom: 15px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* OVERALL PROGRESS CHART - HIGHCHARTS DONUT CHART */
    .chart-box {
        position: relative;
        width: 100%;
        height: 280px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #overallProgressChart {
        width: 100% !important;
        height: 100% !important;
        position: relative;
    }

    /* Custom legend untuk chart progress */
    .progress-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        margin-top: 10px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        padding: 4px 8px;
        background: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e9ecef;
    }

    .legend-color {
        width: 10px;
        height: 10px;
        border-radius: 2px;
        display: inline-block;
    }

    /* Styling khusus untuk Highcharts Progress Chart */
    .highcharts-plot-background {
        fill: transparent !important;
    }

    .highcharts-data-label text {
        font-weight: 700 !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .highcharts-center-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .center-percentage {
        font-size: 28px;
        font-weight: 800;
        color: #2c3e50;
        line-height: 1;
        margin: 0;
    }

    .center-text {
        font-size: 12px;
        font-weight: 600;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 5px;
    }

    /* Status color boxes untuk legend */
    .status-box {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 2px;
        margin-right: 5px;
        vertical-align: middle;
    }

    .status-open-box {
        background-color: #1f77b4;
    }

    .status-inprogress-box {
        background-color: #00a591;
    }

    .status-completed-box {
        background-color: #9acd32;
    }

    .status-onhold-box {
        background-color: #f0ad4e;
    }

    .status-cancelled-box {
        background-color: #d9534f;
    }

    .status-nostatus-box {
        background-color: #34495e;
    }

    /* PLAN HOURS vs HOURS SPENT - IMPROVED VISUALIZATION */
    /* .hours-visualization-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        height: 140px;
        margin-top: 15px;
        padding: 0 10px;
    } */

    .hours-visualization-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        height: 100%;
        margin-top: auto;
        padding: 0 10px;
    }


    .hours-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 45%;
    }

    .hours-bar-container {
        position: relative;
        width: 60px;
        height: 100px;
        margin-bottom: 10px;
    }

    .hours-bar {
        position: absolute;
        bottom: 0;
        width: 100%;
        border-radius: 4px 4px 0 0;
        transition: height 0.5s ease-in-out;
    }

    .hours-bar.plan-hours {
        background: linear-gradient(to top, #1eb4e9, #4a90e2);
        z-index: 2;
    }

    .hours-bar.hours-spent {
        background: linear-gradient(to top, #7fd7ff, #a5d8ff);
        z-index: 1;
        opacity: 0.9;
    }

    .hours-bar-label {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 14px;
        font-weight: bold;
        color: #333;
        white-space: nowrap;
    }

    .hours-value {
        font-size: 22px;
        font-weight: bold;
        margin-top: 5px;
        color: #333;
    }

    .hours-label {
        font-size: 12px;
        color: #666;
        font-weight: 600;
        margin-top: 5px;
    }

    /* GANTT CHART STYLES */
    .gantt-section {
        margin-top: 30px;
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.12);
    }

    .gantt-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .gantt-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    /* Export menu styles */
    .export-menu-container {
        position: relative;
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

    /* Hide default Highcharts export button */
    .highcharts-contextbutton {
        display: none !important;
    }

    /* Hilangkan semua grid kiri Gantt */
    .highcharts-grid-line,
    .highcharts-yaxis-grid,
    .highcharts-axis-line,
    .highcharts-axis,
    .highcharts-row-series {
        display: none !important;
    }

    /* MILESTONE & TASKS PROGRESS - GROUPED STYLE */
    .tasks-grouped-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .task-group-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .task-group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .task-group-card.hidden {
        display: none !important;
    }

    /* Status colors */
    .status-open {
        background: rgba(31, 119, 180, 0.1);
        color: #1f77b4;
        border-left-color: #1f77b4;
    }

    .status-inprogress {
        background: rgba(0, 165, 145, 0.1);
        color: #00a591;
        border-left-color: #00a591;
    }

    .status-completed {
        background: rgba(154, 205, 50, 0.1);
        color: #9acd32;
        border-left-color: #9acd32;
    }

    .status-onhold {
        background: rgba(240, 173, 78, 0.1);
        color: #f0ad4e;
        border-left-color: #f0ad4e;
    }

    .status-cancelled {
        background: rgba(217, 83, 79, 0.1);
        color: #d9534f;
        border-left-color: #d9534f;
    }

    .status-nostatus {
        background: rgba(52, 73, 94, 0.1);
        color: #34495e;
        border-left-color: #34495e;
    }

    /* Filter Controls */
    .filter-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 200px;
    }

    .filter-label {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        background: white;
        font-size: 14px;
        color: #495057;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-select:hover {
        border-color: #adb5bd;
    }

    .filter-select:focus {
        outline: none;
        border-color: #1f77b4;
        box-shadow: 0 0 0 3px rgba(31, 119, 180, 0.1);
    }

    .no-tasks {
        text-align: center;
        padding: 40px;
        color: #6c757d;
        font-style: italic;
        grid-column: 1 / -1;
    }

    .no-tasks.hidden {
        display: none;
    }

    /* Status Legend */
    .status-legend {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 15px;
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
    }

    /* Task Counter */
    .task-counter {
        margin-left: 10px;
        font-size: 0.9em;
        color: #6c757d;
        font-weight: normal;
    }

    /* Invoice Table Styles */
    .invoice-table-wrapper {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-top: 10px;
    }

    .invoice-table-wrapper table thead {
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
    }

    .invoice-table-wrapper table {
        margin-bottom: 0;
    }

    .invoice-table-wrapper tbody tr:last-child td {
        border-bottom: none;
    }

    .invoice-table-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .invoice-table-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .invoice-table-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .invoice-table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .currency-value {
        font-variant-numeric: tabular-nums;
        display: block;
    }

    /* Gantt Chart Styling - Garis Timeline */
    .highcharts-xaxis-grid .highcharts-grid-line {
        display: block !important;
        stroke: #e0e0e0 !important;
        stroke-width: 1px !important;
    }

    .highcharts-axis-line {
        display: block !important;
        stroke: #ccc !important;
        stroke-width: 1px !important;
    }

    .highcharts-axis-labels text {
        fill: #666 !important;
        font-size: 11px !important;
    }

    /* LEVEL 3 STRUCTURE STYLES */
    .task-milestone-card {
        padding: 20px;
        border-bottom: 3px solid #e9ecef;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 5px solid;
    }

    .milestone-header {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .milestone-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        color: #2c3e50;
    }

    .milestone-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-left: auto;
        background: #fff;
        border: 1px solid #dee2e6;
    }

    .milestone-meta {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: #6c757d;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .activities-container {
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .task-activity-card {
        padding: 12px 15px;
        border-radius: 8px;
        background: white;
        border: 1px solid #e9ecef;
        border-left: 4px solid;
        transition: all 0.2s ease;
        margin-left: 15px;
    }

    .task-activity-card:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
        transform: translateX(5px);
    }

    .activity-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-size: 15px;
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .activity-meta {
        display: flex;
        gap: 10px;
        font-size: 12px;
        color: #6c757d;
    }

    .activity-status {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        min-width: 80px;
        text-align: center;
        background: rgba(0, 0, 0, 0.05);
    }

    .subactivities-container {
        margin-left: 30px;
        padding: 5px 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .task-subactivity-card {
        padding: 10px 15px;
        border-radius: 6px;
        background: white;
        border: 1px solid #f1f3f5;
        border-left: 3px solid;
        transition: all 0.2s ease;
    }

    .task-subactivity-card:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    .subactivity-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .subactivity-content {
        flex: 1;
    }

    .subactivity-title {
        font-size: 14px;
        font-weight: 400;
        color: #495057;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .subactivity-meta {
        display: flex;
        gap: 8px;
        font-size: 11px;
        color: #868e96;
    }

    .subactivity-status {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 10px;
        min-width: 70px;
        text-align: center;
        background: rgba(0, 0, 0, 0.03);
    }

    /* Status colors for each level */
    .task-milestone-card.status-open {
        border-left-color: #1f77b4;
    }

    .task-milestone-card.status-inprogress {
        border-left-color: #00a591;
    }

    .task-milestone-card.status-completed {
        border-left-color: #9acd32;
    }

    .task-milestone-card.status-onhold {
        border-left-color: #f0ad4e;
    }

    .task-milestone-card.status-cancelled {
        border-left-color: #d9534f;
    }

    .task-milestone-card.status-nostatus {
        border-left-color: #34495e;
    }

    .task-activity-card.status-open {
        border-left-color: #1f77b4;
        background: rgba(31, 119, 180, 0.05);
    }

    .task-activity-card.status-inprogress {
        border-left-color: #00a591;
        background: rgba(0, 165, 145, 0.05);
    }

    .task-activity-card.status-completed {
        border-left-color: #9acd32;
        background: rgba(154, 205, 50, 0.05);
    }

    .task-activity-card.status-onhold {
        border-left-color: #f0ad4e;
        background: rgba(240, 173, 78, 0.05);
    }

    .task-activity-card.status-cancelled {
        border-left-color: #d9534f;
        background: rgba(217, 83, 79, 0.05);
    }

    .task-activity-card.status-nostatus {
        border-left-color: #34495e;
        background: rgba(52, 73, 94, 0.05);
    }

    .task-subactivity-card.status-open {
        border-left-color: #1f77b4;
        background: rgba(31, 119, 180, 0.03);
    }

    .task-subactivity-card.status-inprogress {
        border-left-color: #00a591;
        background: rgba(0, 165, 145, 0.03);
    }

    .task-subactivity-card.status-completed {
        border-left-color: #9acd32;
        background: rgba(154, 205, 50, 0.03);
    }

    .task-subactivity-card.status-onhold {
        border-left-color: #f0ad4e;
        background: rgba(240, 173, 78, 0.03);
    }

    .task-subactivity-card.status-cancelled {
        border-left-color: #d9534f;
        background: rgba(217, 83, 79, 0.03);
    }

    .task-subactivity-card.status-nostatus {
        border-left-color: #34495e;
        background: rgba(52, 73, 94, 0.03);
    }

    /* Status Bullets */
    .status-bullet {
        width: 12px;
        height: 12px;
        border-radius: 2px;
        display: inline-block;
        background-color: currentColor;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .status-open-bullet {
        color: #1f77b4;
    }

    .status-inprogress-bullet {
        color: #00a591;
    }

    .status-completed-bullet {
        color: #9acd32;
    }

    .status-onhold-bullet {
        color: #f0ad4e;
    }

    .status-cancelled-bullet {
        color: #d9534f;
    }

    .status-nostatus-bullet {
        color: #34495e;
    }

    /* Category-based text styling */
    .category-milestone {
        color: #28a745 !important;
        font-weight: 600 !important;
    }

    .category-deliverable {
        color: #000000 !important;
        font-weight: bold !important;
    }

    .category-task {
        color: #6c757d !important;
        font-weight: normal !important;
    }

    /* TRIAL CHART STYLING */
    .chart-container {
        margin-top: 20px;
        padding: 15px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chart-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .chart-wrapper {
        height: 400px;
        min-height: 400px;
    }

    /* Select Process Area */
    .process-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Default button */
    .btn-process {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        transition: background-color .2s ease, color .2s ease, border-color .2s ease;
    }

    /* Hover = hijau gelap */
    .btn-process:hover {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
    }

    /* Focus */
    .btn-process:focus {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
        box-shadow: none;
    }

    /* Active (yang diklik) */
    .btn-process.btn-primary {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .tasks-grouped-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .tasks-grouped-container {
            grid-template-columns: 1fr;
        }

        .filter-controls {
            flex-direction: column;
        }

        .filter-group {
            min-width: 100%;
        }

        .task-activity-card {
            margin-left: 10px;
        }

        .subactivities-container {
            margin-left: 20px;
        }

        .milestone-title {
            font-size: 16px;
            flex-wrap: wrap;
        }

        .activity-title,
        .subactivity-title {
            font-size: 14px;
        }

        .milestone-meta {
            flex-direction: column;
            gap: 5px;
        }

        .card-row {
            grid-template-columns: 1fr;
        }

        .hours-visualization-container {
            height: 120px;
        }

        .hours-bar-container {
            width: 50px;
        }

        .chart-box {
            height: 240px;
        }

        .center-percentage {
            font-size: 24px;
        }

        .center-text {
            font-size: 11px;
        }

        #container {
            height: 350px;
        }

        .chart-wrapper {
            height: 350px;
        }
    }

    /* Select Process Area */
    .process-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Default button */
    .btn-process {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        transition: background-color .2s ease, color .2s ease, border-color .2s ease;
    }

    /* Hover = hijau gelap */
    .btn-process:hover {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
    }

    /* Focus */
    .btn-process:focus {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
        box-shadow: none;
    }

    /* Active (yang diklik) */
    .btn-process.btn-primary {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
    }
</style>

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <h4 class="mb-4">Project Dashboard - {{ $project->project_name ?? 'Unknown Project' }}</h4>

                <!-- WRAPPER 4 CARD -->
                <div class="card-row">
                    <!-- CARD 1 - OVERALL PROGRESS - HIGHCHARTS DONUT CHART YANG RAPIH -->
                    <div class="dash-card">
                        <div class="card-title">OVERALL PROGRESS</div>
                        <div class="chart-box">
                            <div id="overallProgressChart"></div>
                        </div>
                        <!-- Legend di bawah chart -->
                        <div class="progress-legend">
                            <div class="legend-item">
                                <span class="legend-color" style="background-color: #1f77b4;"></span>
                                <span>Open</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background-color: #00a591;"></span>
                                <span>In Progress</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background-color: #9acd32;"></span>
                                <span>Completed</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background-color: #f0ad4e;"></span>
                                <span>On Hold</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background-color: #d9534f;"></span>
                                <span>Cancelled</span>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2 - PROJECT MILESTONE - HORIZONTAL BAR CHART DENGAN DRILLDOWN -->
                    <div class="dash-card">
                        <div class="card-title">PROJECT MILESTONE</div>
                        <div id="container"></div>
                        <div class="progress-legend" style="margin-top: 10px;">
                            <!-- <div class="legend-item">
                                <span class="status-open-box"></span>
                                <span>Click bars to view activities (Subactivities not counted)</span>
                            </div> -->
                            <!-- Legend di bawah chart -->
                            <div class="progress-legend">
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #1f77b4;"></span>
                                    <span>Open</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #00a591;"></span>
                                    <span>In Progress</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #9acd32;"></span>
                                    <span>Completed</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #f0ad4e;"></span>
                                    <span>On Hold</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #d9534f;"></span>
                                    <span>Cancelled</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3 - PLAN HOURS vs HOURS SPENT -->
                    <div class="dash-card">
                        <div class="card-title">PLAN HOURS VS HOURS SPENT</div>

                        <!-- Visualization container -->
                        <div class="hours-visualization-container" id="hoursVisualization">
                            <!-- Plan Hours Column -->
                            <div class="hours-column">
                                <div class="hours-bar-container">
                                    <div class="hours-bar plan-hours" id="planHoursBar">
                                        <div class="hours-bar-label" id="planHoursLabel">{{ $planHours }}</div>
                                    </div>
                                </div>
                                <div class="hours-label">PLAN HOURS</div>
                            </div>

                            <!-- Hours Spent Column -->
                            <div class="hours-column">
                                <div class="hours-bar-container">
                                    <div class="hours-bar hours-spent" id="hoursSpentBar">
                                        <div class="hours-bar-label" id="hoursSpentLabel">{{ $hoursSpent }}</div>
                                    </div>
                                </div>
                                <div class="hours-label">HOURS SPENT</div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 4 - PROJECT BUDGET -->
                    <div class="dash-card">
                        <div class="card-title">PROJECT BUDGET</div>
                        <h2 style="margin-top:10px">Rp{{ number_format($budget, 0, ',', '.') }}</h2>
                    </div>

                    <!-- CARD 5 - INVOICE -->
                    <div class="dash-card" id="invoiceCard" style="cursor:pointer">
                        <div class="card-title">INVOICE</div>
                        <h2 style="margin-top:10px">Rp{{ number_format($invoiceAmount, 0, ',', '.') }}</h2>
                    </div>

                    <!-- CARD 6 - REMAINING BUDGET -->
                    <div class="dash-card">
                        <div class="card-title">REMAINING BUDGET</div>
                        <h2 style="margin-top:10px;">
                            Rp{{ number_format($remainingBudget, 0, ',', '.') }}
                        </h2>
                    </div>
                </div>

                <!-- GANTT CHART SECTION -->
                <div class="gantt-section">
                    <div class="gantt-header">
                        <h3 class="gantt-title">Project Timeline</h3>
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
                    <div id="ganttContainer">
                        <div style="text-align: center; padding: 50px; color: #6c757d;">
                            Loading Gantt Chart...
                        </div>
                    </div>
                </div>

                <!-- MILESTONE & TASKS PROGRESS SECTION -->
                <div class="gantt-section" style="margin-top: 20px;">
                    <div class="gantt-header">
                        <h3 class="gantt-title">Milestone & Tasks Progress
                            <span class="task-counter" id="visibleTaskCounter">({{ count($tasks) }} tasks)</span>
                        </h3>
                    </div>

                    <!-- Filter Controls - Hanya Filter Milestone -->
                    <div class="filter-controls">
                        <div class="filter-group">
                            <div class="filter-label">Filter by Milestone</div>
                            <select class="filter-select" id="milestoneFilter">
                                <option value="all">All Milestones</option>
                                @foreach($groupedTasks as $milestoneId => $milestoneData)
                                    @if($milestoneData['parent'])
                                        <option value="{{ $milestoneId }}">
                                            {{ $milestoneData['parent']->milestone_task ?? 'Unnamed Milestone' }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status Legend -->
                    <div class="status-legend">
                        <div class="legend-item">
                            <div class="status-bullet status-open-bullet"></div> Open
                        </div>
                        <div class="legend-item">
                            <span class="status-bullet status-inprogress-bullet"></span> In Progress
                        </div>
                        <div class="legend-item">
                            <span class="status-bullet status-completed-bullet"></span> Completed
                        </div>
                        <div class="legend-item">
                            <span class="status-bullet status-onhold-bullet"></span> On Hold
                        </div>
                        <div class="legend-item">
                            <span class="status-bullet status-cancelled-bullet"></span> Cancelled
                        </div>
                        <div class="legend-item">
                            <span class="status-bullet status-nostatus-bullet"></span> No Status
                        </div>
                    </div>

                    <!-- Task Grid - GROUPED VERSION 3 LEVEL -->
                    <div class="tasks-grouped-container" id="taskGridContainer">
                        @if(count($groupedTasks) > 0)
                            @foreach($groupedTasks as $milestoneId => $milestoneData)
                                <div class="task-group-card" data-milestone-id="{{ $milestoneId }}">
                                    <!-- Level 1: Milestone Card -->
                                    @if($milestoneData['parent'])
                                        @php
                                            $parentStatus = $milestoneData['parent']->status ?? 0;
                                            $parentStatusClass = getStatusClass($parentStatus);
                                            $parentStatusBullet = getStatusBulletClass($parentStatus);
                                            $parentStatusText = getStatusText($parentStatus);
                                            $parentCategoryClass = getCategoryClass($milestoneData['parent']->is_milestone ?? '');
                                        @endphp
                                        <div class="task-milestone-card {{ $parentStatusClass }}">
                                            <div class="milestone-header">
                                                <div class="milestone-title">
                                                    <span class="status-bullet {{ $parentStatusBullet }}"></span>
                                                    <strong
                                                        class="{{ $parentCategoryClass }}">{{ $milestoneData['parent']->milestone_task ?? 'Unnamed Milestone' }}</strong>
                                                    <span class="milestone-badge">{{ $parentStatusText }}</span>
                                                </div>
                                                <div class="milestone-meta">
                                                    @if($milestoneData['parent']->responsible_name)
                                                        <span class="meta-item">
                                                            <i class="icon ni ni-user"></i>
                                                            {{ $milestoneData['parent']->responsible_name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Level 2 & 3: Activities and Sub-activities -->
                                    @if(count($milestoneData['activities']) > 0)
                                        <div class="activities-container">
                                            @foreach($milestoneData['activities'] as $activityId => $activityData)
                                                <!-- Level 2: Activity Card -->
                                                @if($activityData['activity'])
                                                    @php
                                                        $activityStatus = $activityData['activity']->status ?? 0;
                                                        $activityStatusClass = getStatusClass($activityStatus);
                                                        $activityStatusBullet = getStatusBulletClass($activityStatus);
                                                        $activityStatusText = getStatusText($activityStatus);
                                                        $activityCategoryClass = getCategoryClass($activityData['activity']->is_milestone ?? '');
                                                    @endphp
                                                    <div class="task-activity-card {{ $activityStatusClass }}"
                                                        data-status="{{ $activityStatus }}">
                                                        <div class="activity-header">
                                                            <span class="status-bullet {{ $activityStatusBullet }}"></span>
                                                            <div class="activity-content">
                                                                <div class="activity-title">
                                                                    <span
                                                                        class="{{ $activityCategoryClass }}">{{ $activityData['activity']->milestone_task ?? 'Unnamed Activity' }}</span>
                                                                </div>
                                                                <div class="activity-meta">
                                                                    @if($activityData['activity']->plan_start)
                                                                        <span class="meta-item">
                                                                            <i class="icon ni ni-calendar"></i>
                                                                            {{ date('d M', strtotime($activityData['activity']->plan_start)) }}
                                                                        </span>
                                                                    @endif
                                                                    @if($activityData['activity']->responsible_name)
                                                                        <span class="meta-item">
                                                                            <i class="icon ni ni-user"></i>
                                                                            {{ $activityData['activity']->responsible_name }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <span class="activity-status">{{ $activityStatusText }}</span>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Level 3: Sub-activity Cards -->
                                                @if(count($activityData['subactivities']) > 0)
                                                    <div class="subactivities-container">
                                                        @foreach($activityData['subactivities'] as $subactivity)
                                                            @php
                                                                $subStatus = $subactivity->status ?? 0;
                                                                $subStatusClass = getStatusClass($subStatus);
                                                                $subStatusBullet = getStatusBulletClass($subStatus);
                                                                $subStatusText = getStatusText($subStatus);
                                                                $subCategoryClass = getCategoryClass($subactivity->is_milestone ?? '');
                                                            @endphp
                                                            <div class="task-subactivity-card {{ $subStatusClass }}"
                                                                data-status="{{ $subStatus }}">
                                                                <div class="subactivity-header">
                                                                    <span class="status-bullet {{ $subStatusBullet }}"></span>
                                                                    <div class="subactivity-content">
                                                                        <div class="subactivity-title">
                                                                            <span
                                                                                class="{{ $subCategoryClass }}">{{ $subactivity->milestone_task ?? 'Unnamed Sub-activity' }}</span>
                                                                        </div>
                                                                        <div class="subactivity-meta">
                                                                            @if($subactivity->plan_start)
                                                                                <span class="meta-item">
                                                                                    <i class="icon ni ni-calendar"></i>
                                                                                    {{ date('d M', strtotime($subactivity->plan_start)) }}
                                                                                </span>
                                                                            @endif
                                                                            @if($subactivity->responsible_name)
                                                                                <span class="meta-item">
                                                                                    <i class="icon ni ni-user"></i>
                                                                                    {{ $subactivity->responsible_name }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <span class="subactivity-status">{{ $subStatusText }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="no-tasks">
                                No tasks found for this project
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TRIAL CHART SECTION -->
                @if($hasTrialProcess)
                    <div class="gantt-section" style="margin-top: 20px;">
                        <div class="gantt-header">
                            <h3 class="gantt-title">Trial Record</h3>
                        </div>

                        <!-- Select Process untuk Trial Charts -->
                        <div class="card card-bordered mb-3">
                            <div class="card-inner">
                                <label class="form-label fw-bold mb-2">Select Process</label>
                                <div class="process-wrapper">
                                    @foreach($process as $p)
                                        <button type="button" class="btn btn-outline-primary btn-process"
                                            data-process-id="{{ $p->lov_id }}" data-process-name="{{ $p->description }}">
                                            {{ $p->description }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Grafik Section -->
                        <div class="row g-4 mb-4 d-none" id="trialChartSection">
                            <!-- Grafik 1: %OK RATIO -->
                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">%OK RATIO</div>
                                        <div id="trialChart1" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik 2: CT -->
                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">Cycle Time (CT)</div>
                                        <div id="trialChart2" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik 3: BERAT -->
                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">Berat</div>
                                        <div id="trialChart3" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- MODAL INVOICE -->
<div class="modal fade" id="invoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formInvoice">
                <div class="modal-header">
                    <h5 class="modal-title">Add Invoice</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row gy-3">
                        <input type="hidden" name="project_id" value="{{ $projectId }}">
                        <div class="col-md-6">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="amount" placeholder="Enter amount..."
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="remarks" rows="1" placeholder="Enter Description..."
                                required></textarea>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <h6>Invoice List</h6>
                            <div class="table-responsive invoice-table-wrapper">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices as $inv)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Rp {{ number_format($inv->amount, 0, ',', '.') }}</td>
                                                <td>{{ $inv->remarks ?: '-' }}</td>
                                                <td>{{ $inv->date_created ? date('Y-m-d', strtotime($inv->date_created)) : '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">There is no invoice data yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Helper functions for status
    @php
        function getStatusClass($status)
        {
            $statusClasses = [
                0 => 'status-nostatus',
                1 => 'status-open',
                2 => 'status-inprogress',
                3 => 'status-completed',
                4 => 'status-onhold',
                5 => 'status-cancelled'
            ];
            return $statusClasses[$status] ?? 'status-nostatus';
        }

        function getStatusBulletClass($status)
        {
            $bulletClasses = [
                0 => 'status-nostatus-bullet',
                1 => 'status-open-bullet',
                2 => 'status-inprogress-bullet',
                3 => 'status-completed-bullet',
                4 => 'status-onhold-bullet',
                5 => 'status-cancelled-bullet'
            ];
            return $bulletClasses[$status] ?? 'status-nostatus-bullet';
        }

        function getStatusText($status)
        {
            $statusTexts = [
                0 => 'No Status',
                1 => 'Open',
                2 => 'In Progress',
                3 => 'Completed',
                4 => 'On Hold',
                5 => 'Cancelled'
            ];
            return $statusTexts[$status] ?? 'No Status';
        }

        function getCategoryClass($isMilestone)
        {
            $categoryClasses = [
                '20' => 'category-milestone',
                '21' => 'category-deliverable',
                '70' => 'category-task'
            ];
            return $categoryClasses[$isMilestone] ?? 'category-task';
        }
    @endphp

    // Function to create Highcharts Donut Chart yang RAPIH
    function createOverallProgressChart(elementId, statusData, overallPercentage) {
        const data = [
            {
                name: 'Open',
                y: statusData.open || 0,
                color: '#1f77b4',
                borderColor: '#1a6499'
            },
            {
                name: 'In Progress',
                y: statusData.inProgress || 0,
                color: '#00a591',
                borderColor: '#00897b'
            },
            {
                name: 'Completed',
                y: statusData.completed || 0,
                color: '#9acd32',
                borderColor: '#7cb342'
            },
            {
                name: 'On Hold',
                y: statusData.onHold || 0,
                color: '#f0ad4e',
                borderColor: '#eea236'
            },
            {
                name: 'Cancelled',
                y: statusData.cancelled || 0,
                color: '#d9534f',
                borderColor: '#d43f3a'
            }
        ];

        const chart = Highcharts.chart(elementId, {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false,
                height: 260,
                margin: [0, 0, 0, 0],
                spacing: [0, 0, 0, 0],
                events: {
                    load: function () {
                        const centerX = this.plotWidth / 2;
                        const centerY = this.plotHeight / 2;

                        this.renderer.label(
                            `<div class="center-percentage">${overallPercentage}%</div>
                             <div class="center-text">OVERALL<br>PROGRESS</div>`,
                            centerX - 40,
                            centerY - 25
                        )
                            .css({
                                textAlign: 'center',
                                width: '80px',
                                height: '50px',
                                color: '#2c3e50'
                            })
                            .add();
                    }
                }
            },
            title: {
                text: null
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                borderColor: '#dee2e6',
                borderRadius: 6,
                borderWidth: 1,
                style: {
                    color: '#333333',
                    fontSize: '12px'
                },
                headerFormat: '',
                pointFormat: '<span style="color:{point.color};font-weight:bold">{point.name}</span>: <b>{point.y}</b> tasks<br>({point.percentage:.1f}%)',
                shadow: true
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    innerSize: '75%',
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false,
                    borderWidth: 0,
                    states: {
                        hover: {
                            brightness: 0.1,
                            halo: {
                                size: 0
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Tasks',
                colorByPoint: true,
                data: data,
                size: '100%',
                innerSize: '75%',
                dataLabels: {
                    enabled: false
                }
            }]
        });

        return chart;
    }

    // Function to create PROJECT MILESTONE chart dengan warna berdasarkan status
    function createMilestoneDrilldownChart(elementId, groupedTasks) {
        // Fungsi untuk mendapatkan warna berdasarkan status
        function getStatusColor(status) {
            const statusColors = {
                0: '#34495e', // No Status
                1: '#1f77b4', // Open
                2: '#00a591', // In Progress
                3: '#9acd32', // Completed
                4: '#f0ad4e', // On Hold
                5: '#d9534f'  // Cancelled
            };
            return statusColors[status] || '#34495e';
        }

        function getStatusTextFromNumber(status) {
            const statusTexts = {
                0: 'No Status',
                1: 'Open',
                2: 'In Progress',
                3: 'Completed',
                4: 'On Hold',
                5: 'Cancelled'
            };
            return statusTexts[status] || 'No Status';
        }

        // Siapkan data untuk main chart (milestone)
        const mainSeriesData = [];
        const drilldownSeries = [];

        // Proses data dari groupedTasks
        Object.entries(groupedTasks).forEach(([milestoneId, milestoneData]) => {
            if (milestoneData['parent']) {
                const milestoneName = milestoneData['parent'].milestone_task || 'Unnamed Milestone';
                const milestoneStatus = milestoneData['parent'].status || 0;
                const milestoneColor = getStatusColor(milestoneStatus);

                // Hitung total ACTIVITIES untuk milestone ini (TANPA subactivities)
                let totalActivities = 0;
                const drilldownData = [];

                // Kumpulkan activities untuk tooltip
                const activitiesList = [];

                // Hitung dari activities saja (Level 2) - TANPA subactivities
                if (milestoneData['activities']) {
                    Object.entries(milestoneData['activities']).forEach(([activityId, activityData]) => {
                        if (activityData['activity']) {
                            totalActivities++;
                            const activityName = activityData['activity'].milestone_task || 'Unnamed Activity';
                            const activityStatus = activityData['activity'].status || 0;
                            const activityColor = getStatusColor(activityStatus);

                            // Tambahkan ke drilldown data - HANYA activity
                            drilldownData.push({
                                name: activityName,
                                y: 1,
                                color: activityColor,
                                status: activityStatus,
                                statusText: getStatusTextFromNumber(activityStatus)
                            });

                            // Tambahkan ke activities list untuk tooltip
                            activitiesList.push({
                                name: activityName,
                                color: activityColor,
                                statusText: getStatusTextFromNumber(activityStatus)
                            });
                        }
                    });
                }

                // Tambahkan ke main series dengan data tambahan untuk tooltip
                mainSeriesData.push({
                    name: milestoneName,
                    y: totalActivities,
                    drilldown: `milestone-${milestoneId}`,
                    color: milestoneColor,
                    status: milestoneStatus,
                    statusText: getStatusTextFromNumber(milestoneStatus),
                    activitiesList: activitiesList,
                    totalActivities: totalActivities
                });

                // Tambahkan ke drilldown series
                drilldownSeries.push({
                    name: milestoneName,
                    id: `milestone-${milestoneId}`,
                    data: drilldownData,
                    color: milestoneColor,
                    isDrilldown: true  // Flag untuk membedakan drilldown series
                });
            }
        });

        // Buat chart - MENGUBAH ASUMSI MINIMAL SUMBU Y MENJADI 1
        Highcharts.chart(elementId, {
            chart: {
                type: 'bar',
                height: 400,
                events: {
                    drilldown: function (e) {
                        // Saat drilldown, tetap gunakan warna yang sama
                        if (e.seriesOptions) {
                            e.seriesOptions.color = e.point.color;
                        }
                    },
                    drillup: function (e) {
                        // Reset saat drillup
                        this.series[0].update({
                            colorByPoint: true
                        });
                    }
                }
            },
            title: {
                text: '',
                align: 'left'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Number of Activities'
                },
                min: 1, // MENGUBAH INI DARI 0 MENJADI 1
                allowDecimals: false,
                tickInterval: 1
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}',
                        style: {
                            fontWeight: 'bold'
                        }
                    },
                    cursor: 'pointer'
                },
                bar: {
                    pointPadding: 0.2,
                    groupPadding: 0.1
                }
            },
            tooltip: {
                useHTML: true,
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                borderColor: '#dee2e6',
                borderRadius: 6,
                borderWidth: 1,
                shadow: true,
                style: {
                    color: '#333333',
                    fontSize: '12px',
                    padding: '10px'
                },
                formatter: function () {
                    // Jika ini adalah DRILLDOWN (activity individual)
                    if (this.series.userOptions && this.series.userOptions.isDrilldown) {
                        // Tooltip untuk activity individual
                        return `
                            <span style="font-size:13px; font-weight:bold">${this.point.name}</span><br>
                            <span style="color:${this.point.color}">●</span> 
                            Status: <b style="color:${this.point.color}">${this.point.statusText}</b>
                        `;
                    } else {
                        // Ini adalah MILESTONE (main chart)
                        let tooltipHTML = `
                            <div style="text-align:left;">
                                <span style="font-size:13px; font-weight:bold">${this.point.name}</span><br>
                                <span style="color:${this.point.color}">●</span> 
                                Milestone Status: <b style="color:${this.point.color}">${this.point.statusText}</b><br/>
                                Total Activities: <b>${this.point.totalActivities}</b>
                        `;

                        // Jika ada activities, tampilkan list-nya
                        if (this.point.activitiesList && this.point.activitiesList.length > 0) {
                            tooltipHTML += `
                                <hr style="margin:8px 0; border:none; border-top:1px solid #eee;">
                                <div style="font-weight:600; margin-bottom:5px;">Activities:</div>
                            `;

                            this.point.activitiesList.forEach((activity, index) => {
                                tooltipHTML += `
                                    <div style="margin-left:8px; margin-bottom:3px; display:flex; align-items:center; gap:5px;">
                                        <div style="width:8px; height:8px; background:${activity.color}; border-radius:1px;"></div>
                                        <span style="font-size:11px;">${activity.name}</span>
                                        <span style="font-size:10px; color:${activity.color}; margin-left:auto;">${activity.statusText}</span>
                                    </div>
                                `;
                            });
                        }

                        tooltipHTML += `</div>`;
                        return tooltipHTML;
                    }
                }
            },
            series: [{
                name: 'Milestones',
                colorByPoint: true,
                data: mainSeriesData
            }],
            drilldown: {
                activeDataLabelStyle: {
                    color: '#333333',
                    fontWeight: 'bold'
                },
                breadcrumbs: {
                    position: {
                        align: 'right'
                    },
                    buttonTheme: {
                        fill: '#f8f9fa',
                        stroke: '#dee2e6',
                        'stroke-width': 1,
                        style: {
                            color: '#495057'
                        },
                        states: {
                            hover: {
                                fill: '#e9ecef'
                            }
                        }
                    }
                },
                series: drilldownSeries
            },
            credits: {
                enabled: false
            }
        });
    }

    // Initialize charts
    const statusChart = @json($statusChart);
    const overallPercentage = {{ $overall }};
    const groupedTasks = @json($groupedTasks);

    createOverallProgressChart('overallProgressChart', statusChart, overallPercentage);
    createMilestoneDrilldownChart('container', groupedTasks);

    // Initialize Plan Hours vs Hours Spent visualization
    function initializeHoursVisualization() {
        const planHours = parseFloat({{ $planHours }}) || 0;
        const hoursSpent = parseFloat({{ $hoursSpent }}) || 0;
        const maxValue = Math.max(planHours, hoursSpent, 1);
        const containerHeight = 100;

        const planHeight = (planHours / maxValue) * (containerHeight * 0.8);
        const spentHeight = (hoursSpent / maxValue) * (containerHeight * 0.8);

        const planBar = document.getElementById('planHoursBar');
        const spentBar = document.getElementById('hoursSpentBar');

        if (planBar) {
            planBar.style.height = Math.max(20, planHeight) + 'px';
        }

        if (spentBar) {
            spentBar.style.height = Math.max(20, spentHeight) + 'px';
        }

        const planLabel = document.getElementById('planHoursLabel');
        const spentLabel = document.getElementById('hoursSpentLabel');

        if (planLabel) {
            planLabel.style.top = (planHeight > 25 ? '-25px' : '-30px');
        }

        if (spentLabel) {
            spentLabel.style.top = (spentHeight > 25 ? '-25px' : '-30px');
        }
    }

    // Gantt Chart functionality
    const day = 24 * 36e5;
    let chart;

    function convertTime(dateString) {
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

    function getColorMilestone(isMilestone) {
        switch (isMilestone) {
            case '20': return { color: '#28a745', fontWeight: '600' };
            case '21': return { color: '#000000', fontWeight: 'bold' };
            case '70': return { color: '#000000', fontWeight: 'normal' };
            default: return { color: '#6c757d', fontWeight: 'normal' };
        }
    }

    function getStyledMilestone(taskName, isMilestone) {
        const style = getColorMilestone(isMilestone);
        return `<span style="color: ${style.color}; font-weight: ${style.fontWeight}">${taskName}</span>`;
    }

    function isTaskOverdue(planEnd, actualEnd) {
        if (!planEnd || !actualEnd) return false;
        try {
            const planDate = new Date(planEnd);
            const actualDate = new Date(actualEnd);

            planDate.setHours(0, 0, 0, 0);
            actualDate.setHours(0, 0, 0, 0);

            return actualDate > planDate;
        } catch (error) {
            console.error('Error comparing dates:', error);
            return false;
        }
    }

    function prepareGanttData(tasks) {
        const seriesData = [];
        const projectId = {{ $projectId }};
        const projectName = "{{ addslashes($tasks->first()->project_name ?? 'Project') }}";

        const projectTasks = [{
            name: projectName,
            id: `project_${projectId}`,
            color: '#fac70fff'
        }];

        tasks.forEach((task, index) => {
            const taskId = `task_${projectId}_${index}`;
            const taskName = task.milestone_task ||
                (task.is_milestone_name ? `Milestone ${index + 1}` : `Task ${index + 1}`);

            const planStart = convertTime(task.plan_start);
            const planEnd = convertTime(task.plan_end);
            const actualStart = convertTime(task.actual_start);
            const actualEnd = convertTime(task.actual_end);

            const formattedName = getStyledMilestone(taskName, task.is_milestone);
            const isOverdue = isTaskOverdue(task.plan_end, task.actual_end);

            // BAR 1: PLAN (jika ada plan dates)
            if (planStart && planEnd) {
                projectTasks.push({
                    name: getStyledMilestone(taskName + " (Plan)", task.is_milestone),
                    id: taskId + "_plan",
                    parent: `project_${projectId}`,
                    start: planStart,
                    end: planEnd,
                    color: '#3498db',
                    borderColor: '#2980b9',
                    opacity: 0.8,
                    type: 'plan',
                    responsible: task.responsible_name,
                    status: task.status,
                    plan_start: task.plan_start?.split(' ')[0],
                    plan_end: task.plan_end?.split(' ')[0],
                    actual_start: task.actual_start?.split(' ')[0],
                    actual_end: task.actual_end?.split(' ')[0],
                    is_overdue: false,
                    is_plan: true
                });
            }

            // BAR 2: ACTUAL (jika ada actual dates)
            if (actualStart) {
                let actualColor, actualBorderColor, actualType;

                if (!actualEnd) {
                    actualColor = '#f39c12';
                    actualBorderColor = '#d68910';
                    actualType = 'actual_inprogress';
                } else {
                    if (isOverdue) {
                        actualColor = '#e74c3c';
                        actualBorderColor = '#c0392b';
                        actualType = 'actual_complete_overdue';
                    } else {
                        actualColor = '#2ecc71';
                        actualBorderColor = '#27ae60';
                        actualType = 'actual_complete_ontime';
                    }
                }

                projectTasks.push({
                    name: getStyledMilestone(taskName + " (Actual)", task.is_milestone),
                    id: taskId + "_actual",
                    parent: `project_${projectId}`,
                    start: actualStart,
                    end: actualEnd || actualStart + day,
                    color: actualColor,
                    borderColor: actualBorderColor,
                    opacity: 0.9,
                    type: actualType,
                    responsible: task.responsible_name,
                    status: task.status,
                    plan_start: task.plan_start?.split(' ')[0],
                    plan_end: task.plan_end?.split(' ')[0],
                    actual_start: task.actual_start?.split(' ')[0],
                    actual_end: task.actual_end?.split(' ')[0],
                    is_overdue: isOverdue,
                    is_actual: true,
                    is_inprogress: !actualEnd
                });
            }
        });

        seriesData.push({
            name: projectName,
            data: projectTasks
        });

        return seriesData;
    }

    function getDateRange() {
        const now = new Date();
        const currentMonth = now.getMonth();
        const currentYear = now.getFullYear();

        const startDate = new Date(currentYear, currentMonth - 3, 1);
        const endDate = new Date(currentYear, currentMonth + 4, 0);

        return {
            min: Date.UTC(startDate.getFullYear(), startDate.getMonth(), startDate.getDate(), 0, 0, 0, 0),
            max: Date.UTC(endDate.getFullYear(), endDate.getMonth(), endDate.getDate(), 23, 59, 59, 999)
        };
    }

    function getXAxisConfig() {
        const dateRange = getDateRange();
        const dateTimeLabelFormats = {
            day: '',
            week: '',
            month: '%b %Y',
            year: '%Y'
        };

        return {
            dateTimeLabelFormats: dateTimeLabelFormats,
            tickInterval: 30 * day
        };
    }

    function renderGanttChart() {
        const tasks = @json($tasks);

        if (!tasks || tasks.length === 0) {
            document.getElementById('ganttContainer').innerHTML =
                '<div style="text-align: center; padding: 50px; color: #6c757d;">No tasks available for this project</div>';
            document.getElementById('exportMenuContainer').style.display = 'none';
            return;
        }

        const ganttData = prepareGanttData(tasks);
        const dateRange = getDateRange();
        const xAxisConfig = getXAxisConfig();
        const totalTasks = ganttData.reduce((sum, series) => sum + series.data.length, 0);
        const rowHeight = 20;
        const dynamicHeight = Math.max(100, totalTasks * rowHeight);

        const legendData = [
            { color: '#3498db', label: 'Plan Only', text: '' },
            { color: '#f39c12', label: 'In Progress', text: '' },
            { color: '#2ecc71', label: 'On Time', text: '' },
            { color: '#e74c3c', label: 'Overdue', text: '' }
        ];

        const options = {
            chart: {
                plotBackgroundColor: 'rgba(128,128,128,0.02)',
                plotBorderColor: 'rgba(128,128,128,0.1)',
                plotBorderWidth: 1,
                height: dynamicHeight + 100,
                events: {
                    load: function () {
                        document.getElementById('exportMenuContainer').style.display = 'block';
                        addCustomLegend(legendData);
                    }
                }
            },
            credits: { enabled: false },
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
                    }]
                }
            },
            series: ganttData,
            tooltip: {
                pointFormat: '<span style="font-weight: bold">{point.name}</span><br>' +
                    'Responsible: <b>{point.responsible}</b><br>' +
                    'Start: {point.start:%e %b %Y}<br>' +
                    'End: {point.end:%e %b %Y}<br>' +
                    '{#if point.is_plan}' +
                    'Type: <span style="color: #3498db"><b>Plan</b></span><br>' +
                    '{else}' +
                    '{#if point.is_inprogress}' +
                    'Type: <span style="color: #f39c12"><b>Actual (In Progress)</b></span><br>' +
                    '{else}' +
                    '{#if point.is_overdue}' +
                    'Type: <span style="color: #e74c3c"><b>Actual (Overdue)</b></span><br>' +
                    '{else}' +
                    'Type: <span style="color: #2ecc71"><b>Actual (Completed)</b></span><br>' +
                    '{/if}' +
                    '{/if}' +
                    '{/if}' +
                    'Plan Dates: {point.plan_start:%e %b %Y} - {point.plan_end:%e %b %Y}<br>' +
                    'Actual Dates: {point.actual_start:%e %b %Y} - {point.actual_end:%e %b %Y}',
                useHTML: true,
                outside: true,
                zIndex: 999999
            },
            title: { text: '' },
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
                units: [['month', [1]]]
            }],
            yAxis: {
                gridLineWidth: 0,
                labels: { enabled: false },
                staticScale: 35
            },
            exporting: {
                enabled: true,
                sourceWidth: 1200,
                sourceHeight: 800,
                chartOptions: {
                    chart: { backgroundColor: '#ffffff' }
                }
            }
        };

        if (chart) {
            chart.destroy();
        }

        chart = Highcharts.ganttChart('ganttContainer', options);
    }

    function addCustomLegend(legendData) {
        const legendContainer = document.createElement('div');
        legendContainer.className = 'gantt-legend';
        legendContainer.style.cssText = `
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        `;

        legendData.forEach(item => {
            const legendItem = document.createElement('div');
            legendItem.style.cssText = `
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 12px;
                color: #495057;
            `;

            const colorBox = document.createElement('div');
            colorBox.style.cssText = `
                width: 15px;
                height: 15px;
                background: ${item.color};
                border-radius: 3px;
                border: 1px solid rgba(0,0,0,0.1);
            `;

            const textContainer = document.createElement('div');
            textContainer.innerHTML = `
                <strong>${item.label}</strong><br>
                <span style="font-size: 11px; color: #6c757d;">${item.text}</span>
            `;

            legendItem.appendChild(colorBox);
            legendItem.appendChild(textContainer);
            legendContainer.appendChild(legendItem);
        });

        const ganttContainer = document.getElementById('ganttContainer');
        ganttContainer.parentNode.insertBefore(legendContainer, ganttContainer.nextSibling);
    }

    // TRIAL CHART FUNCTIONS
    let selectedProcessId = null;
    const projectId = {{ $projectId }};
    let trialData = [];

    // Select Process untuk Trial Charts
    document.querySelectorAll('.btn-process').forEach(btn => {
        btn.addEventListener('click', function () {
            // Reset semua button
            document.querySelectorAll('.btn-process')
                .forEach(b => b.classList.remove('btn-primary'));

            // Set active button
            this.classList.add('btn-primary');

            selectedProcessId = this.dataset.processId;
            document.getElementById('trialChartSection').classList.remove('d-none');
            loadTrialData();
        });
    });

    function loadTrialData() {
        if (!selectedProcessId) return;

        // Reset chart containers dengan loading
        ['trialChart1', 'trialChart2', 'trialChart3'].forEach(id => {
            const container = document.getElementById(id);
            if (container) {
                container.innerHTML = `
                <div class="text-center text-muted p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading chart data...</p>
                </div>
            `;
            }
        });

        fetch("{{ route('trial.data') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                project_id: projectId,
                process_id: selectedProcessId
            })
        })
            .then(res => res.json())
            .then(data => {
                trialData = data;
                renderTrialCharts(data);
            })
            .catch(err => {
                console.error('Error loading trial data:', err);
                ['trialChart1', 'trialChart2', 'trialChart3'].forEach(id => {
                    const container = document.getElementById(id);
                    if (container) {
                        container.innerHTML = '<div class="text-center text-danger p-5">Error loading chart data</div>';
                    }
                });
            });
    }

    function renderTrialCharts(data) {
        if (!data || data.length === 0) {
            ['trialChart1', 'trialChart2', 'trialChart3'].forEach(id => {
                document.getElementById(id).innerHTML = '<div class="text-center text-muted p-5">No trial data available</div>';
            });
            return;
        }

        // Sort data by TRIAL_NO
        const sortedData = [...data].sort((a, b) => {
            return (a.trial_no || '').localeCompare(b.trial_no || '');
        });

        const trialNos = sortedData.map(item => item.trial_no || '');
        const selectedButton = document.querySelector('.btn-process.btn-primary');
        const selectedProcessName = selectedButton ? selectedButton.dataset.processName : '';

        // Grafik 1: %OK RATIO
        const perctData = sortedData.map(item => parseFloat(item.perct) || 0);
        const targetData = sortedData.map(item => parseFloat(item.target) || 0);

        Highcharts.chart('trialChart1', {
            chart: {
                type: 'column',
                height: 380
            },
            title: {
                text: '%OK RATIO',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            subtitle: {
                text: selectedProcessName,
                align: 'center'
            },
            xAxis: {
                categories: trialNos,
                title: {
                    text: 'Trial No'
                },
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Percentage (%)'
                },
                labels: {
                    format: '{value}%'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">Trial {point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f}%</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: '%OK RATIO',
                data: perctData,
                color: '#4CAF50'
            }, {
                name: 'Target',
                data: targetData,
                type: 'line',
                color: '#FF9800',
                marker: {
                    symbol: 'circle',
                    radius: 6
                }
            }],
            credits: {
                enabled: false
            }
        });

        // Grafik 2: CT (Cycle Time)
        const ctData = sortedData.map(item => parseFloat(item.ct) || 0);
        const ctTargetData = sortedData.map(item => parseFloat(item.ct_target) || 0);

        Highcharts.chart('trialChart2', {
            chart: {
                type: 'column',
                height: 380
            },
            title: {
                text: 'Cycle Time (CT)',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            subtitle: {
                text: selectedProcessName,
                align: 'center'
            },
            xAxis: {
                categories: trialNos,
                title: {
                    text: 'Trial No'
                },
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cycle Time'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">Trial {point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'CT',
                data: ctData,
                color: '#2196F3'
            }, {
                name: 'CT Target',
                data: ctTargetData,
                type: 'line',
                color: '#FF5722',
                marker: {
                    symbol: 'circle',
                    radius: 6
                }
            }],
            credits: {
                enabled: false
            }
        });

        // Grafik 3: BERAT
        const beratData = sortedData.map(item => parseFloat(item.berat) || 0);
        const beratTargetData = sortedData.map(item => parseFloat(item.berat_target) || 0);

        Highcharts.chart('trialChart3', {
            chart: {
                type: 'column',
                height: 380
            },
            title: {
                text: 'Berat',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            subtitle: {
                text: selectedProcessName,
                align: 'center'
            },
            xAxis: {
                categories: trialNos,
                title: {
                    text: 'Trial No'
                },
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Berat'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">Trial {point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Berat',
                data: beratData,
                color: '#9C27B0'
            }, {
                name: 'Berat Target',
                data: beratTargetData,
                type: 'line',
                color: '#795548',
                marker: {
                    symbol: 'circle',
                    radius: 6
                }
            }],
            credits: {
                enabled: false
            }
        });
    }

    // Task Filtering - Hanya Filter Milestone
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Hours Visualization
        initializeHoursVisualization();

        // Initialize task filtering
        let currentMilestoneFilter = 'all';

        // Elements
        const taskGridContainer = document.getElementById('taskGridContainer');
        const visibleTaskCounter = document.getElementById('visibleTaskCounter');
        const milestoneFilter = document.getElementById('milestoneFilter');

        // Simple filtering function
        function filterTasks() {
            let visibleTaskCount = 0;
            const taskGroups = document.querySelectorAll('.task-group-card');

            taskGroups.forEach(group => {
                const milestoneId = group.getAttribute('data-milestone-id');

                if (currentMilestoneFilter === 'all' || milestoneId === currentMilestoneFilter) {
                    group.classList.remove('hidden');

                    const milestoneCard = group.querySelector('.task-milestone-card');
                    const activityCards = group.querySelectorAll('.task-activity-card');
                    const subactivityCards = group.querySelectorAll('.task-subactivity-card');

                    if (milestoneCard) visibleTaskCount++;
                    visibleTaskCount += activityCards.length;
                    visibleTaskCount += subactivityCards.length;
                } else {
                    group.classList.add('hidden');
                }
            });

            visibleTaskCounter.textContent = `(${visibleTaskCount} tasks)`;

            const noTasksMessage = document.querySelector('.no-tasks');
            if (noTasksMessage) {
                if (visibleTaskCount === 0) {
                    noTasksMessage.classList.remove('hidden');
                } else {
                    noTasksMessage.classList.add('hidden');
                }
            }
        }

        // Event Listeners
        if (milestoneFilter) {
            milestoneFilter.addEventListener('change', function () {
                currentMilestoneFilter = this.value;
                filterTasks();
            });
        }

        // Initialize
        filterTasks();

        // Export menu functionality
        const exportMenuBtn = document.getElementById('exportMenuBtn');
        const exportMenu = document.getElementById('exportMenu');

        if (exportMenuBtn) {
            exportMenuBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                exportMenu.classList.toggle('show');
            });

            document.addEventListener('click', function () {
                exportMenu.classList.remove('show');
            });

            // Fullscreen functionality
            document.getElementById('fullscreenBtn').addEventListener('click', function () {
                if (chart) chart.fullscreen.toggle();
                exportMenu.classList.remove('show');
            });

            // Print functionality
            document.getElementById('printChartBtn').addEventListener('click', function () {
                if (chart) {
                    chart.exportChart({
                        type: 'application/pdf',
                        filename: 'Gantt-Chart-' + new Date().toISOString().slice(0, 10),
                        sourceWidth: 1200,
                        sourceHeight: 800
                    });
                }
                exportMenu.classList.remove('show');
            });

            // Download PNG functionality
            document.getElementById('downloadPNGBtn').addEventListener('click', function () {
                if (chart) {
                    chart.exportChart({
                        type: 'image/png',
                        filename: 'Gantt-Chart-' + new Date().toISOString().slice(0, 10),
                        sourceWidth: 1200,
                        sourceHeight: 800
                    });
                }
                exportMenu.classList.remove('show');
            });

            // Download JPEG functionality
            document.getElementById('downloadJPGBtn').addEventListener('click', function () {
                if (chart) {
                    chart.exportChart({
                        type: 'image/jpeg',
                        filename: 'Gantt-Chart-' + new Date().toISOString().slice(0, 10),
                        sourceWidth: 1200,
                        sourceHeight: 800
                    });
                }
                exportMenu.classList.remove('show');
            });
        }

        // Initialize Gantt Chart
        renderGanttChart();

        // Invoice modal functionality
        const invoiceCard = document.getElementById('invoiceCard');
        if (invoiceCard) {
            invoiceCard.addEventListener('click', function () {
                var modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                modal.show();
            });
        }

        // Handle invoice form submission
        const form = document.getElementById('formInvoice');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const amount = form.querySelector('[name="amount"]').value;
                const remarks = form.querySelector('[name="remarks"]').value;

                if (!amount || amount <= 0) {
                    Swal.fire('Error', 'Please enter a valid amount', 'error');
                    return;
                }

                if (!remarks || remarks.trim() === '') {
                    Swal.fire('Error', 'Description is required', 'error');
                    return;
                }

                fetch("{{ route('invoice.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: new URLSearchParams(new FormData(form))
                })
                    .then(response => response.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Failed to save invoice', 'error');
                    });
            });
        }
    });

    // Add weekend plot bands plugin
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

            axis.options.plotBands = weekendPlotBands;
        }
    });
</script>