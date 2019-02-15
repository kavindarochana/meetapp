

<?php
$servername = "localhost";
$username = "root";
$password = "war369";
$dbname = "connectIt";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>