<?php
$dbserver = '127.0.0.1';
$dbuser = 'root';
$dbpwd = '';
$dbname = 'ticket_booking';

$dbconn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookid = $_POST['bookid'];
    $bookdate = $_POST['bookdate'];
    $moviename = $_POST['moviename'];
    $mobilenumber = $_POST['mobilenumber'];
    $numberoftickets = $_POST['numberoftickets'];
    $seats = $_POST['seats'];
    $amount = $_POST['amount'];

    $query = "INSERT INTO booking_details (booking_id, booking_date, moviename, mobilenumber, number_of_tickets, seats, amount)
              VALUES ('$bookid', '$bookdate', '$moviename', '$mobilenumber', '$numberoftickets', '$seats', '$amount')";

    if ($dbconn->query($query) === TRUE) {
        echo 'success';
    } else {
        echo 'Error: ' . $dbconn->error;
    }

    $dbconn->close();
}
?>
