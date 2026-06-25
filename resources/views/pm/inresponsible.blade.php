<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                                <h4 class="nk-block-title mb-0">Resource Management List</h4>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addResourceModal">
                                    <em class="icon ni ni-plus"></em> Add Resource
                                </button>
                            </div>
                        </div>

                        <div class="card card-bordered card-preview mt-3">
                            <div class="card-inner">
                                <table class="datatable-init-export nowrap table" data-ordering="false">
                                    <thead>
                                        <tr>
                                            <th>NPK</th>
                                            <th>Emp Name</th>
                                            <th>Emp Type</th>
                                            <th>Department</th>
                                            <th>Max Hour per Day</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if (!empty($resource)) { ?>
                                        <?php foreach ($resource as $r) { ?>
                                        <tr>
                                            <td><?= $r->NPK ?></td>
                                            <td><?= $r->EMP_NAME ?></td>
                                            <td><?= $r->EMP_TYPE ?></td>
                                            <td><?= $r->DEPARTMENT ?></td>
                                            <td><?= $r->MAX_HOUR ?></td>
                                            <td>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                        data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#" class="edit-resource"
                                                                    data-npk="<?= $r->NPK ?>"
                                                                    data-emp_name="<?= $r->EMP_NAME ?>"
                                                                    data-emp_type_id="<?= $r->EMP_TYPE_ID ?>"
                                                                    data-department_id="<?= $r->DEPARTMENT_ID ?>"
                                                                    data-max_hour="<?= $r->MAX_HOUR ?>">
                                                                    <em class="icon ni ni-edit"></em><span>Edit</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="delete-resource"
                                                                    data-npk="<?= $r->NPK ?>">
                                                                    <em class="icon ni ni-trash"></em><span>Delete</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Resource -->
<div class="modal fade" id="addResourceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formResource">
                <div class="modal-header">
                    <h5 class="modal-title">Add Resource</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>

                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">NPK</label>
                            <input type="text" class="form-control" name="npk" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Employee Name</label>
                            <input type="text" class="form-control" name="emp_name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Employee Type</label>
                            <select class="form-control" name="emp_type" required>
                                <option value="" disabled selected>-- Select Employee Type --</option>
                                <?php if (!empty($lov_emptype)) { ?>
                                <?php foreach ($lov_emptype as $et) { ?>
                                <option value="<?= $et->LOV_ID ?>"><?= $et->DESCRIPTION ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department" required>
                                <option value="" disabled selected>-- Select Department --</option>
                                <?php if (!empty($lov_empdept)) { ?>
                                <?php foreach ($lov_empdept as $dept) { ?>
                                <option value="<?= $dept->LOV_ID ?>"><?= $dept->DESCRIPTION ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Max Hour per Day</label>
                            <input type="number" class="form-control" name="max_hour" required min="1" max="24">
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Resource -->
<div class="modal fade" id="editResourceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditResource">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Resource</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="npk" id="editNpk">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Employee Name</label>
                            <input type="text" class="form-control" name="emp_name" id="editEmpName" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Employee Type</label>
                            <select class="form-control" name="emp_type" id="editEmpType" required>
                                <option value="" disabled selected>-- Select Employee Type --</option>
                                <?php if (!empty($lov_emptype)) { ?>
                                <?php foreach ($lov_emptype as $et) { ?>
                                <option value="<?= $et->LOV_ID ?>"><?= $et->DESCRIPTION ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department" id="editDepartment" required>
                                <option value="" disabled selected>-- Select Department --</option>
                                <?php if (!empty($lov_empdept)) { ?>
                                <?php foreach ($lov_empdept as $dept) { ?>
                                <option value="<?= $dept->LOV_ID ?>"><?= $dept->DESCRIPTION ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Max Hour per Day</label>
                            <input type="number" class="form-control" name="max_hour" id="editMaxHour" required min="1" max="24">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle form submission for add
        const formResource = document.getElementById('formResource');
        if (formResource) {
            formResource.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch("{{ route('insert_resource') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: new URLSearchParams(new FormData(formResource))
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
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Failed to save resource', 'error');
                    });
            });
        }

        // Handle edit button clicks
        document.querySelectorAll('.edit-resource').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const npk = this.getAttribute('data-npk');
                const empName = this.getAttribute('data-emp_name');
                const empTypeId = this.getAttribute('data-emp_type_id');
                const departmentId = this.getAttribute('data-department_id');
                const maxHour = this.getAttribute('data-max_hour');

                document.getElementById('editNpk').value = npk;
                document.getElementById('editEmpName').value = empName;
                document.getElementById('editEmpType').value = empTypeId;
                document.getElementById('editDepartment').value = departmentId;
                document.getElementById('editMaxHour').value = maxHour;

                const editModal = new bootstrap.Modal(document.getElementById('editResourceModal'));
                editModal.show();
            });
        });

        // Handle edit form submission
        const formEditResource = document.getElementById('formEditResource');
        if (formEditResource) {
            formEditResource.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch("{{ route('update_resource') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: new URLSearchParams(new FormData(formEditResource))
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
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Failed to update resource', 'error');
                    });
            });
        }

        // Handle delete button clicks
        document.querySelectorAll('.delete-resource').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const npk = this.getAttribute('data-npk');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('delete_resource') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: new URLSearchParams({ npk: npk })
                        })
                            .then(response => response.json())
                            .then(res => {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error', res.message, 'error');
                                }
                            })
                            .catch(err => {
                                Swal.fire('Error', 'Failed to delete resource', 'error');
                            });
                    }
                });
            });
        });
    });
</script>