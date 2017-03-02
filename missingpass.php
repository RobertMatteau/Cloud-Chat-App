<!--

Robert Matteau
100522340
March 1, 2017

This file is where the users comes if they clicked on the forgot password button.
They can send sms through here to get their saved password from the database.



-->

<?php
  //starts the session
  session_start();

  //checks to see if the button is pressed
  if (isset($_POST['button_msg'])) {

   
    //gets the information added into the text boxes
    $username_pass = mysql_real_escape_string($_POST['username_pass']);
    $phone_pass = mysql_real_escape_string($_POST['phone_pass']);
    $uname = (isset($_SESSION['username']) ? $_SESSION['username']:null);

    //created a connection to the database
    $con = mysqli_connect('localhost','root','', 'authentication');

    //query for the passwords
    $result1 = mysqli_query($con, "SELECT password FROM users WHERE username = '$uname'");


    
    //sens message to the users phone depending on phone number
    $to = $phone_pass + "@vtext.com";
    $from = "ChatApp@chatapp.com";
    $message = $row["username"];
    mail($to, '', $message);

    //leave the session
     session_destroy();
    unset($_SESSION['username']);

    //change location 
    header("location: register.php");
   
   

  }


?>


<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Chat Room</title>
  <script src="https://www.google.com/recaptcha/api.js"></script>

  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <!-- used css stylesheet -->
  <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
<!-- page to allow users to enter information -->
  <div class="form">

  <ul class="tab-group">
    <li class="tab active"><a href="#signup">Missing Password</a></li>
  </ul>



  <div class="tab-content">
    <div id="signup">
      <h1>Missing Password</h1>

<!-- uses this class' as the action -->
     <form action="missingpass.php" method="post">

        <div class="field-wrap">
        <!-- set text boxes for the Username and the users phone number-->
          <label>
                Username<span class="req">*</span>
              </label>
          <input type="text" name="username_pass" required autocomplete="off" />
        </div>

        <div class="field-wrap">
          <label>
              Phone Number<span class="req">*</span>
            </label>
          <input type="Number" name="phone_pass" required autocomplete="off" />
        </div>
        <button type="submit" name="button_msg" class="button button-block" />Message</button>

      </form>

    </div>

  </div>
  <!-- tab-content -->

</div>
<!-- /form -->



  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>