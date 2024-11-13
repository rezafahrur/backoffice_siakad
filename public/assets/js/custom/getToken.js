const routeToken = document
    .getElementById("getToken")
    .getAttribute("data-route");
const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

async function getToken() {
    console.log(`routeToken: ${routeToken}`);
    console.log(`csrfToken: ${csrfToken}`);
    return await fetch(routeToken, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("HTTP STATUS: " + response.status);
            }
            return response.status;
        })
        .then((data) => {
            console.log(`datanya: ${data}`);
        })
        .catch((ex) => {
            console.log(`err: ${ex}`);
        });
}

getToken();
