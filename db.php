<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "error_log";

$conn = new mysqli($db_server, $db_user, $db_password, $db_name);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$guestTableSql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($guestTableSql) !== TRUE) {
    logError($conn, "Error creating MyGuests table: " . $conn->error);
}

$errorTableSql = "CREATE TABLE IF NOT EXISTS ErrorLogs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    error_message TEXT NOT NULL,
    error_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($errorTableSql) !== TRUE) {
    die("Error creating ErrorLogs table: " . $conn->error);
}

function logError($conn, $message)
{
    $stmt = $conn->prepare("INSERT INTO ErrorLogs (error_message) VALUES (?)");
    $stmt->bind_param("s", $message);
    $stmt->execute();
    $stmt->close();
}


function fetchGuests($conn)
{
    $sql = "SELECT id, firstname, lastname, email, reg_date FROM MyGuests";
    return $conn->query($sql);
}

function addGuest($conn, $firstname, $lastname, $email)
{
    $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $firstname, $lastname, $email);
    if (!$stmt->execute()) {
        logError($conn, "Error adding guest: " . $stmt->error);
    }
    $stmt->close();
}

function updateGuest($conn, $id, $firstname, $lastname, $email)
{
    $stmt = $conn->prepare("UPDATE MyGuests SET firstname=?, lastname=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $firstname, $lastname, $email, $id);
    if (!$stmt->execute()) {
        logError($conn, "Error updating guest: " . $stmt->error);
    }
    $stmt->close();
}

function deleteGuest($conn, $id)
{
    $stmt = $conn->prepare("DELETE FROM MyGuests WHERE id=?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        logError($conn, "Error deleting guest: " . $stmt->error);
    }
    $stmt->close();
}
