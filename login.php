<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

  if ($_SESSION["user_type"] == 'admin') {
    header("location: admin/home.php");
  } else {
    header("location: welcome.php");
  }

  exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = $password = $user_type = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if email is empty
  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter a matching email.";
  } else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", trim($_POST['email']))) {
    $email_err = 'Email must be of format xxx@xxx.xxx';
  } else {
    $email = trim($_POST["email"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if (empty($email_err) && empty($password_err)) {
    // Prepare a select statement
    // $sql = "SELECT id, email, user_type, password FROM users VALUES (?, ?)";
    $sql = "SELECT * FROM users_with_email_verification WHERE email = ? LIMIT 1";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("s", $param_email);

      // Set parameters
      $param_email = $email;
      // $param_user_type = $user_type;

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Store result
        $stmt->store_result();

        // Check if email exists, if yes then verify password
        if ($stmt->num_rows == 1) {
          // Bind result variables
          $stmt->bind_result($id, $name, $email, $user_type, $verified, $token, $hashed_password);
          if ($stmt->fetch()) {
            if (password_verify($password, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();
              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION['name'] = $name;
              $_SESSION["email"] = $email;
              $_SESSION['verified'] = $verified;
              // $sql_user_type = "SELECT user_type from users WHERE email = $email LIMIT 1";
              // $query = $mysqli -> query($sql_user_type);
              // $user_type = $query -> fetch_assoc($query);
              if ($user_type == 'admin') {
                $_SESSION["user_type"] = $user_type;
                header("location: admin/home.php");
              } else {
                $_SESSION["user_type"] = 'user';
                // Redirect user to welcome page
                header("location: welcome.php");
              }
            } else {
              // Display an error message if password is not valid
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          // Display an error message if email doesn't exist
          $email_err = "No account found with that email.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    $stmt->close();
  }

  // Close connection
  $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="icon" href="./media/logo.jpg">
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="styles.css">

</head>

<body>

  <!-- <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId: '373595116684942',
        cookie: true,
        xfbml: true,
        version: 'v3.3'
      });

      FB.AppEvents.logPageView();

    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script> -->

  <div class="container">
    <div class="row">
      <div class="form-wrapper auth login" style="width: 380px;">
        <h3 class="text-center form-title">Login</h3>

        <form action="" method="post">
          <!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> -->
          <div id="un" class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="text" name="email" class="form-control form-control-lg" value="<?php echo $email; ?>">
            <?php if (!empty($email_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li>
                  <?php echo $email_err; ?>
                </li>
              </div> <?php endif; ?>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input id="pw" type="password" name="password" class="form-control form-control-lg">
            <?php if (!empty($password_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li>
                  <?php echo $password_err; ?>
                </li>
              </div>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <button id="sbm" type="submit" name="Login" class="btn btn-lg btn-block" value="Login">Login</button>
          </div>
          <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
      </div>
    </div>
  </div>
</body>

</html>