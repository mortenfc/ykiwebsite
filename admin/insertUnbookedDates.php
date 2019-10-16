<?php

require_once '../config.php';

$sql = "INSERT INTO appointments (dates, free, name, email) VALUES (?, ?, ?, ?)";
// $sql = 'INSERT INTO appointments (dates, free) VALUES (?, ?) ON DUPLICATE KEY UPDATE dates=VALUES(dates),
// free=VALUES(free)';
// $sql = "INSERT INTO employees (type, address, salary) VALUES (?, ?, ?)";

    // session_start();
// Validate time
$date_err = "";
// echo $_GET["date"];
$time = substr(trim($_GET["date"]), 11);
// echo $time;
if (empty(trim($_GET["date"]))) {
  $date_err = "Please fill out the time input";
} else if (!(preg_match('/(?:[01]\d|2[0-3]):(?:[0-5]\d):(?:[0-5]\d)/', $time))) {
  $date_err = "Time input must be of 24-hour format HH:MM";
} else {
  // Prepare a select statement
  $sqlCheck = "SELECT dates FROM appointments WHERE dates = ?";

  if ($stmtCheck = $mysqli->prepare($sqlCheck)) {
    // Bind variables to the prepared statement as parameters
    $stmtCheck->bind_param("s", $param_dates);

    // Set parameters
    $param_dates = trim($_GET["date"]);

    // Attempt to execute the prepared statement
    if ($stmtCheck->execute()) {
      // store result
      $stmtCheck->store_result();

      if ($stmtCheck->num_rows == 1) {
        $date_err = "This time is already made available to students.";
      } else {
        $date = trim($_GET["date"]);
      }
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
  }

  // Close statement
  $stmtCheck->close();
}

if (empty($date_err)) {
  if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    // $stmt->bind_param("s", $param_dates);
    $stmt->bind_param("ssss",  $param_dates, $param_free, $param_name, $param_email);

    // Set parameters
    $param_dates = $date;
    $param_free = 1;
    $param_name = '';
    $param_email = '';
    // $param_dates = $_GET["date"];

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
      echo "Success";
    } else {
      echo $_GET["date"];
      echo " ";
      echo $date;
      echo " ";
      echo "Could not execute statement";
    }
  } else {
    echo "Could not prepare statement";
    // echo $_GET["date"];
  }
  $stmt->close();
} else {
  echo $date_err;
}

$mysqli->close();
