$(document).ready(function() {
    setInterval(function() {
        $('#refresh').load("refresh.php");
    }, 1500)
    $('#refresh').load("refresh.php");
});