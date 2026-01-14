<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview mx-auto w-100">

                    <!-- BLOCK -->
                    <div class="nk-block nk-block-lg">

                        <!-- BLOCK HEADER (SAMA DENGAN HALAMAN SEBELUMNYA) -->
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title mb-0">
    Trial Report
    - {{ $project_name ?? 'Project' }}
    - {{ $process_name ?? 'Process' }}
    - Trial {{ $trial }}
</h4>

                            </div>
                        </div>

                        <!-- CARD -->
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">

                                <!-- SEARCH -->
                                <div class="d-flex justify-content-between mb-3">
                                    <input type="text" id="reportFreshSearch" class="form-control form-control-sm w-25"
                                        placeholder="Search...">
                                </div>

                                <!-- TABLE -->
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

                                           @php
                                                $totalQty = 0;
                                                $totalPercent = 0;
                                            @endphp


                                            <!-- CASTING -->
                                            <tr data-category="casting" class="category-row fw-bold">
                                                <td rowspan="8" class="fw-bold text-center align-middle">
                                                    {{ $report['category'] ?? 'Casting' }}
                                                </td>
                                                <td>OK</td>
                                                <td class="text-end fw-bold">
                                                    {{ $report['ok'] ?? '' }}
                                                </td>
                                                <td class="text-end text-danger fw-bold">
                                                    {{ isset($report['ok_percent']) ? number_format($report['ok_percent'], 2, ',', '.') . '%' : '' }}
                                                </td>

                                            </tr>

                                            @php
                                                $totalQty += $report['ok'] ?? 0;
                                                $totalPercent += $report['ok_percent'] ?? 0;
                                            @endphp


                                            @foreach ($report['defects'] as $label => $qty)
                                                <tr data-category="casting">
                                                    <td>{{ $label }}</td>
                                                    <td class="text-end">
                                                        {{ $qty ?? '' }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ isset($qty) ? number_format($qty, 2, ',', '.') . '%' : '' }}
                                                    </td>

                                                </tr>

                                                @php
                                                    $totalQty += $qty ?? 0;
                                                    $totalPercent += $qty ?? 0;
                                                @endphp

                                            @endforeach

                                            <tr data-category="casting" class="fw-bold">
                                                <td>Jumlah</td>
                                                <td class="text-end">
                                                    {{ $totalQty }}
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($totalPercent, 2, ',', '.') }}%
                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                        <!-- END CARD -->

                    </div>
                    <!-- END BLOCK -->

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('reportFreshSearch').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#reportFreshTable tbody tr');

        let categoryHasMatch = {};

        // reset
        rows.forEach(row => row.style.display = 'none');

        // filter rows
        rows.forEach(row => {
            const category = row.dataset.category;
            const cells = row.querySelectorAll('td');

            if (cells.length < 3) return;

            const searchableText = (
                cells[cells.length - 3].innerText + ' ' +
                cells[cells.length - 2].innerText + ' ' +
                cells[cells.length - 1].innerText
            ).toLowerCase();

            if (searchableText.includes(keyword) || keyword === '') {
                row.style.display = '';
                categoryHasMatch[category] = true;
            }
        });

        // show category header if any child visible
        rows.forEach(row => {
            if (row.classList.contains('category-row')) {
                const category = row.dataset.category;
                if (categoryHasMatch[category]) {
                    row.style.display = '';
                }
            }
        });
    });
</script>