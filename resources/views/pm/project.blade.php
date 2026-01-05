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

</script>