<?php
// Include config file
require_once "config.php";
require_once 'mailgunphp.php';
// require_once 'sendEmails.php';
require_once './vendor/autoload.php';


// Define variables and initialize with empty values
$email = $password = $name = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = $captcha_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $secret = "6Lft9boUAAAAAAWlrEkq8YmhY9-tQSqK2FoUFNys";
  // $secret = "6Lem8roUAAAAAK1fV5o5j6G17IyH_kq4CzAY_TOs";
  // empty response
  $response = null;
  // check secret key
  $reCaptcha = new \ReCaptcha\ReCaptcha($secret);

  if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha
      ->setExpectedHostname($_SERVER['SERVER_NAME'])
      ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
  };

  if (!($response->isSuccess())) {
    //   echo "Hi " . $_POST["name"] . " (" . $_POST["email"] . "), thanks for submitting the form!";
    // } else {
    $captcha_err = $respose->getErrorCodes();
  }

  // Validate email
  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter a email.";
  } else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", trim($_POST['email']))) {
    $email_err = 'Email must be of format A@B.C';
  } else {
    // Prepare a select statement
    $sql = "SELECT id FROM users_with_email_verification WHERE email = ?";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("s", $param_email);

      // Set parameters
      $param_email = trim($_POST["email"]);

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // store result
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $email_err = "This email is already taken.";
        } else {
          $email = trim($_POST["email"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    $stmt->close();
  }

  if (empty(trim($_POST["name"]))) {
    $name_err = "Please enter your full name.";
  } elseif (strlen(trim($_POST["name"])) < 2) {
    $name_err = "name must have atleast 2 characters.";
  } else {
    $name = trim($_POST["name"]);
  }

  // Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Password must have atleast 6 characters.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm password.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Check input errors before inserting in database
  if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($captcha_err)) {

    // Prepare an insert statement
    $sql = "INSERT INTO users_with_email_verification (name, email, user_type, token, password) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sssss", $param_name, $param_email, $param_user_type, $param_token, $param_password);

      $token = bin2hex(random_bytes(50));
      // Set parameters
      $param_name = $name;
      $param_email = $email;
      $param_user_type = 'user';
      $param_token = $token;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        sendVerificationEmail($email, $token);
        // sendVerificationEmail($email, $token, $name);
        session_start();
        $_SESSION['verified'] = false;
        $_SESSION["loggedin"] = true;
        $_SESSION['name'] = $name;
        $_SESSION["email"] = $email;
        // Redirect to login page
        header("location: login.php");
      } else {
        echo "Something went wrong. Please try again later.";
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
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="styles.css">

  <!-- <link rel="stylesheet" href="strongWeakPW.css"> -->
  <!-- <script src="strongWeakPW.js"></script> -->

</head>

<body>

  <script src='./dist/register.js'></script>

  <div class="container">
    <div class="row">
      <div class="form-wrapper auth login" style="width: 380px;">
        <h3 class="text-center form-title">Sign Up</h3>
        <form action="" method="post">

          <div class="form-group name_wrap <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
            <label>Full Name</label>
            <input type="text" name="name" class="fullname form-control form-control-lg" value="<?php echo $name; ?>" required>
            <?php if (!empty($name_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li><?php echo $name_err; ?></li>
              </div>
            <?php endif; ?>
          </div>
          <div class="form-group email_wrap <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="text" name="email" class="email form-control form-control-lg" value="<?php echo $email; ?>" required>
            <?php if (!empty($email_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li><?php echo $email_err; ?></li>
              </div>
            <?php endif; ?>
          </div>

          <div class="form-group password_wrap <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <span style="padding: 0;" id="pw-span" class="form-control form-control-lg">
              <!-- <span id="pw-cnt"> -->
              <input id="pw" type="password" class="pw-input" name="password" value="<?php echo $password; ?>" required>
              <!-- </span> -->
              <!-- <span id="eye-cnt"> -->
              <i id="eye" class="fas fa-eye" onclick="eyebtn()"></i>
              <!-- </span> -->
            </span>
            <!-- <div class="progress-bar_wrap">
              <div class="progress-bar_item progress-bar_item-1"></div>
              <div class="progress-bar_item progress-bar_item-2"></div>
              <div class="progress-bar_item progress-bar_item-3"></div>
            </div>
            <span class="progress-bar_text"></span> -->

            <?php if (!empty($password_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li><?php echo $password_err; ?></li>
              </div>
            <?php endif; ?>
          </div>

          <div class="form-group confirm_password_wrap <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="confirm_password form-control form-control-lg" value="<?php echo $confirm_password; ?>" required>
            <?php if (!empty($confirm_password_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li><?php echo $confirm_password_err; ?></li>
              </div>
            <?php endif; ?>
          </div>

          <div class="form-group  <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
            <div class="g-recaptcha" style="display: flex; align-items: center; justify-content: center;">
              <!-- <div class="g-recaptcha" data-sitekey="6Lem8roUAAAAAE4G61W49TYCqhEAjtGZJBM5sgZb"> -->
            </div>
            <?php if (!empty($captcha_err)) : ?>
              <div class="alert alert-danger" style="margin-top: 10px;">
                <li><?php echo $captcha_err; ?></li>
              </div>
            <?php endif; ?>
          </div>
          <!-- <script src="https://www.google.com/recaptcha/api.js?hl=en&render=explicit" async defer></script> -->
          <script src="https://www.google.com/recaptcha/api.js?hl=en&onload=onloadCallback&render=explicit" async defer></script>

          <div class="form-group">
            <button type="submit" name="Submit" class="btn btn-lg btn-block" value="Submit" disabled>Submit</button>
            <button type="reset" name="Reset" class="btn btn-lg btn-block btn-primary" value="Reset" onclick="removeValidationClasses()">Reset</button>
          </div>

          <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>


        <script type="text/javascript">
          var eyebtn = function() {
            console.log(this)
            if (document.getElementById("pw").type === "password") {
              document.getElementById("pw").type = "text";
              document.getElementById("eye").className = "fas fa-eye";
            } else {
              document.getElementById("pw").type = "password";
              document.getElementById("eye").className = "fas fa-eye-slash";
            }
          }

          let removeValidationClasses = function() {
            let failEles = document.querySelectorAll('.Fail');
            let succEles = document.querySelectorAll('.Success');
            console.log(failEles, succEles);
            for (let i = 0; i < failEles.length; i++) {
              failEles[i].classList.remove('Fail');
            }
            for (let j = 0; j < succEles.length; j++) {
              console.log(j, succEles[j].length);
              succEles[j].classList.remove('Success');
            }
          }

          let disableTrueArray = [false, false, false, false, false];

          var clickCallBack = function() {
            console.log("Clicked!");
            disableTrueArray[0] = true;
            enableSubmitCheck();
          };

          var captchaContainer = document.querySelector('.g-recaptcha');
          var onloadCallback = function() {
            grecaptcha.render(captchaContainer, {
              'callback': 'clickCallBack',
              'sitekey': '6Lft9boUAAAAAPivvB-yEVeH44mUgyeRdwydR9xB'
            });
          }

          var checkName = function() {
            // console.log(fullname.value)
            if (fullname.value.length === 0) {
              console.log("This field is required")

              $(".errpop").remove();
              fullname.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">This field is required</div>');

              fullname.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[1] = false;
            } else if (fullname.value.indexOf(' ') === -1) {
              $(".errpop").remove();
              fullname.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">It must be your <i>full</i> name</div>');

              fullname.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[1] = false;
            } else {
              $(".errpop").remove();
              console.log("Validation passsed")
              fullname.classList.remove('Fail');
              fullname.classList.add('Success');
              disableTrueArray[1] = true;
              enableSubmitCheck();
            }
          }

          var checkEmail = function() {
            // var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            let re = "[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?";
            if (!email.value.match(re)) {
              // if (!(re.test(email))) {
              // console.log("Email must be of format A@B.C")
              $(".errpop").remove();
              email.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">This field must be of format aaa@bbb</div>');
              email.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[2] = false;
            } else {
              $(".errpop").remove();
              email.classList.remove('Fail');
              email.classList.add('Success');
              disableTrueArray[2] = true;
              console.log("Validation passed")
              enableSubmitCheck();
            }
          }
          var checkPW = function() {
            var appender = document.getElementById("pw-span");
            // var appender = $("#pw-span");
            console.log(appender);
            // let re = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,8}$";
            if (!pw.value.match(/[a-z]/g)) {
              $(".errpop").remove();
              appender.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">At least 1 lowercase character</div>');
              // console.log("At least 1 lowercase character failed")
              appender.classList.add('Fail');
              // pw.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[3] = false;
            } else if (!pw.value.match(/[A-Z]/g)) {
              $(".errpop").remove();
              appender.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">At least 1 uppercase character</div>');
              appender.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[3] = false;
              // console.log("At least 1 uppercase character failed")
            } else if (!pw.value.match(/[0-9]/g)) {
              appender.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[3] = false;
              $(".errpop").remove();
              appender.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">Minimum 1 digit</div>');
              // console.log("At least 1 digit failed")
            } else if (pw.value.length < 8) {
              appender.classList.add('Fail');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[3] = false;
              $(".errpop").remove();
              appender.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">Minimum 8 characters</div>');
            } else {
              $(".errpop").remove();
              appender.classList.remove('Fail');
              appender.classList.add('Success');
              disableTrueArray[3] = true;
              console.log("Validation passed")
              enableSubmitCheck();
            }
          }

          var checkCPW = function() {
            if (cpw.value !== pw.value) {
              cpw.classList.add('Fail');
              $(".errpop").remove();
              cpw.insertAdjacentHTML('afterend', '<div style="margin-top: 10px;" class="errpop alert alert-danger">Passwords do not match</div>');
              document.querySelector('button[type="submit"]').disabled = true;
              disableTrueArray[4] = false;
            } else {
              $(".errpop").remove();
              cpw.classList.remove('Fail');
              cpw.classList.add('Success');
              disableTrueArray[4] = true;
              console.log("Validation passed")
              enableSubmitCheck();
            }
          }

          var fullname = document.getElementsByClassName("fullname")[0];
          fullname.addEventListener("focusout", checkName);
          // fullname.addEventListener("mouseleave", checkName);
          var email = document.getElementsByClassName("email")[0];
          email.addEventListener("focusout", checkEmail);
          // email.addEventListener("mouseleave", checkEmail);
          var pw = document.getElementsByClassName("pw-input")[0];
          pw.addEventListener("focusout", checkPW);
          // pw.addEventListener("mouseleave", checkPW);
          var cpw = document.getElementsByClassName("confirm_password")[0];
          cpw.addEventListener("focusout", checkCPW);
          // cpw.addEventListener("mouseleave", checkCPW);

          let enableSubmitCheck = function() {
            if (disableTrueArray[0] === true && disableTrueArray[1] === true && disableTrueArray[2] === true && disableTrueArray[3] === true && disableTrueArray[4] === true) {
              document.querySelector('button[type="submit"]').disabled = false;
              console.log("Enabled the button");
            };
            // console.log("Failed to disable the button", disableTrueArray)

          }

          // let x = document.getElementsByClassName("form-group");
          // for (let i = 0; i < x.length; i++) {
          //   // x[i].addEventListener("mouseleave", enableSubmitCheck);
          //   x[i].addEventListener("focusout", enableSubmitCheck);
          //   console.log("Event listeners added to form groups")
          // }
          // document.getElementsByClassName("form-group").forEach(element => {
          //   element.addEventListener("mouseleave", enableSubmitCheck);
          //   element.addEventListener("focusout", enableSubmitCheck);
          // });
        </script>

      </div>
    </div>
  </div>
</body>

</html>