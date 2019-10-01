<?php
session_start();

$conn = new mysqli('localhost', 'root', '79127912mfc', 'demo');

if (isset($_GET['token'])) {
  $token = $_GET['token'];
  $sql = "SELECT * FROM users_with_email_verification WHERE token='$token' LIMIT 1";
  $result = mysqli_query($conn, $sql);

  if ($result === FALSE) {
    echo "This user does not seem to have been sent a confirmation e-mail.";
    exit(0);
  }

  if (mysqli_num_rows($result) == true) {
    $user = mysqli_fetch_assoc($result);
    $query = "UPDATE users_with_email_verification SET verified=1 WHERE token='$token'";

    if (mysqli_query($conn, $query)) {
      $_SESSION['id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['verified'] = true;
      $_SESSION['message'] = "Your email address has been verified successfully";
      $_SESSION['type'] = 'alert-success';
      header('location: welcome.php');
      exit(0);
    }
  } else {
    echo "Could not verify the user. Are you sure you clicked on the latest activation link?";
  }
} else {
  echo "No token provided!";
}
