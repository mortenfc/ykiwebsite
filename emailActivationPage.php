<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="icon" href="./media/logo.jpg">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="styles.css">
  <title>Verify Email</title>
</head>

<body>
  <script>
    $(document).ready(function() {
      // $('[data-toggle="tooltip"]').tooltip();
      $('#btn').click(function() {
        $.ajax({
          url: 'resendActivationLink.php?call=true',
          type: 'GET',
          success: function(data) {
            console.log("Succesful resend");
          }
        });
      })
    });
  </script>

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

      <h4 class="text-center form-title">Welcome, <?php echo $_SESSION['name']; ?></h4>
      <div class="d-flex justify-content-center">
        <a href="logout.php" class="btn btn-warning" style="margin-bottom: 15px;">Logout</a>
      </div>
      <?php if (!$_SESSION['verified']) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          You need to verify your email address!
          Sign into your email account and click
          on the verification link we just emailed you
          at
          <strong><?php echo $_SESSION['email']; ?></strong>
        </div>
        <div class="d-flex justify-content-center">
          <button title="This will render the previous link unusable" id="btn" value="click" class="btn btn-warning d-flex justify-content-center">
            Send a new activation link!
          </button>
        </div>
      <?php else : ?>
        <button class="btn btn-lg btn-primary btn-block">I'm verified!</button>
      <?php endif; ?>

      <div class="footer pull-down">
        Copyright ©
        <?php $the_year = date("Y");
        echo $the_year; ?>
        <?php echo "https://ykitest.website/" ?>
        All Rights Reserved.
      </div>

    </div>
  </div>
</body>

</html>