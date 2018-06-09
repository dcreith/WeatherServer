<?php
// connect to database
//
//
//
$mysqli = new mysqli("localhost", "appuser", "appdog", "weather");
/* check connection */
if (mysqli_connect_errno()) {
    // printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
