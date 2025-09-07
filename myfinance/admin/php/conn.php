<?php
    $servername = "localhost";
    $username = "root"; // default XAMPP/WAMP username
    $password = ""; // default XAMPP/WAMP password
    $dbname = "mfinance";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>