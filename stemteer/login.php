<?php
	//session session_start
  session_start();
  ini_set( 'display_errors', 1 );
 error_reporting( E_ALL );
	 include "conn.php";

   ?>
   <!DOCTYPE html>
   <html>
   <head>
     <!-- Standard Meta -->
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

     <!-- Site Properties -->
     <title>Login</title>
      <link rel="stylesheet" type="text/css" href="lib/semantic/dist/semantic.min.css">
     <script type="text/javascript" src="lib/jquery.js"></script>
     <script type="text/javascript" src="lib/semantic/dist/semantic.min.js"></script>

     <script src="assets/library/jquery.min.js"></script>
     <script src="lib/semantic/dist/components/form.js"></script>
     <script src="lib/semantic/dist/components/transition.js"></script>

     <style type="text/css">
       body {
         background-color: #DADADA;
       }
       body > .grid {
         height: 100%;
       }
       .image {
         margin-top: -100px;
       }
       .column {
         max-width: 450px;
       }
     </style>

   </head>
   <body>
     <?php
      if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = md5($_POST['password']);
      if(isset($email) && $email != "" && isset($password) && $password != ""){
        $con = mysqli_connect($con_host, $con_user, $con_pass);
        $db = mysqli_select_db($con,  $con_db);
       	if(mysqli_error($con)){
         echo mysqli_error();
        }
        //Create query
        $query ="SELECT * FROM users WHERE email='$email' AND password= '$password'";
        $result = mysqli_query($con, $query);
        //Check whether query is SUccessful or not
          if(mysqli_num_rows($result) > 0){
              //Login SUccessful
              $user = mysqli_fetch_assoc($result);
              $_SESSION['SESS_USER_ID'] = $user['userId'];
              $_SESSION['SESS_MAIL'] = $user['email'];
              $_SESSION['SESS_PASS'] = $user['password'];
            //  $_SESSION['SESS_PRIVILEDGE'] = $user['priviledgeId'];

                  header("location: stemteers.php");
                    exit;
          }else{
            //Login Failed
            $EMSG_ARR = 'Record not found!';
          }
     }
     }
?>
<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="assets/images/logo.png" class="image">
      <div class="content">
        Log-in to your account
      </div>
    </h2>
    <form action = "login.php" method="post" class="ui large form">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="email" placeholder="E-mail address">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <input type = "submit" name = "login" value="Login" class="ui fluid large teal submit button" />
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      New to us? <a href="signup.php">Sign Up</a>
    </div>
  <?php include "shared/footer.php"; ?>
</div>
</div>
</body>

</html>
