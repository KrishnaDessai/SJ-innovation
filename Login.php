<?php
include "partials/_dbconnect.php";
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $email=$_POST['email'];
  $password = $_POST['password'];


  $sql = "select * from users where email='$email'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;

        $_SESSION['emailId'] = $row['email'];
        header("location:index.php");
      } else {
        $showError = true;
      }
    }
  } else {
    $showError = true;
  }
}
require "partials/_nav.php";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  
  <?php
  if ($login) {
    echo '<div class="alert alert-success" role="alert">
    <strong>Success!</strong> You are logged in.
</div>';
  }
  if ($showError) {
    echo '<div class="alert alert-danger" role="alert">
    <strong>Error!</strong> Invalid Credentials </div>';
  }
  ?>

  <div class="container my-4">
    <h1 style="text-align: center;">Login to our website</h1>
    <form action="/sj_innovation/Login.php" method="Post" style="display: flex;
        flex-direction:column;
        align-items:center;">
     

      <div class="mb-3 col-md-6">
        <label for="email" class="form-label">Email </label>
        <input type="email" class="form-control" id="email " name="email" placeholder="Enter Email">
      </div>

      <div class="mb-3 col-md-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
      </div>

      <button type="submit" class="btn btn-primary col-md-6">Sign up</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>