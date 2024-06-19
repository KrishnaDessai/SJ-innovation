





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">



</head>

<body>

  <?php
  if (isset($_SESSION['loggedin'])  && $_SESSION['loggedin'] == true) {
  
    $loggedin = true;
    
    $profile_email = $_SESSION['emailId'];
    include "partials/_dbconnect.php";
  
    // $sql = "SELECT * FROM `users`";
  
  $sql = "SELECT * FROM `users` where `email`='$profile_email'";
  $result=mysqli_query($conn,$sql,);
  
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);
  if ($num == 1) {

      // echo  $row['id'] ." ".$row['email'] ." ".$row['firstname'] ." ".$row['lastname']." ".$row['contact'] ;
  
      // echo "fnameProfile.value =".$row['firstname']."lnameProfile.value".$row['lastname']."contactProfile.value".$row['contact']."emailProfile.value".$row['email'];
  
    
  } else {
    $showError = true;
  }
  } else {
    $loggedin = false;
  
  }

  echo '<nav class="navbar bg-dark navbar-expand-lg" data-bs-theme="dark">
<div class="container-fluid">
  <span class="navbar-brand">Task Management System</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex w-100">';
  if ($loggedin) {
    echo ' <li class="nav-item me-auto">
          <a class="nav-link active" aria-current="page" href="/sj_innovation/index.php">Home</a>
        </li> ';
  }
  if (!$loggedin) {
    echo '<li class="nav-item  ">
          <a class="nav-link" href="/sj_innovation/Login.php" >Login</a>
      </li>
      <li class="nav-item ">
          <a class="nav-link" href="/sj_innovation/register.php">Register</a>
      </li> ';
  }

  if ($loggedin) {

    echo  '<li class="nav-item">
          <form id="form-submit" method="post" action="/sj_innovation/index.php" class="d-flex" role="search"> 
            <input id="UserSearchValue" name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          </form> 
         
        </li>';
  }


  if ($loggedin) {
    echo ' <li class="nav-item">
             <a class="nav-link" href="/sj_innovation/Logout.php">Logout</a>
         </li >' .

      '<li >
        <a  id="profile-set" class="nav-link" >
        <i class="fas fa-user-circle" style="font-size:1.5rem;color:white;">Profile</i>
        </a>
        
     </li>
  </ul>';
  }

  echo  ' </div>
  </div>
</nav>';
  ?>
  
<div class="modal" id="editProfile" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="form_profile"action="/sj_innovation/index.php" method="post">

            <div class="modal-body">
              <!-- hidden Tag -->
            
     <input type="hidden" name="userid" id="userid" value="<?php echo htmlspecialchars($row['id']); ?>">
 

              <div class="mb-3 col-md-6">
                <label for="firstname"  class="form-label">First Name</label>
                <input type="text" value="<?php echo htmlspecialchars($row['firstname']); ?>"  maxlength="50" class="form-control" id="fnameProfile" name="fnameProfile">
              </div>
              <div class="mb-3 col-md-6">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" maxlength="50" class="form-control" value="<?php echo htmlspecialchars($row['lastname']); ?>" id="lnameProfile" name="lnameProfile">
              </div>
              <div class="mb-3 col-md-6">
                <label for="contact" class="form-label">Contact no.</label>
                <input type="tel" maxlength="15" class="form-control" id="contactProfile" name="contactProfile" value="<?php echo htmlspecialchars($row['contact']); ?>">
              </div>

              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" maxlength="40" class="form-control" id="emailProfile " disabled name="emailProfile" value="<?php echo htmlspecialchars($row['email']); ?>">
              </div>

            </div>
            <div class="modal-footer d-block ">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script>
    let profile = document.getElementById('profile-set');

    profile.addEventListener("click", (e) => {
      tr = e.target.parentNode.parentNode;
      $('#editProfile').modal('toggle');
    })
   
  </script>

  <script src="script.js"></script>
</body>

</html>