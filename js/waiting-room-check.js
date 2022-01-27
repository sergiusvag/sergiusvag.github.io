$(document).ready(function() {
    setInterval(function() {
        $('#waiting-refresh').load("game-waiting-refresh.php");
    }, 1500)
});