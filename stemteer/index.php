<?php
    if(isset($_SESSION['EMSG_ARR'])){
      echo $_SESSION['EMSG_ARR'];
      unset($_SESSION['EMSG_ARR']);
    }
    //Array to store validations errors
    $EMSG_ARR = "";
    //Input validations

    if(isset($_POST['signup'])){
      $required = array('firstname', 'middleName', 'surname', 'email', 'phone', 'password', 'con_password');
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
          $password = $_POST['password'];
          //Create query
          $sql ="INSERT INTO users (firstname, middleName, surname, email, phoneNum, password) VALUES ('".$_POST["firstname"]."','".$_POST["middleName"]."','".$_POST["surname"]."', '".$_POST["email"]."','".$_POST["phone"]."', '".md5($_POST["password"])."')";
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
                http://elchi-heron.com/activated.php?email='.$email.'&password='.$password.'

                '; //Message and link included

                $headers = 'From:noreply@elchi-heron.com' . "\r\n"; //Set the header_register_callback
                mail($to, $subject, $message, $headers); //Sends the mail
                echo "New records created successfully";

                header("location: validated.php");
                  exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
        }
      }
      include "conn.php";

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
<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>STEMTeers</title>
  <link rel="icon" href="images/sci2.jpg" type="shortcut-icon">
  <link rel="stylesheet" type="text/css" href="lib/semantic/dist/semantic.min.css">
  <script type="text/javascript" src="lib/jquery.js"></script>
  <script type="text/javascript" src="lib/semantic/dist/semantic.min.js"></script>

  <style type="text/css">
    .hidden.menu {
      display: none;
    }
    .masthead{
      background-image: url('images/pix.jpg') !important;
      background-repeat: no-repeat !important;
      background-size: 100% !important;
      background-attachment: fixed !important;
      background-position: center;

      /*background-color: #b47408 !important;*/
    }
    .masthead.segment {
      min-height: 700px;
      padding: 1em 0em;
    }
    .masthead .logo.item img {
      margin-right: 1em;
    }
    .masthead .ui.button{
      background-color: #F2711C !important;
      color: #000000 !important;
    }
    .masthead .ui.menu .ui.button {
      margin-left: 0.5em;
    }
    .masthead h1.ui.header {
      margin-top: 3em;
      margin-bottom: 0em;
      font-size: 4em;
      font-weight: normal;
    }
    .masthead h2 {
      font-size: 1.7em;
      font-weight: normal;
    }
    .ui.vertical.stripe {
      padding: 8em 0em;
    }
    .ui.vertical.stripe h3 {
      font-size: 2em;
    }
    .ui.vertical.stripe .button + h3,
    .ui.vertical.stripe p + h3 {
      margin-top: 3em;
    }
    .ui.vertical.stripe .floated.image {
      clear: both;
    }
    .ui.vertical.stripe p {
      font-size: 1.33em;
    }
    .ui.vertical.stripe .horizontal.divider {
      margin: 3em 0em;
    }
    .quote.stripe.segment {
      padding: 0em;
    }
    .quote.stripe.segment .grid .column {
      padding-top: 5em;
      padding-bottom: 5em;
    }
    .footer.segment {
      padding: 5em 0em;
    }
    .secondary.pointing.menu .toc.item {
      display: none;
    }
    @media only screen and (max-width: 700px) {
      .ui.fixed.menu {
        display: none !important;

      }
      .secondary.pointing.menu .item,
      .secondary.pointing.menu .menu {
        display: none;
      }
      .secondary.pointing.menu .toc.item {
        display: block;
      }
      .masthead.segment {
        min-height: 350px;
      }
      .masthead h1.ui.header {
        font-size: 2em;
        margin-top: 1.5em;
      }
      .masthead h2 {
        margin-top: 0.5em;
        font-size: 1.5em;
      }
      a{

      }
    }
  </style>

  <script src="assets/library/jquery.min.js"></script>
  <script src="lib/semantic/dist/components/visibility.js"></script>
  <script src="lib/semantic/dist/components/sidebar.js"></script>
  <script src="lib/semantic/dist/components/transition.js"></script>
  <script>
  $(document)
    .ready(function() {
      // fix menu when passed
      $('.masthead')
        .visibility({
          once: false,
          onBottomPassed: function() {
            $('.fixed.menu').transition('fade in');
          },
          onBottomPassedReverse: function() {
            $('.fixed.menu').transition('fade out');
          }
        })
      ;
      // create sidebar and attach to menu open
      $('.ui.sidebar')
        .sidebar('attach events', '.toc.item')
      ;
    })
  ;
  </script>
</head>
<body>


<!-- Page Contents -->
<div class="pusher">
    <div class="ui inverted vertical masthead center aligned segment">
    <div class="ui container">
      <div class="ui large secondary grey pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="item" href="stemteers.php" style="font-size:18px; font-weight:bold">Home</a>
        <a class="item" href="mentors.php" style="font-size:18px; font-weight:bold">Mentors</a>
        <a class="item" href="volunteers.php" style="font-size:18px; font-weight:bold">Volunteers</a>
        <a class="item" href="students.php" style="font-size:18px; font-weight:bold">Students</a>
        <a class="item" href="communities.php" style="font-size:18px; font-weight:bold">Resource Communities</a>
        <a class="item" href="careers.php" style="font-size:18px; font-weight:bold">Careers</a>
        <div class="right item">
          <a data-modal="modal1" id="call1" class="ui button">Log in</a>
          <a data-modal="modal2" id="call2" class="ui button">Sign Up</a>
        </div>
      </div>
    </div>

    <div class="ui text container">
      <h1 class="ui inverted header"  style="font-family:cursive; font-weight:bold; color:#F2711C;">
        STEMTeers
      </h1>
      <h2 style=" color:#F2711C;"> Inspire | Connect | Engage</h2>
      <div class="ui huge primary button">Get Started <i class="right arrow icon"></i></div>
    </div>
  </div>
  <div class="ui united basic modal" id="modal2">
  <i class="close icon"></i>
  <div class="header">
    Sign Up
  </div>
  <div class="content">
    <form action = "signup.php" method="post" class="ui form">
      <div class="ui stacked segment">
        <div class="field">
            <input type="text" name="firstname" placeholder="First Name">
        </div>
        <div class="field">
            <input type="text" name="surname" placeholder="Last Name">
        </div>
        <div class="field">
            <input type="text" name="middleName" placeholder="Other name(s)">
          </div>
        <div class="field">
            <input type="text" name="email" placeholder="E-mail address">
        </div>
        <div class="field">
            <input type="text" name="phone" placeholder="Phone Number">
        </div>

        <div class="field">
            <input type="password" name="password" placeholder="Password">
        </div>
        <div class="field">
            <input type="password" name="con_password" placeholder="Confirm Password">
        <!-- <input type = "submit" name = "signup" value="Sign Up" class="ui fluid large orange submit button" /> -->
        </div>
          <div class="actions">
            <div class="two fluid ui inverted buttons">
              <div class="ui cancel red basic button">
                <i class="remove icon"></i>
                Cancel
              </div>
              <div type = "submit" name = "signup" class="ui ok green basic button">
                <i class="checkmark icon"></i>
                Submit
              </div>
            </div>
          </div>
        <div class="ui error message"></div>
      </form>
      <div class="ui message" style="padding-left:350px; font-size:16px">
        Already Signed Up? <a href="" data-modal="modal1" id="call1" >Log in</a>
      </div>
    </div>
  </div>

  <div class="ui united small modal" id="modal1">
  <i class="close icon"></i>
  <div class="header">
    Login
  </div>
  <div class="content">
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

          <div class="ui message" style="padding-left:280px; font-size:16px">
            New to us? <a href="" data-modal="modal2" id="call2" >Sign Up</a>
          </div>
          </div>
        </div>

  <div class="ui vertical stripe segment">
    <div class="ui middle aligned stackable grid container">
      <div class="row">
        <div class="eight wide column">
          <h3 class="ui header">We Help STEM volunteers connect</h3>
          <p> We build IT SOlutions to solve STEM Problems</p>
          <h3 class="ui header"> We Help startups begin with an IT edge.</h3>
          <p> We open you to a possibilies of possibilities!!.</p>
        </div>
        <div class="six wide right floated column">
          <img src="assets/images/wireframe/white-image.png" class="ui large bordered rounded image">
        </div>
      </div>
      <div class="row">
        <div class="center aligned column">
          <a class="ui huge button">Check Them Out</a>
        </div>
      </div>
    </div>
  </div>
        <div class="seven wide column">
          <h4 class="ui inverted header">Footer Header</h4>
          <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
        </div>
      </div>
    </div>
<?php include "shared/footer.php"; ?>
</div>
<script type="text/JavaScript">
$('.united.modal').modal({
	// this parameter will enable/disable the closing for the previous .united modals when the next will be opened :)
	allowMultiple: false,
});
// attach events
// haven't attached events over button of modal 3
$('#modal1').modal('attach events', '#call1');
$('#modal2').modal('attach events', '#call2');
// disable the comment bellow to call the modal 4 after click on button into modal 3
//$('#modal4').modal('attach events', '#btn-modal-3');
// Individual events - unecessary but i does it.
$('div .button').on('click', function(){
	// using the attribute data-modal to identify for what modal the button references
	modal = $(this).attr('data-modal');
	// creating the individual event attached to click over button
	$('#'+modal+'.modal').modal(
		'show'
	);
});
</script>
</body>
</html>
