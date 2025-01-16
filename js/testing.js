document.addEventListener("DOMContentLoaded", () => {
    console.log("Testing");

    fetchUsers();
    function fetchUsers() {
        fetch("/api/admin/users", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        }).then(response => {
            console.log("Response received");
            if (response.ok) {
                console.log("Response was ok");
                return response.json();
            }
            throw new Error("Failed to fetch users");
        }).catch(error => console.error(error));
    }
});

