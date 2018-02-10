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

   ?>
<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="assets/images/logo.png" class="image">
      <div class="content">
        <?php echo "Congratulations". $firstname; ?>
        You have successfully activated your account!!!
        Login to enter your account
      </div>
    </h2>


    <div class="ui message">
      <a href="login.php"> Log in</a>
    </div>
  </div>
</div>
<?php include "shared/footer.php"; ?>
</body>

</html>
