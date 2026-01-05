<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">
                    <div class="nk-block nk-block-lg">

                        <div class="nk-block-head-content d-flex justify-content-between align-items-center">
                            <h4 class="nk-block-title mb-0">Client List</h4>

                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                <em class="icon ni ni-plus"></em> Add Client
                            </button>
                        </div>

                        <div class="card card-bordered card-preview mt-3">
                            <div class="card-inner">

                                <table class="datatable-init-export nowrap table">
                                    <thead>
                                        <tr>
                                            <th>Client_Ora</th>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Country</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($client as $c) { ?>
                                        <tr>
                                            <td><?= $c->client_ora ?></td>
                                            <td><?= $c->name ?></td>
                                            <td><?= $c->company ?></td>
                                            <td><?= $c->country ?></td>
                                            <td>
                                                <em class="icon ni ni-edit text-primary btn-edit"
                                                    style="font-size: 20px; cursor: pointer; margin-right: 8px;"
                                                    data-id="<?= $c->id ?>" data-client_ora="<?= $c->client_ora ?>"
                                                    data-name="<?= $c->name ?>" data-company="<?= $c->company ?>"
                                                    data-country="<?= $c->country ?>" data-bs-toggle="tooltip"
                                                    title="Edit Client">
                                                </em>

                                                <em class="icon ni ni-trash text-danger btn-delete"
                                                    style="font-size: 20px; cursor: pointer;" data-id="<?= $c->id ?>"
                                                    data-bs-toggle="tooltip" title="Delete Client">
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

<!-- ADD CLIENT MODAL -->
<div class="modal fade" id="addClientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formAddClient">
                <div class="modal-header">
                    <h5 class="modal-title">Add Client</h5>
                    <a class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Client ORA</label>
                        <input type="text" class="form-control" name="client_ora" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" name="company" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- EDIT CLIENT MODAL -->
<div class="modal fade" id="editClientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formEditClient">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Client</h5>
                    <a class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Client ORA</label>
                        <input type="text" class="form-control" name="client_ora" id="edit_client_ora" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" name="company" id="edit_company" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" id="edit_country" required>
                    </div>

                </div>

                <div class="modal-footer">
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
    insert_client();
    edit_client();
    update_client();
    delete_client();

});


/* ========================= TOOLTIP ========================= */
function tooltip() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}


/* ========================= INSERT CLIENT ========================= */
function insert_client() {

    const formAdd = document.getElementById("formAddClient");

    if (!formAdd) return;

    formAdd.addEventListener("submit", function (e) {
        e.preventDefault();

        fetch("{{ route('client.save') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: new URLSearchParams(new FormData(formAdd))
        })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    Swal.fire("Success", res.message, "success")
                        .then(() => location.reload());
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            });
    });
}


/* ========================= EDIT BUTTON OPEN MODAL ========================= */
function edit_client() {

    document.querySelectorAll(".btn-edit").forEach(btn => {

        btn.addEventListener("click", function () {

            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_client_ora").value = this.dataset.client_ora;
            document.getElementById("edit_name").value = this.dataset.name;
            document.getElementById("edit_company").value = this.dataset.company;
            document.getElementById("edit_country").value = this.dataset.country;

            new bootstrap.Modal(document.getElementById("editClientModal")).show();
        });

    });

}


/* ========================= UPDATE CLIENT ========================= */
function update_client() {

    const formEdit = document.getElementById("formEditClient");

    if (!formEdit) return;

    formEdit.addEventListener("submit", function (e) {
        e.preventDefault();

        fetch("{{ route('client.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: new URLSearchParams(new FormData(formEdit))
        })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    Swal.fire("Updated!", res.message, "success")
                        .then(() => location.reload());
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            });

    });

}


/* ========================= DELETE CLIENT ========================= */
function delete_client() {

    document.querySelectorAll(".btn-delete").forEach(btn => {

        btn.addEventListener("click", function () {

            let id = this.dataset.id;

            Swal.fire({
                title: "Delete this client?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel"
            }).then((result) => {

                if (result.isConfirmed) {

                    fetch("{{ route('client.delete') }}", {
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
