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
                                <h6 class="mb-3">
                                    Report -
                                    <span id="selectedProcess"></span>
                                </h6>

                                <table class="datatable-init-export nowrap table"
                                    data-export-title="Export Trial Report" data-ordering="false">

                                    <thead>
                                        <tr>
                                            <th>Trial</th>
                                            <th>Casting</th>
                                            <th>Machine</th>
                                            <th>Date</th>
                                            <th>OK</th>
                                            <th>%</th>
                                            <th>Target</th>
                                            <th>CT</th>
                                            <th>CT Target</th>
                                            <th>Berat</th>
                                            <th>Berat Target</th>
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
</div>

<script>
    document.querySelectorAll('.btn-process').forEach(btn => {
        btn.addEventListener('click', function () {

            // highlight active button
            document.querySelectorAll('.btn-process')
                .forEach(b => b.classList.remove('btn-primary'));

            this.classList.add('btn-primary');

            const processName = this.dataset.processName;

            document.getElementById('selectedProcess').innerText = processName;

            const tbody = document.getElementById('trialTableBody');

            // 🔥 DATA DUMMY
            tbody.innerHTML = `
            <tr>
                <td>Trial 1</td>
                <td>${processName} Improve A</td>
                <td>TIHO 5A</td>
                <td>25/11/25</td>
                <td>78</td>
                <td class="text-danger fw-bold">78%</td>
                <td>97%</td>
                <td>117</td>
                <td>120</td>
                <td>14.4</td>
                <td>15</td>
            </tr>
            <tr>
                <td>Trial 2</td>
                <td>${processName} Improve B</td>
                <td>4A</td>
                <td>26/11/25</td>
                <td>98</td>
                <td class="text-success fw-bold">98%</td>
                <td>97%</td>
                <td>122</td>
                <td>120</td>
                <td>14.2</td>
                <td>15</td>
            </tr>
        `;

            document.getElementById('trialTableCard').classList.remove('d-none');
        });
    });
</script>