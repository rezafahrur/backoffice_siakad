$(document).ready(function () {
    // Buat konfigurasi mixin untuk SweetAlert
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    // Ambil nilai dari data-attributes yang sudah kita set di body
    const sessionSuccess = $("body").data("session-success");
    const sessionError = $("body").data("session-error");

    // Jika ada session 'success', tampilkan SweetAlert dengan icon success
    if (sessionSuccess) {
        Toast.fire({
            icon: "success",
            title: sessionSuccess,
        });
    }

    // Jika ada session 'error', tampilkan SweetAlert dengan icon error
    if (sessionError) {
        Toast.fire({
            icon: "error",
            title: sessionError,
        });
    }
});
