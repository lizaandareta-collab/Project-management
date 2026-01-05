{{-- HAIGHCHARTS --}}
<script src="{{ asset('assets/js/highcharts-chart.js') }}"></script>
<!-- <script src="{{ asset('assets/js/exporting-chart.js') }}"></script> -->
<script src="{{ asset('assets/js/export-data-chart.js') }}"></script>
<script src="{{ asset('assets/js/accessibility-chart.js') }}"></script>
<script src="{{ asset('assets/js/adaptive-chart.js') }}"></script>

<style>
    body {
        font-family:
            -apple-system,
            BlinkMacSystemFont,
            "Segoe UI",
            Roboto,
            Helvetica,
            Arial,
            "Apple Color Emoji",
            "Segoe UI Emoji",
            "Segoe UI Symbol",
            sans-serif;
        background: var(--highcharts-background-color);
        color: var(--highcharts-neutral-color-100);
        padding: 20px;
    }

    .highcharts-figure {
        width: 100%;
        max-width: 100%;
        margin: 1em auto;
    }

    #container {
        width: 100%;
        height: 500px;
    }

    .highcharts-description {
        margin: 0.5rem 10px;
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .loading {
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .chart-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        /* border-bottom: 2px solid #007bff; */
        padding-bottom: 10px;
    }
</style>

<div class="page-title">Resource Workload</div>

<div class="highcharts-figure">
    <div id="container">
        <div class="loading">Loading resource data from all projects...</div>
    </div>
</div>

<script>
    let chart;

    document.addEventListener('DOMContentLoaded', function () {
        loadAllResourcesData();
    });

    function loadAllResourcesData() {
        document.getElementById('container').innerHTML = '<div class="loading">Loading resource data from all projects...</div>';

        fetch(`/resource/all-data`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderChart(data.data, data.stats.total_projects); 
                } else {
                    document.getElementById('container').innerHTML = '<div class="loading">Error loading data</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('container').innerHTML = '<div class="loading">Error loading data</div>';
            });
    }

    function renderChart(resourceData, totalProjects) {
        const filtered = Object.entries(resourceData)
            .filter(([responsibleName, data]) => {
                return responsibleName && responsibleName !== 'Unassigned' && responsibleName !== '' && responsibleName !== null;
            })
            .sort(([, a], [, b]) => b.plan_hours - a.plan_hours);

        const responsibleNames = filtered.map(([responsibleName]) => responsibleName);
        const planHours = filtered.map(([responsibleName, data]) => data.plan_hours);
        const taskCounts = filtered.map(([responsibleName, data]) => data.tasks);
        const milestones = filtered.map(([responsibleName, data]) => data.milestones);

        const seriesData = responsibleNames.map((name, index) => {
            return {
                name: name,
                planHours: planHours[index],
                tasks: taskCounts[index],
                milestones: milestones[index],
                y: planHours[index],
                y2: taskCounts[index]
            };
        });

        Highcharts.chart('container', {
            chart: {
                zooming: { type: 'xy' }
            },
            title: {
                text: 'Resource Workload',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            subtitle: {
                text: `Total ${totalProjects} Projects`,
                align: 'center',
                style: {
                    fontSize: '12px',
                    color: '#666'
                }
            },
            credits: {
                enabled: false
            },
            xAxis: [{
                categories: responsibleNames,
                crosshair: true,
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '11px'
                    }
                },
                title: {
                    text: 'Responsible',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                }
            }],
            yAxis: [{
                title: {
                    text: 'Plan Hours',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                },
                labels: {
                    format: '{value} hours'
                },
                lineColor: Highcharts.getOptions().colors[0],
                lineWidth: 2
                // opposite: false (default) -> di kiri
            }, {
                title: {
                    text: 'Tasks',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                },
                labels: {
                    format: '{value} tasks'
                },
                lineColor: Highcharts.getOptions().colors[1],
                lineWidth: 2,
                opposite: true // true -> di kanan
            }],
            tooltip: {
                shared: true,
                useHTML: true,
                formatter: function () {
                    const points = this.points || [];
                    const point = points[0] || this.point;

                    const responsibleName = point.category || point.key;
                    const resourceData = filtered.find(([name]) => name === responsibleName);

                    if (!resourceData) {
                        return `<b>${responsibleName}</b><br/>No data available`;
                    }

                    const [, data] = resourceData;

                    let tooltipHTML = `
                    <div style="padding: 5px;">
                        <div style="font-weight: bold; font-size: 14px; margin-bottom: 8px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">
                            ${responsibleName}
                        </div>
                `;

                    points.forEach(p => {
                        if (p.series.name === 'Plan Hours') {
                            tooltipHTML += `
                            <div style="margin: 3px 0;">
                                <span style="color:${p.series.color}">●</span> 
                                <b>Plan Hours:</b> ${Math.round(p.y)} hours
                            </div>
                        `;
                        } else if (p.series.name === 'Tasks') {
                            tooltipHTML += `
                            <div style="margin: 3px 0;">
                                <span style="color:${p.series.color}">●</span> 
                                <b>Tasks:</b> ${Math.round(p.y)} tasks
                            </div>
                        `;
                        }
                    });

                    if (data.milestones > 0) {
                        tooltipHTML += `
                        <div style="margin: 3px 0;">
                            <span style="color:#ff9800">●</span> 
                            <b>Milestones:</b> ${data.milestones}
                        </div>
                    `;
                    }

                    tooltipHTML += '</div>';
                    return tooltipHTML;
                }
            },
            legend: {
                align: 'center',
                verticalAlign: 'top',
                layout: 'horizontal'
            },
            plotOptions: {
                column: {
                    borderRadius: 3,
                    pointPadding: 0.1,
                    groupPadding: 0.1
                },
                spline: {
                    marker: {
                        enabled: true,
                        radius: 4
                    }
                },
                series: {
                    stickyTracking: false
                }
            },
            series: [{
                name: 'Plan Hours',
                type: 'column',
                yAxis: 0, 
                data: planHours,
                color: Highcharts.getOptions().colors[0],
                tooltip: {
                    valueSuffix: ' hours',
                    valueDecimals: 0
                }
            }, {
                name: 'Tasks',
                type: 'spline',
                yAxis: 1, 
                data: taskCounts,
                color: Highcharts.getOptions().colors[1],
                tooltip: {
                    valueSuffix: ' tasks',
                    valueDecimals: 0
                }
            }]
        });
    }
</script>