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
    $bookid = $_POST['bookid'];
    $bookdate = $_POST['bookdate'];
    $moviename = $_POST['moviename'];
    $mobilenumber = $_POST['mobilenumber'];
    $numberoftickets = $_POST['numberoftickets'];
    $seats = $_POST['seats'];
    $amount = $_POST['amount'];

    $sql = "UPDATE booking_details 
            SET booking_date = '$bookdate', moviename = '$moviename', mobilenumber = '$mobilenumber', 
                number_of_tickets = '$numberoftickets', seats = '$seats', amount = '$amount' 
            WHERE booking_id = '$bookid'";

    if ($dbconn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $dbconn->error;
    }
}

$dbconn->close();
?>
