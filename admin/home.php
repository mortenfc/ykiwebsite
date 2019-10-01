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
    /* h1 {
      max-width: 80%;
      margin: 4% auto;
      margin-bottom: 1.5%;
      text-align: center;
      font-size: 800%;
      text-transform: uppercase;
      font-family: 'ZCOOL KuaiLe', serif;
      text-shadow: 1px 1px 50px red, 0 0 5em yellow, 0 0 0.1em darkblue;
    } */

    hr {
      border: 0;
      height: 1px;
      width: 70%;
      /* background: rgba(182, 134, 137, 1); */
      /* color: rgba(182, 134, 137, 1); */
      margin-bottom: 20px;
      /* background-image: linear-gradient(to right, #FFF, rgba(182, 134, 137, 1), #FFF); */
      /* background-image: linear-gradient(to right, #FFF, rgba(255, 255, 255, 1), #FFF); */
      /* background-image: linear-gradient(to right, rgba(182, 134, 137, 0), rgba(182, 134, 137, 1), rgba(182, 134, 137, 0)); */
    }
  </style>

</head>

<body>
  <div class="home-wrapper-wrapper">
    <div class="home-wrapper">
      <div class="header">
        <h2>Admin - Home Page</h2>
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
    </div>
  </div>
</body>

</html>