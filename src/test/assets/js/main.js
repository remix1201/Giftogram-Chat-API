const apiUrl = APP.local.apiPath;

function registerUser() {
    const email = document.getElementById("register-email").value;
    const password = document.getElementById("register-password").value;
    const firstName = document.getElementById("register-first-name").value;
    const lastName = document.getElementById("register-last-name").value;

    fetch(`${apiUrl}/register`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            email,
            password,
            first_name: firstName,
            last_name: lastName,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("register-response").innerText = JSON.stringify(data, null, 2);
        });
}

function loginUser() {
    const email = document.getElementById("login-email").value;
    const password = document.getElementById("login-password").value;

    fetch(`${apiUrl}/login`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password }),
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("login-response").innerText = JSON.stringify(data, null, 2);
        });
}

function sendMessage() {
    const senderUserId = document.getElementById("sender-user-id").value.trim();
    const receiverUserId = document.getElementById("receiver-user-id").value.trim();
    const message = document.getElementById("message-text").value.trim();

    fetch(`${apiUrl}/send_message`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            sender_user_id: senderUserId,
            receiver_user_id: receiverUserId,
            message,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("send-message-response").innerText = JSON.stringify(data, null, 2);
        });
}

function viewMessages() {
    const userIdA = document.getElementById("view-user-id-a").value;
    const userIdB = document.getElementById("view-user-id-b").value;

    fetch(`${apiUrl}/view_messages?user_id_a=${userIdA}&user_id_b=${userIdB}`, {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("view-messages-response").innerText = JSON.stringify(data, null, 2);
        });
}

function listAllUsers() {
    const requesterUserId = document.getElementById("requester_user_id").value;

    fetch(`${apiUrl}/list_all_users?requester_user_id=${requesterUserId}`, {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("list-users-response").innerText = JSON.stringify(data, null, 2);
        });
}
