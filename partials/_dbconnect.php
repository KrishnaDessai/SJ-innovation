<?php

$server="localhost";
$username="root";
$password="root";
// $database="sj_innovation";


// $conn=mysqli_connect($server,$username,$password,$database);

$conn=mysqli_connect($server,$username,$password);

if(!$conn){
    die("Error in connection due to ".mysqli_connect_error());
}
// else{
//     echo"connected sucessfully";
// }


// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS task_management_system";

if (!$conn->query($sql) === TRUE) {

    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db("task_management_system");


// SQL to create tasks table
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (user_id)
)";

if (!$conn->query($sql) === TRUE) {
    echo "Error creating table: " . $conn->error;
}

// SQL to create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(45) NOT NULL UNIQUE,
    password VARCHAR(255) UNIQUE,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    contact VARCHAR(30),
    PRIMARY KEY (id)
)";

if (!$conn->query($sql) === TRUE) {
    echo "Error creating table: " . $conn->error;
}


// Close connection
// $conn->close();
?>