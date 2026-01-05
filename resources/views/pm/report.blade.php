<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Birth day</h3>
                            <div class="nk-block-des text-soft">
                                <p>Comprehensive birth records and statistics for the hospital.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                                    <em class="icon ni ni-more-v"></em>
                                </a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="#" class="btn btn-primary">
                                                <em class="icon ni ni-download"></em>
                                                <span>Export Report</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#addBirthRecord">
                                                <em class="icon ni ni-plus"></em>
                                                <span>Add Birth Record</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Detailed Birth Records Table -->
                <div class="card card-bordered card-stretch mt-4">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Recent Birth Records</h6>
                                </div>
                                <div class="card-tools">
                                    <div class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap">
                                            <select class="form-select js-select2" data-search="off"
                                                data-placeholder="Filter by Month">
                                                <option value="">All Months</option>
                                                <option value="january">January 2024</option>
                                                <option value="december">December 2023</option>
                                                <option value="november">November 2023</option>
                                            </select>
                                        </div>
                                        <div class="form-wrap ms-2">
                                            <select class="form-select js-select2" data-search="off"
                                                data-placeholder="Filter by Type">
                                                <option value="">All Types</option>
                                                <option value="normal">Normal Delivery</option>
                                                <option value="csection">C-Section</option>
                                                <option value="preterm">Preterm</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                data-target="search">
                                                <em class="icon ni ni-search"></em>
                                            </a>
                                        </li>
                                        <li class="btn-toolbar-sep"></li>
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-setting"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                    <ul class="link-check">
                                                        <li><span>Show</span></li>
                                                        <li class="active"><a href="#">10</a></li>
                                                        <li><a href="#">20</a></li>
                                                        <li><a href="#">50</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search">
                                            <em class="icon ni ni-arrow-left"></em>
                                        </a>
                                        <input type="text" class="form-control border-transparent form-focus-none"
                                            placeholder="Search by baby or mother name">
                                        <button class="search-submit btn btn-icon">
                                            <em class="icon ni ni-search"></em>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="sub-text">Baby Name</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Gender</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Birth Date & Time</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Birth Weight</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Mother's Name</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Delivery Type</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools"></div>
                                </div>

                                <!-- Sample Birth Records -->
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead">Baby Boy Smith</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dim bg-primary">Male</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span>15/01/2024 - 08:30 AM</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="fw-medium">3.2 kg</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span>Sarah Smith</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dim bg-success">Normal</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dim bg-success">Healthy</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                        data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em class="icon ni ni-eye"></em><span>View
                                                                        Details</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit
                                                                        Record</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-download"></em><span>Download
                                                                        Certificate</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-printer"></em><span>Print
                                                                        Report</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead">Baby Girl Johnson</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dim bg-pink">Female</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span>14/01/2024 - 14:20 PM</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="fw-medium">2.9 kg</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span>Emily Johnson</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dim bg-warning">C-Section</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dim bg-success">Stable</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                        data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em class="icon ni ni-eye"></em><span>View
                                                                        Details</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit
                                                                        Record</span></a></li>
                                                            <li><a href="#"><em
                                                                        class="icon ni ni-download"></em><span>Download
                                                                        Certificate</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        <li class="page-item">
                                            <a class="page-link" href="#">Prev</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <span class="page-link"><em class="icon ni ni-more-h"></em></span>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">6</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">7</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="g">
                                    <div
                                        class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                        <div>Page</div>
                                        <div>
                                            <select class="form-select js-select2" data-search="on"
                                                data-dropdown="xs center">
                                                <option value="page-1">1</option>
                                                <option value="page-2">2</option>
                                                <option value="page-3">3</option>
                                                <option value="page-4">4</option>
                                            </select>
                                        </div>
                                        <div>OF 4</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Add Birth Record Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addBirthRecord">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal">
                <em class="icon ni ni-cross-sm"></em>
            </a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Add New Birth Record</h5>
                <form action="#" class="mt-4">
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="babyFirstName">Baby First Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="babyFirstName"
                                        placeholder="Enter baby's first name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="babyLastName">Baby Last Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="babyLastName"
                                        placeholder="Enter baby's last name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" data-placeholder="Select Gender">
                                        <option value=""></option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="birthWeight">Birth Weight (kg)</label>
                                <div class="form-control-wrap">
                                    <input type="number" step="0.1" class="form-control" id="birthWeight"
                                        placeholder="e.g., 3.2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="motherName">Mother's Full Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="motherName"
                                        placeholder="Enter mother's full name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="fatherName">Father's Full Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="fatherName"
                                        placeholder="Enter father's full name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Delivery Type</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" data-placeholder="Select Delivery Type">
                                        <option value=""></option>
                                        <option value="normal">Normal Delivery</option>
                                        <option value="csection">C-Section</option>
                                        <option value="assisted">Assisted Delivery</option>
                                        <option value="water">Water Birth</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Birth Status</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" data-placeholder="Select Birth Status">
                                        <option value=""></option>
                                        <option value="healthy">Healthy</option>
                                        <option value="stable">Stable</option>
                                        <option value="critical">Critical</option>
                                        <option value="monitoring">Under Monitoring</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Birth Date</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy"
                                        placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Birth Time</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" class="form-control time-picker" placeholder="HH:MM">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="birthLength">Birth Length (cm)</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="birthLength" placeholder="e.g., 50">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="headCircumference">Head Circumference (cm)</label>
                                <div class="form-control-wrap">
                                    <input type="number" step="0.1" class="form-control" id="headCircumference"
                                        placeholder="e.g., 34.5">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="apgarScore">Apgar Score (1 min)</label>
                                <div class="form-control-wrap">
                                    <input type="number" min="0" max="10" class="form-control" id="apgarScore"
                                        placeholder="0-10">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="apgarScore5min">Apgar Score (5 min)</label>
                                <div class="form-control-wrap">
                                    <input type="number" min="0" max="10" class="form-control" id="apgarScore5min"
                                        placeholder="0-10">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="deliveryNotes">Delivery Notes</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="deliveryNotes"
                                        placeholder="Any additional notes about the delivery" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="medicalConditions">Medical Conditions</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="medicalConditions"
                                        placeholder="Any medical conditions or complications" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="attendingDoctor">Attending Doctor</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" data-placeholder="Select Attending Doctor">
                                        <option value=""></option>
                                        <option value="dr_smith">Dr. John Smith</option>
                                        <option value="dr_johnson">Dr. Sarah Johnson</option>
                                        <option value="dr_williams">Dr. Mike Williams</option>
                                        <option value="dr_brown">Dr. Emily Brown</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="submit" class="btn btn-primary">Save Birth Record</button>
                                </li>
                                <li>
                                    <a href="#" class="link link-light" data-bs-dismiss="modal">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize select2
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.js-select2').select2();
        }

        // Search functionality
        const searchToggle = document.querySelector('.search-toggle');
        if (searchToggle) {
            searchToggle.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');
                const searchWrap = document.querySelector(`[data-search="${target}"]`);
                if (searchWrap) {
                    searchWrap.classList.toggle('active');
                }
            });
        }

        // Date and Time picker initialization
        if (typeof $ !== 'undefined' && $.fn.datepicker) {
            $('.date-picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });
        }

        if (typeof $ !== 'undefined' && $.fn.timepicker) {
            $('.time-picker').timepicker({
                showMeridian: false,
                minuteStep: 5
            });
        }

        // Form submission
        const birthRecordForm = document.querySelector('#addBirthRecord form');
        if (birthRecordForm) {
            birthRecordForm.addEventListener('submit', function (e) {
                e.preventDefault();
                // Add your form submission logic here
                alert('Birth record added successfully!');
                $('#addBirthRecord').modal('hide');
                this.reset();
            });
        }
    });
</script>