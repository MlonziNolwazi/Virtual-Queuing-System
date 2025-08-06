<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
//let warningTime = 55 * 60 * 1000; // 55 minutes
//let logoutTime  = 60 * 60 * 1000; // 60 minutes

let warningTime = 5 * 1000; // 5 seconds
let logoutTime  = 10 * 1000; // 10 seconds

let warningTimer, logoutTimer;

function resetTimers() {
    clearTimeout(warningTimer);
    clearTimeout(logoutTimer);

    warningTimer = setTimeout(() => {
        Swal.fire({
            title: "Session Expiring Soon",
            text: "You’ve been inactive. You will be logged out in 5 minutes unless there's activity.",
            icon: "warning",
            timer: 5000,
            toast: true,
            position: 'top-end',
            showConfirmButton: false
        });
    }, warningTime);

    logoutTimer = setTimeout(() => {
        // Redirect to logout
        window.location.href = "logout.php?timeout=1";
    }, logoutTime);
}

// Listen for activity
['click', 'mousemove', 'keydown', 'scroll'].forEach(event => {
    document.addEventListener(event, resetTimers, false);
});

resetTimers(); // Start timers on load
</script>
