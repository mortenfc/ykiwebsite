<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$type = $address = $salary = "";
$type_err = $address_err = $salary_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate name
  $input_type = trim($_POST["type"]);
  if (empty($input_type)) {
    $type_err = "Please enter a type.";
  // } elseif (!filter_var($input_type, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    // $type_err = "Please enter a valid type.";
  } else {
    $type = $input_type;
  }

  // Validate address
  $input_address = trim($_POST["address"]);
  if (empty($input_address)) {
    $address_err = "Please enter an address.";
  } else {
    $address = $input_address;
  }

  // Validate salary
  $input_salary = trim($_POST["salary"]);
  if (empty($input_salary)) {
    $salary_err = "Please enter the salary amount.";
  } elseif (!ctype_digit($input_salary)) {
    $salary_err = "Please enter a positive integer value.";
  } else {
    $salary = $input_salary;
  }

  // Check input errors before inserting in database
  if (empty($type_err) && empty($address_err) && empty($salary_err)) {
    // Prepare an insert statement
    $sql = "INSERT INTO employees (type, address, salary) VALUES (?, ?, ?)";
    // $sql = "INSERT INTO employees (type, address, salary) VALUES (?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sss", $param_type, $param_address, $param_salary);

      // Set parameters
      $param_type = $type;
      $param_address = $address;
      $param_salary = $salary;

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Records created successfully. Redirect to landing page
        header("location: CRUDLandingPage.php");
        exit();
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

  <link rel="icon" href="../media/logo.jpg">
  <meta charset="UTF-8">
  <title>Create Record</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header">
            <h2>Create Record</h2>
          </div>
          <p>Please fill this form and submit to add employee record to the database.</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
              <label>Type</label>
              <select name="name" class="form-control">
                <option value="pdf">PDF</option>
                <option value="video">Video</option>
                <option value="podcast">Podcast</option>
              </select>
              <span class="help-block"><?php echo $type_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
              <label>Address</label>
              <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
              <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
              <label>Salary</label>
              <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
              <span class="help-block"><?php echo $salary_err; ?></span>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="CRUDLandingPage.php" class="btn btn-default">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>