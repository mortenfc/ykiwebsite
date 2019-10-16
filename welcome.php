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
  <!-- <link rel="stylesheet" href="media/loading/loading.css"> -->
  <link rel="text/javascript" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <link rel="stylesheet" href="styles.css?version=1.1">
  <script src="https://cdn.dwolla.com/1/dwolla.js"></script>
  <style type="text/css">

  </style>

</head>

<body oncontextmenu="return false">
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
        <a href="content/level1/courses.php" class="btn btn-lg btn-info btn-secondary">Level 1</a>
        <a href="content/level2/courses.php" class="btn btn-lg btn-info btn-secondary">Level 2</a>
        <a href="content/level3/courses.php" class="btn btn-lg btn-info btn-secondary">Level 3</a>
      </div>

      <div class="item">
        <a href="reset-password.php" class="btn btn-lg btn-info btn-secondary">Reset Password</a>
      </div>

      <div class="item">
        <a href="logout.php" class="btn btn-lg btn-info btn-secondary" style="margin-bottom: 15px; color: red;">Logout</a>
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

      <div class="scheduler" style="position: relative;">
        <form>
          <!-- <span> -->
          <h3 id="schedulerTitle">
            <!-- <span> -->
            Schedule a live tutoring session with
            <a id="iljLink" onmouseleave="removeIljana()" onmouseover="displayIljana()" style="background-color: white; text-decoration: underline;" target="_blank" href="https://www.facebook.com/maailmal/">
              Ilyana Belonina
              <!-- <span id="iljLink" style="text-decoration: underline;"> Ilyana Belonina </span> -->
              <!-- <span style="position: relative; left: 99%; bottom: 22px">
                <span style="display: grid; grid-template-columns: 30% 70%; grid-template-rows: 18% 82%; height: 24px; width: 24px; background-color: #4267b2; border-radius: 2px;">
                  <i style="color:white; text-shadow: none; grid-row: 2 / span 1; grid-column: 2 / span 1;" class="fab fa-facebook-f"></i>
                </span>
              </span> -->
            </a>
            <a style="background-color: white; position: absolute; top: 1.55%; right: 10.3%" target="_blank" href="https://www.facebook.com/maailmal/">
              <span style="float:right; display: grid; grid-template-columns: 30% 70%; grid-template-rows: 18% 82%; height: 24px; width: 24px; background-color: #4267b2; border-radius: 2px; margin: 0;">
                <i style="color:white; text-shadow: none; grid-row: 2 / span 1; grid-column: 2 / span 1; margin: 0;" class="fab fa-facebook-f"></i>
              </span>
            </a>
            <!-- </span> -->
          </h3>
          <!-- </span> -->
          <img id="iljana" style='position: absolute; right: 3%; visibility: hidden; z-index: 1;' src='media/iljana.jpg'>
          <script>
            let ilj = document.getElementById("iljana");
            var displayIljana = function() {
              document.getElementById("iljLink").style.textDecoration = "none";
              ilj.style.visibility = "visible";
            }
            var removeIljana = function() {
              document.getElementById("iljLink").style.textDecoration = "underline";
              ilj.style.visibility = "hidden";
            }
          </script>
          <div id="reviews">
            <!-- <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fsana.grigoryeva%2Fposts%2F1754762364579877%3A0&width=500" width="500" height="411" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe> -->
            <!-- <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fnadiya.byts%2Fposts%2F1641002775975584%3A0&width=500" width="500" height="430" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe> -->
            <!-- <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmaria.melnikova.01%2Fposts%2F1742238685822890%3A0&width=500" width="500" height="411" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe> -->

            <div style="width:80%; margin: 1% auto;" data-token="NS5Qu5oVKzaV6enM24czY9UxHz4S4iLSfl7TwJlVaONbSbXaOY" class="romw-reviews"></div>
            <script src="https://reviewsonmywebsite.com/js/embedLoader.js?id=9b3acdde2be3481c94dd" type="text/javascript"> </script>
            <!-- <div style="height: 100px; width: 80%; position: relative; bottom: 0%; z-index: 2147483638; background-color: white;"> Overlay! </div> -->
          </div>

          <div>
            <div id="datepicker"> </div>
            <script src="dist/welcome.js" type="text/javascript"></script>
          </div>
          <div id="appendDatepicker"></div>
          <button id="payBtn" class="btn btn-lg btn-info btn-secondary" style="margin-bottom: 3%">Go To Payment</button>
              <!-- <script src="dist/dwolla.js"></script> -->
          <a id="book" class="btn btn-lg btn-info btn-secondary" style="color: white; cursor: pointer"> Book (remember to remove) </a>

        </form>
      </div>

      <div class="footer pull-down">
        Copyright ©
        <?php $the_year = date("Y");
        echo $the_year; ?>
        <?php echo "ykitest.website" ?>
        All Rights Reserved.
      </div>
    </div>
  </div>
</body>

</html>