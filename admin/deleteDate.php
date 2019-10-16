<?php

require_once '../config.php';
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// sql to delete a record
$sql = "DELETE FROM appointments WHERE dates='" . $_GET["date"] . "'";

if ($mysqli->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $mysqli->error;
    echo $sql;
}

$mysqli->close();
