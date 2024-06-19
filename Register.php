<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "partials/_dbconnect.php";

    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $contact=$_POST['contact'];

    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // check whether this username exits;
    $exitSql = "select * from `users` where email='$email'";
    $result = mysqli_query($conn, $exitSql);
    $numExitRows = mysqli_num_rows($result);
    if ($numExitRows > 0) {
        $showError = '<strong>Error!</strong>Username Already Exits.</div>';
    } else {

        // make sure that no field is empty
        if ( $email == '' ||$password == '' ||  $cpassword == '') {
            $showError = '<strong>Error! </strong>fill all the fields</div>';
        } else {
            // check whether password and confirm password are same
            if ($password == $cpassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`firstname`,`lastname`,`contact`,`email`, `password`) VALUES ('$fname','$lname','$contact','$email', '$hash')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $showAlert = true;
                }
            } else {
                $showError = '<strong>Error!</strong>password do not match.</div>';;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    require "partials/_nav.php";

    if ($showAlert) {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You have successfully signed up and now you can login to your website.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error</strong> Please Fill All the Fields;
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
    <div class="container my-4">
        <h1 style="text-align: center;">Register to Our website</h1>
        <form action="/sj_innovation/Register.php" method="Post" style="display: flex;
        flex-direction:column;
        align-items:center;">
            <div class="mb-3 col-md-6">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" maxlength="50" class="form-control" id="fname" name="fname">
            </div>

            <div class="mb-3 col-md-6">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" maxlength="50" class="form-control" id="lname" name="lname">
            </div>
            <div class="mb-3 col-md-6">
                <label for="contact" class="form-label">Contact no.</label>
                <input type="tel" maxlength="15" class="form-control" id="contact" name="contact">
            </div>



            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" maxlength="40" class="form-control" id="email " name="email" placeholder="Enter Email">
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="40" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3 col-md-6">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" maxlength="40" class="form-control" id="cpassword" name="cpassword" aria-describedby="ConfirmPass">
                <div id="ConfirmPass" class="form-text">Make sure u type the same password.</div>

            </div>

            <button type="submit" class="btn btn-primary col-md-6">Register</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>