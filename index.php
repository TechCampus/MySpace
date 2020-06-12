<!--
 * ============================================================================
 *                                       🤓
 *              Copyright (c) 12/06/2020 - TechCampus All Rights Reserved
 *                    www.TechCampus.com - Support@TechCampus.com
 * ============================================================================
 *-->
<?php
$salt = 'TechCampus';
 include("config.php");
   session_start();

   if(isset($_SESSION["login_user"])) {  
    header("location: dashboard.php");
  } 
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 

      if($_POST['username'] == '') {
          header("location: index.php");

      }
        // Validate email
      if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
         
      } else {
           header("location: index.php");
      }

      if ($_POST['password'] == '') {
          header("location: index.php");
      }

         if($_POST['password'] <> '') {
              $re = '/^[a-zA-Z0-9\s\p{Arabic}]{1,60}$/iu';
              $str = $_POST['password'];
              $match = preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
                if($match == 0){
                    header("location: index.php");
                }
          }

        
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);

      $password1 = md5($mypassword.$salt);
      
      $sql = "SELECT * FROM users WHERE username = '$myusername' and password = '$password1'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['id'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
    
      if($count == 1) {
         
         $_SESSION['login_user'] = $myusername;
         
         header("location: dashboard.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>

<!DOCTYPE html>
<html lang="en" data-dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" type="image/gif/png" href="images/logo.png">
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
  <nav class="navbar hdrnav1">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 text-center">
        <a class="navbar-brand" href="javascript:void(0);"><img src="images/logo.png" class="img-responsive"></a>
        <h3 class="compname">Cloud MySpace</h3>
        </div>
      </div>
    </div>
  </nav>
  <div class="content-sec">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="twitterbox1">
            <div class="loginbox">
              <h3 class="logintit">Log in to your account</h3>
              <div class="signblk">
                <form id="loginform" name="loginform" method="POST">
                  <div class="form-group">
                    <label class="lbltit">Email</label>
                    <input type="email" name="username" id="username" class="inputcontrol" placeholder="John@TechCampus.com">
                  </div>
                  <div class="form-group">
                    <label class="lbltit">Password</label>
                    <input type="password" name="password" id="password" class="inputcontrol" placeholder="*************">
                  </div>
                  <div class="btnsec text-center">
                    <p class="error" style="color: red;text-align: center;"></p>
                    <button type="submit" class="btn logbtn" tabindex="5">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
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
</body>
</html>