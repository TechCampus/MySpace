<!--
 * ============================================================================
 *                                       🤓
 *              Copyright (c) 12/06/2020 - TechCampus All Rights Reserved
 *                    www.TechCampus.com - Support@TechCampus.com
 * ============================================================================
 *-->
<?php
include("config.php");
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["imgupload"]) && $_FILES["imgupload"]["error"] == 0){
        $filename = $_FILES["imgupload"]["name"];
        $filetype = $_FILES["imgupload"]["type"];
        $filesize = $_FILES["imgupload"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        
            // Check whether file exists before uploading it
            if(file_exists("uploads/" . $filename)){
               header("location: dashboard.php");
            } else{
                move_uploaded_file($_FILES["imgupload"]["tmp_name"], "uploads/" . $filename);

                ////save to db
                $sql = "INSERT INTO uploads (file) VALUES ('$filename') ";
      					$result = mysqli_query($db,$sql);

      				header("location: dashboard.php");
            } 
       
    } else{
        header("location: dashboard.php");
    }
}
?>