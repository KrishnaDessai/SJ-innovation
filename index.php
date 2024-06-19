<?php
session_start();
$search="";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location:Login.php");
  exit;
}
$showAlert = false;
$successfullyAdded = false;
$Pendingbutton = false;
$deleteSuccessfully=false;
$taskcompletedSuccessfully=false;
$profileUpdateSuccessfully=false;
$updateSuccessfully=false;

include "partials/_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // profile update
      if(isset($_POST['userid'])){
            
        // update the record
            $fname = $_POST['fnameProfile'];
            $lname = $_POST['lnameProfile'];
            $contact = $_POST['contactProfile'];
            $id = $_POST['userid'];


        

            $sql ="UPDATE `users` SET `firstname` = '$fname', `lastname` = '$lname', `contact` = '$contact' WHERE (`id` = '$id')";

            $result = mysqli_query($conn, $sql);

            if($result){
              $profileUpdateSuccessfully = true;
            }


            

    }

    // update the record
    if (isset($_POST['snoEdit'])) {
          $sno = $_POST['snoEdit'];
          $user_id = $_POST['uid_Edit'];
          $title = $_POST['titleEdit'];
          $desc = $_POST['descriptionEdit'];

          // echo $sno.",".$user_id.",".$title.",".$desc;
          // exit();
          $sql = "UPDATE `tasks` SET `user_id` = '$user_id', `title` = '$title', `description` = '$desc' WHERE (`id` = '$sno')";

          $result = mysqli_query($conn, $sql);


          if ($result) {
            $updateSuccessfully = true;
          } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> We are facing some technical issue and Your task was not updated sucessfully! We regret the inconvinience caused!!;
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
          }
    } 

    // Search records
    if(isset($_POST['search'])){
        $search = $_POST['search'];        
    }

    // Mark as incomplete
    if (isset($_POST['incomplete'])) {
      $sno = $_POST['statusIncomplete'];
      $sql = "UPDATE `tasks` SET `status` = 'pending' WHERE (`id` = '$sno')";
      $result = mysqli_query($conn, $sql);

      if ($result) {
       $Pendingbutton = true;
      }
    } 

    // Mark as complete
    if (isset($_POST['complete'])) {
      $sno = $_POST['statusComplete'];
      $sql = "UPDATE `tasks` SET `status` = 'completed' WHERE (`id` = '$sno')";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        $taskcompletedSuccessfully = true;
      }
    }

    // insert the record
    if(isset($_POST['u_id'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user_id = $_POST['u_id'];
        
        if($title && $user_id &&  $description){
          $sql = "INSERT INTO `tasks`(user_id,title,description) values('$user_id','$title','$description')";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $successfullyAdded = true;
          } else  {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> We are facing some technical issue and Your task was not  submitted sucessfully! We regret the inconvinience caused!!;
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
          }
        }
        else{
          $showAlert = true;
        }
      }
      }else{
        if (isset($_GET['delete'])) {
          $sno = $_GET['delete'];
          //  echo $sno;

          $sql = "DELETE FROM `tasks` WHERE (`id` = $sno)";
          $Delete = mysqli_query($conn, $sql);

          if ($Delete) {
            $deleteSuccessfully=true;
          } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> We are facing some technical issue and Your task was not updated sucessfully! We regret the inconvinience caused!!;
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
          }
        }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- jQery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
  <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>


  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>

  <title>Task Management System</title>


</head>

<body>
  <!-- Modal- edit form-->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit this Task</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="/sj_innovation/index.php" method="post">

          <div class="modal-body">
            <form action="/sj_innovation/index.php" method="post">
              <!-- hidden Tag -->
              <input type="hidden" name="snoEdit" id="snoEdit">

              <div class="mb-3">
                <label for="title" class="form-label">User Id</label>
                <input type="text" class="form-control" id="uid_Edit" name="uid_Edit" />
              </div>
              <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" />
              </div>

              <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>

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


  <?php
  require "partials/_nav.php";
  if ($showAlert) {
    echo '<div style="position:relative" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> Please Fill All the Fields;
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    
    }
    if ($successfullyAdded) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Successful</strong>  task has been submitted sucessfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($Pendingbutton){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Status updated successfully!</strong> and set to pending.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($deleteSuccessfully){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Successful</strong>  task has been deleted sucessfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if($taskcompletedSuccessfully){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Status updated successfully!</strong> and set to completed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($profileUpdateSuccessfully){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Profile updated successfully!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($updateSuccessfully){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Successful</strong>  task has been updated sucessfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
  ?>

  <div class="container mt-4">

    <h2> Add your Tasks </h2>

    <form action="/sj_innovation/index.php" id="addTaskForm" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">User Id</label>
        <input type="int" class="form-control" id="u_id" name="u_id" placeholder=" Enter The User ID" />
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder=" Enter The Task Title" />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Task Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" placeholder=" Enter The Task Description"></textarea>

      </div>
      <div class="container ">
        <button id="Add_task" type="submit" class="btn btn-primary">Add task</button>
      </div>
    </form>
  </div>

  <div class="container my-5">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">User Id</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Status</th>
          <th scope="col">Created_at</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php
    
        if($search == 0 ){
          $sql = "SELECT * FROM `tasks`";
          }else{
            $sql = "SELECT * FROM `tasks` WHERE `title` LIKE '%$search%' OR `description` LIKE '%$search%'";
        }
            
            
        $result = mysqli_query($conn, $sql);
        $num_Rows = mysqli_num_rows($result);
        $sno = 0;
        if ($num_Rows > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $sno++;
            echo "<tr>
            <th scope='row'>$sno</th>
            <td>" . $row['user_id'] . "</td>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description']  . "</td>
            <td>" . $row['status'] . "</td>
            <td>" . $row['created_at'] . "</td>
            <td>
              <button type='button' class='btn btn-sm btn-info edit' id=" . $row['id'] . ">Edit</button>
              <button type='button' class='btn btn-sm btn-danger delete' id='d" . $row['id'] . "'>Delete</button>";

            if ($row['status'] == 'pending') {
              echo "<form method='post' action='/sj_innovation/index.php' class='d-inline'>
                <input type='hidden' name='statusComplete' value='" . $row['id']  . "'>
                <button type='submit' name='complete' class='btn btn-sm btn-success complete'>Completed</button>
              </form>";
            } else {
              echo " <form method='post' action='/sj_innovation/index.php' class='d-inline'>
                <input type='hidden' name='statusIncomplete' value='" . $row['id']  . "'>
                <button type='submit' name='incomplete' class='btn btn-sm btn-warning incomplete'>Pending</button>
              </form>";
            }

            echo " </td>
          </tr>";
          }
        }
        ?>
  </div>
  </tbody>
  </table>

  </div>
  <hr>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- edit -->
  <script>
    let edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        // console.log("edit",e.target.parentNode.parentNode);
        tr = e.target.parentNode.parentNode;
        u_id = tr.getElementsByTagName("td")[0].innerText;
        title = tr.getElementsByTagName("td")[1].innerText;
        description = tr.getElementsByTagName("td")[2].innerText;
        // console.log(title,description);

        titleEdit.value = title;
        descriptionEdit.value = description;
        uid_Edit.value = u_id;
        snoEdit.value = e.target.id;
        
        // console.log(snoEdit.value);
        $('#editModal').modal('toggle');
      })
    })

    // Delete
    let deleted = document.getElementsByClassName('delete');
    Array.from(deleted).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete?", e.target.parentNode.parentNode);
       

       let sno = e.target.id.substr(1, );

        if (confirm("Are you sure? want to Delete this tasks")) {

          window.location = `/sj_innovation/index.php?delete=${sno}`;


        }
        
      })
    })

    //status - incomplete
    let incomplete_status = document.getElementsByClassName('incomplete');
    Array.from(incomplete_status).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("incomplete", e.target.parentNode.parentNode);

        sno = e.target.id.substr(1, );

        if (confirm("Are you sure? your task is still pending?")) {

          window.location = `/sj_innovation/index.php?pending=${sno}`;


        }


      })
    })


    //status - complete
    let complete_status = document.getElementsByClassName('complete');
    Array.from(complete_status).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("incomplete", e.target.parentNode.parentNode);

        sno = e.target.id.substr(1, );

        if (confirm(" your task complete?")) {

          window.location = `/sj_innovation/index.php?complete=${sno}`;

        }


      })
    })

  </script>

<script src="script.js"></script>
</body>

</html>