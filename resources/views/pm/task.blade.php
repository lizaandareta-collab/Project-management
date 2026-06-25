<style>
    /*Freeze Pane*/
    .table-responsive {
        position: relative;
        overflow-x: auto;
        overflow-y: visible !important;
        max-height: none !important;
    }

    table.dataTable th:nth-child(1),
    table.dataTable td:nth-child(1) {
        position: sticky;
        left: 0;
        z-index: 8;
        background: #fff;
        border-right: 1px solid #ddd;
        min-width: 60px;
    }

    table.dataTable th:nth-child(2),
    table.dataTable td:nth-child(2) {
        position: sticky;
        left: 65px;
        z-index: 7;
        background: #fff;
        border-right: 1px solid #ddd;
        min-width: 150px;
    }

    table.dataTable th:nth-child(3),
    table.dataTable td:nth-child(3) {
        position: sticky;
        left: 215px;
        z-index: 6;
        background: #fff;
        border-right: 1px solid #ddd;
        min-width: 50px;
    }

    table.dataTable th:nth-child(4),
    table.dataTable td:nth-child(4) {
        position: sticky;
        left: 310px;
        z-index: 5;
        background: #fff;
        border-right: 1px solid #ddd;
        min-width: 50px;
    }

    table.dataTable thead th {
        position: sticky;
        top: 0;
        background: #f9f9f9;
        z-index: 12;
        border-bottom: 1px solid #ddd;
    }

    table.dataTable th:nth-child(1),
    table.dataTable th:nth-child(2),
    table.dataTable th:nth-child(3),
    table.dataTable th:nth-child(4) {
        z-index: 13;
    }

    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }

    table.dataTable {
        border-collapse: collapse;
    }


    /* tabel */
    .table-responsive {
        overflow-x: visible !important;
    }

    table.dataTable tbody td {
        white-space: normal !important;
        word-wrap: break-word !important;
        vertical-align: middle !important;
    }

    table.dataTable th:not(:nth-child(5)),
    table.dataTable td:not(:nth-child(5)) {
        max-width: 200px;
    }

    table.dataTable tr.child td {
        padding: 0.5rem 1rem !important;
        background-color: #fafafa !important;
    }

    table.dataTable>tbody>tr.parent td:first-child {
        vertical-align: middle;
    }

    div.dataTables_wrapper .d-flex {
        flex-wrap: nowrap !important;
    }

    div.dataTables_filter {
        margin-right: 50px !important;
    }

    table.dataTable td:first-child::before {
        display: none !important;
    }

    .cursor-pointer {
        cursor: pointer !important;
    }

    /* Status KPI Indicator */
    .kpi-status {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
    }

    .kpi-in-progress {
        background-color: #ffc107;
    }

    .kpi-on-track {
        background-color: #28a745;
    }

    .kpi-delayed {
        background-color: #dc3545;
    }

    .milestone-task-subactivity {
        color: #000000 !important;
        background-color: #ffffff !important;
    }

    .milestone-task-activity {
        color: #000000 !important;
        font-weight: bold !important;
        background-color: #f0f0f0 !important;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .milestone-task-milestone {
        color: #28a745 !important;
        background-color: #e3f2ff !important;
        font-weight: 600 !important;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .legend-circle {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: currentColor !important;
        mix-blend-mode: multiply;
    }

    #editRemarksModal .modal-content::-webkit-scrollbar {
        width: 6px;
    }

    #editRemarksModal .modal-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #editRemarksModal .modal-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    #editRemarksModal .modal-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #editRemarksModal .modal-body>div:last-child>div::-webkit-scrollbar {
        width: 5px;
    }

    #editRemarksModal .modal-body>div:last-child>div::-webkit-scrollbar-track {
        background: #f8f9fa;
    }

    #editRemarksModal .modal-body>div:last-child>div::-webkit-scrollbar-thumb {
        background: #adb5bd;
        border-radius: 3px;
    }
</style>

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">

                    <div class="nk-block nk-block-lg">
                        <!-- Header Judul + Tombol -->
                        <div class="nk-block-head-content d-flex justify-content-between align-items-center mb-4">
                            <h4 class="nk-block-title">
                                Task Management Project - {{ $projectName }}
                            </h4>
                            @if(session('role_name') == 'PM')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addMilestoneModal">
                                <em class="icon ni ni-plus"></em> Add Milestone Task
                            </button>
                            @endif
                        </div>

                        <!-- Project Progress Summary -->
                        <div class="card card-bordered mb-5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h6 class="title">Project Progress Summary</h6>
                                        <div class="progress progress-lg mt-2">
                                            <div class="progress-bar bg-primary" id="projectProgressBar"
                                                role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span id="projectProgressText">0% (0/0 tasks completed)</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row g-4">
                                            <div class="col-4">
                                                <div class="p-3 bg-light rounded text-center shadow-sm">
                                                    <div class="h4 mb-0" id="projectProgressPercent">0%</div>
                                                    <div class="small">Project Progress</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-3 bg-light rounded text-center shadow-sm">
                                                    <div class="h4 mb-0" id="totalTasks">0</div>
                                                    <div class="small">Total Tasks</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-3 bg-light rounded text-center shadow-sm">
                                                    <div class="h4 mb-0" id="completedTasks">0</div>
                                                    <div class="small">Completed Tasks</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Legend Keterangan Warna Task + Status KPI -->
                        <div class="card card-bordered mb-4">
                            <div class="card-body py-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="title mb-2">Task:</h6>
                                        <div class="d-flex flex-wrap gap-4">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-circle milestone-task-milestone me-2"></div>
                                                <span class="milestone-task-milestone">Milestone</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="legend-circle milestone-task-activity me-2"></div>
                                                <span class="milestone-task-activity">Activity</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="legend-circle milestone-task-subactivity me-2"></div>
                                                <span class="milestone-task-subactivity">Sub Activity</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="legend-circle legend-default me-2"></div>
                                                <span class="legend-default">Category belum di isi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="title mb-2">Status KPI:</h6>
                                        <div class="d-flex flex-wrap gap-4">
                                            <div class="d-flex align-items-center">
                                                <span class="kpi-status kpi-in-progress me-2"></span>
                                                <span>On Progress</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="kpi-status kpi-on-track me-2"></span>
                                                <span>Done</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="kpi-status kpi-delayed me-2"></span>
                                                <span>Overdue</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Task List -->
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="table-responsive">
                                    <table class="datatable-init-export table table-auto-wrap"
                                        data-export-title="Export Task" id="taskTable">
                                        <thead id="taskThead"></thead>
                                        <tbody id="taskTbody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Milestone Task -->
<div class="modal fade" id="addMilestoneModal" tabindex="-1" aria-labelledby="addMilestoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addMilestoneForm">
                @csrf
                <input type="hidden" name="project_id" value="{{ request()->route('id') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMilestoneModalLabel">Add New Milestone Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="milestone_task" class="form-label">Milestone Task Name</label>
                        <input type="text" class="form-control" id="milestone_task" name="milestone_task" required
                            placeholder="Enter milestone task name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($lov_is_milestone as $m)
                                <option value="{{ $m->LOV_ID }}">{{ $m->DESCRIPTION }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="insert_after" class="form-label">Insert After</label>
                        <select class="form-control" id="insert_after" name="insert_after" required>
                            <option value="">-- Select Milestone To Insert After --</option>
                            @foreach ($tasks as $t)
                                <option value="{{ $t->ORDER1 }}">{{ $t->MILESTONE_TASK }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Milestone</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Single Field -->
<div class="modal fade" id="editSingleFieldModal" tabindex="-1" aria-labelledby="editSingleFieldModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editSingleFieldForm">
                @csrf
                <input type="hidden" id="task_id" name="task_id">
                <input type="hidden" id="field_type" name="field_type">
                <input type="hidden" name="project_id" value="{{ request()->route('id') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSingleFieldModalLabel">Edit Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="field-input-container"></div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Remarks -->
<div class="modal fade" id="editRemarksModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="max-height: 100vh; display: flex; flex-direction: column;">
            <form id="editRemarksForm" enctype="multipart/form-data">
                @csrf
                @php
                    $user = session('user');
                    $inputby = is_array($user)
                        ? ($user['name'] ?? $user['NAME'] ?? null)
                        : ($user->name ?? $user->NAME ?? null);
                @endphp
                <input type="hidden" name="inputby" value="{{ $inputby }}">
                <input type="hidden" id="remarks_task_id" name="task_id">
                <input type="hidden" id="remarks_project_id" name="project_id" value="{{ request()->route('id') }}">
                <input type="hidden" id="remarks_activity" name="activity">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarksModalTitle">Documentation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="flex: 1; overflow-y: auto; padding: 1.5rem;">
                    <div class="form-group mb-3">
                        <label class="form-label">Dokumentasi
                            <span id="fileRequiredLabel" class="text-danger d-none">*</span>
                            <span id="fileOptionalLabel">(Optional)</span>
                        </label>
                        <div class="form-control">
                            <input type="file" id="activity_file" name="picture[]" class="d-none"
                                accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" multiple>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="document.getElementById('activity_file').click()">
                                Upload Files
                            </button>
                            <span id="file_chosen" class="ms-2 text-muted">No file chosen</span>
                            <div id="fileRequiredWarning" class="text-danger small mt-1 d-none">
                                File dokumentasi wajib diupload untuk status Completed
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Task Detail <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="remark_text" name="task_det" rows="3"
                            placeholder="Enter task details..." required></textarea>
                    </div>
                    <div class="border-top pt-3 mt-3">
                        <h6>History</h6>
                        <div style="max-height: 250px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 4px;">
                            <table class="table table-sm table-hover mb-0">
                                <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                                    <tr>
                                        <th style="width: 120px; background: #f8f9fa;">PIC</th>
                                        <th style="width: 100px; background: #f8f9fa;">Date</th>
                                        <th style="background: #f8f9fa;">Task Detail</th>
                                        <th style="width: 150px; background: #f8f9fa;">Docs</th>
                                    </tr>
                                </thead>
                                <tbody id="activityHistory"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between" style="flex-shrink: 0;">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const canEditAll = {{ session('role_name') == 'PM' ? 'true' : 'false' }};

    document.addEventListener('DOMContentLoaded', function () {
        f_autoload();
        document.addEventListener('click', function (e) {
            const icon = e.target.closest('.ni-edit');
            if (!icon) return;
            add_task(icon);
        });
        document.getElementById('editSingleFieldForm').addEventListener('submit', function (e) {
            e.preventDefault();
            submit_task_add(this);
        });
        document.addEventListener('click', function (e) {
            const span = e.target.closest('.editable-field');
            if (!span) return;
            add_task(span);
        });
        document.getElementById('addMilestoneForm').addEventListener('submit', function (e) {
            e.preventDefault();
            submit_milestone_add(this);
        });
        document.getElementById('editRemarksForm').addEventListener('submit', function (e) {
            e.preventDefault();
            submitRemarksForm(this);
        });
        document.getElementById('activity_file').addEventListener('change', function (e) {
            const files = e.target.files;
            if (!files.length) {
                document.getElementById('file_chosen').textContent = 'No file chosen';
                return;
            }
            let fileNames = [];
            for (let i = 0; i < files.length; i++) {
                fileNames.push(files[i].name);
            }
            document.getElementById('file_chosen').textContent = fileNames.join(', ');
        });
        $('#editRemarksModal').on('hidden.bs.modal', function () {
            document.getElementById('remarksModalTitle').textContent = 'Documentation';
            document.getElementById('editRemarksForm').reset();
            document.getElementById('file_chosen').textContent = 'No file chosen';
            document.getElementById('activityHistory').innerHTML = '';
            document.getElementById('editRemarksModal').dataset.fromStatusUpdate = 'false';
            window.pendingStatusUpdate = null;
            document.getElementById('fileRequiredLabel').classList.add('d-none');
            document.getElementById('fileOptionalLabel').classList.remove('d-none');
            document.getElementById('fileRequiredWarning').classList.add('d-none');
            document.getElementById('activity_file').required = false;
            document.getElementById('remark_text').value = '';
        });
    });

    function f_autoload() {
        const theadHtml = `
    <tr>
        <th>No</th>
        <th>Milestone Task</th>
        <th>Category</th>
        <th>Responsible</th>
        <th>Status KPI</th>
        <th>Remarks</th>
        <th>Plan Start</th>
        <th>Plan Duration</th>
        <th>Plan End</th>
        <th>Actual Start</th>
        <th>Actual Duration</th>
        <th>Actual End</th>
        <th>Status</th>
        <th>Complexity</th>
        <th>Priority</th>
        <th>Plan Hour</th>
        <th>Actual Hour</th>
        <th>Heattasks</th>
        <th>#</th>
    </tr>
`;
        document.getElementById('taskThead').innerHTML = theadHtml;
        let tbodyHtml = '';
        const tasks = allTasks;
        total_persentase();
        const sortedTasks = [...tasks].sort((a, b) => (a.ORDER1 || 0) - (b.ORDER1 || 0));
        sortedTasks.forEach((t, index) => {

            const generateEditableField = (fieldType, taskId, label, currentValue, displayValue) => {
                // Jika bukan PM, hanya tampilkan teks biasa (kecuali remark)
                if (!canEditAll && fieldType !== 'remark') {
                    return `${displayValue || currentValue || ''}`;
                }

                if (!currentValue && currentValue !== 0) {
                    return `<em class="icon ni ni-edit cursor-pointer text-primary"
                        data-type="${fieldType}" data-id="${taskId}"
                        data-label="${label}" data-current=""
                        data-bs-toggle="modal" data-bs-target="#editSingleFieldModal"></em>`;
                } else {
                    return `<span class="editable-field cursor-pointer" data-type="${fieldType}"
                        data-id="${taskId}" data-label="${label}"
                        data-current="${currentValue}" data-bs-toggle="modal"
                        data-bs-target="#editSingleFieldModal">
                        ${displayValue || currentValue}
                    </span>`;
                }
            };

            const kpiStatus = calculateKPIStatus(t);
            let milestoneTaskClass = '';
            if (t.IS_MILESTONE === '70') {
                milestoneTaskClass = 'milestone-task-subactivity';
            } else if (t.IS_MILESTONE === '21') {
                milestoneTaskClass = 'milestone-task-activity';
            } else if (t.IS_MILESTONE === '20') {
                milestoneTaskClass = 'milestone-task-milestone';
            }

            tbodyHtml += `
        <tr data-row-id="${t.ID}">
            <td class="row-index">${index + 1}</td>
            <td class="${milestoneTaskClass}">${t.MILESTONE_TASK || ''}</td>
            <td>
                ${generateEditableField('is_milestone', t.TASK_ID, 'Category', t.IS_MILESTONE, t.IS_MILESTONE_NAME || t.IS_MILESTONE)}
            </td>
            <td>
                ${generateEditableField('responsible', t.TASK_ID, 'Responsible', t.RESPONSIBLE, t.RESPONSIBLE_NAME)}
            </td>
            <td class="text-center">
                ${kpiStatus.class ? `<span class="kpi-status ${kpiStatus.class}" title="${kpiStatus.tooltip}"></span>` : ''}
            </td>
            <td>
                ${t.LAST_TASK_DET
                    ? `<span class="editable-field cursor-pointer"
                        data-type="remark"
                        data-id="${t.TASK_ID}"
                        data-project="${t.PROJECT_ID}"
                        data-label="Remarks"
                        data-current="${t.LAST_TASK_DET}"
                        data-bs-toggle="modal"
                        data-bs-target="#editRemarksModal">
                        ${t.LAST_TASK_DET}
                    </span>`
                    : `<span class="editable-field cursor-pointer"
                        data-type="remark"
                        data-id="${t.TASK_ID}"
                        data-project="${t.PROJECT_ID}"
                        data-label="Remarks"
                        data-current=""
                        data-bs-toggle="modal"
                        data-bs-target="#editRemarksModal">
                        <em class="icon ni ni-edit text-primary"></em>
                    </span>`
                }
            </td>
            <td>
                ${generateEditableField('plan_start', t.TASK_ID, 'Plan Start', t.PLAN_START, t.PLAN_START ? format_date_local(t.PLAN_START) : '')}
            </td>
            <td>
                ${generateEditableField('plan_duration', t.TASK_ID, 'Plan Duration', t.PLAN_DURATION, t.PLAN_DURATION)}
            </td>
            <td>
                ${t.PLAN_END ? format_date_local(t.PLAN_END) : ''}
            </td>
            <td>
                ${generateEditableField('actual_start', t.TASK_ID, 'Actual Start', t.ACTUAL_START, t.ACTUAL_START ? format_date_local(t.ACTUAL_START) : '')}
            </td>
            <td>
                ${t.ACTUAL_DURATION || ''}
            </td>
            <td>
                ${generateEditableField('actual_end', t.TASK_ID, 'Actual End', t.ACTUAL_END, t.ACTUAL_END ? format_date_local(t.ACTUAL_END) : '')}
            </td>
            <td>
                ${generateEditableField('status', t.TASK_ID, 'Status', t.STATUS, t.STATUS_NAME)}
            </td>
            <td>
                ${generateEditableField('complexity', t.TASK_ID, 'Complexity', t.COMPLEXITY, t.COMPLEXITY_NAME)}
            </td>
            <td>
                ${generateEditableField('priority', t.TASK_ID, 'Priority', t.PRIORITY, t.PRIORITY_NAME)}
            </td>
            <td>
                ${generateEditableField('plan_hour', t.TASK_ID, 'Plan Hour', t.PLAN_HOUR, t.PLAN_HOUR)}
            </td>
            <td>
                ${generateEditableField('actual_hour', t.TASK_ID, 'Actual Hour', t.ACTUAL_HOUR, t.ACTUAL_HOUR)}
            </td>
            <td>
                ${t.HEAT_TASK ? Number(t.HEAT_TASK).toFixed(1) : ''}
            </td>
            <td class="text-center">
                ${canEditAll
                    ? `<em class="icon ni ni-trash text-danger cursor-pointer"
                           title="Delete Task" onclick="delete_task('${t.ID}')"></em>`
                    : ''}
            </td>
        </tr>
    `;
        });
        document.getElementById('taskTbody').innerHTML = tbodyHtml;
        setTimeout(() => {
            if ($.fn.DataTable.isDataTable('#taskTable')) {
                $('#taskTable').DataTable().destroy();
            }
            $('#taskTable').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: false,
                autoWidth: false,
                ordering: true,
                pageLength: 10,
                dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                buttons: ['copy', 'excel', 'csv', 'pdf'],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    search: "Search:",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                columnDefs: [
                    { targets: '_all', className: 'text-nowrap' }
                ]
            });
        }, 100);
    }

    function calculateKPIStatus(task) {
        if (!task.ACTUAL_START) {
            return { class: '', tooltip: 'Not Started - Belum dimulai' };
        }
        if (task.ACTUAL_START) {
            const planEnd = task.PLAN_END ? new Date(task.PLAN_END) : null;
            const actualEnd = task.ACTUAL_END ? new Date(task.ACTUAL_END) : null;
            if (actualEnd && planEnd) {
                if (actualEnd > planEnd) {
                    return { class: 'kpi-delayed', tooltip: 'Delayed - Actual End melebihi Plan End' };
                } else {
                    return { class: 'kpi-on-track', tooltip: 'On Track - Selesai sesuai atau lebih cepat dari rencana' };
                }
            }
            return { class: 'kpi-in-progress', tooltip: 'In Progress - Sedang berjalan' };
        }
        return { class: '', tooltip: 'Not Started - Belum dimulai' };
    }

    function updateKPIStatus(row) {
        const taskId = row.querySelector('[data-type]').dataset.id;
        const task = allTasks.find(t => t.TASK_ID == taskId);
        if (task) {
            const kpiStatus = calculateKPIStatus(task);
            const kpiCell = row.querySelector('td:nth-child(5)');
            if (kpiCell) {
                kpiCell.innerHTML = kpiStatus.class ? `<span class="kpi-status ${kpiStatus.class}" title="${kpiStatus.tooltip}"></span>` : '';
            }
        }
    }

    function add_task(icon) {
        const fieldType = icon.dataset.type;
        const fieldLabel = icon.dataset.label;
        const currentValue = icon.dataset.current;
        const taskId = icon.dataset.id;
        const row = $(icon).closest('tr').hasClass('child') ? $(icon).closest('tr').prev() : $(icon).closest('tr');
        const milestoneTask = row.find('td:nth-child(2)').text().trim();
        const isFromIcon = icon.classList.contains('ni-edit');
        const fullTitle = `${isFromIcon ? '' : 'Edit '}${fieldLabel} - ${milestoneTask}`;
        document.getElementById('editSingleFieldModalLabel').textContent = fullTitle;
        document.getElementById('task_id').value = taskId;
        document.getElementById('field_type').value = fieldType;
        const container = document.getElementById('field-input-container');
        container.innerHTML = '';
        let inputField = '';
        if (fieldType === 'responsible') {
            let options = `<option value="" disabled ${!currentValue ? 'selected' : ''}>-- Select Responsible --</option>`;
            @foreach ($responsible as $r)
                options += `<option value="{{ $r->NPK }}" ${currentValue == "{{ $r->NPK }}" ? 'selected' : ''}>{{ $r->EMP_NAME }}</option>`;
            @endforeach
            inputField = `<label class="form-label">${fieldLabel}</label><select class="form-control" name="responsible" required>${options}</select>`;
        } else if (fieldType === 'status') {
            let options = `<option value="" disabled ${!currentValue ? 'selected' : ''}>-- Select Status --</option>`;
            @foreach ($lov_status as $s)
                options += `<option value="{{ $s->LOV_ID }}" ${currentValue == "{{ $s->LOV_ID }}" ? 'selected' : ''}>{{ $s->DESCRIPTION }}</option>`;
            @endforeach
            inputField = `<label class="form-label">${fieldLabel}</label><select class="form-control" name="status" id="statusSelect" required>${options}</select><div id="completedWarning" class="alert alert-warning mt-2 d-none"><small><strong>Status Completed membutuhkan dokumentasi:</strong><br>- Task detail wajib diisi<br>- File dokumentasi wajib diupload</small></div>`;
        } else if (fieldType === 'complexity') {
            let options = `<option value="" disabled ${!currentValue ? 'selected' : ''}>-- Select Complexity --</option>`;
            @foreach ($lov_complexity as $s)
                options += `<option value="{{ $s->LOV_ID }}" ${currentValue == "{{ $s->LOV_ID }}" ? 'selected' : ''}>{{ $s->DESCRIPTION }}</option>`;
            @endforeach
            inputField = `<label class="form-label">${fieldLabel}</label><select class="form-control" name="complexity" required>${options}</select>`;
        } else if (fieldType === 'priority') {
            let options = `<option value="" disabled ${!currentValue ? 'selected' : ''}>-- Select Priority --</option>`;
            @foreach ($lov_priority as $s)
                options += `<option value="{{ $s->LOV_ID }}" ${currentValue == "{{ $s->LOV_ID }}" ? 'selected' : ''}>{{ $s->DESCRIPTION }}</option>`;
            @endforeach
            inputField = `<label class="form-label">${fieldLabel}</label><select class="form-control" name="priority" required>${options}</select>`;
        } else if (fieldType === 'is_milestone') {
            let options = `<option value="" disabled ${!currentValue ? 'selected' : ''}>-- Select Category --</option>`;
            @foreach ($lov_is_milestone as $m)
                options += `<option value="{{ $m->LOV_ID }}" ${currentValue == "{{ $m->LOV_ID }}" ? 'selected' : ''}>{{ $m->DESCRIPTION }}</option>`;
            @endforeach
            inputField = `<label class="form-label">${fieldLabel}</label><select class="form-control" name="is_milestone" required>${options}</select>`;
        } else if (fieldType === 'actual_progress') {
            let options = `<option value="" disabled ${!currentValue ? 'selected' : ''}>-- Select Progress --</option>`;
            @foreach ($lov_actual_progress as $p)
                options += `<option value="{{ $p->LOV_ID }}" ${currentValue == "{{ $p->LOV_ID }}" ? 'selected' : ''}>{{ $p->DESCRIPTION }}</option>`;
            @endforeach
            inputField = `<label class="form-label">${fieldLabel}</label><div class="input-group"><select class="form-control" name="actual_progress" required>${options}</select><span class="input-group-text">%</span></div>`;
        } else if (fieldType === 'plan_start') {
            inputField = `<label class="form-label">${fieldLabel}</label><input type="date" class="form-control" name="plan_start" value="${currentValue ? currentValue.split(' ')[0] : ''}" required>`;
        } else if (fieldType === 'plan_duration') {
            inputField = `<label class="form-label">${fieldLabel}</label><input type="number" min="0" class="form-control" name="plan_duration" value="${currentValue ?? ''}" required>`;
        } else if (fieldType === 'actual_start') {
            inputField = `<label class="form-label">${fieldLabel}</label><input type="date" class="form-control" name="actual_start" value="${currentValue ? currentValue.split(' ')[0] : ''}" id="actual_start_input" required>`;
        } else if (fieldType === 'actual_end') {
            inputField = `<label class="form-label">${fieldLabel}</label><input type="date" class="form-control" name="actual_end" value="${currentValue ? currentValue.split(' ')[0] : ''}" id="actual_end_input" required>`;
        } else if (fieldType === 'actual_duration') {
            inputField = `<label class="form-label">${fieldLabel} (Auto-calculated)</label><input type="number" min="0" class="form-control" name="actual_duration" value="${currentValue ?? ''}" readonly style="background-color: #f8f9fa;"><small class="text-muted mt-1">Duration dihitung otomatis dari Actual Start dan Actual End</small>`;
        } else if (fieldType.includes('hour')) {
            inputField = `<label class="form-label">${fieldLabel}</label><input type="number" min="0" step="0.1" class="form-control" name="${fieldType}" value="${currentValue || ''}" required>`;
        } else if (fieldType === 'remark') {
            openRemarksModal(taskId, milestoneTask, currentValue);
            return;
        } else {
            inputField = `<label class="form-label">${fieldLabel}</label><textarea class="form-control" name="${fieldType}" rows="3" required>${currentValue || ''}</textarea>`;
        }
        container.innerHTML = inputField;
        if (fieldType === 'actual_start' || fieldType === 'actual_end') {
            setTimeout(() => {
                const actualStartInput = document.getElementById('actual_start_input');
                const actualEndInput = document.getElementById('actual_end_input');
                if (actualStartInput && actualEndInput) {
                    if (actualStartInput.value && actualEndInput) {
                        actualEndInput.min = actualStartInput.value;
                    }
                    actualStartInput.addEventListener('change', function () {
                        if (actualEndInput) {
                            actualEndInput.min = this.value;
                        }
                    });
                }
            }, 100);
        }
    }

    function openRemarksModal(taskId, milestoneTask, currentValue, fromStatusUpdate = false) {
        const projectId = document.getElementById('remarks_project_id').value;
        document.getElementById('remarksModalTitle').textContent = `Documentation - ${milestoneTask}`;
        document.getElementById('remarks_task_id').value = taskId;
        document.getElementById('remarks_activity').value = milestoneTask;
        document.getElementById('remark_text').value = currentValue || '';
        document.getElementById('file_chosen').textContent = 'No file chosen';
        document.getElementById('activity_file').value = '';
        document.getElementById('editRemarksModal').dataset.fromStatusUpdate = fromStatusUpdate;
        const isFromStatusUpdate = fromStatusUpdate === true;
        if (isFromStatusUpdate) {
            document.getElementById('fileRequiredLabel').classList.remove('d-none');
            document.getElementById('fileOptionalLabel').classList.add('d-none');
            document.getElementById('fileRequiredWarning').classList.remove('d-none');
            document.getElementById('activity_file').required = true;
        } else {
            document.getElementById('fileRequiredLabel').classList.add('d-none');
            document.getElementById('fileOptionalLabel').classList.remove('d-none');
            document.getElementById('fileRequiredWarning').classList.add('d-none');
            document.getElementById('activity_file').required = false;
        }
        loadActivityHistory(projectId, taskId);
        $('#editRemarksModal').modal('show');
    }

    function loadActivityHistory(projectId, taskId) {
        let url = `/pm/activity-history/${projectId}/${taskId}`;
        document.getElementById('activityHistory').innerHTML = `<tr><td colspan="4" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary me-2"></div>Loading history...</td></tr>`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                let rows = '';
                if (data.length === 0) {
                    rows = `<tr><td colspan="4" class="text-center text-muted py-3"><em class="icon ni ni-info me-1"></em> No history yet</td></tr>`;
                } else {
                    data.forEach(item => {
                        let fileHtml = '-';
                        if (item.docs && item.docs.length > 0) {
                            fileHtml = item.docs.map(doc => {
                                let displayName = doc.CLIENT_NAME;
                                if (displayName.length > 15) {
                                    displayName = displayName.substring(0, 12) + '...';
                                }
                                return `<a href="/${doc.FULL_PATH}" target="_blank" title="${doc.CLIENT_NAME}" class="text-primary d-block text-truncate" style="max-width: 140px;">${displayName}</a>`;
                            }).join('');
                        }
                        let taskDetail = item.task_det || '-';
                        if (taskDetail.length > 50) {
                            taskDetail = taskDetail.substring(0, 47) + '...';
                        }
                        rows += `<tr><td>${item.inputby || '-'}</td><td>${item.sysdate1 ? item.sysdate1.split(' ')[0] : '-'}</td><td title="${item.task_det || ''}">${taskDetail}</td><td>${fileHtml}</td></tr>`;
                    });
                }
                document.getElementById('activityHistory').innerHTML = rows;
            })
            .catch(err => {
                console.error("History load error:", err);
                document.getElementById('activityHistory').innerHTML = `<tr><td colspan="4" class="text-center text-danger py-3"><em class="icon ni ni-warning me-1"></em> Failed to load history</td></tr>`;
            });
    }

    function submit_task_add(form) {
        const formData = new FormData(form);
        const fieldType = formData.get('field_type');
        const selectedStatus = formData.get('status');
        const statusSelect = form.querySelector('#statusSelect');
        let isCompletedStatus = false;
        if (statusSelect) {
            const selectedOption = statusSelect.options[statusSelect.selectedIndex];
            isCompletedStatus = selectedStatus === 'COMPLETED' || selectedOption.text.toUpperCase().includes('COMPLETED');
        }
        if (isCompletedStatus) {
            const taskId = formData.get('task_id');
            const row = document.querySelector(`[data-id="${taskId}"][data-type="${fieldType}"]`).closest('tr');
            const milestoneTask = row.querySelector('td:nth-child(2)').textContent.trim();
            window.pendingStatusUpdate = { taskId: taskId, status: selectedStatus, formData: formData };
            openRemarksModal(taskId, milestoneTask, '', true);
            $('#editSingleFieldModal').modal('hide');
            return;
        }
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        submitBtn.disabled = true;
        fetch(`/zzz_task_add`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Updated!', text: res.message, timer: 1000, showConfirmButton: false });
                    $('#editSingleFieldModal').modal('hide');
                    const taskId = formData.get('task_id');
                    const fieldType = formData.get('field_type');
                    const newValue = formData.get(fieldType);
                    const cell = document.querySelector(`[data-id="${taskId}"][data-type="${fieldType}"]`);
                    const row = cell.closest('tr');
                    if (cell) {
                        let displayValue = newValue;
                        if (fieldType === 'status') {
                            const statusMapping = @json($lov_status->keyBy('LOV_ID'));
                            if (statusMapping[newValue]) {
                                displayValue = statusMapping[newValue].DESCRIPTION;
                            }
                        }
                        if ((fieldType === 'plan_start' || fieldType === 'actual_start' || fieldType === 'actual_end') && newValue) {
                            displayValue = format_date_local(newValue);
                        } else if (fieldType === 'actual_progress') {
                            displayValue = newValue + '%';
                        }
                        if (cell.classList.contains('editable-field')) {
                            cell.textContent = displayValue;
                            cell.dataset.current = newValue;
                        } else {
                            cell.outerHTML = `<span class="editable-field cursor-pointer" data-type="${fieldType}" data-id="${taskId}" data-label="${cell.dataset.label}" data-current="${newValue}" data-bs-toggle="modal" data-bs-target="#editSingleFieldModal">${displayValue}</span>`;
                        }
                        updateTaskInAllTasks(taskId, fieldType, newValue);
                        update_left_join(row, fieldType, newValue);
                        if (fieldType === 'actual_start' || fieldType === 'actual_end') {
                            const actualStart = fieldType === 'actual_start' ? newValue : row.querySelector('[data-type="actual_start"]')?.dataset.current;
                            const actualEnd = fieldType === 'actual_end' ? newValue : row.querySelector('[data-type="actual_end"]')?.dataset.current;
                            if (actualStart && actualEnd) {
                                const actualDuration = calculate_working_days(actualStart, actualEnd);
                                updateTaskInAllTasks(taskId, 'actual_duration', actualDuration);
                                const actualDurationCell = row.querySelector('td:nth-child(11)');
                                if (actualDurationCell) {
                                    actualDurationCell.textContent = actualDuration;
                                }
                                const planHour = row.querySelector('[data-type="plan_hour"]')?.dataset.current;
                                if (planHour && actualDuration > 0) {
                                    const heatTask = (parseFloat(planHour) / actualDuration).toFixed(1);
                                    const heatTaskCell = row.querySelector('td:nth-child(18)');
                                    if (heatTaskCell) {
                                        heatTaskCell.textContent = heatTask;
                                    }
                                    updateTaskInAllTasks(taskId, 'heat_task', heatTask);
                                }
                            }
                        }
                        if (fieldType === 'plan_start' || fieldType === 'plan_duration') {
                            const planStart = fieldType === 'plan_start' ? newValue : row.querySelector('[data-type="plan_start"]')?.dataset.current;
                            const planDuration = fieldType === 'plan_duration' ? newValue : row.querySelector('[data-type="plan_duration"]')?.dataset.current;
                            if (planStart && planDuration) {
                                const planEnd = working_day(planStart, parseInt(planDuration));
                                updateTaskInAllTasks(taskId, 'plan_end', planEnd);
                                const planEndCell = row.querySelector('td:nth-child(9)');
                                if (planEndCell) {
                                    planEndCell.textContent = format_date_local(planEnd);
                                }
                            }
                        }
                        updateKPIStatus(row);
                        if (fieldType === 'is_milestone') {
                            updateMilestoneTaskStyling(row, newValue);
                        }
                        if (fieldType === 'status') {
                            total_persentase_realtime();
                        }
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            })
            .catch(err => { Swal.fire({ icon: 'error', title: 'Request Failed', text: err.message }); })
            .finally(() => { submitBtn.innerHTML = originalText; submitBtn.disabled = false; });
    }

    function submitRemarksForm(form) {
        const fd = new FormData(form);
        const isFromStatusUpdate = document.getElementById('editRemarksModal').dataset.fromStatusUpdate === 'true';
        if (isFromStatusUpdate) {
            const fileInput = document.getElementById('activity_file');
            if (!fileInput.files || fileInput.files.length === 0) {
                Swal.fire({ icon: 'error', title: 'File Required', text: 'Dokumentasi wajib diupload untuk status Completed' });
                form.querySelector('button[type="submit"]').disabled = false;
                form.querySelector('button[type="submit"]').innerHTML = 'Save changes';
                return;
            }
        }
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Saving...';
        fetch('/zzz_activity_add', { method: 'POST', body: fd })
            .then(res => res.json())
            .then(res => {
                if (!res.success) throw new Error(res.message);
                if (isFromStatusUpdate && window.pendingStatusUpdate) {
                    updateStatusAfterRemarks(window.pendingStatusUpdate);
                } else {
                    Swal.fire({ icon: 'success', title: 'Saved!', text: 'Activity Log berhasil disimpan', timer: 1200, showConfirmButton: false });
                    $('#editRemarksModal').modal('hide');
                    const taskId = document.getElementById('remarks_task_id').value;
                    const taskDet = document.getElementById('remark_text').value;
                    const cell = document.querySelector(`[data-id="${taskId}"][data-type="remark"]`);
                    if (cell) {
                        cell.innerHTML = taskDet || '<em class="icon ni ni-edit text-primary"></em>';
                        cell.dataset.current = taskDet || '';
                    }
                }
            })
            .catch(err => { Swal.fire({ icon: 'error', title: 'Error', text: err.message }); })
            .finally(() => { submitBtn.disabled = false; submitBtn.innerHTML = 'Save changes'; });
    }

    function updateStatusAfterRemarks(pendingUpdate) {
        const formData = new FormData();
        formData.append('task_id', pendingUpdate.taskId);
        formData.append('field_type', 'status');
        formData.append('status', pendingUpdate.status);
        formData.append('project_id', pendingUpdate.formData.get('project_id'));
        formData.append('_token', '{{ csrf_token() }}');
        fetch(`/zzz_task_add`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Completed!', text: 'Status berhasil diupdate ke Completed dengan dokumentasi', timer: 1500, showConfirmButton: false });
                    $('#editRemarksModal').modal('hide');
                    const cell = document.querySelector(`[data-id="${pendingUpdate.taskId}"][data-type="status"]`);
                    const row = cell.closest('tr');
                    if (cell) {
                        let displayValue = pendingUpdate.status;
                        const statusMapping = @json($lov_status->keyBy('LOV_ID'));
                        if (statusMapping[pendingUpdate.status]) {
                            displayValue = statusMapping[pendingUpdate.status].DESCRIPTION;
                        }
                        if (cell.classList.contains('editable-field')) {
                            cell.textContent = displayValue;
                            cell.dataset.current = pendingUpdate.status;
                        } else {
                            cell.outerHTML = `<span class="editable-field cursor-pointer" data-type="status" data-id="${pendingUpdate.taskId}" data-label="${cell.dataset.label}" data-current="${pendingUpdate.status}" data-bs-toggle="modal" data-bs-target="#editSingleFieldModal">${displayValue}</span>`;
                        }
                        calculate_duration(row, 'status', pendingUpdate.status, res.heat_task, res.plan_end, res.actual_end);
                    }
                    updateTaskInAllTasks(pendingUpdate.taskId, 'status', pendingUpdate.status);
                    total_persentase_realtime();
                } else {
                    throw new Error(res.message);
                }
            })
            .catch(err => { Swal.fire({ icon: 'error', title: 'Error', text: 'Status berhasil Completed tetapi gagal update UI: ' + err.message }); })
            .finally(() => { window.pendingStatusUpdate = null; });
    }

    const allTasks = @json($tasks);

    function total_persentase() {
        const tasks = allTasks;
        const totalTasks = tasks.length;
        const completedTasks = tasks.filter(t => t.STATUS === 'COMPLETED' || (typeof t.STATUS_NAME === 'string' && t.STATUS_NAME.toUpperCase().includes('COMPLETED'))).length;
        const projectProgress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
        updateProgressUI(projectProgress, totalTasks, completedTasks);
    }

    function total_persentase_realtime() {
        const tasks = allTasks;
        const totalTasks = tasks.length;
        let completedTasks = 0;
        tasks.forEach((task) => {
            const statusValue = task.STATUS;
            const statusText = task.STATUS_NAME || '';
            const isCompleted = statusValue === 'COMPLETED' || (typeof statusText === 'string' && statusText.toUpperCase().includes('COMPLETED')) || statusValue === 'CLOSED' || (typeof statusText === 'string' && statusText.toUpperCase().includes('CLOSED'));
            if (isCompleted) {
                completedTasks++;
            }
        });
        const projectProgress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
        updateProgressUI(projectProgress, totalTasks, completedTasks);
    }

function updateTaskInAllTasks(taskId, field, value) {
    const taskIndex = allTasks.findIndex(t => t.TASK_ID == taskId);
    if (taskIndex !== -1) {
        const upperField = field.toUpperCase();
        allTasks[taskIndex][upperField] = value;
        if (field === 'status') {
            const lovStatus = @json($lov_status->keyBy('LOV_ID'));
            if (lovStatus[value]) {
                allTasks[taskIndex].STATUS_NAME = lovStatus[value].DESCRIPTION;
            }
        }
    }
}

    function updateProgressUI(progress, total, completed) {
        const progressBar = document.getElementById('projectProgressBar');
        if (progressBar) {
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.className = `progress-bar ${progress === 100 ? 'bg-success' : 'bg-primary'}`;
        }
        const progressText = document.getElementById('projectProgressText');
        if (progressText) {
            progressText.textContent = `${progress}% (${completed}/${total} tasks completed)`;
        }
        const progressPercent = document.getElementById('projectProgressPercent');
        if (progressPercent) {
            progressPercent.textContent = `${progress}%`;
        }
        const totalTasksElement = document.getElementById('totalTasks');
        if (totalTasksElement) {
            totalTasksElement.textContent = total;
        }
        const completedTasksElement = document.getElementById('completedTasks');
        if (completedTasksElement) {
            completedTasksElement.textContent = completed;
        }
    }

    function delete_task(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "This task will be deleted permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/zzz_task_delete/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 1000, showConfirmButton: false });
                            const rowToDelete = document.querySelector(`tr[data-row-id="${id}"]`);
                            if (rowToDelete) {
                                const table = $('#taskTable').DataTable();
                                table.row($(rowToDelete)).remove().draw(false);
                                table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                                    const dataRow = this.node();
                                    $(dataRow).find('td:first').text(rowIdx + 1);
                                });
                                setTimeout(total_persentase, 100);
                            } else {
                                f_autoload();
                            }
                            const taskIndex = allTasks.findIndex(t => t.ID == id);
                            if (taskIndex !== -1) {
                                allTasks.splice(taskIndex, 1);
                            }
                            setTimeout(total_persentase_realtime, 100);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                    })
                    .catch(err => { Swal.fire({ icon: 'error', title: 'Request Failed', text: err.message }); });
            }
        });
    }

    function format_date_local(dateString) {
        if (!dateString) return '';
        if (typeof dateString === 'string' && dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
            return dateString;
        }
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function calculate_duration(row, changedField, newValue, heatTaskFromServer = null, planEndFromServer = null, actualEndFromServer = null, actualDurationFromServer = null) {
        const cells = row.querySelectorAll('td');
        const getFieldValue = (fieldType) => {
            const cell = row.querySelector(`[data-type="${fieldType}"]`);
            return cell ? cell.dataset.current : '';
        };
        const planEndCell = row.querySelector('td:nth-child(9)');
        if (planEndFromServer) {
            planEndCell.textContent = format_date_local(planEndFromServer);
        } else {
            const planStart = getFieldValue('plan_start');
            const planDuration = getFieldValue('plan_duration');
            if (planStart && planDuration) {
                const planEnd = working_day(planStart, parseInt(planDuration));
                planEndCell.textContent = planEnd;
            }
        }
        const actualStart = getFieldValue('actual_start');
        const actualEndCell = row.querySelector('td:nth-child(12)');
        const actualDurationCell = row.querySelector('td:nth-child(11)');
        if (changedField === 'actual_end' || changedField === 'actual_start') {
            const actualEnd = changedField === 'actual_end' ? newValue : actualEndCell.textContent;
            if (actualStart && actualEnd) {
                const actualDuration = calculate_working_days(actualStart, actualEnd);
                if (actualDurationCell) {
                    actualDurationCell.textContent = actualDuration;
                }
                actualEndCell.textContent = format_date_local(actualEnd);
                const taskId = row.querySelector('[data-type]').dataset.id;
                updateTaskInAllTasks(taskId, 'actual_duration', actualDuration);
            }
        } else if (actualDurationFromServer !== null) {
            if (actualDurationCell) {
                actualDurationCell.textContent = actualDurationFromServer;
            }
        }
        const planHour = getFieldValue('plan_hour');
        const actualDurationValue = actualDurationCell ? parseInt(actualDurationCell.textContent) : 0;
        let heatTask = null;
        if (heatTaskFromServer !== null) {
            heatTask = heatTaskFromServer;
        } else if (planHour && actualDurationValue > 0) {
            heatTask = (parseFloat(planHour) / actualDurationValue).toFixed(1);
        }
        if (cells[17] && heatTask !== null) {
            cells[17].textContent = heatTask;
        }
        updateKPIStatus(row);
    }

    function calculate_working_days(startDate, endDate) {
        if (!startDate || !endDate) return 0;
        const start = new Date(startDate);
        const end = new Date(endDate);
        if (end < start) return 0;
        let count = 0;
        const current = new Date(start);
        while (current <= end) {
            const day = current.getDay();
            const dateString = current.toISOString().split('T')[0];
            const isWeekend = (day === 0 || day === 6);
            const isHoliday = holidays.includes(dateString);
            if (!isWeekend && !isHoliday) {
                count++;
            }
            current.setDate(current.getDate() + 1);
        }
        return count;
    }

    const holidays = @json($holidays);

    function working_day(startDate, duration) {
        if (!startDate || !duration) return '';
        const date = new Date(startDate);
        const result = new Date(date);
        let addedDays = 0;
        while (addedDays < duration - 1) {
            result.setDate(result.getDate() + 1);
            const day = result.getDay();
            const dateString = result.toISOString().split('T')[0];
            const isWeekend = (day === 0 || day === 6);
            const isHoliday = holidays.includes(dateString);
            if (!isWeekend && !isHoliday) {
                addedDays++;
            }
        }
        const year = result.getFullYear();
        const month = String(result.getMonth() + 1).padStart(2, '0');
        const day = String(result.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function update_left_join(row, changedField, newValue) {
        const lovData = {
            status: @json($lov_status->keyBy('LOV_ID')),
            complexity: @json($lov_complexity->keyBy('LOV_ID')),
            priority: @json($lov_priority->keyBy('LOV_ID')),
            is_milestone: @json($lov_is_milestone->keyBy('LOV_ID')),
            actual_progress: @json($lov_actual_progress->keyBy('LOV_ID')),
            responsible: @json($responsible->keyBy('NPK'))
        };
        const fieldMappings = {
            'status': { data: lovData.status, suffix: '' },
            'complexity': { data: lovData.complexity, suffix: '' },
            'priority': { data: lovData.priority, suffix: '' },
            'is_milestone': { data: lovData.is_milestone, suffix: '' },
            'actual_progress': { data: lovData.actual_progress, suffix: '%' },
            'responsible': { data: lovData.responsible, suffix: '' }
        };
        if (fieldMappings[changedField]) {
            const mapping = fieldMappings[changedField];
            const displayData = mapping.data[newValue];
            if (displayData) {
                const displayValue = displayData.DESCRIPTION || displayData.EMP_NAME || newValue;
                const cell = row.querySelector(`[data-type="${changedField}"]`);
                if (cell && cell.classList.contains('editable-field')) {
                    cell.textContent = displayValue + mapping.suffix;
                }
            }
        }
        if (changedField === 'is_milestone') {
            updateMilestoneTaskStyling(row, newValue);
        }
    }

    function updateMilestoneTaskStyling(row, categoryValue) {
        const milestoneTaskCell = row.querySelector('td:nth-child(2)');
        milestoneTaskCell.classList.remove('milestone-task-subactivity', 'milestone-task-activity', 'milestone-task-milestone');
        if (categoryValue === '70') {
            milestoneTaskCell.classList.add('milestone-task-subactivity');
        } else if (categoryValue === '21') {
            milestoneTaskCell.classList.add('milestone-task-activity');
        } else if (categoryValue === '20') {
            milestoneTaskCell.classList.add('milestone-task-milestone');
        }
    }

    function submit_milestone_add(form) {
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
        submitBtn.disabled = true;
        fetch(`/zzz_task_add_milestone`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success!', text: res.message, timer: 1500, showConfirmButton: false }).then(() => {
                        form.reset();
                        $('#addMilestoneModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            })
            .catch(err => { Swal.fire({ icon: 'error', title: 'Request Failed', text: err.message }); })
            .finally(() => { submitBtn.innerHTML = originalText; submitBtn.disabled = false; });
    }
</script>