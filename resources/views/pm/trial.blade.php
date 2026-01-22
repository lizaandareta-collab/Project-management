<style>
    /* Select Process Area */
    .process-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn-process {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        transition: background-color .2s ease, color .2s ease, border-color .2s ease;
    }

    .btn-process:hover {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
    }

    .btn-process.btn-primary {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
    }

    /* Chart Styling */
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

    /* DataTables Custom */
    #trialDataTable_wrapper {
        margin-top: 10px;
    }

    .text-success-bold {
        color: #0fac81 !important;
        font-weight: 600 !important;
    }

    .text-danger-bold {
        color: #e85347 !important;
        font-weight: 600 !important;
    }

    /* DataTables length menu styling - POSISI KANAN */
    .dataTables_length {
        text-align: right !important;
    }

    .dataTables_length label {
        font-weight: normal;
        white-space: nowrap;
        margin-bottom: 0;
    }

    .dataTables_length select {
        width: 75px;
        display: inline-block;
        margin: 0 5px;
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    /* DataTables filter styling - POSISI KIRI */
    .dataTables_filter {
        text-align: left !important;
    }

    .dataTables_filter label {
        font-weight: normal;
        white-space: nowrap;
        margin-bottom: 0;
    }

    .dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
        width: 200px;
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    /* DataTables buttons styling - DI TENGAH */
    .dt-buttons {
        text-align: center !important;
        margin: 0 auto !important;
        display: flex !important;
        justify-content: center !important;
        gap: 5px;
    }

    .dt-buttons .btn {
        margin: 0 2px !important;
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
    }

    /* Pagination styling - DI KANAN */
    .dataTables_paginate {
        text-align: right !important;
        float: right !important;
    }

    .pagination {
        margin: 0 !important;
    }

    /* Info styling - DI KIRI */
    .dataTables_info {
        text-align: left !important;
        float: left !important;
        padding-top: 0.5em !important;
    }

    /* Layout untuk header DataTables */
    .dt-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .dt-search-col {
        flex: 1;
        min-width: 200px;
    }

    .dt-buttons-col {
        flex: 2;
        min-width: 300px;
        text-align: center;
    }

    .dt-length-col {
        flex: 1;
        min-width: 200px;
        text-align: right;
    }

    /* Layout untuk footer DataTables */
    .dt-footer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    /* GARIS PINGGIR SAJA – WARNA BAWAAN */
    #trialDataTable {
        border: 1px solid var(--bs-border-color);
    }

    /* Simple file upload styling */
    .file-list {
        margin-top: 10px;
    }

    .file-item {
        background: #f8f9fa;
        padding: 5px 10px;
        margin-bottom: 5px;
        border-radius: 4px;
        font-size: 14px;
    }

    /* Kurangi jarak bawah tabel */
    #trialTableCard {
        margin-bottom: 10px !important;
    }

    /* Hilangkan margin DataTables */
    #trialTableCard .dataTables_wrapper {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Rapikan jarak chart */
    #chartSection {
        margin-top: 10px !important;
    }

    /* Report Fresh Table Styling */
    #reportFreshTable {
        font-size: 14px;
    }

    #reportFreshTable th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    #reportFreshTable .category-row {
        background-color: #e9ecef;
    }

    #reportFreshTable td {
        vertical-align: middle;
    }

    /* Edit Cell Styling - HANYA untuk Quant */
    .edit-cell {
        cursor: pointer;
        position: relative;
        min-height: 40px;
    }

    .edit-cell:hover {
        background-color: #f8f9fa;
    }

    .edit-cell .edit-icon {
        display: none;
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .edit-cell:hover .edit-icon {
        display: block;
    }

    .percent-cell {
        cursor: default;
        position: relative;
        min-height: 40px;
    }

    .edit-input {
        width: 80px;
        padding: 2px 5px;
        border: 1px solid #dee2e6;
        border-radius: 3px;
        text-align: right;
    }
</style>

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title mb-0">
                                    Trial Record & Report -
                                    <span>{{ $project->project_name }}</span>
                                </h4>
                            </div>
                        </div>

                        <div class="card card-bordered mb-3">
                            <div class="card-inner">
                                <label class="form-label fw-bold mb-2">Select Process</label>
                                <div class="process-wrapper">
                                    <?php foreach ($process as $p) { ?>
                                    <button type="button" class="btn btn-outline-primary btn-process"
                                        data-process-id="<?= $p->lov_id ?>" data-process-name="<?= $p->description ?>">
                                        <?= $p->description ?>
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="card card-bordered card-preview d-none" id="trialTableCard">
                            <div class="card-inner">
                                <div class="nk-block-head mb-3">
                                    <div
                                        class="nk-block-head-content d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">%OK RATIO - <span id="selectedProcess"></span></h6>
                                        <button type="button" class="btn btn-primary d-none" id="btnAddTrial">
                                            <em class="icon ni ni-plus"></em> Add Trial
                                        </button>
                                    </div>
                                </div>

                                <!-- Tabel akan diinisialisasi via JS -->
                                <div class="table-responsive">
                                    <table class="table" id="trialDataTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Trial</th>
                                                <th>Casting (Status Trial)</th>
                                                <th>Machine</th>
                                                <th>Date</th>
                                                <th>Process (QTY)</th>
                                                <th>OK</th>
                                                <th>OK Ratio Target</th>
                                                <th>%</th>
                                                <th>CT Target</th>
                                                <th>CT</th>
                                                <th>Berat Target</th>
                                                <th>Berat</th>
                                                <th>PIC</th>
                                                <th>Files</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diisi via JS -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Report Fresh Section -->
                        <div class="card card-bordered card-preview d-none" id="reportFreshCard">
                            <div class="card-inner">
                                <div class="nk-block-head mb-3">
                                    <div class="nk-block-head-content">
                                        <h6 class="mb-0">Report - <span id="selectedProcessReport"></span></h6>
                                    </div>
                                </div>

                                <!-- Search -->
                                <div class="d-flex justify-content-between mb-3">
                                    <input type="text" id="reportFreshSearch" class="form-control form-control-sm w-25"
                                        placeholder="Search...">
                                </div>

                                <!-- Report Fresh Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered nowrap" id="reportFreshTable">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Category</th>
                                                <th>Report Fresh</th>
                                                <th>Quant.</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diisi via JS -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Grafik Section -->
                        <div class="row g-4 mb-4 d-none" id="chartSection">
                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">%OK RATIO</div>
                                        <div id="chart1" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">Cycle Time (CT)</div>
                                        <div id="chart2" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">Berat</div>
                                        <div id="chart3" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Trial -->
    <div class="modal fade" id="modalAddTrial" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formAddTrial" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="project_id" value="{{ request()->route('id') }}">
                <input type="hidden" name="process_id" id="process_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Trial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <!-- Row 1 -->
                        <div class="col-md-3">
                            <label class="form-label">Trial <span class="text-danger">*</span></label>
                            <input type="text" name="trial_no" id="trial_no" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Casting (Status Trial) <span class="text-danger">*</span></label>
                            <input type="text" name="trial_stat" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Machine <span class="text-danger">*</span></label>
                            <input type="text" name="trial_machine" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="trial_date" class="form-control" required>
                        </div>

                        <!-- Row 2 -->
                        <div class="col-md-3">
                            <label class="form-label">Process (QTY)</label>
                            <input type="number" name="actual" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">OK</label>
                            <input type="number" name="ok" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">OK Ratio Target</label>
                            <input type="text" id="target_view" class="form-control" readonly>
                            <input type="hidden" name="target" id="target_real">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">%</label>
                            <input type="number" step="0.01" name="perct" id="perct" class="form-control" readonly>
                        </div>

                        <!-- Row 3 -->
                        <div class="col-md-3">
                            <label class="form-label">CT Target</label>
                            <input type="number" name="ct_target" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CT</label>
                            <input type="number" name="ct" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Berat Target</label>
                            <input type="number" name="berat_target" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Berat</label>
                            <input type="number" step="0.01" name="berat" class="form-control">
                        </div>

                        <!-- Tambahkan hidden input untuk PIC -->
                        <input type="hidden" name="pic" id="pic"
                            value="{{ session('user.NAME') ?? session('user.name') ?? 'Guest' }}">

                        <!-- Row 5 - File Upload yang Sederhana -->
                        <div class="col-12">
                            <label class="form-label">Upload Files/Fotos <span class="text-danger">*</span></label>
                            <input type="file" name="picture[]" id="fileInput" class="form-control" multiple required>
                            <small class="text-muted">Pilih satu atau lebih file/foto (wajib)</small>
                            <div class="file-list mt-2" id="fileList"></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto" id="btnSubmit">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Detail - Sederhana seperti Add Trial -->
    <div class="modal fade" id="modalEditDetail" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form id="formEditDetail">
                @csrf
                <input type="hidden" name="project_id" value="{{ request()->route('id') }}">
                <input type="hidden" id="editProcessId" name="process_id">
                <input type="hidden" id="editTrialId" name="trial_id">
                <input type="hidden" id="editDefectId" name="defect_id">
                <input type="hidden" id="editTransType">
                <input type="hidden" id="editDefectName">
                <input type="hidden" id="editActualQty">
                <input type="hidden" id="editColumnName">
                <input type="hidden" id="editCurrentValue">
                <input type="hidden" id="editMaxValue">
                <input type="hidden" id="editTrialKey">
                
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <!-- Row 1 -->
                        <div class="col-md-6">
                            <label class="form-label">Trial</label>
                            <input type="text" id="editTrialInfoDisplay" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Defect</label>
                            <input type="text" id="editDefectNameDisplay" class="form-control" readonly>
                        </div>

                        <!-- Row 2 -->
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <input type="text" id="editTransTypeDisplay" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Process Qty</label>
                            <input type="text" id="editActualQtyDisplay" class="form-control" readonly>
                        </div>

                        <!-- Row 3 -->
                        <div class="col-md-6">
                            <label class="form-label">NG</label>
                            <div class="input-group">
                                <input type="number" 
                                       id="editNgValue" 
                                       name="ng" 
                                       class="form-control" 
                                       step="0.01"
                                       min="0"
                                       required
                                       autocomplete="off">
                                <span class="input-group-text">pcs</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">%</label>
                            <div class="input-group">
                                <input type="number" 
                                       id="editPerctValue" 
                                       name="perct" 
                                       class="form-control" 
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       readonly>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="col-md-6">
                            <label class="form-label">Current NG</label>
                            <input type="text" id="editCurrentNgDisplay" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max NG Allowed</label>
                            <input type="text" id="editMaxNgDisplay" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto" id="btnUpdateDetail">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Highcharts Libraries -->
<script src="{{ asset('assets/js/highcharts-chart.js') }}"></script>
<script src="{{ asset('assets/js/export-data-chart.js') }}"></script>
<script src="{{ asset('assets/js/accessibility-chart.js') }}"></script>
<script src="{{ asset('assets/js/adaptive-chart.js') }}"></script>

<script>
    let selectedProcessId = null;
    const projectId = "{{ request()->route('id') }}";
    let trialDataTable = null;
    let reportFreshData = null;

    /* ===============================
       INITIALIZE
    ================================ */
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener untuk file input
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = '';
                
                Array.from(this.files).forEach((file, index) => {
                    const div = document.createElement('div');
                    div.className = 'file-item';
                    div.innerHTML = `<span class="badge bg-primary me-2">${index + 1}</span> ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
                    fileList.appendChild(div);
                });
            });
        }

        // Pastikan semua button kembali ke state normal saat halaman dimuat
        document.querySelectorAll('.btn-process').forEach(btn => {
            btn.classList.remove('btn-primary');
        });

        // Tambahkan event listener ke semua button process
        document.querySelectorAll('.btn-process').forEach(btn => {
            btn.addEventListener('click', function () {
                // Reset semua button
                document.querySelectorAll('.btn-process')
                    .forEach(b => b.classList.remove('btn-primary'));

                // Set active button
                this.classList.add('btn-primary');

                selectedProcessId = this.dataset.processId;
                const processName = this.dataset.processName;

                document.getElementById('selectedProcess').innerText = ' ' + processName;
                document.getElementById('selectedProcessReport').innerText = ' ' + processName;
                document.getElementById('trialTableCard').classList.remove('d-none');
                document.getElementById('reportFreshCard').classList.remove('d-none');
                document.getElementById('btnAddTrial').classList.remove('d-none');
                document.getElementById('chartSection').classList.remove('d-none');

                // set hidden input (modal)
                const processInput = document.getElementById('process_id');
                if (processInput) {
                    processInput.value = selectedProcessId;
                }

                loadTrialData();
                loadReportFreshData();
            });
        });

        // Initialize auto calculate percent for Add Trial modal
        initAutoCalculatePercent();
        
        // Initialize auto calculate percent for Edit Detail modal
        initEditDetailAutoCalculate();
    });

    /* ===============================
       AUTO CALCULATE PERCENT FOR ADD TRIAL
    ================================ */
    function initAutoCalculatePercent() {
        const actualInput = document.querySelector('input[name="actual"]');
        const okInput = document.querySelector('input[name="ok"]');
        const perctInput = document.querySelector('input[name="perct"]');

        function calculatePercent() {
            const actual = parseFloat(actualInput.value);
            const ok = parseFloat(okInput.value);

            if (!isNaN(actual) && actual > 0 && !isNaN(ok)) {
                const percent = (ok / actual) * 100;
                perctInput.value = percent.toFixed(2);
            } else {
                perctInput.value = '';
            }
        }

        if (actualInput && okInput && perctInput) {
            actualInput.addEventListener('input', calculatePercent);
            okInput.addEventListener('input', calculatePercent);
        }
    }

    /* ===============================
       AUTO CALCULATE PERCENT FOR EDIT DETAIL
    ================================ */
    function initEditDetailAutoCalculate() {
        const editNgInput = document.getElementById('editNgValue');
        if (editNgInput) {
            editNgInput.addEventListener('input', function() {
                calculateEditDetailPercent();
            });
        }
    }

    function calculateEditDetailPercent() {
        const ngValue = parseFloat(document.getElementById('editNgValue').value);
        const actualQty = parseFloat(document.getElementById('editActualQty').value);
        const perctInput = document.getElementById('editPerctValue');

        if (!isNaN(ngValue) && !isNaN(actualQty) && actualQty > 0) {
            const percent = (ngValue / actualQty) * 100;
            perctInput.value = percent.toFixed(2);
        } else {
            perctInput.value = '';
        }
    }

    function formatModalTarget(val) {
        if (val === null || val === '' || isNaN(val)) return '';
        return parseFloat(val).toFixed(2).replace('.', ',');
    }

    /* ===============================
       LOAD TRIAL DATA
    ================================ */
    function loadTrialData() {
        if (!selectedProcessId) return;

        // Tampilkan loading
        const tableBody = document.querySelector('#trialDataTable tbody');
        tableBody.innerHTML = `
            <tr>
                <td colspan="14" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading data...</p>
                </td>
            </tr>
        `;

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
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                updateDataTable(data);
                renderCharts(data);
            })
            .catch(err => {
                console.error('Error loading trial data:', err);
                tableBody.innerHTML = `
                <tr>
                    <td colspan="14" class="text-center text-danger py-4">
                        Error loading data. Please try again.
                    </td>
                </tr>
            `;
            });
    }

    /* ===============================
       LOAD REPORT FRESH DATA
    ================================ */
    function loadReportFreshData() {
        if (!selectedProcessId) return;

        const tbody = document.querySelector('#reportFreshTable tbody');
        tbody.innerHTML = `<tr><td colspan="20" class="text-center text-muted">Loading...</td></tr>`;

        fetch("{{ route('trial.report_multi') }}", {
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
                reportFreshData = data;
                renderReportFreshTable(data);
                initReportFreshSearch();
            })
            .catch(err => {
                console.error('Error loading report fresh data:', err);
                tbody.innerHTML = `<tr><td colspan="20" class="text-center text-danger">Error loading report</td></tr>`;
            });
    }

    /* ===============================
       RENDER REPORT FRESH TABLE
    ================================ */
    function renderReportFreshTable(data) {
        const table = document.querySelector('#reportFreshTable');
        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';

        if (!data || !data.columns || data.columns.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="20" class="text-center text-muted">No data</td>
            </tr>`;
            return;
        }

        const columns = data.columns;
        const rows = data.data || {};
        const categories = data.categories || [];
        const trials = data.trials || {};

        /* ===== HEADER ===== */
        table.querySelector('thead').outerHTML = `
        <thead class="text-center">
            <tr>
                <th rowspan="2">Category</th>
                <th rowspan="2">Report Fresh</th>
                ${columns.map(c => `<th colspan="2">${c}</th>`).join('')}
            </tr>
            <tr>
                ${columns.map(() => `<th>Quant.</th><th>%</th>`).join('')}
            </tr>
        </thead>
    `;

        let html = '';

        /* ======================
           OK ROW (NON EDITABLE)
        ====================== */
        html += `
        <tr class="fw-bold ok-row">
            <td></td>
            <td class="fw-bold">OK</td>
            ${columns.map(col => {
            const item = rows.OK?.OK?.[col] ?? { quant: 0, percent: 0 };
            const target = data.targets?.[col] ?? 0;
            const cls = item.percent >= target
                ? 'text-success-bold'
                : 'text-danger-bold';
            return `
                    <td class="text-end fw-bold">${item.quant}</td>
                    <td class="text-end fw-bold ${cls}">
                        ${Number(item.percent).toFixed(2)}%
                    </td>
                `;
        }).join('')}
        </tr>
    `;

        /* ======================
           CATEGORY (TRANS_TYPE)
        ====================== */
        categories.forEach(category => {
            const defects = rows[category] || {};
            const defectKeys = Object.keys(defects);
            const rowspan = defectKeys.length;

            defectKeys.forEach((defect, i) => {
                const defectData = defects[defect];
                
                html += `
                <tr class="${i === 0 ? 'after-ok' : ''}">
                    ${i === 0 ? `
                        <td rowspan="${rowspan}" class="text-center align-middle fw-bold">
                            ${category}
                        </td>` : ``}
                    <td>${defect}</td>
                    ${columns.map(col => {
                    const item = defectData?.[col] ?? { quant: 0, percent: 0 };
                    const trialInfo = trials[col];
                    const trialId = trialInfo?.id;
                    const defectId = trialInfo?.defectIds?.[defect];
                    const actualQty = item.actual || 0;
                    const maxQuant = actualQty - (item.quant || 0);
                    
                    // HANYA Quant yang bisa diedit (ada icon)
                    return `
                            <td class="text-end edit-cell"
                                data-trial-id="${trialId}"
                                data-defect-id="${defectId}"
                                data-trans-type="${category}"
                                data-defect-name="${defect}"
                                data-column-name="quant"
                                data-current-value="${item.quant}"
                                data-max-value="${maxQuant}"
                                data-trial-key="${col}"
                                data-actual="${actualQty}"
                                data-current-percent="${item.percent}">
                                ${item.quant}
                                <em class="icon ni ni-edit edit-icon"></em>
                            </td>
                            <td class="text-end percent-cell">
                                ${Number(item.percent).toFixed(2)}%
                            </td>
                        `;
                }).join('')}
                </tr>
            `;
            });
        });

        /* ======================
           JUMLAH
        ====================== */
        html += `
        <tr class="fw-bold border-top jumlah-row">
            <td colspan="2" class="fw-bold">Jumlah</td>
            ${columns.map(col => {
            const item = rows.Jumlah?.Jumlah?.[col] ?? { quant: 0, percent: 100 };
            return `
                    <td class="text-end fw-bold">${item.quant}</td>
                    <td class="text-end fw-bold">${Number(item.percent).toFixed(2)}%</td>
                `;
        }).join('')}
        </tr>
    `;

        tbody.innerHTML = html;
        
        // Initialize edit functionality - HANYA untuk sel Quant
        initReportFreshEdit();
    }

    /* ===============================
       INITIALIZE REPORT FRESH EDIT
       HANYA untuk sel Quant (td pertama)
    ================================ */
    function initReportFreshEdit() {
        // Event delegation untuk klik sel Quant SAJA
        document.querySelector('#reportFreshTable tbody').addEventListener('click', function(e) {
            const target = e.target;
            
            // Jika yang diklik adalah icon edit
            if (target.classList.contains('edit-icon') || target.closest('.edit-icon')) {
                const cell = target.closest('td');
                // Hanya cell dengan class edit-cell (Quant) yang bisa diedit
                if (cell && cell.classList.contains('edit-cell')) {
                    openEditModal(cell);
                }
            }
        });
    }

    /* ===============================
       OPEN EDIT MODAL
    ================================ */
    function openEditModal(cell) {
        // Ambil data dari atribut data-*
        const trialId = cell.dataset.trialId;
        const defectId = cell.dataset.defectId;
        const transType = cell.dataset.transType;
        const defectName = cell.dataset.defectName;
        const currentValue = cell.dataset.currentValue || '0';
        const currentPercent = cell.dataset.currentPercent || '0';
        const maxValue = cell.dataset.maxValue || '100';
        const trialKey = cell.dataset.trialKey;
        const actualQty = cell.dataset.actual || '0';
        
        // Validasi data
        if (!trialId || !defectId) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Cannot edit this cell. Data incomplete.'
            });
            return;
        }
        
        // Isi modal fields
        document.getElementById('editProcessId').value = selectedProcessId;
        document.getElementById('editTrialId').value = trialId;
        document.getElementById('editDefectId').value = defectId;
        document.getElementById('editTransType').value = transType;
        document.getElementById('editDefectName').value = defectName;
        document.getElementById('editActualQty').value = actualQty;
        document.getElementById('editCurrentValue').value = currentValue;
        document.getElementById('editMaxValue').value = maxValue;
        document.getElementById('editTrialKey').value = trialKey;
        
        // Set display values
        document.getElementById('editTrialInfoDisplay').value = trialKey;
        document.getElementById('editDefectNameDisplay').value = defectName;
        document.getElementById('editTransTypeDisplay').value = transType;
        document.getElementById('editActualQtyDisplay').value = actualQty;
        
        // Set current values
        document.getElementById('editCurrentNgDisplay').value = currentValue + ' pcs';
        document.getElementById('editMaxNgDisplay').value = maxValue + ' pcs';
        
        // Set input values
        document.getElementById('editNgValue').value = currentValue;
        document.getElementById('editPerctValue').value = currentPercent;
        
        // Calculate initial percentage
        calculateEditDetailPercent();
        
        // Set max untuk NG input
        document.getElementById('editNgValue').max = maxValue;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('modalEditDetail')).show();
        
        // Focus pada NG input field
        setTimeout(() => {
            document.getElementById('editNgValue').focus();
            document.getElementById('editNgValue').select();
        }, 500);
    }

    /* ===============================
       UPDATE REPORT FRESH DATA
    ================================ */
    document.getElementById('formEditDetail').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const ngValue = parseFloat(document.getElementById('editNgValue').value);
        const perctValue = parseFloat(document.getElementById('editPerctValue').value);
        const maxValue = parseFloat(document.getElementById('editMaxValue').value);
        
        // Validasi
        if (isNaN(ngValue) || ngValue < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Value',
                text: 'Please enter a valid positive number for NG'
            });
            return;
        }
        
        if (ngValue > maxValue) {
            Swal.fire({
                icon: 'warning',
                title: 'Value Exceeds Limit',
                text: `Maximum allowed NG value is ${maxValue} pcs`
            });
            return;
        }
        
        // Validasi percentage calculation
        const actualQty = parseFloat(document.getElementById('editActualQty').value);
        if (actualQty > 0) {
            const calculatedPercent = (ngValue / actualQty) * 100;
            if (Math.abs(calculatedPercent - perctValue) > 0.01) {
                Swal.fire({
                    icon: 'error',
                    title: 'Calculation Error',
                    text: 'Percentage calculation mismatch. Please check the values.'
                });
                return;
            }
        }
        
        const formData = {
            project_id: projectId,
            process_id: selectedProcessId,
            trial_id: document.getElementById('editTrialId').value,
            defect_id: document.getElementById('editDefectId').value,
            ng: ngValue,
            perct: perctValue
        };
        
        const submitBtn = document.getElementById('btnUpdateDetail');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        
        fetch("{{ route('trial.update.detail') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('modalEditDetail')).hide();
                
                // Reload data
                loadReportFreshData();
                loadTrialData(); // Reload juga trial data untuk sinkronisasi
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message || 'Data updated successfully',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                throw new Error(data.message || 'Failed to update data');
            }
        })
        .catch(err => {
            console.error('Update error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: err.message || 'Failed to update data. Please try again.'
            });
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Save';
        });
    });

    /* ===============================
       INITIALIZE REPORT FRESH SEARCH
    ================================ */
    function initReportFreshSearch() {
        const searchInput = document.getElementById('reportFreshSearch');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase();
                const rows = document.querySelectorAll('#reportFreshTable tbody tr');

                let categoryHasMatch = {};

                // reset
                rows.forEach(row => row.style.display = 'none');

                // filter rows
                rows.forEach(row => {
                    const category = row.dataset.category;
                    const cells = row.querySelectorAll('td');

                    if (cells.length < 3) return;

                    const searchableText = (
                        cells[cells.length - 3].innerText + ' ' +
                        cells[cells.length - 2].innerText + ' ' +
                        cells[cells.length - 1].innerText
                    ).toLowerCase();

                    if (searchableText.includes(keyword) || keyword === '') {
                        row.style.display = '';
                        categoryHasMatch[category] = true;
                    }
                });

                // show category header if any child visible
                rows.forEach(row => {
                    if (row.classList.contains('category-row')) {
                        const category = row.dataset.category;
                        if (categoryHasMatch[category]) {
                            row.style.display = '';
                        }
                    }
                });
            });
        }
    }

    /* ===============================
       UPDATE DATATABLE
    ================================ */
    function updateDataTable(data) {
        // Jika DataTable sudah ada, hancurkan dulu
        if ($.fn.DataTable.isDataTable('#trialDataTable')) {
            trialDataTable.destroy();
            trialDataTable = null;
        }

        const tableBody = document.querySelector('#trialDataTable tbody');

        if (!data || data.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="14" class="text-center text-muted py-4">
                        No trial data available
                    </td>
                </tr>
            `;

            // Inisialisasi DataTable kosong
            initDataTable([]);
            return;
        }

        // Isi tabel dengan data
        let html = '';
        data.forEach(row => {
            const perctVal = parseFloat(row.perct) || 0;
            const targetVal = parseFloat(row.target) || 0;
            const ctVal = parseFloat(row.ct) || 0;
            const ctTargetVal = parseFloat(row.ct_target) || 0;
            const beratVal = parseFloat(row.berat) || 0;
            const beratTargetVal = parseFloat(row.berat_target) || 0;

            // Tentukan class untuk warna
            const perctClass = !isNaN(perctVal) && !isNaN(targetVal) && perctVal >= targetVal
                ? 'text-success-bold'
                : 'text-danger-bold';

            const ctClass = !isNaN(ctVal) && !isNaN(ctTargetVal) && ctVal < ctTargetVal
                ? 'text-success-bold'
                : 'text-danger-bold';

            const beratClass = !isNaN(beratVal) && !isNaN(beratTargetVal) && beratVal < beratTargetVal
                ? 'text-success-bold'
                : 'text-danger-bold';

            let filesHtml = '-';

            if (row.files && row.files.length > 0) {
                filesHtml = row.files.map(f => `
                <a href="${f.url}" target="_blank" class="d-block text-primary">
                     ${f.name}
                </a>
            `).join('');
            }

            html += `
<tr>
    <td>${row.trial_no || ''}</td>
    <td>${row.trial_stat || ''}</td>
    <td>${row.trial_machine || ''}</td>
    <td>${row.trial_date ? row.trial_date.split(' ')[0] : ''}</td>
    <td>${row.actual || ''}</td>
    <td>${row.ok || ''}</td>
    <td>${targetVal.toFixed(2)}%</td>
    <td class="${perctClass}">${perctVal.toFixed(2)}%</td>
    <td>${row.ct_target || ''}</td>
    <td class="${ctClass}">${row.ct || ''}</td>
    <td>${row.berat_target || ''}</td>
    <td class="${beratClass}">${beratVal.toFixed(1)}</td>
    <td>${row.pic || ''}</td>
    <td>${filesHtml}</td>
</tr>
`;
        });

        tableBody.innerHTML = html;

        // Inisialisasi DataTable dengan data
        initDataTable(data);
    }

    /* ===============================
       INITIALIZE DATATABLE
    ================================ */
    function initDataTable(data) {
        trialDataTable = $('#trialDataTable').DataTable({
            data: data,
            columns: [
                { data: 'trial_no' },
                { data: 'trial_stat' },
                { data: 'trial_machine' },
                {
                    data: 'trial_date',
                    render: function (data) {
                        return data ? data.split(' ')[0] : '';
                    }
                },
                { data: 'actual' },
                { data: 'ok' },
                {
                    data: 'target',
                    render: function (data) {
                        const val = parseFloat(data) || 0;
                        return val.toFixed(2) + '%';
                    }
                },
                {
                    data: 'perct',
                    render: function (data, type, row) {
                        const perctVal = parseFloat(data) || 0;
                        const targetVal = parseFloat(row.target) || 0;
                        const className = perctVal >= targetVal ? 'text-success-bold' : 'text-danger-bold';
                        return `<span class="${className}">${perctVal.toFixed(2)}%</span>`;
                    }
                },
                { data: 'ct_target' },
                {
                    data: 'ct',
                    render: function (data, type, row) {
                        const ctVal = parseFloat(data) || 0;
                        const ctTargetVal = parseFloat(row.ct_target) || 0;
                        const className = ctVal < ctTargetVal ? 'text-success-bold' : 'text-danger-bold';
                        return `<span class="${className}">${data}</span>`;
                    }
                },
                { data: 'berat_target' },
                {
                    data: 'berat',
                    render: function (data, type, row) {
                        const beratVal = parseFloat(data) || 0;
                        const beratTargetVal = parseFloat(row.berat_target) || 0;
                        const className = beratVal < beratTargetVal ? 'text-success-bold' : 'text-danger-bold';
                        return `<span class="${className}">${beratVal.toFixed(1)}</span>`;
                    }
                },
                { data: 'pic' },
                {
                    data: 'files',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        if (!data || data.length === 0) return '-';

                        return data.map(f => `
            <a href="${f.url}" target="_blank" class="d-block text-primary">
                ${f.name}
            </a>
        `).join('');
                    }
                },
            ],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            responsive: true,
            // DOM LAYOUT: Buttons atas tengah, Search kiri, Show kanan
            dom: '<"dt-header-row"<"dt-search-col"f><"dt-buttons-col"B><"dt-length-col"l>>rt<"dt-footer-row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="icon ni ni-copy"></i> Copy',
                    className: 'btn btn-outline-secondary btn-sm',
                    title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim()
                },
                {
                    extend: 'excel',
                    text: '<i class="icon ni ni-file-xls"></i> Excel',
                    className: 'btn btn-outline-success btn-sm',
                    title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim()
                },
                {
                    extend: 'pdf',
                    text: '<i class="icon ni ni-file-pdf"></i> PDF',
                    className: 'btn btn-outline-danger btn-sm',
                    title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim()
                },
                {
                    extend: 'print',
                    text: '<i class="icon ni ni-printer"></i> Print',
                    className: 'btn btn-outline-primary btn-sm',
                    title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim(),
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '10pt')
                            .prepend(
                                '<h3>Trial Report - ' + document.getElementById('selectedProcess').innerText.trim() + '</h3>'
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                zeroRecords: "No matching records found",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Prev"
                }
            },
            initComplete: function () {
                // Custom layout styling
                $('.dt-header-row').css({
                    'display': 'flex',
                    'justify-content': 'space-between',
                    'align-items': 'center',
                    'margin-bottom': '10px',
                    'flex-wrap': 'wrap'
                });

                $('.dt-search-col').css({
                    'flex': '1',
                    'min-width': '200px',
                    'text-align': 'left'
                });

                $('.dt-buttons-col').css({
                    'flex': '2',
                    'min-width': '300px',
                    'text-align': 'center',
                    'display': 'flex',
                    'justify-content': 'center',
                    'gap': '5px'
                });

                $('.dt-length-col').css({
                    'flex': '1',
                    'min-width': '200px',
                    'text-align': 'right'
                });

                $('.dt-footer-row').css({
                    'display': 'flex',
                    'justify-content': 'space-between',
                    'align-items': 'center',
                    'margin-top': '10px'
                });
            },
            drawCallback: function () {
                // Pastikan footer layout tetap
                $('.dataTables_info').css({
                    'text-align': 'left',
                    'float': 'left',
                    'padding-top': '0.5em'
                });

                $('.dataTables_paginate').css({
                    'text-align': 'right',
                    'float': 'right'
                });
            }
        });
    }

    /* ===============================
       RENDER CHARTS
    ================================ */
    function renderCharts(data) {
        if (!data || data.length === 0) {
            document.getElementById('chart1').innerHTML = '<div class="text-center text-muted p-5">No data available</div>';
            document.getElementById('chart2').innerHTML = '<div class="text-center text-muted p-5">No data available</div>';
            document.getElementById('chart3').innerHTML = '<div class="text-center text-muted p-5">No data available</div>';
            return;
        }

        // Sort data by trial_no
        const sortedData = [...data].sort((a, b) => {
            return (a.trial_no || '').localeCompare(b.trial_no || '');
        });

        const trialNos = sortedData.map(item => item.trial_no || '');

        // Grafik 1: %OK RATIO
        const perctData = sortedData.map(item => parseFloat(item.perct) || 0);
        const targetData = sortedData.map(item => parseFloat(item.target) || 0);

        Highcharts.chart('chart1', {
            chart: {
                type: 'column',
                height: 380
            },
            title: {
                text: '%OK RATIO',
                align: 'center'
            },
            subtitle: {
                text: document.getElementById('selectedProcess').innerText,
                align: 'center'
            },
            xAxis: {
                categories: trialNos,
                crosshair: true
            },
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Percentage (%)'
                },
                labels: {
                    formatter: function () {
                        return this.value
                            .toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + '%';
                    }
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

        // Grafik 2: CT
        const ctData = sortedData.map(item => parseFloat(item.ct) || 0);
        const ctTargetData = sortedData.map(item => parseFloat(item.ct_target) || 0);

        Highcharts.chart('chart2', {
            chart: {
                type: 'column',
                height: 380
            },
            title: {
                text: 'Cycle Time (CT)',
                align: 'center'
            },
            subtitle: {
                text: document.getElementById('selectedProcess').innerText,
                align: 'center'
            },
            xAxis: {
                categories: trialNos,
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

        Highcharts.chart('chart3', {
            chart: {
                type: 'column',
                height: 380
            },
            title: {
                text: 'Berat',
                align: 'center'
            },
            subtitle: {
                text: document.getElementById('selectedProcess').innerText,
                align: 'center'
            },
            xAxis: {
                categories: trialNos,
                crosshair: true
            },
            yAxis: {
                title: {
                    text: 'Berat'
                },
                labels: {
                    formatter: function () {
                        return this.value.toLocaleString('id-ID', {
                            minimumFractionDigits: 1,
                            maximumFractionDigits: 1
                        });
                    }
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

    /* ===============================
       LOAD STANDARD TARGET
    ================================ */
    function loadStandardTarget() {
        fetch("{{ route('trial.standard') }}", {
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
                document.getElementById('target_view').value = formatModalTarget(data.target);
                document.getElementById('target_real').value = parseFloat(data.target).toFixed(2);
                document.querySelector('input[name="ct_target"]').value = data.ct_target || '';
                document.querySelector('input[name="berat_target"]').value = data.berat_target || '';
            })
            .catch(err => console.error('Error loading standard target:', err));
    }

    function loadNextTrialNo() {
        fetch("{{ route('trial.next_no') }}", {
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
                document.getElementById('trial_no').value = data.trial_no;
            })
            .catch(err => {
                console.error('Error loading next trial no:', err);
                document.getElementById('trial_no').value = '';
            });
    }

    /* ===============================
       ADD TRIAL BUTTON
    ================================ */
    document.getElementById('btnAddTrial').addEventListener('click', function () {
        if (!selectedProcessId) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select a process first'
            });
            return;
        }

        // Reset form dan files
        document.getElementById('formAddTrial').reset();
        document.getElementById('fileList').innerHTML = '';
        document.getElementById('fileInput').value = '';

        // Set PIC dari session (jika ada input hidden)
        const picInput = document.getElementById('pic');
        if (picInput) {
            picInput.value = "{{ session('user.NAME') ?? session('user.name') ?? 'Guest' }}";
        }

        loadStandardTarget();
        loadNextTrialNo();
        new bootstrap.Modal(document.getElementById('modalAddTrial')).show();
    });

    /* ===============================
       SUBMIT ADD TRIAL
    ================================ */
    document.getElementById('formAddTrial').addEventListener('submit', function (e) {
        e.preventDefault();

        // Disable submit button
        const submitBtn = document.getElementById('btnSubmit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

        // Buat FormData
        const formData = new FormData(this);

        fetch("{{ route('trial.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            }
        })
            .then(async res => {
                const contentType = res.headers.get("content-type");

                // Cek jika response adalah HTML (error)
                if (contentType && contentType.indexOf("text/html") !== -1) {
                    const htmlText = await res.text();
                    throw new Error('Server returned HTML instead of JSON');
                }

                return res.json();
            })
            .then(res => {
                if (res.status) {
                    // Success
                    loadTrialData();
                    loadReportFreshData();
                    bootstrap.Modal.getInstance(document.getElementById('modalAddTrial')).hide();
                    this.reset();
                    document.getElementById('fileList').innerHTML = '';

                    // Show success message menggunakan SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Trial data saved successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    // Server returned error
                    throw new Error(res.message || 'Failed to save trial');
                }
            })
            .catch(err => {
                console.error('Error adding trial:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + err.message
                });
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save';
            });
    });
</script>