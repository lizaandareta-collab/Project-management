<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Calendar</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <a class="btn btn-primary" data-bs-toggle="modal" href="#addEventPopup"><em
                                    class="icon ni ni-plus"></em><span>Add Event</span></a>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div id="calendar" class="nk-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Events</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="addEventForm" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="event-title">Event Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="event-title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Start Date & Time</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="event-start-date" class="form-control date-picker"
                                                data-date-format="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="event-start-time" data-time-format="HH:mm:ss"
                                                class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">End Date & Time</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="event-end-date" class="form-control date-picker"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="event-end-time" data-time-format="HH:mm:ss"
                                                class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="event-description">Event Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="event-description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Event Category</label>
                                <div class="form-control-wrap">
                                    <select id="event-theme" class="select-calendar-theme form-control"
                                        data-search="on">
                                        <option value="event-primary">Company</option>
                                        <option value="event-success">Seminars </option>
                                        <option value="event-info">Conferences</option>
                                        <option value="event-warning">Meeting</option>
                                        <option value="event-danger">Business dinners</option>
                                        <option value="event-pink">Private</option>
                                        <option value="event-primary-dim">Auctions</option>
                                        <option value="event-success-dim">Networking events</option>
                                        <option value="event-info-dim">Product launches</option>
                                        <option value="event-warning-dim">Fundrising</option>
                                        <option value="event-danger-dim">Sponsored</option>
                                        <option value="event-pink-dim">Sports events</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <li>
                                    <button id="addEvent" type="submit" class="btn btn-primary">Add Event</button>
                                </li>
                                <li>
                                    <button id="resetEvent" data-bs-dismiss="modal"
                                        class="btn btn-danger btn-dim">Discard</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="editEventForm" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="edit-event-title">Event Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="edit-event-title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Start Date & Time</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="edit-event-start-date"
                                                class="form-control date-picker" data-date-format="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="edit-event-start-time" data-time-format="HH:mm:ss"
                                                class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">End Date & Time</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="edit-event-end-date" class="form-control date-picker"
                                                data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="edit-event-end-time" data-time-format="HH:mm:ss"
                                                class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="edit-event-description">Event Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="edit-event-description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Event Category</label>
                                <div class="form-control-wrap">
                                    <select id="edit-event-theme" class="select-calendar-theme form-control"
                                        data-search="on">
                                        <option value="event-primary">Company</option>
                                        <option value="event-success">Seminars </option>
                                        <option value="event-info">Conferences</option>
                                        <option value="event-warning">Meeting</option>
                                        <option value="event-danger">Business dinners</option>
                                        <option value="event-pink">Private</option>
                                        <option value="event-primary-dim">Auctions</option>
                                        <option value="event-success-dim">Networking events</option>
                                        <option value="event-info-dim">Product launches</option>
                                        <option value="event-warning-dim">Fundrising</option>
                                        <option value="event-danger-dim">Sponsored</option>
                                        <option value="event-pink-dim">Sports events</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <li>
                                    <button id="updateEvent" type="submit" class="btn btn-primary">Update Event</button>
                                </li>
                                <li>
                                    <button data-bs-dismiss="modal" data-bs-toggle="modal"
                                        data-bs-target="#deleteEventPopup"
                                        class="btn btn-danger btn-dim">Delete</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preview Event Modal -->
<div class="modal fade" id="previewEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div id="preview-event-header" class="modal-header">
                <h5 id="preview-event-title" class="modal-title">Placeholder Title</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="row gy-3 py-1">
                    <div class="col-sm-6">
                        <h6 class="overline-title">Start Time</h6>
                        <p id="preview-event-start"></p>
                    </div>
                    <div class="col-sm-6" id="preview-event-end-check">
                        <h6 class="overline-title">End Time</h6>
                        <p id="preview-event-end"></p>
                    </div>
                    <div class="col-sm-10" id="preview-event-description-check">
                        <h6 class="overline-title">Description</h6>
                        <p id="preview-event-description"></p>
                    </div>
                </div>
                <ul class="d-flex justify-content-between gx-4 mt-3">
                    <li>
                        <button data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editEventPopup"
                            class="btn btn-primary">Edit Event</button>
                    </li>
                    <li>
                        <button data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#deleteEventPopup"
                            class="btn btn-danger btn-dim">Delete</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Delete Event Modal -->
<div class="modal fade" id="deleteEventPopup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal py-4">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title">Are You Sure ?</h4>
                    <div class="nk-modal-text mt-n2">
                        <p class="text-soft">This event data will be removed permanently.</p>
                    </div>
                    <ul class="d-flex justify-content-center gx-4 mt-4">
                        <li>
                            <button data-bs-dismiss="modal" id="deleteEvent" class="btn btn-success">Yes, Delete
                                it</button>
                        </li>
                        <li>
                            <button data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editEventPopup"
                                class="btn btn-danger btn-dim">Cancel</button>
                        </li>
                    </ul>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <!-- SWEETALERT STATES DEMO -->
                <div class="nk-block">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Sweetalert States Demo</h5>
                        </div>
                    </div>
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <ul class="align-center flex-wrap g-2">
                                <li><a href="#" class="btn btn-success eg-swal-success">Success</a></li>
                                <li><a href="#" class="btn btn-info eg-swal-info">Info</a></li>
                                <li><a href="#" class="btn btn-warning eg-swal-warning">Warning</a></li>
                                <li><a href="#" class="btn btn-danger eg-swal-error">Error</a></li>
                                <li><a href="#" class="btn btn-light eg-swal-question">Question</a></li>
                                <li><a href="#" class="btn btn-primary eg-swal-av3">Advanced 03</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    // SweetAlert States Demo dengan Function
    function initSweetAlertDemo() {
        // Success
        $('.eg-swal-success').on("click", function (e) {
            e.preventDefault();
            showSuccessAlert();
        });

        // Info
        $('.eg-swal-info').on("click", function (e) {
            e.preventDefault();
            showInfoAlert();
        });

        // Warning
        $('.eg-swal-warning').on("click", function (e) {
            e.preventDefault();
            showWarningAlert();
        });

        // Error
        $('.eg-swal-error').on("click", function (e) {
            e.preventDefault();
            showErrorAlert();
        });

        // Question
        $('.eg-swal-question').on("click", function (e) {
            e.preventDefault();
            showQuestionAlert();
        });

        // Advanced 03
        $('.eg-swal-av3').on("click", function (e) {
            e.preventDefault();
            showAdvancedAlert();
        });
    }

    // Function untuk Success Alert
    function showSuccessAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Good job!',
            text: 'You clicked the button!',
        });
    }

    // Function untuk Info Alert
    function showInfoAlert() {
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: 'Here is some important information for you.',
        });
    }

    // Function untuk Warning Alert
    function showWarningAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Warning!',
            text: 'This action requires your attention.',
        });
    }

    // Function untuk Error Alert
    function showErrorAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    }

    // Function untuk Question Alert
    function showQuestionAlert() {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: 'Please confirm your action.',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        });
    }

    // Function untuk Advanced Alert
    function showAdvancedAlert() {
        Swal.fire({
            title: 'Custom width, padding, background.',
            width: 600,
            padding: '3em',
            background: '#fff url(/images/trees.png)',
            backdrop: `
                rgba(0,0,123,0.4)
                url("/images/nyan-cat.gif")
                left top
                no-repeat
            `
        });
    }

    // Initialize ketika document ready
    $(document).ready(function () {
        initSweetAlertDemo();
    });
</script>