$(document).ready(function() {
    setInterval(function() {
        $('#waiting-refresh').load("game-reset-refresh.php");
    }, 1500)
});