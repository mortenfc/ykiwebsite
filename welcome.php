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

  <link rel="stylesheet" href="styles.css?version=1.1">
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

      <h3 class="welcomeTitle">Welcome, <?php echo $_SESSION['name']; ?></h3>

      <div class="levels">
        <a href="content/level1/courses.php" class="btn btn-lg btn-secondary">Level 1</a>
        <a href="content/level2/courses.php" class="btn btn-lg btn-secondary">Level 2</a>
        <a href="content/level3/courses.php" class="btn btn-lg btn-secondary">Level 3</a>
      </div>

      <div class="item">
        <a href="reset-password.php" class="btn btn-lg btn-secondary">Reset Password</a>
      </div>

      <div class="item">
        <a href="logout.php" class="btn btn-lg btn-secondary" style="margin-bottom: 15px;">Logout</a>
      </div>

      <?php if (!$_SESSION['verified']) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          You need to verify your email address!
          Sign into your email account and click
          on the verification link we just emailed you
          at
          <strong><?php echo $_SESSION['email']; ?></strong>
        </div>
        <div class="">
          <button title="This will render the previous link unusable" data-trigger="hover" data-toggle="popover" data-content="" id="btn" value="click" class="btn btn-warning ">
            Send a new activation link!
          </button>
        </div>
      <?php else : ?>
        <div class="btn" style="width: 15%; background-color: green; margin: 2% auto 2% auto;">I'm verified!</div>
      <?php endif; ?>

      <!-- <div class="pdf">

        <div class="loading">
          <div class="shape shape-1"></div>
          <div class="shape shape-2"></div>
          <div class="shape shape-3"></div>
          <div class="shape shape-4"></div>
        </div>

        <canvas id="canvasPages"></canvas>
        <div style="margin-bottom: 10px;">
          <span id="page_num"></span>
          <span>/</span>
          <span id="page_count"></span>
        </div>
        <button id="prev" class="btn btn-lg btn-secondary">Prev</button>
        <button id="next" class="btn btn-lg btn-secondary">Next</button>

      </div> -->
      <div class="footer pull-down">
        Copyright ©
        <?php $the_year = date("Y");
        echo $the_year; ?>
        <?php echo "www.ykitest.website" ?>
        All Rights Reserved.
      </div>
    </div>
  </div>

</body>

</html>