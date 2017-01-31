<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php
    $first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
    $last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';

    $errors = [];

    if (is_blank($first_name)) {
      $errors[] = "First name cannot be blank.";
    } else if (!has_length($first_name, array(
      'min' => 2,
      'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($last_name)) {
      $errors[] = "Last name cannot be blank.";
    } else if (!has_length($last_name, array(
      'min' => 2,
      'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($email)) {
      $errors[] = "Email cannot be blank.";
    } else if (!has_valid_email_format($email)) {
      $errors[] = "Email must be valid format.";
    }

    if (is_blank($username)) {
      $errors[] = "Username cannot be blank.";
    } else if (!has_length($username, array(
      'min' => 8))) {
      $errors[] = "Username must be at least 8 characters.";
    } else if (!has_length($username, array(
      'max' => 255))) {
      $errors[] = "Username must be between 8 and 255 characters.";
    }
    
    if (empty($errors) && $_SERVER['REQUEST_METHOD'] == 'POST') {
      $created = date("Y-m-d H:i:s");
      $first_name_esc = mysqli_real_escape_string($db, $first_name);
      $last_name_esc = mysqli_real_escape_string($db, $last_name);
      $email_esc = mysqli_real_escape_string($db, $email);
      $username_esc = mysqli_real_escape_string($db, $username);
      $sql = "INSERT INTO users " .
              "(first_name, last_name, email, username, created_at)" .
              "VALUES('$first_name_esc', '$last_name_esc', '$email_esc', '$username_esc', '$created')";

      $result = db_query($db, $sql);

      if (!$result) {
        die('Could not enter data: ' . mysqli_error($db));
      } else {
        redirect_to('registration_success.php');
      }
      
    }
?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    if (isset($errors) && !empty($errors))  {
      print(display_errors($errors));
    }
  ?>

  <form method="POST">
      First name:<br> 
      <input type="text" name="first_name" value="<?php echo h($first_name) ?>"><br>
      Last name: <br>
      <input type="text" name="last_name" value="<?php echo h($last_name) ?>"><br>
      Email: <br>
      <input type="text" name="email" value="<?php echo h($email) ?>"><br>
      Username: <br>
      <input type="text" name="username" value="<?php echo h($username) ?>"><br>
      <br>
      <input type="submit" value="Submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
