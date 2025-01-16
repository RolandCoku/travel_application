// Description: This file contains the client-side JavaScript code for the application.

// Keep the user session alive by periodically pinging the server
let isActive = true;
let timeout;

// Detect user activity
function userActivityDetected() {
    isActive = true;
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        isActive = false; // Mark user as inactive after 10 minutes
    }, 10 * 60 * 1000); // 10 minutes
}

document.addEventListener('mousemove', userActivityDetected);
document.addEventListener('keydown', userActivityDetected);

// Periodically ping the server only if the user is active
setInterval(() => {
    if (isActive) {
        console.log('Pinging server to keep session alive');
        keepSessionAlive();
    }
}, 10 * 50 * 1000); // Ping every 10 minutes

function keepSessionAlive() {
    fetch('/keep-alive', {
        method: 'POST',
        credentials: 'include'
    }).catch(err => {
        console.error('Failed to keep session alive:', err);
    });
}
