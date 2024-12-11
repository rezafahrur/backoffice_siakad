document.addEventListener("DOMContentLoaded", () => {
    const updateLmsPassword =
        document.body.dataset.updateLmsPassword === "true";
    const username = document.body.dataset.lmsUsername;
    const password = document.body.dataset.lmsPassword;

    if (updateLmsPassword && username && password) {
        // Make the POST request to the Laravel proxy route
        fetch("/proxy-update-lms-password", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                username: username,
                password: password,
            }),
        })
            .then((response) => {
                if (!response.ok)
                    throw new Error("Failed to update LMS password.");
                // console.log("LMS password updated successfully.");
                // console.log("username:", username);
                // console.log("password:", password);
                // Clear the session flag after success
                fetch("/clear-lms-password-session");
            })
            .catch((error) => console.error("Error:", error));
    }
});
