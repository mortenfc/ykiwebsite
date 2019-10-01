<?php

session_start();

$conn = new mysqli('localhost', 'root', '79127912mfc', 'demo');
$token = bin2hex(random_bytes(50)); // generate unique token
$email = $_SESSION['email'];
// $query = "UPDATE INTO users_with_email_verification SET token=?";
$query = "UPDATE users_with_email_verification SET token='$token' WHERE email='$email'";
// $stmt = $conn->prepare($query);
// $stmt->bind_param('s', $token);
// $result = $stmt->execute();
echo "<h1> I update DB </h1>";

if (mysqli_query($conn, $query)) {
  // $stmt->close();

  if (isset($_GET['call'])) {
    require_once './sendEmails.php';
    sendVerificationEmail($email, $token);
  } else {
    echo "Errors";
  }
}
else {
  echo "User not found!";
}