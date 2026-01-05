<style>
    .heatmap-wrapper {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .card-borderless,
    .card-borderless .card-inner {
        border: none !important;
        box-shadow: none !important;
    }

    .heatmap-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        border: none !important;
    }

    .heatmap-table th,
    .heatmap-table td {
        border: 2px solid #dee2e6 !important;
        padding: 6px;
        text-align: center;
        vertical-align: middle;
    }

    .heatmap-table thead th {
        background: #f3f4f7;
        font-weight: 700;
    }

    .heatmap-table tfoot td {
        background: #f3f4f7;
        font-weight: 700 !important;
    }

    .heatmap-wrapper .card-inner {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .hm-hours-low {
        background-color: #d1f2d1 !important;
        font-weight: 700;
    }

    .hm-hours-mid {
        background-color: #faf740ff !important;
        font-weight: 700;
    }

    .hm-hours-high {
        background-color: #ff5c5c !important;
        color: white;
        font-weight: 700;
    }

    .hm-task-low {
        background-color: #d1f2d1 !important;
        font-weight: 700;
    }

    .hm-task-mid {
        background-color: #faf740ff !important;
        font-weight: 700;
    }

    .hm-task-high {
        background-color: #ff5c5c !important;
        color: white;
        font-weight: 700;
    }

    .heatmap-table td:first-child,
    .heatmap-table th:first-child,
    .heatmap-table td:last-child,
    .heatmap-table th:last-child {
        background: #f3f4f7 !important;
        font-weight: 700;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        padding-bottom: 10px;
    }

    /*
    .stats-badge {
        background: #e3f2fd;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        margin-left: 10px;
    }
    */

    .loading-spinner {
        display: none;
        color: #007bff;
        font-size: 14px;
        margin-left: 10px;
    }

    .heatmap-info-inline {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 22px;
        font-size: 14px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
    }

    .info-badge {
        width: 22px;
        height: 22px;
        border-radius: 4px;
        display: inline-block;
        border: 2px solid #888;
    }
</style>

<div class="page-title">
    Tasks Heatmap
    <span class="loading-spinner" id="loadingSpinner">
        <i class="fa fa-spinner fa-spin"></i> Loading...
    </span>
</div>

<!-- ===================== WRAPPER UNTUK 1 GARIS LUAR ===================== -->
<div class="heatmap-wrapper">

    <!-- ===================== FILTER AREA ===================== -->
    <div class="row mb-3">
        <!-- Di bagian filter: -->
        <div class="col-md-3">
            <label class="form-label fw-bold">Year</label>
            <select id="yearFilter" class="form-select">
                <?php 
            
                $minYear = isset($yearRange['min']) ? $yearRange['min'] : (date('Y') - 1);
                $maxYear = isset($yearRange['max']) ? $yearRange['max'] : (date('Y') + 1);

                $minYear = max(2020, $minYear);

                if ($maxYear - $minYear < 2) {
                    $maxYear = $minYear + 2;
                }

                for ($year = $minYear; $year <= $maxYear; $year++): 
                                        ?>
                <option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>>
                    <?= $year ?>
                </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Timeframe</label>
            <select id="timeframeFilter" class="form-select">
                <option value="planned" selected>Planned</option>
                <option value="actual">Actual</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Select Person</label>
            <select id="personFilter" class="form-select">
                <option value="">All</option>
                <?php foreach ($resources as $resource): ?>
                <?php    if (!empty($resource->npk) && !empty($resource->emp_name)): ?>
                <option value="<?= $resource->npk ?>">
                    <?= htmlspecialchars($resource->emp_name) ?>
                </option>
                <?php    endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Aggregate</label>
            <select id="aggregateFilter" class="form-select">
                <option value="hours" selected>Hours</option>
                <option value="task">Task</option>
            </select>
        </div>
    </div>

    <!-- ===================== HOURS & TASK COLOR INFO ===================== -->
    <div class="heatmap-info-inline">
        <!-- HOURS -->
        <strong>Hours:</strong>

        <div class="info-item">
            <span class="info-badge hm-hours-low"></span>
            < 4 </div>

                <div class="info-item">
                    <span class="info-badge hm-hours-mid"></span>
                    4 – 6
                </div>

                <div class="info-item">
                    <span class="info-badge hm-hours-high"></span>
                    > 6
                </div>

                <div style="width:1px;height:18px;background:#ccc;margin:0 5px;"></div>

                <!-- TASK -->
                <strong>Task:</strong>

                <div class="info-item">
                    <span class="info-badge hm-task-low"></span>
                    < 3 </div>

                        <div class="info-item">
                            <span class="info-badge hm-task-mid"></span>
                            3 – 4
                        </div>

                        <div class="info-item">
                            <span class="info-badge hm-task-high"></span>
                            > 4
                        </div>
                </div>

                <!-- ===================== TABLE HEATMAP ===================== -->
                <div class="card card-borderless">
                    <div class="card-inner">
                        <table id="heatmapTable" class="table heatmap-table">
                            <thead>
                                <tr>
                                    <th width="50" id="currentYear"></th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                    <th width="70">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                            <tfoot id="tableFooter">
                            </tfoot>
                        </table>
                    </div>
                </div>
        </div>

        <script>
            let heatmapData = <?= json_encode($initialHeatmapData) ?>;
            let holidays = [];
            let currentYear = new Date().getFullYear();

            console.log('=== INITIAL HEATMAP DATA ===');
            console.log('Full heatmapData:', heatmapData);
            console.log('Type:', typeof heatmapData);

            if (heatmapData) {
                console.log('Keys:', Object.keys(heatmapData));
                console.log('Has hours?', 'hours' in heatmapData);
                console.log('Has tasks?', 'tasks' in heatmapData);

                if (heatmapData.hours) {
                    console.log('Hours years:', Object.keys(heatmapData.hours));
                    console.log('Sample hours 2025:', heatmapData.hours[2025]);
                }

                if (heatmapData.tasks) {
                    console.log('Tasks years:', Object.keys(heatmapData.tasks));
                    console.log('Sample tasks 2025:', heatmapData.tasks[2025]);

                    if (heatmapData.tasks[2025]) {
                        console.log('Tasks 2025 days 1-5:');
                        for (let day = 1; day <= 5; day++) {
                            if (heatmapData.tasks[2025][day]) {
                                console.log(`  Day ${day}:`, heatmapData.tasks[2025][day]);
                            }
                        }
                    }
                }
            }

            function getHeatmapClass(value, mode) {
                if (!value || value === 0) return '';

                if (mode === 'hours') {
                    if (value < 4) return 'hm-hours-low';
                    if (value < 6) return 'hm-hours-mid';
                    return 'hm-hours-high';
                } else { 
                    if (value < 3) return 'hm-task-low';
                    if (value < 4) return 'hm-task-mid';
                    return 'hm-task-high';
                }
            }

            function formatNumber(num, isTaskMode = false) {
                console.log('formatNumber called:', { num, isTaskMode, type: typeof num });

                if (num === null || num === undefined || num === '' || num === 0 || num === '0') {
                    return '';
                }
                let numberValue;

                if (typeof num === 'string') {
                    numberValue = parseFloat(num);
                } else {
                    numberValue = num;
                }

                if (isNaN(numberValue)) {
                    return '';
                }

                if (isTaskMode) {
                    return numberValue % 1 === 0
                        ? numberValue.toString()
                        : numberValue.toFixed(2);
                }

                if (Number.isInteger(numberValue)) {
                    return numberValue.toString();
                }

                return numberValue.toFixed(1);
            }

            function calculateMonthlyTotals(yearData) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const monthTotals = months.map(() => 0);

                if (!yearData) {
                    console.log('No yearData in calculateMonthlyTotals');
                    return monthTotals;
                }

                console.log('Calculating monthly totals from:', yearData);

                for (let day = 1; day <= 31; day++) {
                    const dayData = yearData[day];
                    if (dayData) {
                        months.forEach((month, index) => {
                            const value = dayData[month] || 0;
                            monthTotals[index] += value;
                        });
                    }
                }

                console.log('Monthly totals:', monthTotals);
                return monthTotals;
            }

            function updateHeatmap() {
                console.log('=== UPDATE HEATMAP START ===');

                const yearSelect = document.getElementById('yearFilter');
                const modeSelect = document.getElementById('aggregateFilter');
                const selectedYear = yearSelect.value;
                const selectedMode = modeSelect.value;
                const tableBody = document.getElementById('tableBody');
                const tableFooter = document.getElementById('tableFooter');
                const currentYearHeader = document.getElementById('currentYear');

                console.log('Selected:', { year: selectedYear, mode: selectedMode });
                console.log('Current heatmapData:', heatmapData);

                currentYearHeader.textContent = selectedYear;
                
                tableBody.innerHTML = '';
                tableFooter.innerHTML = '';

                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                // GET DATA
                let yearData = null;

                if (selectedMode === 'hours' && heatmapData && heatmapData.hours) {
                    yearData = heatmapData.hours[selectedYear];
                    console.log('Using HOURS data for', selectedYear, ':', yearData);
                } else if (selectedMode === 'task' && heatmapData && heatmapData.tasks) {
                    yearData = heatmapData.tasks[selectedYear];
                    console.log('Using TASKS data for', selectedYear, ':', yearData);
                }

                if (!yearData) {
                    console.log(`No ${selectedMode} data found for year ${selectedYear}`);
                    console.log('Available tasks years:', heatmapData?.tasks ? Object.keys(heatmapData.tasks) : 'none');
                    console.log('Available hours years:', heatmapData?.hours ? Object.keys(heatmapData.hours) : 'none');

                    // Show empty table
                    for (let day = 1; day <= 31; day++) {
                        const row = document.createElement('tr');
                        const dayCell = document.createElement('td');
                        dayCell.textContent = day;
                        row.appendChild(dayCell);

                        months.forEach(() => {
                            const cell = document.createElement('td');
                            cell.textContent = '';
                            row.appendChild(cell);
                        });

                        const totalCell = document.createElement('td');
                        totalCell.textContent = '';
                        row.appendChild(totalCell);

                        tableBody.appendChild(row);
                    }
                    console.log('=== UPDATE HEATMAP END (no data) ===');
                    return;
                }

                const monthTotals = calculateMonthlyTotals(yearData);

                // Buat 31 baris (1-31)
                for (let day = 1; day <= 31; day++) {
                    const row = document.createElement('tr');

                    // Kolom pertama: nomor hari
                    const dayCell = document.createElement('td');
                    dayCell.textContent = day;
                    row.appendChild(dayCell);

                    const dayData = yearData[day] || {};
                    let totalForDay = 0;

                    console.log(`Day ${day} data:`, dayData);

                    months.forEach((month, monthIndex) => {
                        const cell = document.createElement('td');

                        const dateObj = new Date(selectedYear, monthIndex, day);
                        const dayOfWeek = dateObj.getDay(); // 0=Sunday, 6=Saturday

                        const dateStr = `${selectedYear}-${String(monthIndex + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                        // ========== SKIP WEEKEND & HOLIDAY ==========
                        if (
                            dayOfWeek === 0 || dayOfWeek === 6 || 
                            holidays.includes(dateStr)            
                        ) {
                            cell.textContent = '';       
                            cell.className = '';         
                            row.appendChild(cell);
                            return;
                        }

                        let value = dayData[month] || 0;

                        if (value && value > 0) {
                            const displayValue = formatNumber(value, selectedMode === 'task');
                            cell.textContent = displayValue;
                            cell.className = getHeatmapClass(value, selectedMode);
                            totalForDay += parseFloat(value) || 0;
                        } else {
                            cell.textContent = '';
                        }

                        row.appendChild(cell);
                    });

                    // Kolom total untuk hari ini
                    const totalCell = document.createElement('td');
                    totalCell.textContent = formatNumber(totalForDay, selectedMode === 'task') || '0';
                    totalCell.className = totalForDay > 0 ? getHeatmapClass(totalForDay, selectedMode) : '';

                    row.appendChild(totalCell);
                    tableBody.appendChild(row);
                }

                // Generate footer jika ada data
                if (yearData) {
                    // Row 1: Monthly totals
                    const totalRow = document.createElement('tr');
                    totalRow.className = 'fw-bold';

                    const totalLabelCell = document.createElement('td');
                    totalLabelCell.textContent = 'TOTAL';
                    totalRow.appendChild(totalLabelCell);

                    let grandTotal = 0;
                    monthTotals.forEach((total, index) => {
                        const cell = document.createElement('td');
                        const displayValue = formatNumber(total, selectedMode === 'task');
                        cell.textContent = displayValue || '0';
                        grandTotal += parseFloat(total) || 0;
                        console.log(`Month ${months[index]}: ${total} -> ${displayValue}`);
                        totalRow.appendChild(cell);
                    });

                    const grandTotalCell = document.createElement('td');
                    const displayGrandTotal = formatNumber(grandTotal, selectedMode === 'task');
                    grandTotalCell.textContent = displayGrandTotal || '0';
                    grandTotalCell.className = 'fw-bold';
                    totalRow.appendChild(grandTotalCell);

                    tableFooter.appendChild(totalRow);

                    // Row 2: Daily averages (only for HOURS mode)
                    if (selectedMode === 'hours' || selectedMode === 'task') {
                        const avgRow = document.createElement('tr');
                        avgRow.className = 'fw-bold';

                        const avgLabelCell = document.createElement('td');
                        avgLabelCell.textContent = 'DAILY AVERAGE';
                        avgRow.appendChild(avgLabelCell);

                        // Hitung working days per bulan
                        const workingDaysList = months.map((month, idx) => {
                            const totalDays = new Date(selectedYear, idx + 1, 0).getDate();
                            let working = 0;

                            for (let d = 1; d <= totalDays; d++) {
                                const date = new Date(selectedYear, idx, d);
                                const dayOfWeek = date.getDay();

                                const dateStr = `${selectedYear}-${String(idx + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

                                if (
                                    dayOfWeek !== 0 &&
                                    dayOfWeek !== 6 &&
                                    !holidays.includes(dateStr)
                                ) {
                                    working++;
                                }
                            }
                            return working;
                        });

                        // DAILY AVERAGE = TOTAL / WORKING DAYS
                        months.forEach((month, index) => {
                            const cell = document.createElement('td');
                            const working = workingDaysList[index];
                            const total = monthTotals[index];
                            const avg = working > 0 ? total / working : 0;

                            cell.textContent = formatNumber(
                                avg,
                                selectedMode === 'task'
                            ) || '0.0';

                            avgRow.appendChild(cell);
                        });

                        const yearlyAvgCell = document.createElement('td');
                        const totalWorkingDaysYear = workingDaysList.reduce((a, b) => a + b, 0);
                        const yearlyAvg = totalWorkingDaysYear > 0 ? (grandTotal / totalWorkingDaysYear) : 0;

                        yearlyAvgCell.textContent = formatNumber(
                            yearlyAvg,
                            selectedMode === 'task'
                        ) || '0.0';

                        avgRow.appendChild(yearlyAvgCell);
                        tableFooter.appendChild(avgRow);

                        // Row 3: Working Days (days in each month)
                        const workRow = document.createElement('tr');
                        workRow.className = 'fw-bold';

                        const workLabelCell = document.createElement('td');
                        workLabelCell.textContent = 'WORKING DAYS';
                        workRow.appendChild(workLabelCell);

                        months.forEach((month) => {
                            const monthIndex = months.indexOf(month); // 0–11
                            const totalDays = new Date(selectedYear, monthIndex + 1, 0).getDate();
                            let workingDays = 0;

                            for (let day = 1; day <= totalDays; day++) {
                                const date = new Date(selectedYear, monthIndex, day);
                                const dayOfWeek = date.getDay();

                                const dateStr = `${selectedYear}-${String(monthIndex + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                                if (
                                    dayOfWeek !== 0 &&
                                    dayOfWeek !== 6 &&
                                    !holidays.includes(dateStr)
                                ) {
                                    workingDays++;
                                }
                            }

                            const cell = document.createElement('td');
                            cell.textContent = workingDays;
                            workRow.appendChild(cell);
                        });

                        // Total working days in the year
                        let workingDaysYear = 0;
                        for (let month = 0; month < 12; month++) {
                            const totalDays = new Date(selectedYear, month + 1, 0).getDate();
                            for (let day = 1; day <= totalDays; day++) {
                                const date = new Date(selectedYear, month, day);
                                const dayOfWeek = date.getDay();
                                const dateStr = `${selectedYear}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                                if (
                                    dayOfWeek !== 0 &&
                                    dayOfWeek !== 6 &&
                                    !holidays.includes(dateStr)
                                ) {
                                    workingDaysYear++;
                                }
                            }
                        }

                        const workYearCell = document.createElement('td');
                        workYearCell.textContent = workingDaysYear;
                        workRow.appendChild(workYearCell);

                        tableFooter.appendChild(workRow);
                    }
                }

                console.log('=== UPDATE HEATMAP END ===');
            }

            function loadHeatmapData() {
                console.log('=== LOAD HEATMAP DATA START ===');

                const yearSelect = document.getElementById('yearFilter');
                const timeframeSelect = document.getElementById('timeframeFilter');
                const personSelect = document.getElementById('personFilter');

                const selectedYear = yearSelect.value;
                const selectedTimeframe = timeframeSelect.value;
                const selectedPerson = personSelect.value;

                console.log('Filters:', { selectedYear, selectedTimeframe, selectedPerson });

                // Tampilkan loading spinner
                document.getElementById('loadingSpinner').style.display = 'inline';

                let url = '/heatmap/data';
                const params = new URLSearchParams({
                    year: selectedYear,
                    timeframe: selectedTimeframe,
                    person: selectedPerson
                });

                const fullUrl = url + '?' + params.toString();
                console.log('Fetching from:', fullUrl);

                fetch(fullUrl)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('=== SERVER RESPONSE ===');
                        console.log('Success:', data.success);

                        if (data.success) {
                            heatmapData = data.data;
                            holidays = data.holidays || [];

                            // ========== UPDATE YEAR DROPDOWN ==========
                            const yearFilter = document.getElementById('yearFilter');
                            const currentYear = yearFilter.value;

                            if (data.yearRange) {
                                const minYear = data.yearRange.min;
                                const maxYear = data.yearRange.max;

                                yearFilter.innerHTML = '';

                                for (let year = minYear; year <= maxYear; year++) {
                                    const option = document.createElement('option');
                                    option.value = year;
                                    option.textContent = year;
                                    if (year == currentYear) {
                                        option.selected = true;
                                    }
                                    yearFilter.appendChild(option);
                                }

                                // Jika tahun yang dipilih sebelumnya tidak ada dalam range baru,
                                // pilih tahun terdekat yang valid
                                if (![...yearFilter.options].some(opt => opt.value == currentYear)) {
                                    // Pilih tahun maksimal jika tahun sebelumnya lebih besar
                                    if (currentYear > maxYear) {
                                        yearFilter.value = maxYear;
                                    } else if (currentYear < minYear) {
                                        yearFilter.value = minYear;
                                    }
                                }
                            }
                            
                            updateHeatmap();
                        } else {
                            console.error('Server error:', data.message);
                            alert('Failed to load heatmap data: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Failed to load heatmap data: ' + error.message);
                    })
                    .finally(() => {
                        document.getElementById('loadingSpinner').style.display = 'none';
                        console.log('=== LOAD HEATMAP DATA END ===');
                    });
            }

            // Inisialisasi saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function () {
                console.log('=== DOM CONTENT LOADED ===');

                // Set event listeners untuk semua filter
                const yearFilter = document.getElementById('yearFilter');
                const timeframeFilter = document.getElementById('timeframeFilter');
                const personFilter = document.getElementById('personFilter');
                const aggregateFilter = document.getElementById('aggregateFilter');

                // Tambahkan event listener untuk semua filter
                yearFilter.addEventListener('change', loadHeatmapData);
                timeframeFilter.addEventListener('change', loadHeatmapData);
                personFilter.addEventListener('change', loadHeatmapData);
                aggregateFilter.addEventListener('change', updateHeatmap);

                // Set tahun sekarang di select
                if (yearFilter.querySelector(`option[value="${currentYear}"]`)) {
                    yearFilter.value = currentYear;
                }

                // Update header tahun
                document.getElementById('currentYear').textContent = currentYear;

                // Load data awal
                console.log('Calling loadHeatmapData...');
                loadHeatmapData();
            });
        </script>