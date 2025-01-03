const routeToken = document
    .getElementById("getToken")
    .getAttribute("data-route");
const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

async function getToken() {
    try {
        const response = await fetch(routeToken, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            },
        });

        if (!response.ok) {
            throw new Error("HTTP STATUS: " + response.status);
        }

        const data = await response.status;
        console.log(`datanya: ${data}`);
    } catch (ex) {
        console.log(`err: ${ex}`);

        // Cek apakah URL mengandung kata yang menunjukkan halaman CRUD
        const isCrudPage = routeToken.includes('/create') || routeToken.includes('/edit') || routeToken.includes('/delete');

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `Terjadi kesalahan: ${ex.message}`,
            footer: 'Silakan coba lagi atau hubungi administrator.'
        }).then(() => {
            // Jika halaman CRUD, kembalikan ke halaman sebelumnya
            if (isCrudPage) {
                window.history.back();
            }
        });
    }
}

getToken();
