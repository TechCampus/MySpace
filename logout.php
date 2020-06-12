<?php
session_start();
if(!isset($_SESSION["login_user"])) {  
  header("location: index.php");
} else {
    $_SESSION['login_user'] = '';
    session_unset();

    header("location: index.php");
}