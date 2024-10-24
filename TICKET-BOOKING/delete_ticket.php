<?php
$dbserver = '127.0.0.1';
$dbuser = "root";
$dbpwd = "";
$dbname = "ticket_booking";
$dbconn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = $_POST['bookingId'];

    
    $bookingId = $dbconn->real_escape_string($bookingId);

    $sql = "DELETE FROM booking_details WHERE booking_id = '$bookingId'";

    if ($dbconn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $dbconn->error;
    }
}

$dbconn->close();
?>
