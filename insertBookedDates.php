<?php

session_start();
// if (isset($_SESSION["booked"]) && $_SESSION["booked"] == true) {
//   echo "Already booked a date";
//   exit;
// }
require_once './config.php';
// $param_dates = $param_free = $param_email = $param_name = "";

// $sql = "UPDATE appointments SET (free=?, name=?, email=?) WHERE dates=?";
$sql = 'INSERT INTO appointments (dates, free, name, email) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE dates=VALUES(dates),
free=VALUES(free),
name=VALUES(name),
email=VALUES(email)';
// $sql = "INSERT INTO employees (type, address, salary) VALUES (?, ?, ?)";

if ($stmt = $mysqli->prepare($sql)) {
  // Bind variables to the prepared statement as parameters
  $stmt->bind_param("ssss",  $param_dates, $param_free, $param_name, $param_email);

  // Set parameters
  $param_dates = $_GET["date"];
  $param_free = 0;
  $param_name = $_SESSION["name"];
  $param_email = $_SESSION["email"];
  $_SESSION["booked"] = true;

  // Attempt to execute the prepared statement
  if ($stmt->execute()) {
    echo "Success";
  } else {
    echo "Could not execute statement";
  }
} else {
  echo "Could not prepare statement";
  // echo $_GET["date"];
}
