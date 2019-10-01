<?php
session_start();

if (isset($_GET['level'])) {
  $_SESSION['level'] = $_GET['level'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="icon" href="../media/logo.jpg">
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"> -->
  <link rel="stylesheet" href="../styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  <style type="text/css">
    .page-header h2 {
      margin-top: 0;
    }

    /* th {
      text-align: center;
    } */

    table tr td:last-child a {
      margin-right: 15px;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
</head>

<body>
  <div class="wrapper-wrapper">
    <div class="wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="page-header clearfix">
              <?php if (isset($_SESSION['level'])) : ?>
                <div class="header" style="margin-top: 10px;">
                  <li>
                    <h2 class='pull-left'>Content - Level <?php echo $_SESSION['level'] ?> </h2>
                  </li>
                </div>
              <?php else : ?>
                <div class="alert alert-danger" style="margin-top: 10px;">
                  <li>
                    <?php echo "Level not specified" ?>
                  </li>
                </div>
              <?php endif; ?>
              <a href="home.php" class="btn btn-info pull-right" style="margin-left: 5px;">Admin Home</a>
              <a href="create.php" class="btn btn-success pull-right">Add PDF, video or podcast</a>
            </div>
            <?php
            // Include config file
            require_once "../config.php";

            // Attempt select query execution
            $sql = "SELECT * FROM employees";
            if ($result = mysqli_query($mysqli, $sql)) {
              if (mysqli_num_rows($result) > 0) {
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>#</th>";
                echo "<th>Type</th>";
                echo "<th>Title</th>";
                echo "<th>Thumbnail</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                  // if ($row['type'] = 'video') {
                  // echo video html
                  // } else if ($row['type'] = 'pdf') {
                  // echo pdf html
                  // JS should also be called somehow
                  // onload parameters function?
                  // Or just load javascript by use of mysql somwhow
                  // }
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['name'] . "</td>";
                  echo "<td>" . $row['address'] . "</td>";
                  echo "<td>" . $row['salary'] . "</td>";
                  echo "<td>";
                  echo "<a href='read.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                  echo "<a href='update.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                  echo "<a href='delete.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                  echo "</td>";
                  echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
              } else {
                echo "<p class='lead'><em>No records were found.</em></p>";
              }
            } else {
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
            }

            // Close connection
            mysqli_close($mysqli);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>