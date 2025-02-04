import Swal from 'sweetalert2';
import './bootstrap';
import '../css/app.css';

// Modal Logout start
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logout-btn');

    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah aksi default tombol

        // Menampilkan SweetAlert2 untuk konfirmasi logout
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form logout jika dikonfirmasi
                document.getElementById('logout-form').submit();
            }
        });
    });
});
// Modal Logout end

// Modal delete user start
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button click
    document.querySelectorAll('.delete-btn-user').forEach(button => {
        button.addEventListener('click', function(e) {
            const employeeId = this.getAttribute('data-id');

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
                    deleteUser(employeeId);
                }
            });
        });
    });

    // Function to handle delete request
    function deleteUser(employeeId) {
        fetch(`/admin/${employeeId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Deleted!',
                        'The employee has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire(
                    'Error!',
                    'Failed to delete the employee.',
                    'error'
                );
            });
    }
});
// Modal delete user start

// Fungsi untuk menampilkan SweetAlert
function showAlert(type, title, message) {
    Swal.fire({
        icon: type, // success, error, warning, info, question
        title: title,
        text: message,
        confirmButtonText: 'OK',
    });
}

// Event DOMContentLoaded untuk memastikan elemen HTML sudah siap
document.addEventListener('DOMContentLoaded', () => {
    if (window.flashMessage) {
        showAlert(window.flashMessage.type, window.flashMessage.title, window.flashMessage.message);
    }
});
