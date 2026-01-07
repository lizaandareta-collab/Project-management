<style>
    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1020;
        /* 🔥 di atas semua isi modal */
        border-radius: 6px;
    }
</style>

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                                <h4 class="nk-block-title mb-0">Project Management</h4>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addProjectModal">
                                    <em class="icon ni ni-plus"></em> Add Project
                                </button>
                            </div>
                        </div>

                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init-export nowrap table" data-export-title="Export Project"
                                    data-ordering="false">

                                    <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Responsible</th>
                                            <th>Client</th>
                                            <th>Budget</th>
                                            <th>Start Date</th>
                                            <th>Days</th>
                                            <th>End Date</th>
                                            <!-- <th>Complexity</th> -->
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($projects as $p) { ?>
                                        <tr>
                                            <td><?= $p->project_name ?></td>
                                            <td><?= $p->responsible ?></td>
                                            <td><?= $p->client ?></td>
                                            <td>Rp <?= number_format($p->budget, 0, ',', '.') ?></td>
                                            <td><?= date('Y-m-d', strtotime($p->start_date)) ?></td>
                                            <td><?= $p->days ?></td>
                                            <td><?= date('Y-m-d', strtotime($p->end_date)) ?></td>
                                            <!-- <td><?= $p->complexity ?></td> -->
                                            <td><?= $p->priority ?></td>
                                            <td><?= $p->status ?></td>
                                            <td>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                        data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="{{ route('projectdash', ['id' => $p->id]) }}">
                                                                    <em class="icon ni ni-eye"></em><span>Project
                                                                        Dashboard</span></a></li>
                                                            <li><a href="{{ route('task', ['id' => $p->id]) }}">
                                                                    <em class="icon ni ni-eye"></em><span>Task
                                                                        Management</span></a></li>
                                                            <li><a href="{{ route('trial', ['id' => $p->id]) }}">
                                                                    <em class="icon ni ni-eye"></em><span>Trial
                                                                        Record</span></a></li>
                                                            <li><a href="{{ route('problem', ['id' => $p->id]) }}">
                                                                    <em class="icon ni ni-eye"></em><span>Problem
                                                                        History</span></a></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Project -->
<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content position-relative">
            <div id="addProjectOverlay" class="modal-overlay d-none"></div>
            <form id="formProject">
                <div class="modal-header">
                    <h5 class="modal-title">Add Project</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>

                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" name="project_name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Responsible</label>
                            <select class="form-control" name="responsible" required>
                                <option value="" disabled selected>-- Select Responsible --</option>
                                <?php foreach ($responsible as $a) { ?>
                                <option value="<?= $a->npk ?>"><?= $a->emp_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Client</label>
                            <select class="form-control" name="client" required>
                                <option value="" disabled selected>-- Select Client --</option>
                                <!-- <?php foreach ($client as $b) { ?>
                                <option value="<?= $b->client_ora ?>"><?= $b->name ?></option>
                                <?php } ?> -->

                                <?php foreach ($client as $b) { ?>
                                <?php    if ($b->client_ora) { ?>
                                <option value="<?= $b->client_ora ?>"><?= $b->name ?></option>
                                <?php    } ?>
                                <?php } ?>

                            </select>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Budget</label>
                            <input type="number" class="form-control" name="budget" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Days (Auto)</label>
                            <input type="number" class="form-control" name="days" readonly>
                        </div>

                        <!-- <div class="col-md-6">
                            <label class="form-label">Complexity</label>
                            <select class="form-control" name="complexity" required>
                                <option value="" disabled selected>-- Select Complexity --</option>
                                <?php foreach ($lov_complexity as $c) { ?>
                                <option value="<?= $c->lov_id ?>"><?= $c->description ?></option>
                                <?php } ?>
                            </select>
                        </div> -->

                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <select class="form-control" name="priority" required>
                                <option value="" disabled selected>-- Select Priority --</option>
                                <?php foreach ($lov_priority as $p) { ?>
                                <option value="<?= $p->lov_id ?>"><?= $p->description ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="" disabled selected>-- Select Status --</option>
                                <?php foreach ($lov_status as $s) { ?>
                                <option value="<?= $s->lov_id ?>"><?= $s->description ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Flow Process</label>
                            <div class="row g-2">

                                <?php foreach ($lov_process as $proc) { ?>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input process-checkbox"
                                            id="proc_<?= $proc->lov_id ?>" data-lov-id="<?= $proc->lov_id ?>"
                                            data-init="process">

                                        <label class="custom-control-label" for="proc_<?= $proc->lov_id ?>">
                                            <?= $proc->description ?>
                                        </label>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer d-flex">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditStatus">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Status</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="project_name" id="editProjectName">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" id="editStatusSelect" required>
                            <option value="" disabled selected>-- Select Status --</option>
                            <?php foreach ($lov_status as $s) { ?>
                            <option value="<?= $s->description ?>"><?= $s->description ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Input Standard Process Value -->
<div class="modal fade" id="stdValueModal" tabindex="-1" data-bs-backdrop="false">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formStdValue">
                <div class="modal-header">
                    <h5 class="modal-title">Standard Process Value</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="std_process_id">

                    <div class="mb-3">
                        <label class="form-label">OK Ratio Target (%)</label>
                        <input type="number" class="form-control std-value" data-stdproc="77">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CT Target (second)</label>
                        <input type="number" class="form-control std-value" data-stdproc="78">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Berat Target (kg - 2 angka dibelakang koma)</label>
                        <input type="number" class="form-control std-value" data-stdproc="79">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const holidayList = @json($holiday);
    document.addEventListener('DOMContentLoaded', function () {
        // === AUTO HITUNG END DATE ===
        const startInput = document.querySelector('input[name="start_date"]');
        const daysInput = document.querySelector('input[name="days"]');
        const endInput = document.querySelector('input[name="end_date"]');

        // function update_end_date() {
        //     const startDate = new Date(startInput.value);
        //     const days = parseInt(daysInput.value);

        //     if (!isNaN(startDate) && !isNaN(days)) {
        //         const endDate = new Date(startDate);
        //         endDate.setDate(startDate.getDate() + days);
        //         endInput.value = endDate.toISOString().split('T')[0];
        //     } else {
        //         endInput.value = '';
        //     }
        // }

        function update_days() {
            const startDate = new Date(startInput.value);
            const endDate = new Date(endInput.value);

            if (isNaN(startDate) || isNaN(endDate) || endDate < startDate) {
                daysInput.value = '';
                return;
            }

            let count = 0;
            let current = new Date(startDate);

            while (current <= endDate) {

                const day = current.getDay();
                const formatted = current.toISOString().split('T')[0];

                const isWeekend = (day === 0 || day === 6);
                const isHoliday = holidayList.includes(formatted);

                if (!isWeekend && !isHoliday) {
                    count++;
                }

                current.setDate(current.getDate() + 1);
            }

            daysInput.value = count;
        }


        startInput.addEventListener('change', update_days);
        endInput.addEventListener('change', update_days);


        const form = document.getElementById('formProject');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch("{{ route('zzz_project') }}", {
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
                    Swal.fire('Error', 'Failed to save project', 'error');
                });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.process-checkbox').forEach(cb => {
            cb.addEventListener('change', function () {

                fetch("{{ route('zzz_save_process_temp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        lov_id: this.dataset.lovId,
                        init: this.dataset.init,
                        checked: this.checked
                    })
                })
                    .then(res => res.json())
                    .then(res => {
                        if (!res.success) {
                            Swal.fire('Error', res.message, 'error');
                            this.checked = !this.checked;
                            return;
                        }

                        // 🔥 JIKA CHECKED → BUKA MODAL VALUE
                        if (this.checked) {
                            activeProcessCheckbox = this; // 🔥 SIMPAN REFERENSI
                            document.getElementById('std_process_id').value = this.dataset.lovId;
                            new bootstrap.Modal(document.getElementById('stdValueModal')).show();
                        }

                    });
            });

        });

    });

    document.addEventListener('DOMContentLoaded', function () {

        const modal = document.getElementById('addProjectModal');

        modal.addEventListener('hidden.bs.modal', function () {

            document.querySelectorAll('.process-checkbox').forEach(cb => {
                if (cb.checked) {

                    fetch("{{ route('zzz_save_process_temp') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            lov_id: cb.dataset.lovId,
                            init: cb.dataset.init,
                            checked: false   // 🔥 PAKSA DELETE
                        })
                    });

                    cb.checked = false; // reset UI
                }
            });

        });

    });

    document.getElementById('formStdValue').addEventListener('submit', function (e) {
        e.preventDefault();

        let valid = true;

        document.querySelectorAll('.std-value').forEach(input => {
            if (input.value === '') {
                valid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!valid) {
            Swal.fire('Warning', 'All Standard Process Value must be filled!', 'warning');
            return;
        }

        const processId = document.getElementById('std_process_id').value;

        document.querySelectorAll('.std-value').forEach(input => {
            fetch("{{ route('zzz_save_process_temp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    process_id: processId,
                    stdproc_id: input.dataset.stdproc,
                    value: input.value,
                    init: 'stdproc',
                    checked: true
                })
            });

            input.value = '';
        });

        document.getElementById('std_process_id').value = '';
        activeProcessCheckbox = null;

        bootstrap.Modal.getInstance(
            document.getElementById('stdValueModal')
        ).hide();
    });

    document.getElementById('stdValueModal').addEventListener('hidden.bs.modal', function () {

        // jika masih ada checkbox aktif → berarti batal
        if (activeProcessCheckbox) {

            fetch("{{ route('zzz_save_process_temp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    lov_id: activeProcessCheckbox.dataset.lovId,
                    init: 'process',
                    checked: false
                })
            });

            activeProcessCheckbox.checked = false;
            activeProcessCheckbox = null;

            document.querySelectorAll('.std-value').forEach(i => i.value = '');
            document.getElementById('std_process_id').value = '';
        }
    });

    const stdModal = document.getElementById('stdValueModal');
    const overlay = document.getElementById('addProjectOverlay');

    stdModal.addEventListener('show.bs.modal', function () {
        overlay.classList.remove('d-none');
    });

    stdModal.addEventListener('hidden.bs.modal', function () {
        overlay.classList.add('d-none');
    });


</script>