<?php
// require_once 'consolejs.php';
require_once '../config.php';

if(isset($_GET["name"]) && $_GET["name"] == true) {
  $sql = "SELECT dates, name, email FROM appointments where free=" . trim($_GET["free"]) .  " ORDER BY dates";
  if ($result = mysqli_query($mysqli, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        // console_log('2 times?');
        echo json_encode($row["dates"]);
        echo '|';
        echo $row["name"];
        echo '|';
        echo $row["email"];
        echo '!';
      }
    }
  } else {
    echo "Error getting record: " . $mysqli->error;
    echo $sql;
  }
} else {
  $sql = "SELECT dates FROM appointments where free=" . $_GET["free"] .  " ORDER BY dates";
  if ($result = mysqli_query($mysqli, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        // console_log('2 times?');
        echo json_encode($row["dates"]);
        echo '!';
      }
    }
  } else {
    echo "Error getting record: " . $mysqli->error;
    echo $sql;
  }
}
// console_log($sql);

$mysqli->close();

// INSERT INTO `appointments` (`dates`, `free`, `name`, `email`) VALUES ('2019-10-12 10:20:00.000000', '1', '', ''), ('2019-10-11 10:20:00.000000', '1', '', '');

// echo json_encode('test');