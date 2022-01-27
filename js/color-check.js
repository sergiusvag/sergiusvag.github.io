$(document).ready(function() {
    setInterval(function() {
        $('#color-refresh').load("color-refresh.php");
    }, 3000)
    // $('#color-refresh').load("color-refresh.php");
});