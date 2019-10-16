<?php

session_start();

// if (!isAdmin()) {
//   $_SESSION['msg'] = "You must log in first";
//   header('location: ../login.php');
// }

if ($_SESSION["user_type"] != 'admin') {
  header('location: ../login.php');
  echo "not admin";
  exit;
}

if (isset($_GET['logout'])) {
  $_SESSION = array();
  session_destroy();
  echo "logout";
  header("location: ../login.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>

  <link rel="icon" href="../media/logo.jpg">
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../styles.css">

  <style>
    h2 {
      font-size: 3em;
    }

    hr {
      border: 0;
      height: 1px;
      width: 70%;
      margin-bottom: 20px;
    }
  </style>

</head>

<body>
  <div class="home-wrapper-wrapper">
    <div class="home-wrapper">
      <div class="header">
        <h2 style="width: 450px;">Admin Home Page</h2>
      </div>
      <div class="content">
        <!-- logged in user information -->
        <div class="profile_info">
          <!-- <img src="../images/admin_profile.png"> -->

          <div>
            <?php if (isset($_SESSION['name'])) : ?>
              <strong><?php echo $_SESSION['name']; ?></strong>

              <div>
                <i style="color: #888;">(<?php echo ucfirst($_SESSION['user_type']); ?>)</i>
                <br>
                <a class="btn btn-lg btn-info btn-primary" href="home.php?logout='1'" style="color: red;">Logout</a>
                <br>
                <div>
                  <h2> Content </h2>
                </div>
                <hr>
                &nbsp; <a class="btn btn-lg btn-info btn-secondary" href="CRUDLandingPage.php?level=1">Edit Level 1</a>
                &nbsp; <a class="btn btn-lg btn-info btn-secondary" href="CRUDLandingPage.php?level=2">Edit Level 2</a>
                &nbsp; <a class="btn btn-lg btn-info btn-secondary" href="CRUDLandingPage.php?level=3">Edit Level 3</a>
                <br>
                <div>
                  <h2> Users </h2>
                </div>
                <a class="btn btn-lg btn-info btn-secondary" href="create_user.php"> + Add User</a>
                <a class="btn btn-lg btn-info btn-secondary" href="create_user.php"> Edit Profile</a>
              </div>


            <?php endif ?>
          </div>
        </div>

      </div>
      <div class="scheduler" style="position: relative;">

        <!-- <form> -->
        <h3 class="schedulerTitle">
          Edit the dates that the students can choose from
        </h3>

        <div>
          <div id="datepicker"> </div>

          <script src="../dist/adminWelcome.js" type="text/javascript"></script>
        </div>
        <div id="appendDatepicker"></div>
        <!-- <button type="submit" class="btn btn-lg btn-info btn-secondary" style="margin-bottom: 3%">Confirm Dates</button> -->
        <!-- </form> -->

        <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
              <!-- <header class="modal__header"> -->
              <!-- <h2 class="modal__title" id="modal-1-title">
                  Micromodal
                </h2> -->
              <!-- <button class="modal__btn" aria-label="Close modal" data-micromodal-close>X</button> -->
              <!-- </header> -->
              <main class="modal__content" id="modal-1-content">
                <p>
                  Are you sure you want to remove an appointment a student paid for?
                </p>
              </main>
              <footer class="modal__footer">
                <button tabindex="-1" class="modal__btn modalYes">Hell yeah!</button>
                <button tabindex="-1" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Are you crazy?</button>
              </footer>
            </div>
          </div>
        </div>

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