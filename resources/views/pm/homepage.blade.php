<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <div class="components-preview mx-auto w-100">
                    <div class="nk-block-head nk-block-head-lg">
                        <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                            <h2 class="nk-block-title fw-normal">Project Management</h2>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                                <em class="icon ni ni-plus"></em> Add Project
                            </button>
                        </div>
                    </div>

                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init-export nowrap table" data-export-title="Export Project">
                                    <thead>
                                        <tr>
                                            <!-- <th>ID</th> -->
                                            <th>Project Name</th>
                                            <th>Responsible</th>
                                            <th>Client</th>
                                            <th>Budget</th>
                                            <th>Start Date</th>
                                            <th>Days</th>
                                            <th>End Date</th>
                                            <th>Complexity</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($projects as $p) { ?>
                                        <tr>
                                            <!-- <td><?= $p->id ?></td> -->
                                            <td><?= $p->project_name ?></td>
                                            <td><?= $p->responsible ?></td>
                                            <td><?= $p->client ?></td>
                                            <td><?= $p->budget ?></td>
                                            <td><?= date('Y-m-d', strtotime($p->start_date)) ?></td>
                                            <td><?= $p->days ?></td>
                                            <td><?= date('Y-m-d', strtotime($p->end_date)) ?></td>
                                            <td><?= $p->complexity ?></td>
                                            <!-- <td><?= $p->status ?></td> -->
                                            <td><?= $p->priority ?></td>
                                            <td class="editable-status" data-project="<?= $p->project_name ?>">
                                                <?= $p->status ?>
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
        <div class="modal-content">
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
                                <option value="" disabled selected>-- Select Client --</option>
                                <?php foreach ($responsible as $a) { ?>
                                <option value="<?= $a->emp_name ?>"><?= $a->emp_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Client</label>
                            <select class="form-control" name="client" required>
                                <option value="" disabled selected>-- Select Client --</option>
                                <?php foreach ($client as $b) { ?>
                                <option value="<?= $b->name ?>"><?= $b->name ?></option>
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
                            <label class="form-label">Days</label>
                            <input type="number" class="form-control" name="days" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Complexity</label>
                            <select class="form-control" name="complexity" required>
                                <option value="" disabled selected>-- Select Complexity --</option>
                                <?php foreach ($lov_complexity as $c) { ?>
                                <option value="<?= $c->description ?>"><?= $c->description ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <select class="form-control" name="priority" required>
                                <option value="" disabled selected>-- Select Priority --</option>
                                <?php foreach ($lov_priority as $p) { ?>
                                <option value="<?= $p->description ?>"><?= $p->description ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="" disabled selected>-- Select Status --</option>
                                <?php foreach ($lov_status as $s) { ?>
                                <option value="<?= $s->description ?>"><?= $s->description ?></option>
                                <?php } ?>
                            </select>
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
                    <h5 class="modal-title">Edit Status <span id="editProjectTitle"></span></h5>
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
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // === AUTO HITUNG END DATE ===
        const startInput = document.querySelector('input[name="start_date"]');
        const daysInput = document.querySelector('input[name="days"]');
        const endInput = document.querySelector('input[name="end_date"]');

        function updateEndDate() {
            const startDate = new Date(startInput.value);
            const days = parseInt(daysInput.value);

            if (!isNaN(startDate) && !isNaN(days)) {
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + days);
                endInput.value = endDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
            } else {
                endInput.value = ''; // Kosongkan kalau input belum lengkap
            }
        }

        startInput.addEventListener('change', updateEndDate);
        daysInput.addEventListener('input', updateEndDate);

        // === SCRIPT AJAX SIMPAN PROJECT ===
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

    // === KLIK STATUS UNTUK EDIT ===
    document.querySelectorAll('.editable-status').forEach(cell => {
        cell.addEventListener('click', function () {
            const projectName = this.dataset.project;
            const currentStatus = this.textContent.trim();

            // Isi nilai ke modal
            document.getElementById('editProjectName').value = projectName;
            document.getElementById('editStatusSelect').value = currentStatus;

            // Tampilkan nama project di title modal
            document.getElementById('editProjectTitle').textContent = projectName;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('editStatusModal'));
            modal.show();
        });
    });


    // === SIMPAN STATUS BARU VIA AJAX ===
    const formEditStatus = document.getElementById('formEditStatus');
    formEditStatus.addEventListener('submit', function (e) {
        e.preventDefault();

        fetch("{{ route('zzz_updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: new URLSearchParams(new FormData(formEditStatus))
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'Status updated successfully',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Failed to update status', 'error');
            });
    });
</script>