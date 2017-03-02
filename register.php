<!--

Robert Matteau
100522340
March 1, 2017

This file is where the the users can register and log into the system.



-->

<?php

  session_start();

  //connect to database
  $db = mysqli_connect("localhost", "root", "", "authentication");

  //if the signup button is pressed to sign up
  if (isset($_POST['button_signup'])) {

    //checks to see if reCaptcha was done
    if( isset($_POST['g-recaptcha-response']) && !empty( $_POST['g-recaptcha-response'] ) ) {

      //reCaptca keep and location for information to be verified
      $secret = '6LeVShcUAAAAAC8r5VpXNZ5Cs5XKg0Cgthpbv6Ll';
      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
      $responseData = json_decode($verifyResponse);
    
      //get infro from the textboxes
      $username_signup = mysql_real_escape_string($_POST['username_signup']);
      $email_signup = mysql_real_escape_string($_POST['email_signup']);
      $password1_signup = mysql_real_escape_string($_POST['password1_signup']);
      $password2_signup = mysql_real_escape_string($_POST['password2_signup']);

      //runs if the recapta worked
      if($responseData->success) 
      {

      //checks to make sure the passwords matched
      if($password1_signup == $password2_signup) {
          

          $password1_signup = md5($password1_signup); 
          //hash password before storing it

          //query the database to insert the info into usres tabeke
          $sql_signup = "INSERT INTO users(username, email, password) VALUES('$username_signup', '$email_signup', '$password1_signup')";
          mysqli_query($db, $sql_signup);

          //creates session values
          $_SESSION['message'] = "You are now logged in";
          $_SESSION['username'] = $username_signup;
          
          // change location to home page
          header("location: home.php"); 

      }else {
          //failed
          $_SESSION['message_signup'] = "The passwords do not match";
      }
    }

      else
      {
        //recpatca faile
        $_SESSION['message_recaptcha'] = "Robot verification failed, please try again.";
      }

    }

    else 
    {
            //recaptcha not used
            $_SESSION['message_recaptcha'] = 'Please click on the reCAPTCHA box.';
        }
  }



  

  //checks if the login button was pressed
  if (isset($_POST['button_login']))  {

      //sets values from entered text
      $username_login = mysql_real_escape_string($_POST['username_login']);
      $password_login = mysql_real_escape_string($_POST['password_login']);

      //hashed passwords
      $password_login = md5($password_login); 

      //query the database to confirm user
      $sql_login = "SELECT * FROM users WHERE username = '$username_login' AND password = '$password_login'";
      $result = mysqli_query($db, $sql_login);


      //if user is found
      if(mysqli_num_rows($result) == 1) 
      {

        //creats session values
        $_SESSION['message'] = "You are now logged in";
        $_SESSION['username'] = $username_login;

        //changes location
        header("location: home.php"); 
      }

      else
      {
        //if user not found
        $_SESSION['message_login'] = "Username or Password incorrect";
      }

  }

// if forgot password button is pressed
  if (isset($_POST['button_pass'])) {
    //changes location
    header("location: missingpass.php");
  }

  

?>


<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Chat Room</title>
  <!-- set style and api links -->
  <script src="https://www.google.com/recaptcha/api.js"></script>

  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
<!-- create a form for the info-->
  <div class="form">

  <ul class="tab-group">
  <!-- create the tabs -->
    <li class="tab active"><a href="#signup">Sign Up</a></li>
    <li class="tab"><a href="#login">Log In</a></li>
  </ul>



  <div class="tab-content">
    <div id="signup">
      <h1>Sign Up for Free</h1>

      <?php
      //used to display the error messages

        //signup error message
        if (isset($_SESSION['message_signup'])) 
        {
        echo "<div id='error_msg'>".$_SESSION['message_signup']."</div>";
        unset($_SESSION['message_signup']);
        }

        //recaptcha error message
        else if (isset($_SESSION['message_recaptcha'])) 
        {
        echo "<div id='error_msg'>".$_SESSION['message_recaptcha']."</div>";
        unset($_SESSION['message_recaptcha']);
        }
      ?>


      <form action="register.php" method="post">

      <!-- sets text fields for all the values wanted -->
        <div class="field-wrap">
          <label>
                Username<span class="req">*</span>
              </label>
          <input type="text" name="username_signup" required autocomplete="off" />
        </div>

        <div class="field-wrap">
          <label>
              Email Address<span class="req">*</span>
            </label>
          <input type="email" name="email_signup" required autocomplete="off" />
        </div>

        <div class="field-wrap">
          <label>
              Set A Password<span class="req">*</span>
            </label>
          <input type="password" name="password1_signup" required autocomplete="off" />
        </div>

        <div class="field-wrap">
          <label>
                Re-enter Password<span class="req">*</span>
              </label>
          <input type="password" name="password2_signup" required autocomplete="off" />
        </div>

        <!-- recaptcha api placement-->
        <div class="g-recaptcha" align="center" data-sitekey="6LeVShcUAAAAAB3jGdgqsRO--4OmhjtW9F6tdJmr"></div>

        <!-- button used to sign up -->
        <button type="submit" name="button_signup" class="button button-block" />Get Started</button>

      </form>

    </div>

    <!--login tab-->
    <div id="login">
      <h1>Welcome Back!</h1>

     <?php

      //error message for login
        if (isset($_SESSION['message_login'])) 
        {
        echo "<div id='error_msg'>".$_SESSION['message_login']."</div>";
        unset($_SESSION['message_login']);
        }
      ?>

      <form action="register.php" method="post">

          <!-- text fields for login -->
        <div class="field-wrap">
          <label>
              Username<span class="req">*</span>
            </label>
          <input type="text" name="username_login" required autocomplete="off" />
        </div>

        <div class="field-wrap">
          <label>
              Password<span class="req">*</span>
            </label>
          <input type="password" name="password_login" required autocomplete="off" />
        </div>

        <!-- forgot passwrod button -->
        <p class="forgot"><button name="button_pass"/>Forgot Password?</a></p>

        <!-- login button -->
        <button type="submit" name="button_login" class="button button-block" />Log In</button>

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
