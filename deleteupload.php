<!--
 * ============================================================================
 *                                       🤓
 *              Copyright (c) 12/06/2020 - TechCampus All Rights Reserved
 *                    www.TechCampus.com - Support@TechCampus.com
 * ============================================================================
 *-->
<?php
session_start();
include("config.php");
if(!isset($_SESSION["login_user"])) {  
  header("location: index.php");
} 
// Check if the form was submitted
if($_GET["id"]){

	$id = $_GET["id"];

	$sql = "DELETE FROM uploads WHERE id='$id'";
		if(mysqli_query($db, $sql)){
		    header("location: dashboard.php");
		} else{
		    header("location: dashboard.php");
		}

}
?>