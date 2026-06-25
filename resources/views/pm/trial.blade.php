<!-- Highcharts Libraries -->
<script src="{{ asset('assets/js/highcharts-chart.js') }}"></script>
<script src="{{ asset('assets/js/export-data-chart.js') }}"></script>
<script src="{{ asset('assets/js/accessibility-chart.js') }}"></script>
<script src="{{ asset('assets/js/adaptive-chart.js') }}"></script>

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

    .dataTables_paginate {
        text-align: right !important;
        float: right !important;
    }

    .pagination {
        margin: 0 !important;
    }

    .dataTables_info {
        text-align: left !important;
        float: left !important;
        padding-top: 0.5em !important;
    }

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

    .dt-footer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    #trialDataTable {
        border: 1px solid var(--bs-border-color);
    }

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

    #trialTableCard {
        margin-bottom: 10px !important;
    }

    #trialTableCard .dataTables_wrapper {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    #chartSection {
        margin-top: 10px !important;
    }

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

    .ng-input {
        width: 80px;
        padding: 2px 5px;
        border: 1px solid #dee2e6;
        border-radius: 3px;
        text-align: right;
        font-size: 14px;
        display: block;
        margin: 0 auto;
    }

    .ng-input:focus {
        outline: none;
        border-color: #0fac81;
        box-shadow: 0 0 0 2px rgba(15, 172, 129, 0.1);
    }

    .ng-input.error {
        border-color: #e85347;
        background-color: #fff5f5;
    }

    .warning-message {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 10px 15px;
        border-radius: 4px;
        margin-bottom: 15px;
        display: none;
    }

    .warning-message.show {
        display: block;
    }

    #fileList {
        display: none !important;
    }

    .locked-value {
        text-align: right !important;
        font-weight: normal !important;
        color: #212529 !important;
    }

    #btnSaveData {
        display: none;
        padding: 6px 16px;
        font-size: 14px;
    }

    #btnSaveData.show {
        display: inline-block;
    }

    #lockedMessage {
        display: none;
        margin-bottom: 15px;
        padding: 10px 15px;
    }

    #lockedMessage.show {
        display: block;
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
                                    <span>{{ $project->PROJECT_NAME ?? 'Unknown Project' }}</span>
                                </h4>
                            </div>
                        </div>

                        <div class="card card-bordered mb-3">
                            <div class="card-inner">
                                <label class="form-label fw-bold mb-2">Select Process</label>
                                <div class="process-wrapper">
                                    <?php foreach ($process as $p) { ?>
                                    <button type="button" class="btn btn-outline-primary btn-process"
                                        data-process-id="<?= $p->LOV_ID ?>" data-process-name="<?= $p->DESCRIPTION ?>">
                                        <?= $p->DESCRIPTION ?>
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="card card-bordered card-preview d-none" id="trialTableCard">
                            <div class="card-inner">
                                <div class="nk-block-head mb-3">
                                    <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">%OK RATIO - <span id="selectedProcess"></span></h6>
                                        @if(in_array(session('role_name'), ['PM', 'PE']))
                                        <button type="button" class="btn btn-primary d-none" id="btnAddTrial">
                                            <em class="icon ni ni-plus"></em> Add Trial
                                        </button>
                                        @else
                                        {{-- QA: tombol tidak dirender sama sekali --}}
                                        <span id="btnAddTrial" style="display:none;"></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table" id="trialDataTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Trial</th>
                                                <th id="tableProcessHeader">Casting</th>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Report Fresh Section -->
                        <div class="card card-bordered card-preview d-none" id="reportFreshCard">
                            <div class="card-inner">
                                <div class="nk-block-head mb-3">
                                    <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Report - <span id="selectedProcessReport"></span></h6>
                                        <button type="button" class="btn btn-warning btn-sm d-none" id="btnSaveData">
                                            <em class="icon ni ni-save"></em> Save Data
                                        </button>
                                    </div>
                                </div>

                                <div class="warning-message" id="warningMessage">
                                    <strong>Note:</strong> Total NG + OK cannot exceed 100%. Please adjust your input.
                                </div>

                                <div class="alert alert-success d-none" id="lockedMessage">
                                    <em class="icon ni ni-lock"></em> Data has been Save. Total has reached 100.00%
                                </div>

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
                                        <div class="chart-title">Cycle Time (Second)</div>
                                        <div id="chart2" class="chart-wrapper"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="chart-title">Berat(Kg)</div>
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

    <!-- Modal Add Trial — hanya dirender untuk PM dan PE -->
    @if(in_array(session('role_name'), ['PM', 'PE']))
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
                        <div class="col-md-3">
                            <label class="form-label">Trial <span class="text-danger">*</span></label>
                            <input type="text" name="trial_no" id="trial_no" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" id="trialStatLabel">Casting <span class="text-danger">*</span></label>
                            <input type="text" name="trial_stat" id="trial_stat_input" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Machine <span class="text-danger">*</span></label>
                            <input type="text" name="trial_machine" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="trial_date" class="form-control" required>
                        </div>

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

                        <input type="hidden" name="pic" id="pic"
                            value="{{ session('user.NAME') ?? session('user.name') ?? 'Guest' }}">

                        <div class="col-12">
                            <label class="form-label">Upload Files/Fotos <span class="text-danger">*</span></label>
                            <input type="file" name="picture[]" id="fileInput" class="form-control" multiple required>
                            <small class="text-muted">Pilih satu atau lebih file/foto (wajib)</small>
                            <div class="file-list mt-2" id="fileList"></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-auto" id="btnSubmit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

<script>
    // Variabel role dari session
    const canEditTrial = {{ in_array(session('role_name'), ['PM', 'PE']) ? 'true' : 'false' }};

    let selectedProcessId = null;
    const projectId = "{{ request()->route('id') }}";
    let trialDataTable = null;
    let reportFreshData = null;
    let lastTrialInfo = null;
    let saveTimeout = null;
    let isDataLocked = false;

    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = '';
            });
        }

        document.querySelectorAll('.btn-process').forEach(btn => {
            btn.classList.remove('btn-primary');
        });

        document.querySelectorAll('.btn-process').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.btn-process')
                    .forEach(b => b.classList.remove('btn-primary'));

                this.classList.add('btn-primary');

                selectedProcessId = this.dataset.processId;
                const processName = this.dataset.processName;

                document.getElementById('selectedProcess').innerText = ' ' + processName;
                document.getElementById('selectedProcessReport').innerText = ' ' + processName;

                document.getElementById('trialStatLabel') &&
                    (document.getElementById('trialStatLabel').innerHTML =
                        `${processName} <span class="text-danger">*</span>`);

                document.getElementById('tableProcessHeader').innerText = `${processName}`;

                const dataTableTitle = `Trial Report - ${processName}`;

                document.getElementById('trialTableCard').classList.remove('d-none');
                document.getElementById('reportFreshCard').classList.remove('d-none');

                // Tombol Add Trial hanya tampil untuk PM dan PE
                if (canEditTrial) {
                    document.getElementById('btnAddTrial').classList.remove('d-none');
                }

                document.getElementById('chartSection').classList.remove('d-none');

                const processInput = document.getElementById('process_id');
                if (processInput) {
                    processInput.value = selectedProcessId;
                }

                loadTrialData();
                loadReportFreshData();

                if (trialDataTable) {
                    trialDataTable.buttons().destroy();
                    trialDataTable.buttons([
                        {
                            extend: 'copy',
                            text: '<i class="icon ni ni-copy"></i> Copy',
                            className: 'btn btn-outline-secondary btn-sm',
                            title: dataTableTitle
                        },
                        {
                            extend: 'excel',
                            text: '<i class="icon ni ni-file-xls"></i> Excel',
                            className: 'btn btn-outline-success btn-sm',
                            title: dataTableTitle
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="icon ni ni-file-pdf"></i> PDF',
                            className: 'btn btn-outline-danger btn-sm',
                            title: dataTableTitle
                        },
                        {
                            extend: 'print',
                            text: '<i class="icon ni ni-printer"></i> Print',
                            className: 'btn btn-outline-primary btn-sm',
                            title: dataTableTitle,
                            customize: function (win) {
                                $(win.document.body)
                                    .css('font-size', '10pt')
                                    .prepend(`<h3>${dataTableTitle}</h3>`);
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        }
                    ]).container().appendTo($('.dt-buttons-col'));
                }
            });
        });

        initAutoCalculatePercent();

        // Event listener Add Trial hanya untuk PM dan PE
        if (canEditTrial) {
            const btnAddTrial = document.getElementById('btnAddTrial');
            if (btnAddTrial) {
                btnAddTrial.addEventListener('click', function () {
                    if (!selectedProcessId) {
                        Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select a process first' });
                        return;
                    }

                    document.getElementById('formAddTrial').reset();
                    document.getElementById('fileList').innerHTML = '';
                    document.getElementById('fileInput').value = '';

                    const picInput = document.getElementById('pic');
                    if (picInput) {
                        picInput.value = "{{ session('user.NAME') ?? session('user.name') ?? 'Guest' }}";
                    }

                    loadStandardTarget();
                    loadNextTrialNo();
                    new bootstrap.Modal(document.getElementById('modalAddTrial')).show();
                });
            }

            const formAddTrial = document.getElementById('formAddTrial');
            if (formAddTrial) {
                formAddTrial.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('btnSubmit');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

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
                            if (contentType && contentType.indexOf("text/html") !== -1) {
                                throw new Error('Server returned HTML instead of JSON');
                            }
                            return res.json();
                        })
                        .then(res => {
                            if (res.status) {
                                loadTrialData();
                                loadReportFreshData();
                                bootstrap.Modal.getInstance(document.getElementById('modalAddTrial')).hide();
                                this.reset();
                                document.getElementById('fileList').innerHTML = '';
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Trial data saved successfully!',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                throw new Error(res.message || 'Failed to save trial');
                            }
                        })
                        .catch(err => {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Error: ' + err.message });
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Save';
                        });
                });
            }
        }
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
       LOAD TRIAL DATA
    ================================ */
    function loadTrialData() {
        if (!selectedProcessId) return;

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
                if (!res.ok) throw new Error('Network response was not ok');
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
                lastTrialInfo = getLastTrial(data.trials || {});
                renderReportFreshTable(data);
            })
            .catch(err => {
                console.error('Error loading report fresh data:', err);
                tbody.innerHTML = `<tr><td colspan="20" class="text-center text-danger">Error loading report</td></tr>`;

                const btnAddTrial = document.getElementById('btnAddTrial');
                if (btnAddTrial && canEditTrial) {
                    btnAddTrial.disabled = false;
                    btnAddTrial.classList.remove('btn-disabled');
                }
            });
    }

    /* ===============================
       RENDER REPORT FRESH TABLE
    ================================ */
    function renderReportFreshTable(data) {
        const table = document.querySelector('#reportFreshTable');
        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';

        const btnAddTrial = document.getElementById('btnAddTrial');

        if (canEditTrial && btnAddTrial) {
            btnAddTrial.disabled = false;
        }

        if (
            !data ||
            !data.columns ||
            data.columns.length === 0 ||
            !data.data ||
            Object.keys(data.data).length === 0
        ) {
            const thead = table.querySelector('thead');
            if (thead) thead.innerHTML = '';
            tbody.innerHTML = `<tr><td colspan="20" class="text-center text-muted">No data</td></tr>`;

            if (canEditTrial && btnAddTrial) {
                btnAddTrial.disabled = false;
                btnAddTrial.removeAttribute('title');
            }
            return;
        }

        const columns = data.columns;
        const rows = data.data || {};
        const categories = data.categories || [];
        const trials = data.trials || {};

        lastTrialInfo = getLastTrial(trials);
        const lastTrialKey = lastTrialInfo ? lastTrialInfo.key : null;
        const lastTrialIndex = lastTrialKey ? columns.indexOf(lastTrialKey) : -1;

        const isAlreadyLocked = checkIfAllColumnsLocked(data);

        if (isAlreadyLocked) {
            isDataLocked = true;
            updateLockUI(true);
            hideSaveDataButton();
        } else {
            isDataLocked = false;
            updateLockUI(false);
            hideSaveDataButton();
        }

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

        /* ===== OK ROW ===== */
        html += `
        <tr class="fw-bold ok-row">
            <td></td>
            <td class="fw-bold">OK</td>
            ${columns.map((col, colIndex) => {
                const item = rows.OK?.OK?.[col] ?? { quant: 0, percent: 0 };
                const target = data.targets?.[col] ?? 0;
                const cls = item.percent >= target ? 'text-success-bold' : 'text-danger-bold';
                const percentValue = parseFloat(item.percent).toFixed(2);
                return `
                    <td class="text-end fw-bold" id="ok-value-${colIndex}">${item.quant}</td>
                    <td class="text-end fw-bold ${cls}">${percentValue}%</td>
                `;
            }).join('')}
        </tr>
        `;

        /* ===== CATEGORY ROWS ===== */
        categories.forEach(category => {
            const defects = rows[category] || {};
            const defectKeys = Object.keys(defects);
            const rowspan = defectKeys.length;

            defectKeys.forEach((defectId, i) => {
                const defectData = defects[defectId];
                const defectLabel = defectData._label || '-';

                html += `
                <tr class="${i === 0 ? 'after-ok' : ''}" data-defect-id="${defectId}" data-category="${category}">
                    ${i === 0 ? `<td rowspan="${rowspan}" class="text-center align-middle fw-bold">${category}</td>` : ``}
                    <td data-defect-id="${defectId}">${defectLabel}</td>

                    ${columns.map((col, colIndex) => {
                        const item = defectData?.[col] ?? { quant: 0, percent: 0 };
                        const trialInfo = trials[col];
                        const trialId = trialInfo?.id;
                        const actualQty = item.actual || 0;
                        const currentValue = item.quant || 0;
                        const percentValue = parseFloat(item.percent).toFixed(2);
                        const isLastTrial = lastTrialKey && col === lastTrialKey;

                        // Hanya PM dan PE yang bisa edit input, QA hanya lihat
                        if (isLastTrial && trialId && canEditTrial && !isDataLocked) {
                            return `
                                <td class="text-center">
                                    <input type="number"
                                           class="ng-input"
                                           value="${currentValue}"
                                           min="0"
                                           max="${actualQty}"
                                           step="0.01"
                                           data-trial-id="${trialId}"
                                           data-defect-id="${defectId}"
                                           data-actual="${actualQty}"
                                           data-trial-key="${col}"
                                           data-column-index="${lastTrialIndex}"
                                           data-trans-type="${category}"
                                           data-defect-name="${defectLabel}"
                                           data-original-value="${currentValue}"
                                           data-current-percent="${percentValue}">
                                </td>
                                <td class="text-end percent-cell" id="percent-${defectId}-${colIndex}">
                                    ${percentValue}%
                                </td>`;
                        } else {
                            // QA atau data locked: tampilkan teks saja
                            return `
                                <td class="text-end locked-value">${currentValue}</td>
                                <td class="text-end percent-cell">${percentValue}%</td>`;
                        }
                    }).join('')}
                </tr>`;
            });
        });

        /* ===== JUMLAH ROW ===== */
        html += `
            <tr class="fw-bold border-top jumlah-row" id="jumlahRow">
                <td colspan="2" class="fw-bold">Jumlah</td>
                ${columns.map((col, colIndex) => {
                    const item = rows.Jumlah?.Jumlah?.[col] ?? { quant: 0, percent: 100 };
                    const percent = parseFloat(item.percent) || 0;
                    const statusClass = Math.abs(percent - 100) <= 0.01 ? 'text-success-bold' : 'text-danger-bold';
                    const percentValue = percent.toFixed(2);
                    return `
                        <td class="text-end fw-bold" id="totalNG-${colIndex}">${item.quant}</td>
                        <td class="text-end fw-bold ${statusClass}" id="totalPercent-${colIndex}">${percentValue}%</td>
                    `;
                }).join('')}
            </tr>
            `;

        tbody.innerHTML = html;

        // Attach input listeners hanya untuk PM dan PE, dan data belum locked
        if (canEditTrial && !isDataLocked) {
            attachInputListeners();
        }

        if (canEditTrial && btnAddTrial) {
            if (isDataLocked) {
                btnAddTrial.disabled = false;
                btnAddTrial.removeAttribute('title');
            } else {
                btnAddTrial.disabled = true;
                btnAddTrial.setAttribute('title', 'Cannot add trial: Total must reach 100.00%');
            }
        }
    }

    /* ===============================
       CHECK IF ALL COLUMNS LOCKED
    ================================ */
    function checkIfAllColumnsLocked(data) {
        if (!data || !data.data || !data.data.Jumlah || !data.data.Jumlah.Jumlah) return false;

        const jumlahData = data.data.Jumlah.Jumlah;
        const columns = data.columns || [];

        for (const col of columns) {
            const item = jumlahData[col];
            const trialInfo = data.trials[col];

            if (item && item.percent) {
                const percent = parseFloat(item.percent);
                if (Math.abs(percent - 100.00) <= 0.001) {
                    if (trialInfo && trialInfo.att1 === null) continue;
                }
            }
            return false;
        }
        return true;
    }

    /* ===============================
       UPDATE LOCK UI
    ================================ */
    function updateLockUI(isLocked) {
        const lockedMessage = document.getElementById('lockedMessage');
        const btnAddTrial = document.getElementById('btnAddTrial');
        const btnSaveData = document.getElementById('btnSaveData');

        if (isLocked) {
            if (lockedMessage) lockedMessage.classList.add('show');
            if (canEditTrial && btnAddTrial) {
                btnAddTrial.disabled = false;
                btnAddTrial.removeAttribute('title');
            }
            if (btnSaveData) {
                btnSaveData.classList.remove('show');
                btnSaveData.style.display = 'none';
            }
            isDataLocked = true;
        } else {
            if (lockedMessage) lockedMessage.classList.remove('show');
            if (canEditTrial && btnAddTrial) {
                btnAddTrial.disabled = true;
                btnAddTrial.setAttribute('title', 'Cannot add trial: Total must reach 100.00%');
            }
            isDataLocked = false;
        }
    }

    /* ===============================
       HIDE SAVE DATA BUTTON
    ================================ */
    function hideSaveDataButton() {
        const btnSaveData = document.getElementById('btnSaveData');
        if (btnSaveData) {
            btnSaveData.classList.remove('show');
            btnSaveData.style.display = 'none';
        }
    }

    /* ===============================
       SHOW LOCK CONFIRMATION
    ================================ */
    function showLockConfirmation() {
        if (!canEditTrial) return; // QA tidak bisa lock
        if (document.querySelector('.swal2-container')) return;

        Swal.fire({
            title: 'Total Reached 100.00%',
            text: 'Data will be saved and locked. You cannot edit NG values after this.',
            icon: 'info',
            showCancelButton: false,
            confirmButtonColor: '#0fac81',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                lockAndReloadData();
            }
        });
    }

    /* ===============================
       LOCK AND RELOAD DATA
    ================================ */
    function lockAndReloadData() {
        const btnAddTrial = document.getElementById('btnAddTrial');
        const lockedMessage = document.getElementById('lockedMessage');

        saveAllChangesBeforeLock()
            .then(() => {
                isDataLocked = true;
                if (lockedMessage) lockedMessage.classList.add('show');
                if (canEditTrial && btnAddTrial) {
                    btnAddTrial.disabled = false;
                    btnAddTrial.removeAttribute('title');
                }
                hideSaveDataButton();
                loadReportFreshData();
                loadTrialData();
            })
            .catch(error => {
                console.error('Error saving/locking data:', error);
                Swal.fire({ icon: 'error', title: 'Save Failed', text: 'Failed to save data. Please try again.' });
            });
    }

    /* ===============================
       REPLACE INPUTS WITH TEXT
    ================================ */
    function replaceInputsWithText() {
        const ngInputs = document.querySelectorAll('.ng-input');
        ngInputs.forEach(input => {
            const value = input.value || '0';
            const tdElement = input.parentElement;
            const spanElement = document.createElement('span');
            spanElement.className = 'locked-value';
            spanElement.textContent = value;
            tdElement.innerHTML = '';
            tdElement.appendChild(spanElement);
            tdElement.classList.remove('text-center');
            tdElement.classList.add('text-end');
        });
    }

    /* ===============================
       SAVE ALL CHANGES BEFORE LOCK
    ================================ */
    function saveAllChangesBeforeLock() {
        return new Promise((resolve, reject) => {
            const ngInputs = document.querySelectorAll('.ng-input');
            let savePromises = [];

            ngInputs.forEach(input => {
                const originalValue = parseFloat(input.dataset.originalValue) || 0;
                const currentValue = parseFloat(input.value) || 0;
                if (Math.abs(currentValue - originalValue) > 0.001) {
                    savePromises.push(saveSingleNG(input, currentValue));
                }
            });

            if (savePromises.length === 0) { resolve(); return; }

            Promise.all(savePromises).then(() => resolve()).catch(error => reject(error));
        });
    }

    /* ===============================
       SAVE SINGLE NG VALUE
    ================================ */
    function saveSingleNG(input, value) {
        return new Promise((resolve, reject) => {
            const trialId = input.dataset.trialId;
            const defectId = input.dataset.defectId;
            const actualQty = parseFloat(input.dataset.actual) || 0;

            const saveData = {
                project_id: projectId,
                process_id: selectedProcessId,
                trial_id: trialId,
                defect_id: defectId,
                ng: value,
                perct: actualQty > 0 ? parseFloat(((value / actualQty) * 100).toFixed(2)) : 0
            };

            fetch("{{ route('trial.update.detail') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
                body: JSON.stringify(saveData)
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || `Server returned ${response.status}`);
                    resolve(data);
                })
                .catch(error => reject(error));
        });
    }

    /* ===============================
       ATTACH INPUT LISTENERS
    ================================ */
    function attachInputListeners() {
        // Guard: hanya PM dan PE
        if (!canEditTrial) return;

        const ngInputs = document.querySelectorAll('#reportFreshTable .ng-input');

        ngInputs.forEach(input => {
            const att1Status = input.dataset.att1;
            const isAlreadyLocked = att1Status === 'null' && parseFloat(input.dataset.currentPercent || 0) == 100.00;

            if (isAlreadyLocked) {
                input.disabled = true;
                input.style.backgroundColor = '#f8f9fa';
                input.style.cursor = 'not-allowed';
                return;
            }

            const originalValue = parseFloat(input.value) || 0;

            input.addEventListener('input', function () {
                if (isDataLocked) return;

                const value = parseFloat(this.value) || 0;
                const actualQty = parseFloat(this.dataset.actual) || 0;
                const maxValue = parseFloat(this.max) || 0;

                if (value < 0) { this.value = 0; this.classList.add('error'); return; }
                if (value > maxValue) { this.value = maxValue; this.classList.add('error'); return; }

                this.classList.remove('error');
                updatePercentCell(this, value, actualQty);

                const colIndex = parseInt(this.dataset.columnIndex);
                const totalPercent = updateTotalForColumn(colIndex);

                if (totalPercent > 100.01) {
                    this.value = originalValue;
                    this.classList.add('error');
                    updatePercentCell(this, originalValue, actualQty);
                    updateTotalForColumn(colIndex);
                    showWarningMessage(true);
                    return;
                } else {
                    this.classList.remove('error');
                    showWarningMessage(false);
                }

                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    const currentTotalPercent = updateTotalForColumn(colIndex);
                    if (currentTotalPercent <= 100.01) saveNGValue(this, value);
                }, 500);
            });

            input.addEventListener('focus', function () {
                if (!isDataLocked) this.select();
            });

            input.addEventListener('keydown', function (e) {
                if (isDataLocked) return;
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const allInputs = Array.from(document.querySelectorAll('.ng-input'));
                    const currentIndex = allInputs.indexOf(this);
                    if (currentIndex < allInputs.length - 1) allInputs[currentIndex + 1].focus();
                }
                if (e.key === 'Escape') {
                    this.value = originalValue;
                    this.classList.remove('error');
                    const actualQty = parseFloat(this.dataset.actual) || 0;
                    updatePercentCell(this, originalValue, actualQty);
                    const colIndex = parseInt(this.dataset.columnIndex);
                    updateTotalForColumn(colIndex);
                    showWarningMessage(false);
                    this.blur();
                }
            });

            input.addEventListener('blur', function () {
                if (isDataLocked) return;
                const value = parseFloat(this.value) || 0;
                const colIndex = parseInt(this.dataset.columnIndex);
                const totalPercent = updateTotalForColumn(colIndex);
                if (totalPercent <= 100.01) {
                    saveNGValue(this, value);
                } else {
                    this.value = originalValue;
                    this.classList.add('error');
                    const actualQty = parseFloat(this.dataset.actual) || 0;
                    updatePercentCell(this, originalValue, actualQty);
                    updateTotalForColumn(colIndex);
                }
            });
        });
    }

    /* ===============================
       UPDATE PERCENT CELL REAL-TIME
    ================================ */
    function updatePercentCell(input, value, actualQty) {
        const defectId = input.dataset.defectId;
        const colIndex = parseInt(input.dataset.columnIndex);
        const percentCell = document.getElementById(`percent-${defectId}-${colIndex}`);
        if (percentCell) {
            if (actualQty > 0) {
                const percent = (value / actualQty) * 100;
                percentCell.textContent = `${percent.toFixed(2)}%`;
                if (input.dataset) input.dataset.currentPercent = percent.toFixed(2);
            } else {
                percentCell.textContent = '0.00%';
                if (input.dataset) input.dataset.currentPercent = '0.00';
            }
        }
    }

    /* ===============================
       UPDATE TOTAL FOR COLUMN
    ================================ */
    function updateTotalForColumn(colIndex) {
        const okCell = document.getElementById(`ok-value-${colIndex}`);
        if (!okCell) return 100;

        const okValue = parseFloat(okCell.textContent) || 0;
        const ngInputs = document.querySelectorAll(`.ng-input[data-column-index="${colIndex}"]`);
        let totalNG = 0;
        let actualQty = 0;

        ngInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            const inputActual = parseFloat(input.dataset.actual) || 0;
            totalNG += value;
            if (inputActual > 0) actualQty = inputActual;
        });

        const total = totalNG + okValue;
        const totalNGCell = document.getElementById(`totalNG-${colIndex}`);
        const totalPercentCell = document.getElementById(`totalPercent-${colIndex}`);

        if (totalNGCell) totalNGCell.textContent = total;

        if (totalPercentCell && actualQty > 0) {
            const percent = (total / actualQty) * 100;
            totalPercentCell.textContent = `${percent.toFixed(2)}%`;

            if (Math.abs(percent - 100) <= 0.01) {
                totalPercentCell.className = 'text-end fw-bold text-success-bold';
                totalPercentCell.style.color = '#0fac81';
                if (Math.abs(percent - 100.00) <= 0.001 && !isDataLocked) showLockConfirmation();
            } else {
                totalPercentCell.className = 'text-end fw-bold text-danger-bold';
                totalPercentCell.style.color = '#e85347';
            }

            updateAddTrialButtonStatus(percent);
            return percent;
        }
        return 100;
    }

    /* ===============================
       UPDATE ADD TRIAL BUTTON STATUS
    ================================ */
    function updateAddTrialButtonStatus(currentPercent) {
        if (!canEditTrial) return; // QA tidak perlu update button
        const btnAddTrial = document.getElementById('btnAddTrial');
        if (!btnAddTrial) return;

        if (isDataLocked) {
            btnAddTrial.disabled = false;
            btnAddTrial.removeAttribute('title');
        } else if (Math.abs(currentPercent - 100.00) <= 0.001) {
            btnAddTrial.disabled = true;
            btnAddTrial.setAttribute('title', 'Cannot add trial: Total must be saved first');
        } else {
            btnAddTrial.disabled = true;
            btnAddTrial.setAttribute('title', 'Cannot add trial: Total must reach 100.00%');
        }
    }

    /* ===============================
       SHOW/HIDE WARNING MESSAGE
    ================================ */
    function showWarningMessage(show) {
        const warningMessage = document.getElementById('warningMessage');
        if (warningMessage) {
            if (show) warningMessage.classList.add('show');
            else warningMessage.classList.remove('show');
        }
    }

    /* ===============================
       SAVE NG VALUE REAL-TIME
    ================================ */
    function saveNGValue(input, value) {
        if (!canEditTrial || isDataLocked) return; // QA tidak bisa save

        const trialId = input.dataset.trialId;
        const defectId = input.dataset.defectId;
        const actualQty = parseFloat(input.dataset.actual) || 0;
        const originalValue = parseFloat(input.dataset.originalValue) || 0;
        const colIndex = parseInt(input.dataset.columnIndex);

        const totalPercent = updateTotalForColumn(colIndex);
        if (totalPercent > 100.01) {
            input.value = originalValue;
            input.classList.add('error');
            updatePercentCell(input, originalValue, actualQty);
            updateTotalForColumn(colIndex);
            return;
        }

        if (Math.abs(value - originalValue) < 0.001) return;

        input.dataset.originalValue = value;

        const saveData = {
            project_id: projectId,
            process_id: selectedProcessId,
            trial_id: trialId,
            defect_id: defectId,
            ng: value,
            perct: actualQty > 0 ? parseFloat(((value / actualQty) * 100).toFixed(2)) : 0
        };

        fetch("{{ route('trial.update.detail') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
            body: JSON.stringify(saveData)
        })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || `Server returned ${response.status}`);
                return data;
            })
            .then(data => {
                if (data.success) {
                    input.classList.remove('error');
                    if (data.perct !== undefined) {
                        const percentCell = document.getElementById(`percent-${defectId}-${colIndex}`);
                        if (percentCell) percentCell.textContent = `${parseFloat(data.perct).toFixed(2)}%`;
                    }
                } else {
                    throw new Error(data.message || 'Failed to save data');
                }
            })
            .catch(err => {
                console.error('Save error:', err);
                input.value = originalValue;
                input.dataset.originalValue = originalValue;
                input.classList.add('error');
                updatePercentCell(input, originalValue, actualQty);
                updateTotalForColumn(colIndex);
            });
    }

    /* ===============================
       GET LAST TRIAL
    ================================ */
    function getLastTrial(trials) {
        const trialKeys = Object.keys(trials || {});
        if (trialKeys.length === 0) return null;

        if (trials[trialKeys[0]]?.order) {
            const sortedTrials = trialKeys
                .map(key => ({ key, order: trials[key]?.order || 0 }))
                .sort((a, b) => b.order - a.order);
            return { key: sortedTrials[0]?.key, order: sortedTrials[0]?.order, id: trials[sortedTrials[0]?.key]?.id };
        }

        let lastTrial = null;
        let maxNumber = -1;

        trialKeys.forEach(key => {
            const match = key.match(/\d+/);
            if (match) {
                const num = parseInt(match[0]);
                if (num > maxNumber) { maxNumber = num; lastTrial = { key, number: num, id: trials[key]?.id }; }
            }
        });

        if (maxNumber !== -1) return lastTrial;

        const sortedKeys = trialKeys.sort((a, b) => b.localeCompare(a));
        return { key: sortedKeys[0], order: trialKeys.length, id: trials[sortedKeys[0]]?.id };
    }

    /* ===============================
       UPDATE DATATABLE
    ================================ */
    function updateDataTable(data) {
        if ($.fn.DataTable.isDataTable('#trialDataTable')) {
            trialDataTable.destroy();
            trialDataTable = null;
        }

        const tableBody = document.querySelector('#trialDataTable tbody');

        if (!data || data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="14" class="text-center text-muted py-4">No trial data available</td></tr>`;
            initDataTable([]);
            return;
        }

        let html = '';
        data.forEach(row => {
            const perctVal = parseFloat(row.PERCT) || 0;
            const targetVal = parseFloat(row.TARGET) || 0;
            const ctVal = parseFloat(row.CT) || 0;
            const ctTargetVal = parseFloat(row.CT_TARGET) || 0;
            const beratVal = parseFloat(row.BERAT) || 0;
            const beratTargetVal = parseFloat(row.BERAT_TARGET) || 0;
            const perctClass = perctVal >= targetVal ? 'text-success-bold' : 'text-danger-bold';
            const ctClass = ctVal < ctTargetVal ? 'text-success-bold' : 'text-danger-bold';
            const beratClass = beratVal < beratTargetVal ? 'text-success-bold' : 'text-danger-bold';

            let filesHtml = '-';
            if (row.files && row.files.length > 0) {
                filesHtml = row.files.map(f => `<a href="${f.url}" target="_blank" class="d-block text-primary">${f.name}</a>`).join('');
            }

            html += `
                <tr>
                    <td>${row.TRIAL_NO || ''}</td>
                    <td>${row.TRIAL_STAT || ''}</td>
                    <td>${row.TRIAL_MACHINE || ''}</td>
                    <td>${row.TRIAL_DATE ? row.TRIAL_DATE.split(' ')[0] : ''}</td>
                    <td>${row.ACTUAL || ''}</td>
                    <td>${row.OK || ''}</td>
                    <td>${targetVal.toFixed(2)}%</td>
                    <td class="${perctClass}">${perctVal.toFixed(2)}%</td>
                    <td>${row.CT_TARGET || ''}</td>
                    <td class="${ctClass}">${row.CT || ''}</td>
                    <td>${row.BERAT_TARGET || ''}</td>
                    <td class="${beratClass}">${beratVal.toFixed(1)}</td>
                    <td>${row.PIC || ''}</td>
                    <td>${filesHtml}</td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
        initDataTable(data);
    }

    /* ===============================
       INITIALIZE DATATABLE
    ================================ */
    function initDataTable(data) {
        trialDataTable = $('#trialDataTable').DataTable({
            data: data,
            columns: [
                { data: 'TRIAL_NO' },
                { data: 'TRIAL_STAT' },
                { data: 'TRIAL_MACHINE' },
                { data: 'TRIAL_DATE', render: function (data) { return data ? data.split(' ')[0] : ''; } },
                { data: 'ACTUAL' },
                { data: 'OK' },
                { data: 'TARGET', render: function (data) { return (parseFloat(data) || 0).toFixed(2) + '%'; } },
                {
                    data: 'PERCT', render: function (data, type, row) {
                        const perctVal = parseFloat(data) || 0;
                        const targetVal = parseFloat(row.TARGET) || 0;
                        const className = perctVal >= targetVal ? 'text-success-bold' : 'text-danger-bold';
                        return `<span class="${className}">${perctVal.toFixed(2)}%</span>`;
                    }
                },
                { data: 'CT_TARGET' },
                {
                    data: 'CT', render: function (data, type, row) {
                        const ctVal = parseFloat(data) || 0;
                        const ctTargetVal = parseFloat(row.CT_TARGET) || 0;
                        const className = ctVal < ctTargetVal ? 'text-success-bold' : 'text-danger-bold';
                        return `<span class="${className}">${data}</span>`;
                    }
                },
                { data: 'BERAT_TARGET' },
                {
                    data: 'BERAT', render: function (data, type, row) {
                        const beratVal = parseFloat(data) || 0;
                        const beratTargetVal = parseFloat(row.BERAT_TARGET) || 0;
                        const className = beratVal < beratTargetVal ? 'text-success-bold' : 'text-danger-bold';
                        return `<span class="${className}">${beratVal.toFixed(1)}</span>`;
                    }
                },
                { data: 'PIC' },
                {
                    data: 'files', orderable: false, searchable: false,
                    render: function (data) {
                        if (!data || data.length === 0) return '-';
                        return data.map(f => `<a href="${f.url}" target="_blank" class="d-block text-primary">${f.name}</a>`).join('');
                    }
                },
            ],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            responsive: true,
            dom: '<"dt-header-row"<"dt-search-col"f><"dt-buttons-col"B><"dt-length-col"l>>rt<"dt-footer-row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                { extend: 'copy', text: '<i class="icon ni ni-copy"></i> Copy', className: 'btn btn-outline-secondary btn-sm', title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim() },
                { extend: 'excel', text: '<i class="icon ni ni-file-xls"></i> Excel', className: 'btn btn-outline-success btn-sm', title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim() },
                { extend: 'pdf', text: '<i class="icon ni ni-file-pdf"></i> PDF', className: 'btn btn-outline-danger btn-sm', title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim() },
                {
                    extend: 'print', text: '<i class="icon ni ni-printer"></i> Print', className: 'btn btn-outline-primary btn-sm',
                    title: 'Trial Report - ' + document.getElementById('selectedProcess').innerText.trim(),
                    customize: function (win) {
                        $(win.document.body).css('font-size', '10pt').prepend('<h3>Trial Report - ' + document.getElementById('selectedProcess').innerText.trim() + '</h3>');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }
            ],
            language: {
                search: "_INPUT_", searchPlaceholder: "Search records...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                zeroRecords: "No matching records found",
                paginate: { first: "First", last: "Last", next: "Next", previous: "Prev" }
            },
            search: { regex: false, smart: false },
            columnDefs: [{ targets: '_all', searchable: true }],
            initComplete: function () {
                $('.dt-header-row').css({ 'display': 'flex', 'justify-content': 'space-between', 'align-items': 'center', 'margin-bottom': '10px', 'flex-wrap': 'wrap' });
                $('.dt-search-col').css({ 'flex': '1', 'min-width': '200px', 'text-align': 'left' });
                $('.dt-buttons-col').css({ 'flex': '2', 'min-width': '300px', 'text-align': 'center', 'display': 'flex', 'justify-content': 'center', 'gap': '5px' });
                $('.dt-length-col').css({ 'flex': '1', 'min-width': '200px', 'text-align': 'right' });
                $('.dt-footer-row').css({ 'display': 'flex', 'justify-content': 'space-between', 'align-items': 'center', 'margin-top': '10px' });
            },
            drawCallback: function () {
                $('.dataTables_info').css({ 'text-align': 'left', 'float': 'left', 'padding-top': '0.5em' });
                $('.dataTables_paginate').css({ 'text-align': 'right', 'float': 'right' });
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

        const sortedData = [...data].sort((a, b) => (a.TRIAL_NO || '').localeCompare(b.TRIAL_NO || ''));
        const trialNos = sortedData.map(item => item.TRIAL_NO || '');
        const perctData = sortedData.map(item => parseFloat(item.PERCT) || 0);
        const targetData = sortedData.map(item => parseFloat(item.TARGET) || 0);

        Highcharts.chart('chart1', {
            chart: { type: 'column', height: 380 },
            title: { text: '%OK RATIO', align: 'center' },
            subtitle: { text: document.getElementById('selectedProcess').innerText, align: 'center' },
            xAxis: { categories: trialNos, crosshair: true },
            yAxis: { min: 0, max: 100, title: { text: 'Percentage (%)' }, labels: { formatter: function () { return this.value.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '%'; } } },
            tooltip: { headerFormat: '<span style="font-size:10px">Trial {point.key}</span><tr>', pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.2f}%</b></td></tr>', footerFormat: '</tr>', shared: true, useHTML: true },
            plotOptions: { column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, format: '{y:.2f}%', style: { fontSize: '11px', fontWeight: 'bold', textOutline: 'none' }, color: '#ffffff', inside: true, verticalAlign: 'middle', crop: false, overflow: 'none' } } },
            series: [{ name: '%OK RATIO', data: perctData, color: '#4CAF50' }, { name: 'Target', data: targetData, type: 'line', color: '#FF9800', marker: { symbol: 'circle', radius: 6 } }],
            credits: { enabled: false }
        });

        const ctData = sortedData.map(item => parseFloat(item.CT) || 0);
        const ctTargetData = sortedData.map(item => parseFloat(item.CT_TARGET) || 0);

        Highcharts.chart('chart2', {
            chart: { type: 'column', height: 380 },
            title: { text: 'Cycle Time (Second)', align: 'center' },
            subtitle: { text: document.getElementById('selectedProcess').innerText, align: 'center' },
            xAxis: { categories: trialNos, crosshair: true },
            yAxis: { min: 0, title: { text: 'Cycle Time' } },
            tooltip: { headerFormat: '<span style="font-size:10px">Trial {point.key}</span></table>', pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.2f}</b></td></tr>', footerFormat: '</tr>', shared: true, useHTML: true },
            plotOptions: { column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, format: '{y:.1f}', style: { fontSize: '11px', fontWeight: 'bold', textOutline: 'none' }, color: '#ffffff', inside: true, verticalAlign: 'middle', crop: false, overflow: 'none' } } },
            series: [{ name: 'CT', data: ctData, color: '#2196F3' }, { name: 'CT Target', data: ctTargetData, type: 'line', color: '#FF5722', marker: { symbol: 'circle', radius: 6 } }],
            credits: { enabled: false }
        });

        const beratData = sortedData.map(item => parseFloat(item.BERAT) || 0);
        const beratTargetData = sortedData.map(item => parseFloat(item.BERAT_TARGET) || 0);

        Highcharts.chart('chart3', {
            chart: { type: 'column', height: 380 },
            title: { text: 'Berat', align: 'center' },
            subtitle: { text: document.getElementById('selectedProcess').innerText, align: 'center' },
            xAxis: { categories: trialNos, crosshair: true },
            yAxis: { title: { text: 'Berat' }, labels: { formatter: function () { return this.value.toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 }); } } },
            tooltip: { headerFormat: '<span style="font-size:10px">Trial {point.key}</span><tr>', pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f}</b></td></tr>', footerFormat: '</tr>', shared: true, useHTML: true },
            plotOptions: { column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, format: '{y:.1f}', style: { fontSize: '11px', fontWeight: 'bold', textOutline: 'none' }, color: '#ffffff', inside: true, verticalAlign: 'middle', crop: false, overflow: 'none' } } },
            series: [{ name: 'Berat', data: beratData, color: '#9C27B0' }, { name: 'Berat Target', data: beratTargetData, type: 'line', color: '#795548', marker: { symbol: 'circle', radius: 6 } }],
            credits: { enabled: false }
        });
    }

    /* ===============================
       LOAD STANDARD TARGET
    ================================ */
    function loadStandardTarget() {
        fetch("{{ route('trial.standard') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
            body: JSON.stringify({ project_id: projectId, process_id: selectedProcessId })
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

    /* ===============================
       LOAD NEXT TRIAL NO
    ================================ */
    function loadNextTrialNo() {
        fetch("{{ route('trial.next_no') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
            body: JSON.stringify({ project_id: projectId, process_id: selectedProcessId })
        })
            .then(res => res.json())
            .then(data => { document.getElementById('trial_no').value = data.trial_no; })
            .catch(err => { console.error('Error loading next trial no:', err); document.getElementById('trial_no').value = ''; });
    }

    function formatModalTarget(val) {
        if (val === null || val === '' || isNaN(val)) return '';
        return parseFloat(val).toFixed(2).replace('.', ',');
    }
</script>