<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        .booking {
            display: flex;
            justify-content: space-evenly;
        }

        #bookingForm {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            width: 45%;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .seat-container {
            margin-top: 20px;
        }

        .seat-map {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .seat {
            width: 50px;
            height: 50px;
            margin: 5px;
            text-align: center;
            line-height: 50px;
            border: 1px solid #ccc;
            background-color: #eee;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .seat.booked {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: #90ee90;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .btn-update {
            background-color: #4CAF50;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-update:hover,
        .btn-delete:hover {
            opacity: 0.8;
        }
    #seatLayout {
        display: flex;
        flex-wrap: wrap; 
        justify-content: center; 
        margin-bottom: 10px;
        cursor: not-allowed;
    }

    .seat {
        width: 50px; 
        height: 50px; 
        background-color: lightgray; 
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border: 2px solid transparent;
        margin: 5px;
    }

    .seat.selected {
        background-color: green; 
        border: 2px solid darkgreen;
    }

    .seat.booked {
        background-color: red; 
        cursor: not-allowed; 
    }
    .seatcontiner {
        display:flex;
    }
</style>
</head>

<body>
  
    <h1>Booking Details</h1>
    <div class="seatcontiner">
    <form method="post" id="bookingForm">
        <label>Booking_id:</label>
        <input type="text" name="bookid" id="bookid" required><br><br>

        <label>Booking_date:</label>
        <input type="date" name="bookdate" id="bookdate" oninput="document.getElementById('seatLayout').style.pointerEvents = ''" required><br><br>

        <label>Movie Name:</label>
        <input type="text" name="moviename" id="moviename" required><br><br>

        <label>Mobile Number:</label>
        <input type="text" name="mobilenumber" id="mobilenumber" required><br><br>

        <label>Number of Tickets:</label>
        <input type="number" name="numberoftickets" id="numberoftickets" required><br><br>

        <label>Seats:</label>
        <input type="text" name="seats" id="seats" readonly required><br><br>

        <label>Total_Amount:</label>
        <input type="text" name="amount" id="amount" required><br><br>

        <input type="hidden" id="bookingId" name="bookingId">
        <h2>Select Your Seats</h2>

   
        <button type="submit" name="book" onclick="document.getElementByClass('seat').classList.remove('selected')">Book</button>
        <button type="button" onclick="changeTicket()">Change</button>
        <button type="button" onclick="deleteTicket()">Delete</button>
    </form>

    <div id="seatLayout" style="pointer-events: none" >
        <div class="seat" data-value="A1">A1</div>
        <div class="seat" data-value="A2">A2</div>
        <div class="seat" data-value="A3">A3</div>
        <div class="seat" data-value="A4">A4</div>
        <div class="seat" data-value="A5">A5</div>
        <div class="seat" data-value="A6">A6</div>
    </div>

   
    </div>
    <br><br>
    <table border="1" id="bookingTable">
        <thead>
            <tr>
                <th>Booking_id</th>
                <th>Booking_date</th>
                <th>Movie Name</th>
                <th>Mobile Number</th>
                <th>Number of Tickets</th>
                <th>Seats</th>
                <th>Total_Amount</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $dbserver = '127.0.0.1';
            $dbuser = "root";
            $dbpwd = "";
            $dbname = "ticket_booking";
            $dbconn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

            if ($dbconn->connect_error) {
                die("Connection failed: " . $dbconn->connect_error);
            }
            $result = $dbconn->query("SELECT * FROM booking_details");

            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='selectBooking(this)' data-id='{$row['booking_id']}'>
                            <td>{$row['booking_id']}</td>
                            <td>{$row['booking_date']}</td>
                            <td>{$row['moviename']}</td>
                            <td>{$row['mobilenumber']}</td>
                            <td>{$row['number_of_tickets']}</td>
                            <td>{$row['seats']}</td>
                            <td>{$row['amount']}</td>
                          </tr>";
            }

            $dbconn->close();
            ?>
        </tbody>
    </table>

    <script>
       
        let selectedRow = null;

        function selectBooking(row) {
            selectedRow = row;
            document.getElementById('bookid').value = row.cells[0].innerText;
            document.getElementById('bookdate').value = row.cells[1].innerText;
            document.getElementById('moviename').value = row.cells[2].innerText;
            document.getElementById('mobilenumber').value = row.cells[3].innerText;
            document.getElementById('numberoftickets').value = row.cells[4].innerText;
            document.getElementById('seats').value = row.cells[5].innerText;
            document.getElementById('amount').value = row.cells[6].innerText;
            document.getElementById('bookingId').value = row.getAttribute('data-id');
        }
        function changeTicket() {
            if (selectedRow) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_ticket.php", true);

                var formData = new FormData(document.getElementById('bookingForm'));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        if (xhr.responseText === 'success') {
                            selectedRow.cells[0].innerText = document.getElementById('bookid').value;
                            selectedRow.cells[1].innerText = document.getElementById('bookdate').value;
                            selectedRow.cells[2].innerText = document.getElementById('moviename').value;
                            selectedRow.cells[3].innerText = document.getElementById('mobilenumber').value;
                            selectedRow.cells[4].innerText = document.getElementById('numberoftickets').value;
                            selectedRow.cells[5].innerText = document.getElementById('seats').value;
                            selectedRow.cells[6].innerText = document.getElementById('amount').value;
                            document.getElementById('bookingForm').reset();
                            selectedRow = null;
                        }
                    }
                };

                xhr.send(formData);
            }
        }

        function deleteTicket() {
            if (selectedRow) {
                let bookingId = selectedRow.cells[0].innerText;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_ticket.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log('Delete response:', xhr.responseText);
                        if (xhr.responseText.trim() === 'success') {
                            selectedRow.remove();
                            document.getElementById('bookingForm').reset();
                            selectedRow = null;
                        } else {
                            console.error('Delete failed:', xhr.responseText);
                        }
                    }
                };

                xhr.send("bookingId=" + encodeURIComponent(bookingId));
            }
        }

        document.getElementById('bookingForm').addEventListener('submit', function (event) {
            event.preventDefault();
            seats.forEach(function(seat) {
                seat.classList.remove('selected');
            });
            
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "book_ticket.php", true);

            var formData = new FormData(this);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    if (xhr.responseText.trim() === 'success') {
                        let table = document.getElementById('bookingTable').getElementsByTagName('tbody')[0];
                        let newRow = table.insertRow();

                        newRow.innerHTML = `
                    <td>${document.getElementById('bookid').value}</td>
                    <td>${document.getElementById('bookdate').value}</td>
                    <td>${document.getElementById('moviename').value}</td>
                    <td>${document.getElementById('mobilenumber').value}</td>
                    <td>${document.getElementById('numberoftickets').value}</td>
                    <td>${document.getElementById('seats').value}</td>
                    <td>${document.getElementById('amount').value}</td>
                `;

                        newRow.setAttribute('data-id', document.getElementById('bookid').value);
                        newRow.onclick = function () {
                            selectBooking(newRow);
                        };

                        document.getElementById('bookingForm').reset();
                    }
                }
            };

            xhr.send(formData);
        });


        var seats = document.querySelectorAll('.seat');
        var selectedSeats = [];

        seats.forEach(function (seat) {
            seat.addEventListener('click', function () {
                if (!seat.classList.contains('booked')) {
                    seat.classList.toggle('selected');
                    var seatValue = seat.getAttribute('data-value');

                    if (selectedSeats.includes(seatValue)) {
                        selectedSeats.splice(selectedSeats.indexOf(seatValue), 1);
                    } else {
                        selectedSeats.push(seatValue);
                    }

                    document.getElementById('seats').value = selectedSeats.join(', ');
                    var numberOfTickets = selectedSeats.length;
                    document.getElementById('numberoftickets').value = numberOfTickets;

                    document.getElementById('amount').value = numberOfTickets * 200;
                }
            });
        });
    </script>

</body>

</html>
