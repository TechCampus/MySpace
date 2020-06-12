<!--
 * ============================================================================
 *                                       🤓
 *              Copyright (c) 12/06/2020 - TechCampus All Rights Reserved
 *                    www.TechCampus.com - Support@TechCampus.com
 * ============================================================================
 *-->
<?php
$salt = 'TechCampus';
session_start();
include("config.php");
if(!isset($_SESSION["login_user"])) {  
  header("location: index.php");
} 

$username = $_SESSION["login_user"];

////get the uploaded files
$sql = "SELECT * FROM uploads where 1=1 order by id desc";
$result = mysqli_query($db,$sql);


// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

  if($_POST['oldpassword'] != '' && $_POST['newpassword'] != '' && $_POST['confirmpassword'] != '') {

     if ($_POST['oldpassword'] == '') {
          header("location: dashboard.php");
      }

         if($_POST['oldpassword'] <> '') {
              $re = '/^[a-zA-Z0-9\s\p{Arabic}]{1,60}$/iu';
              $str = $_POST['oldpassword'];
              $match = preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
                if($match == 0){
                    header("location: dashboard.php");
                }
          }


           if ($_POST['newpassword'] == '') {
              header("location: dashboard.php");
          }

         if($_POST['newpassword'] <> '') {
              $re = '/^[a-zA-Z0-9\s\p{Arabic}]{1,60}$/iu';
              $str = $_POST['newpassword'];
              $match = preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
                if($match == 0){
                    header("location: dashboard.php");
                }
          }

          if ($_POST['confirmpassword'] == '') {
              header("location: dashboard.php");
          }

         if($_POST['confirmpassword'] <> '') {
              $re = '/^[a-zA-Z0-9\s\p{Arabic}]{1,60}$/iu';
              $str = $_POST['confirmpassword'];
              $match = preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
                if($match == 0){
                    header("location: dashboard.php");
                }
          }

    ///get the old password
    $sql1 = "SELECT * FROM users where 1=1";
    $result1 = mysqli_query($db,$sql1);
    $row1= mysqli_fetch_array($result1,MYSQLI_ASSOC);
    $password = $row1['password'];

    $oldpasswordval = md5($_POST['oldpassword'].$salt);

    if($password == $oldpasswordval) {
      ////
      if($_POST['newpassword'] == $_POST['confirmpassword']) {

        $password_new = md5($_POST['newpassword'].$salt);

        $sql = "UPDATE users SET password='$password_new' where username ='$username'";
        $result = mysqli_query($db,$sql);

        header("location: dashboard.php");

      }

    } else {
      header("location: dashboard.php");
    }

  }
  
   

}


?>
<!DOCTYPE html>
<html lang="en" data-dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="MySpace" />
    <meta charset="utf-8">
    <meta property="og:image" content="images/logo.png" />
    <meta property="og:title" content="Cloud MySpace " />
    <meta property="og:description" content="MySpace" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title>Cloud MySpace</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a75fd39b78.js" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar hdrnav">
    <div class="container">
      <div class="row">
        <div class="col-xs-4 col-sm-4 text-center">
          <form action="upload.php" id="uploadform" name="uploadform" method="post" enctype="multipart/form-data">
            <label class="lblupload" for="imgupload">
              +
            </label>
            <input type="file" name="imgupload" id="imgupload" style="display: none;">
             <div class="progress" style="display: none;">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>
            <button type="submit" class="btn btncss" id="uploadbtn" tabindex="5" disabled=""><i class="fa fa-upload" aria-hidden="true" style="font-size: 14px;"></i></button>
            <p class="errormsg" style="color:red;"></p>
          </form>
        </div>
        <div class="col-xs-4 col-sm-4 text-center">
        <a class="navbar-brand text-center logocenter" href="javascript:void(0);"><img src="images/logo.png" class="img-responsive"></a>
        <h3 class="compname">Cloud MySpace</h3>
        </div>
        <div class="col-xs-4 col-sm-4 text-center">
          <button class="setbtn btncss">Settings</button>
          <button class="logoutbtn btncss" >Logout</button>
        </div>
      </div>
    </div>
  </nav>
  <div class="content-sec">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive topspace">
            <table class="member-tb table-fixed table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Time</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                <tr>
                  <td><a href="/uploads/<?php echo $row['file'];?>" target="_blank"><?php echo $row['file'];?></a></td>
                  <td><?php echo $row['timestamp'];?></td>
                  <td class="closerow"><a href="deleteupload.php?id=<?php echo $row['id'];?>"><p><i class="fal fa-times"></i></p></a></td>
                </tr>
              <?php } ?> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footersec">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 text-center">
          <p>Cloud MySpace</p>
          <h3>Powered By TechCampus</h3>
        </div>
      </div>
    </div>
  </footer>
  <div class="modal" id="changepasswordmdl" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form  method="post" enctype="multipart/form-data">
          <div class="col-xs-12 col-sm-12">
            <h3 class="warningmaintit">Change Password</h3>
            <div class="form-group">
              <label class="lbltit">Old Password</label>
              <input type="password" name="oldpassword" id="oldpassword" class="inputcontrol" placeholder="****" required="">
            </div>
            <div class="form-group">
              <label class="lbltit">New Password</label>
              <input type="password" name="newpassword" id="newpassword" class="inputcontrol" placeholder="****" required="">
            </div>
            <div class="form-group">
              <label class="lbltit">Confirm Password</label>
              <input type="password" name="confirmpassword" id="confirmpassword" class="inputcontrol" placeholder="****" required="">
            </div>
          </div>
          <div class="btnsec row">
            <div class="col-xs-6 col-sm-6 rtlcol">
              <button type="submit" class="btn mdlbtncss" id="cofirm_alert">Yes</button>
            </div>
            <div class="col-xs-6 col-sm-6 rtlcol">
              <button type="button" class="btn mdlbtncss" data-dismiss="modal">No</button>
            </div>              
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">

    $(document).ready(
    function(){
        $('input:file').change(
            function(){
                if ($(this).val()) {
                    $('#uploadbtn').attr('disabled',false);
                } 
            }
            );
    });




    $(document).on("click",".setbtn",function(){
        $("#changepasswordmdl").modal();
    });

    
     $(document).on("click",".logoutbtn",function(){
        window.location.href="logout.php";
    });

    ///
    // $(document).on("click","#uploadbtn",function(){

    //   var data = new FormData($('#uploadform')[0]);

    //    $.ajax({
    //       type:"POST",
    //       url:'upload.php',
    //       data:data,
    //       dataType: "json",
    //       mimeType: "multipart/form-data",
    //       contentType: false,
    //       cache: false,
    //       processData: false,
    //       // xhr: function () {
    //       //     var xhr = new window.XMLHttpRequest();
    //       //     xhr.upload.addEventListener("progress", function (evt) {
    //       //                     $('.progress').show();
                              
    //       //                       if (evt.lengthComputable) {
    //       //                           var percentComplete = evt.loaded / evt.total;
    //       //                           percentComplete = parseInt(percentComplete * 100);
    //       //                           $('.myprogress').text(percentComplete + '%');
    //       //                           $('.myprogress').css('width', percentComplete + '%');
    //       //                       }
    //       //                   }, false);
    //       //                   return xhr;
    //       //   },
    //       success:function(data) { 
    //         //$('.progress').hide();
    //         alert(4)
    //         // if(data != 0) {
    //         //   alert(data);
    //         //   window.location.href = 'dashboard.php';
    //         // } else {
    //         //   $('.errormsg').html('file is not uploaded');

    //         //   setTimeout(function(){
    //         //      window.location.href = 'dashboard.php';        
    //         //   },1000);

    //         // }


    //       }

    //     });

    // });
  </script>
</body>
</html>