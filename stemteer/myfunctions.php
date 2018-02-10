<?php
//This code is to check multiple values in a form: Example one
if(isset($_POST['signup'])){
$allOk = true;
$userArray = array('firstname', 'middleName', 'surname', 'email', 'phone', 'altPhone', 'postalAdd', 'password', 'con_password');
foreach($checkVars as $checkVar) {
 if(!isset($_POST[$checkVar]) OR !$_POST[$checkVar]) {
      $allOk = false;
      // break; // if you wish to break the loop
 }
}
if(!$allOk) {
// error handling here
echo "problems!!";
}
}
//This code is to check multiple values in a form: Example two

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
    } else {
      echo "Proceed...";
    }
  }
//php code for sending e-mail: example one
  //if "email" variable is filled out, send email
    if (isset($_REQUEST['email']))  {

    //Email information
    $admin_email = "someone@example.com";
    $email = $_REQUEST['email'];
    $subject = $_REQUEST['subject'];
    $comment = $_REQUEST['comment'];

    //send email
    mail($admin_email, "$subject", $comment, "From:" . $email);

    //Email response
    echo "Thank you for contacting us!";
    }

    //if "email" variable is not filled out, display the form
    else  {
  ?>

   <form method="post">
    Email: <input name="email" type="text" /><br />
    Subject: <input name="subject" type="text" /><br />
    Message:<br />
    <textarea name="comment" rows="15" cols="40"></textarea><br />
    <input type="submit" value="Submit" />
    </form>

  <?php
    }

?>
