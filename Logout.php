<?php

session_start();
session_unset();    //frees all session variables currently registred
session_destroy();
header("location:Login.php");  //redirect to login.php
exit;
?>