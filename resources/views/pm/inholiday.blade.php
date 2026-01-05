<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">
                    <div class="nk-block nk-block-lg">

                        <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                            <h4 class="nk-block-title mb-0">Holiday List</h4>

                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
                                <em class="icon ni ni-plus"></em> Add Holiday
                            </button>
                        </div>
                        
                        <div class="card card-bordered card-preview mt-3">
                            <div class="card-inner">

                                <table class="datatable-init-export nowrap table" data-ordering="false">

                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($holiday as $h) { ?>
                                        <tr>
                                            <td><?= $h->description ?></td>
                                            <td><?= date('Y-m-d', strtotime($h->date)) ?></td>

                                            <td>
                                                <em class="icon ni ni-edit text-primary btn-edit"
                                                    style="font-size: 20px; cursor: pointer;" data-id="<?= $h->id ?>"
                                                    data-description="<?= $h->description ?>"
                                                    data-date="<?= date('Y-m-d', strtotime($h->date)) ?>"
                                                    data-bs-toggle="tooltip" title="Edit Holiday">
                                                </em>
                                                <em class="icon ni ni-trash text-danger btn-delete"
                                                    style="font-size: 20px; cursor: pointer;" data-id="<?= $h->id ?>"
                                                    data-bs-toggle="tooltip" title="Delete Holiday">
                                                </em>
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

<div class="modal fade" id="addHolidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formHoliday">
                <div class="modal-header">
                    <h5 class="modal-title">Add Holiday</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
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

<div class="modal fade" id="editHolidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formHolidayEdit">
                <input type="hidden" name="id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Holiday</h5>
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                </div>

                <div class="modal-footer d-flex">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {

        tooltip();
        insert_holiday();
        edit_holiday();
        update_holiday();
        delete_holiday();

    });


    /* ===================== TOOLTIP ===================== */
    function tooltip() {
        let list = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        list.map(function (el) {
            return new bootstrap.Tooltip(el);
        });
    }


    /* ===================== SAVE HOLIDAY ===================== */
    function insert_holiday() {

        const form = document.getElementById("formHoliday");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            fetch("{{ route('holiday.save') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: new URLSearchParams(new FormData(form))
            })
                .then(res => res.json())
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
                        Swal.fire("Error", res.message, "error");
                    }
                });
        });

    }


    /* ===================== OPEN EDIT MODAL ===================== */
    function edit_holiday() {

        document.querySelectorAll(".btn-edit").forEach(btn => {

            btn.addEventListener("click", function () {

                const modal = document.getElementById("editHolidayModal");

                modal.querySelector("input[name='id']").value = this.dataset.id;
                modal.querySelector("input[name='description']").value = this.dataset.description;
                modal.querySelector("input[name='date']").value = this.dataset.date;

                new bootstrap.Modal(modal).show();
            });

        });

    }


    /* ===================== UPDATE HOLIDAY ===================== */
    function update_holiday() {

        const form = document.getElementById("formHolidayEdit");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            fetch("{{ route('holiday.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: new URLSearchParams(new FormData(form))
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                });
        });

    }


    /* ===================== DELETE HOLIDAY ===================== */
    function delete_holiday() {

        document.querySelectorAll(".btn-delete").forEach(btn => {

            btn.addEventListener("click", function () {

                let id = this.dataset.id;

                Swal.fire({
                    title: "Delete this holiday?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it",
                    cancelButtonText: "Cancel"
                }).then((result) => {

                    if (result.isConfirmed) {

                        fetch("{{ route('holiday.delete') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: new URLSearchParams({ id: id })
                        })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    Swal.fire("Deleted!", res.message, "success")
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            });
                    }

                });

            });

        });

    }

</script>