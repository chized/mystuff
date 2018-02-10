<?php
	//session session_start
  session_start();
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
  <title>SignUp</title>
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
      max-width: 600px;
    }
  </style>

</head>
<body>
  <?php
      if(isset($_SESSION['EMSG_ARR'])){
        echo $_SESSION['EMSG_ARR'];
        unset($_SESSION['EMSG_ARR']);
      }
      //Array to store validations errors
      $EMSG_ARR = "";
      //Input validations

      if(isset($_POST['signup'])){
        $required = array('firstname', 'middleName', 'surname', 'email', 'phone', 'altPhone', 'postalAdd', 'password', 'con_password');
        $error = false;
          foreach($required as $field) {
            if (empty($_POST[$field])) {
              $error = true;
            }
          }
          if ($error) {
            echo "All fields are required.";
          } elseif($_POST['password'] !== $_POST['con_password']){
            echo "Your password feilds do not match!!";
          }else{
            $con = mysqli_connect($con_host,$con_user,$con_pass);
            $db = mysqli_select_db($con,$con_db);
            if(mysqli_error($con)){
              echo mysqli_error();
              die();
            }
            $firstname = $_POST['firstname'];
            $middleName = $_POST['middleName'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $altPhone = $_POST['altPhone'];
            $postalAdd = $_POST['postalAdd'];
            $password = $_POST['password'];
            //Create query
            $sql ="INSERT INTO users (firstname, middleName, surname, email, phoneNum, altPhoneNum, postalAdd, password) VALUES ('".$_POST["firstname"]."','".$_POST["middleName"]."','".$_POST["surname"]."', '".$_POST["email"]."','".$_POST["phone"]."','".$_POST["altPhone"]."','".$_POST["postalAdd"]."', '".md5($_POST["password"])."')";
            //$result = mysqli_query($con, $query);
            if (mysqli_multi_query($con, $sql)) {
                //  echo "New records created successfully";
                include 'mail.php';
                  $to = $email; //wher email is going to
                  $subject = 'Sign up verification';
                  $message = ' Thanks for signing up!
                  Your account has been created, you can login in with
                  the following credentials
                  --------------------
                  Username: '.$_POST['email'].'
                  Password: '.$_POST['password'].'
                  -----------------------
                  Please click this link to activate your account:
                  http://stemteers.org/activated.php?email='.$email.'&password='.$password.'

                  '; //Message and link included

                  $headers = 'From:noreply@elchi-heron.com' . "\r\n"; //Set the header_register_callback
                  mail($to, $subject, $message, $headers); //Sends the mail
                  echo "New records created successfully";

                  header("location: validated.php");
                    exit;
              } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($con);
              }

            // if ($con->query($result) === TRUE) {
            // echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
            // } else {
            // echo "<script type= 'text/javascript'>alert('Error: " . $result . "<br>" . $con->error."');</script>";
            // //echo "Complete!!";
            // }

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
    <form action = "signup.php" method="post" class="ui large form">
      <div class="ui stacked segment">
        <div class="field">
            <input type="text" name="firstname" placeholder="First Name">
        </div>
        <div class="field">
            <input type="text" name="middleName" placeholder="Middle Name">
          </div>
        <div class="field">
            <input type="text" name="surname" placeholder="Last Name">
        </div>
        <div class="field">
            <input type="text" name="email" placeholder="E-mail address">
        </div>
        <div class="field">
            <input type="text" name="postalAdd" placeholder="Postal Address">
        </div>
        <div class="field">
            <input type="text" name="phone" placeholder="Phone Number">
        </div>
        <div class="field">
            <input type="text" name="altPhone" placeholder="Alternate Phone Number">
        </div>
        <div class="field">
            <input type="password" name="password" placeholder="Password">
        </div>
        <div class="field">
            <input type="password" name="con_password" placeholder="Confirm Password">
        <input type = "submit" name = "signup" value="Sign Up" class="ui fluid large teal submit button" />
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      Already Signed Up? <a href="login.php">Log in</a>
    </div>
    <?php include "shared/footer.php"; ?>
  </div>
</div>

</body>

</html>
