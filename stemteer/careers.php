<?php //session session_start
  session_start();
  include "conn.php";

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
  ?>
  <?php include "shared/header.php" ?>
  <?php include "shared/sidebar.php" ?>
  <div id="content">
      <div div="ui container">
        <h1 class="ui block header"> Contact Us</h1>
        <img class="ui small left floated image" src="images/rec.jpg">
        <p>Te eum doming eirmod, nominati pertinacia argumentum ad his. Ex eam alia facete scriptorem, est autem aliquip detraxit at. Usu ocurreret referrentur at, cu epicurei appellantur vix. Cum ea laoreet recteque electram, eos choro alterum definiebas in. Vim dolorum definiebas an. Mei ex natum rebum iisque.</p>
        <img class="ui small right floated image" src="/images/wireframe/text-image.png">
        <p>Audiam quaerendum eu sea, pro omittam definiebas ex. Te est latine definitiones. Quot wisi nulla ex duo. Vis sint solet expetenda ne, his te phaedrum referrentur consectetuer. Id vix fabulas oporteat, ei quo vide phaedrum, vim vivendum maiestatis in.</p>
         <p>Eu quo homero blandit intellegebat. Incorrupte consequuntur mei id. Mei ut facer dolores adolescens, no illum aperiri quo, usu odio brute at. Qui te porro electram, ea dico facete utroque quo. Populo quodsi te eam, wisi everti eos ex, eum elitr altera utamur at. Quodsi convenire mnesarchum eu per, quas minimum postulant per id.</p>
      </div>
  </div>
</div>
<script >
$(document).ready(function() {
    $('.ui.dropdown').dropdown();
});
</script>
  <?php include "shared/footer.php"; ?>
</body>
</html>
