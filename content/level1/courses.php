<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="icon" href="./media/logo.jpg">
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="media/loading/loading.css">
  <link rel="text/javascript" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>

  <link rel="stylesheet" href="../../styles.css?version=1.1">
  <style type="text/css">
  </style>

</head>

<body oncontextmenu="return false">
  <!-- <script src="media/pdfViewer.js"></script> -->

  <div class="home-wrapper-wrapper">
    <div class="home-wrapper">


      <!-- Display messages -->
      <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert <?php echo $_SESSION['type'] ?>">
          <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['type']);
            ?>
        </div>
      <?php endif; ?>

      <h3 class="welcomeTitle">Courses overview for Level 1</h3>

      <div class="levels">
        <a href="course1.php" class="btn btn-lg btn-secondary">Course 1</a>
        <a href="course2.php" class="btn btn-lg btn-secondary">Course 2</a>
        <a href="course3.php" class="btn btn-lg btn-secondary">Course 3</a>
        <a href="course4.php" class="btn btn-lg btn-secondary">Course 4</a>
        <a href="course5.php" class="btn btn-lg btn-secondary">Course 5</a>
      </div>

      <div class="item">
        <a href="reset-password.php" class="btn btn-lg btn-secondary">Reset Password</a>
      </div>

      <div class="footer pull-down">
        Copyright ©
        <?php $the_year = date("Y");
        echo $the_year; ?>
        <?php echo "https://www.ykitest.website/" ?>
        All Rights Reserved.
      </div>
    </div>
  </div>

</body>

</html>