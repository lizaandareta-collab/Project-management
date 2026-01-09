<style>
    /* Select Process Area */
    .process-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Default button */
    .btn-process {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        transition: background-color .2s ease, color .2s ease, border-color .2s ease;
    }

    /* Hover = hijau gelap */
    .btn-process:hover {
        background-color: #0fac81;
        /* hijau gelap template */
        border-color: #0fac81;
        color: #fff !important;
    }

    /* Focus */
    .btn-process:focus {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
        box-shadow: none;
    }

    /* Active (yang diklik) */
    .btn-process.btn-primary {
        background-color: #0fac81;
        border-color: #0fac81;
        color: #fff !important;
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
                                    <span>
                                        {{ $project->project_name }}
                                    </span>
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

                        <div class="card card-bordered card-preview d-none" id="trialTableCard">
                            <div class="card-inner">
                                <div class="nk-block-head mb-3">
                                    <div
                                        class="nk-block-head-content d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">%OK RATIO -<span id="selectedProcess"></span></h6>
                                        <button type="button" class="btn btn-primary d-none" id="btnAddTrial">
                                            <em class="icon ni ni-plus"></em>Add Trial
                                        </button>
                                    </div>
                                </div>

                                <table class="datatable-init-export nowrap table"
                                    data-export-title="Export Trial Report" data-ordering="false">

                                    <thead>
                                        <tr>
                                            <th>Trial</th>
                                            <th>Casting (Status Trial)</th>
                                            <th>Machine</th>
                                            <th>Date</th>
                                            <th>Process</th>
                                            <th>OK</th>
                                            <th>OK Ratio Target</th>
                                            <th>%</th>
                                            <th>CT Target</th>
                                            <th>CT</th>
                                            <th>Berat Target</th>
                                            <th>Berat</th>
                                        </tr>
                                    </thead>

                                    <tbody id="trialTableBody">
                                        <!-- dummy -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddTrial" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formAddTrial">
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
                            <label class="form-label">Trial</label>
                            <input type="text" name="trial_no" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Casting (Status Trial)</label>
                            <input type="text" name="trial_stat" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Machine</label>
                            <input type="text" name="trial_machine" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="trial_date" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Process</label>
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
                    </div>

                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary ms-auto">
                            Save
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<script>
    let selectedProcessId = null;
    const projectId = "{{ request()->route('id') }}";

    /* ===============================
       SELECT PROCESS
    ================================ */
    document.querySelectorAll('.btn-process').forEach(btn => {
        btn.addEventListener('click', function () {

            document.querySelectorAll('.btn-process')
                .forEach(b => b.classList.remove('btn-primary'));

            this.classList.add('btn-primary');

            selectedProcessId = this.dataset.processId;
            const processName = this.dataset.processName;

            document.getElementById('selectedProcess').innerText = processName;
            document.getElementById('trialTableCard').classList.remove('d-none');
            document.getElementById('btnAddTrial').classList.remove('d-none');

            // set hidden input (modal)
            const processInput = document.getElementById('process_id');
            if (processInput) {
                processInput.value = selectedProcessId;
            }

            loadTrialData();
        });
    });

    function formatModalTarget(val) {
        if (val === null || val === '' || isNaN(val)) return '';
        return parseFloat(val).toFixed(2).replace('.', ','); // 97,00
    }

    function formatTableTarget(val) {
        if (val === null || val === '' || isNaN(val)) return '';
        return parseFloat(val).toFixed(2); // 97.00
    }

    /* ===============================
       LOAD REAL DATA (NO DUMMY)
    ================================ */
    function loadTrialData() {
        if (!selectedProcessId) return;

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
            .then(res => res.json())
            .then(data => {
                let html = '';

                if (!data || data.length === 0) {
                    html = `
                <tr>
                    <td colspan="12" class="text-center text-muted">
                        No data available
                    </td>
                </tr>
            `;
                } else {
                    data.forEach(row => {

                        const perctVal = parseFloat(row.perct);
                        const targetVal = parseFloat(row.target);

                        const ctVal = parseFloat(row.ct);
                        const ctTargetVal = parseFloat(row.ct_target);

                        const beratVal = parseFloat(row.berat);
                        const beratTargetVal = parseFloat(row.berat_target);

                        // tentukan warna %
                        let perctClass = '';
                        if (!isNaN(perctVal) && !isNaN(targetVal)) {
                            perctClass = perctVal >= targetVal
                                ? 'text-success fw-bold'
                                : 'text-danger fw-bold';
                        }

                        let ctClass = '';
                        if (!isNaN(ctVal) && !isNaN(ctTargetVal)) {
                            ctClass = ctVal <= ctTargetVal
                                ? 'text-success fw-bold'
                                : 'text-danger fw-bold';
                        }

                        let beratClass = '';
                        if (!isNaN(beratVal) && !isNaN(beratTargetVal)) {
                            beratClass = beratVal >= beratTargetVal
                                ? 'text-success fw-bold'
                                : 'text-danger fw-bold';
                        }

                        html += `
        <tr>
            <td>${row.trial_no ?? ''}</td>
            <td>${row.trial_stat ?? ''}</td>
            <td>${row.trial_machine ?? ''}</td>
            <td>${row.trial_date ? row.trial_date.split(' ')[0] : ''}</td>
            <td>${row.actual ?? ''}</td>
            <td>${row.ok ?? ''}</td>
            <td>${formatTableTarget(row.target)} %</td>
            <td class="${perctClass}">
                ${formatTableTarget(row.perct)} %
            </td>
            <td>${row.ct_target ?? ''}</td>
            <td class="${ctClass}">
                ${row.ct ?? ''}
            </td>
            <td>${row.berat_target ?? ''}</td>
            <td class="${beratClass}">
                ${row.berat ?? ''}
            </td>

            
        </tr>
    `;
                    });

                }

                document.getElementById('trialTableBody').innerHTML = html;
            })
            .catch(err => console.error(err));
    }

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
                // tampil ke user (pakai koma)
                document.getElementById('target_view').value =
                    formatModalTarget(data.target);

                // kirim ke DB (angka murni, titik)
                document.getElementById('target_real').value =
                    parseFloat(data.target).toFixed(2);

                document.querySelector('input[name="ct_target"]').value =
                    data.ct_target ?? '';

                document.querySelector('input[name="berat_target"]').value =
                    data.berat_target ?? '';
            })

            .catch(err => console.error(err));
    }


    /* ===============================
       ADD TRIAL BUTTON
    ================================ */
    document.getElementById('btnAddTrial').addEventListener('click', function () {
        if (!selectedProcessId) {
            alert('Pilih process terlebih dahulu');
            return;
        }

        loadStandardTarget();


        new bootstrap.Modal(
            document.getElementById('modalAddTrial')
        ).show();
    });

    /* ===============================
       SUBMIT ADD TRIAL
    ================================ */
    document.getElementById('formAddTrial').addEventListener('submit', function (e) {
        e.preventDefault();

        fetch("{{ route('trial.store') }}", {
            method: "POST",
            body: new FormData(this)
        })
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    loadTrialData();
                    bootstrap.Modal.getInstance(
                        document.getElementById('modalAddTrial')
                    ).hide();
                    this.reset();
                } else {
                    alert(res.message);
                }
            })
            .catch(err => console.error(err));
    });

    /* ===============================
       AUTO CALCULATE PERCENT (%)
       % = (OK / ACTUAL) * 100
    ================================ */

    const actualInput = document.querySelector('input[name="actual"]');
    const okInput = document.querySelector('input[name="ok"]');
    const perctInput = document.querySelector('input[name="perct"]');

    function calculatePercent() {
        const actual = parseFloat(actualInput.value);
        const ok = parseFloat(okInput.value);

        if (!isNaN(actual) && actual > 0 && !isNaN(ok)) {
            const percent = (ok / actual) * 100;
            perctInput.value = percent.toFixed(2); // 88.78
        } else {
            perctInput.value = '';
        }
    }

    actualInput.addEventListener('input', calculatePercent);
    okInput.addEventListener('input', calculatePercent);
</script>