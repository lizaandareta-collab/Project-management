<!-- SweetAlert2 -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
// Alert Functions menggunakan SweetAlert2
class CustomAlerts {
    // Success Alert
    static success(message = 'Operation completed successfully!', title = 'Success!') {
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#6576ff'
        });
    }
    
    // Error Alert
    static error(message = 'Something went wrong!', title = 'Error!') {
        Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#e85347'
        });
    }
    
    // Warning Alert
    static warning(message = 'Please check your input!', title = 'Warning!') {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#f5a623'
        });
    }
    
    // Info Alert
    static info(message = 'Information', title = 'Info') {
        Swal.fire({
            icon: 'info',
            title: title,
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#0fac81'
        });
    }
    
    // Confirm Dialog
    static confirm(message = 'Are you sure?', title = 'Confirmation') {
        return Swal.fire({
            title: title,
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonColor: '#6576ff',
            cancelButtonColor: '#e85347'
        });
    }
    
    // Loading Alert
    static loading(message = 'Processing...', title = 'Loading') {
        Swal.fire({
            title: title,
            text: message,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
    
    // Close Alert
    static close() {
        Swal.close();
    }
}

// Global functions untuk mudah dipanggil
function showSuccess(message, title) {
    CustomAlerts.success(message, title);
}

function showError(message, title) {
    CustomAlerts.error(message, title);
}

function showWarning(message, title) {
    CustomAlerts.warning(message, title);
}

function showInfo(message, title) {
    CustomAlerts.info(message, title);
}

function showConfirm(message, title) {
    return CustomAlerts.confirm(message, title);
}

function showLoading(message, title) {
    CustomAlerts.loading(message, title);
}

function closeAlert() {
    CustomAlerts.close();
}
</script>