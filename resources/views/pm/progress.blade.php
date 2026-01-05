<style>
    /* CSS tetap sama seperti sebelumnya, hapus loading-overlay dan spinner */
    body {
        background: #ffffff;
        color: #333333;
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    .page-container {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
    }

    .left-panel {
        flex: 1;
        min-width: 300px;
        max-width: 400px;
    }

    .select-row {
        display: flex;
        margin-bottom: 20px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .select-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        min-width: 140px;
    }

    .select-box {
        flex: 1;
        border: none;
        padding: 12px 15px;
        font-size: 0.9rem;
        background: white;
        color: #495057;
        cursor: pointer;
        font-weight: 400;
    }

    .select-box:focus {
        outline: none;
        box-shadow: inset 0 0 0 2px #667eea;
    }

    .select-box:disabled {
        opacity: 0.7;
        cursor: wait;
    }

    .grid-box {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 15px;
    }

    .info-box {
        background: white;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-left: 3px solid #667eea;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .info-box .number {
        display: block;
        font-size: 1.8rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .info-box .label {
        display: block;
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.4;
    }

    .right-panel {
        flex: 2;
        min-width: 400px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .panel-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #495057;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .legend-dot {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 4px;
        margin-right: 8px;
        vertical-align: middle;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    #customLegend {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 25px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    #customLegend>div {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        color: #495057;
        font-weight: 500;
    }

    #taskProgressChart {
        width: 100%;
        height: 380px;
        margin-bottom: 10px;
    }

    @media (max-width: 992px) {
        .page-container {
            flex-direction: column;
        }

        .left-panel,
        .right-panel {
            max-width: 100%;
            min-width: 100%;
        }

        .grid-box {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .grid-box {
            grid-template-columns: 1fr;
        }

        .select-row {
            flex-direction: column;
        }

        .select-label {
            min-width: 100%;
            justify-content: center;
            padding: 10px;
        }

        #customLegend {
            flex-direction: column;
            gap: 10px;
        }

        .info-box .number {
            font-size: 1.6rem;
        }

        .info-box .label {
            font-size: 0.75rem;
        }
    }

    .highcharts-background {
        fill: #ffffff !important;
    }

    .highcharts-data-label text {
        font-weight: 600 !important;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8) !important;
        fill: #000000 !important;
    }

    .highcharts-tooltip-box {
        fill: white !important;
        fill-opacity: 0.95 !important;
        stroke: #dee2e6 !important;
        stroke-width: 1 !important;
    }

    .highcharts-color-0 {
        fill: #1f77b4 !important;
    }

    .highcharts-color-1 {
        fill: #00a591 !important;
    }

    .highcharts-color-2 {
        fill: #9acd32 !important;
    }

    .highcharts-color-3 {
        fill: #f0ad4e !important;
    }

    .highcharts-color-4 {
        fill: #d9534f !important;
    }

    .highcharts-color-5 {
        fill: #34495e !important;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        padding-bottom: 10px;
    }
</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="page-title">Task Progress</div>

<div class="page-container">
    <!-- LEFT SECTION -->
    <div class="left-panel">
        <div class="select-row">
            <div class="select-label" style="font-weight: 600; font-size: 0.9rem;">*Select Person</div>
            <select class="select-box" id="personSelect">
                <option value="all" {{ $defaultResource == 'all' ? 'selected' : '' }}>-- All --</option>
                @foreach($resources as $resource)
                    <option value="{{ $resource['id'] }}" {{ $defaultResource == $resource['id'] ? 'selected' : '' }}>
                        {{ $resource['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid-box">
            <div class="info-box">
                <div class="number" id="tasksAssigned">{{ $stats['total_tasks'] ?? 0 }}</div>
                <div class="label" style="font-weight: 600; color: #666666; font-size: 0.8rem;">TASKS ASSIGNED</div>
            </div>
            <div class="info-box">
                <div class="number" id="tasksCompleted">{{ $stats['completed_tasks'] ?? 0 }}</div>
                <div class="label" style="font-weight: 600; color: #666666; font-size: 0.8rem;">TASKS COMPLETED</div>
            </div>

            <div class="info-box">
                <div class="number" id="dueThisMonth">{{ $stats['due_this_month'] ?? 0 }}</div>
                <div class="label" style="font-weight: 600; color: #666666; font-size: 0.8rem;">DUE THIS MONTH</div>
            </div>
            <div class="info-box">
                <div class="number" id="dueNextMonth">{{ $stats['due_next_month'] ?? 0 }}</div>
                <div class="label" style="font-weight: 600; color: #666666; font-size: 0.8rem;">DUE NEXT MONTH</div>
            </div>

            <div class="info-box">
                <div class="number" id="dueThisYear">{{ $stats['due_this_year'] ?? 0 }}</div>
                <div class="label" style="font-weight: 600; color: #666666; font-size: 0.8rem;">DUE THIS YEAR</div>
            </div>
            <div class="info-box">
                <div class="number" id="dueNextYear">{{ $stats['due_next_year'] ?? 0 }}</div>
                <div class="label" style="font-weight: 600; color: #666666; font-size: 0.8rem;">DUE NEXT YEAR</div>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="right-panel">
        <div class="panel-title">TASK PROGRESS</div>
        <div id="taskProgressChart"></div>

        <div id="customLegend">
            <div><span class="legend-dot" style="background:#1f77b4;"></span> Open</div>
            <div><span class="legend-dot" style="background:#00a591;"></span> InProgress</div>
            <div><span class="legend-dot" style="background:#9acd32;"></span> Completed</div>
            <div><span class="legend-dot" style="background:#f0ad4e;"></span> On Hold</div>
            <div><span class="legend-dot" style="background:#d9534f;"></span> Cancelled</div>
            <div><span class="legend-dot" style="background:#34495e;"></span> OTHER</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        renderChart(@json($initialData), {{ $stats['completed_tasks'] ?? 0 }}, {{ $stats['total_tasks'] ?? 0 }});

        $('#personSelect').on('change', function () {
            const person = $(this).val();
            loadProgressData(person); 
        });
    });

    function loadProgressData(person) {
        $('#personSelect').prop('disabled', true);

        $('#personSelect').css('color', '#999');
        $('#personSelect').parent().append('<div class="loading-text" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #667eea;">Loading...</div>');

        $.ajax({
            url: '{{ route("getProgressData") }}',
            type: 'GET',
            data: {
                person: person || 'all' 
            },
            success: function (response) {
                if (response.success) {
                    // Update statistics
                    $('#tasksAssigned').text(response.stats.total_tasks);
                    $('#tasksCompleted').text(response.stats.completed_tasks);
                    $('#dueThisMonth').text(response.stats.due_this_month);
                    $('#dueNextMonth').text(response.stats.due_next_month);
                    $('#dueThisYear').text(response.stats.due_this_year);
                    $('#dueNextYear').text(response.stats.due_next_year);

                    // Update chart
                    renderChart(response.chartData, response.completedTasks, response.totalTasks);
                } else {
                    alert('Error loading data: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Failed to load data. Please try again.');
            },
            complete: function () {
                // Enable select box kembali
                $('#personSelect').prop('disabled', false);
                $('#personSelect').css('color', '#495057');
                $('.loading-text').remove();
            }
        });
    }

    function renderChart(chartData, completedTasks, totalTasks) {
        const overallProgress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;

        Highcharts.chart('taskProgressChart', {
            chart: {
                type: 'pie',
                backgroundColor: '#ffffff',
                events: {
                    render() {
                        const chart = this;
                        const series = chart.series[0];
                        let lbl = chart.customCenterLabel;

                        if (!lbl) {
                            lbl = chart.customCenterLabel = chart.renderer.label('', 0, 0)
                                .css({
                                    textAlign: 'center',
                                    fontSize: '24px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                })
                                .add();
                        }

                        lbl.attr({
                            text: `${overallProgress}%<br><span style="font-size:14px; font-weight:600; color:#666666;">OVERALL<br>PROGRESS</span>`
                        });

                        const x = chart.plotLeft + series.center[0] - (lbl.getBBox().width / 2);
                        const y = chart.plotTop + series.center[1] - 35;

                        lbl.attr({ x: x, y: y });
                    }
                }
            },

            title: {
                text: '',
                style: {
                    color: '#333333'
                }
            },

            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                borderColor: '#dee2e6',
                style: {
                    color: '#333333'
                },
                pointFormat: '<b>{point.y}</b> tasks ({point.percentage:.0f}%)'
            },

            legend: {
                enabled: true,
                itemStyle: {
                    color: '#333333'
                }
            },

            plotOptions: {
                pie: {
                    innerSize: '70%',
                    dataLabels: {
                        enabled: true,
                        formatter() {
                            return '<b style="color: #000000;">' + this.y + ' TASKS</b>';
                        },
                        distance: -30,
                        style: {
                            fontSize: '12px',
                            color: '#000000',
                            textOutline: '1px #ffffff'
                        }
                    }
                }
            },

            series: [{
                name: 'Tasks',
                colorByPoint: true,
                data: chartData
            }]
        });
    }
</script>