<?php
// require_once 'consolejs.php';
require_once 'config.php';
$sql = "SELECT dates FROM appointments where free=TRUE ORDER BY dates";
// console_log($sql);
if ($result = mysqli_query($mysqli, $sql)) {
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
      // console_log('2 times?');
      echo json_encode($row["dates"]);
      echo '!';
    }
  }
}

// INSERT INTO `appointments` (`dates`, `free`, `name`, `email`) VALUES ('2019-10-12 10:20:00.000000', '1', '', ''), ('2019-10-11 10:20:00.000000', '1', '', '');

// echo json_encode('test');