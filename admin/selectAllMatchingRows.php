<?php
// require_once 'consolejs.php';
require_once '../config.php';

// $date = substr(trim($_GET["date"]), 0, 11);
// echo $date . "|";
$sql = "SELECT dates, free, name, email FROM appointments ORDER BY dates";
// $sql = "SELECT dates FROM appointments WHERE dates LIKE '" . $date . "%' ORDER BY dates";

if ($result = mysqli_query($mysqli, $sql)) {
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
      // console_log('2 times?');
      // echo $row["free"];
      if($row["free"]) {
        $object = (object) [
          'free' => $row["free"],
          'date' => $row["dates"],
        ];
      } else {
        $object = (object) [
          'free' => $row["free"],
          'date' => $row["dates"],
          'name' => $row["name"],
          'email' => $row["email"],
        ];
      }

      // echo $object;
      echo json_encode($object);
      echo '!';
      // echo json_encode($row["free"]) . "=>" . json_encode($row["dates"]);
      // echo '!';
    }
  }
} else {
  echo "Error getting record: " . $mysqli->error;
  echo $sql;
}

$mysqli->close();