<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "kosovo_info";

// Krijoni një lidhje
$conn = new mysqli($servername, $username, $password, $database);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
} else {

}
?>