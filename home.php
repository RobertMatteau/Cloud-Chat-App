<!--

Robert Matteau
100522340
March 1, 2017

This file is where the chat part of the app was code into the system allowing the users to chat between eachother.



-->

<?php
  session_start();

  
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
	<title>ChatRoom</title>
	<!--<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">-->
  <link rel="stylesheet" type="text/css" href="css/chat.css" />


  <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
  <!-- this is where i styled my ssytem -->  
  <style type="text/css">
      #box{
        width: 425px;
        margin: 0 auto;
        border: 2px dotted grey;

      }
      #chatlogs{
        height: 600px;
        align-content: right;
        overflow-y: scroll;
        overflow-x: hidden;
        padding: 20px;
      }
      input[type=text]{
          width: 85%;
          padding: 10px;
          box-sizing: border-box;
          border-radius: 4px;
          margin: 10px;
          background-color: #F8F8F8;

      }
      #button_clear{
        padding: 10px;
        color: white;
        background-color: grey;
      }
      #button2{
        padding: 10px;
        color: white;
        background-color: green;
        width: 90px;
      }
      a {
            text-decoration: none;
            background-color: gray;
            padding: 13px 20px 13px 20px;
            color: white;
        }
        
        a:hover {
            background-color: darkgray;
        }
  </style>
  <script>
//this function was used when the submit chat button was pressed.
      function submitChat(){

//alert if no message
 if(form1.msg.value == '' ){
  alert('Enter your message');
  return;
 }

 var msg = form1.msg.value;
 var xmlhttp = new XMLHttpRequest();
 
 //waited for state change to update statud
 xmlhttp.onreadystatechange = function(){
 if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
  document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
  }
 

 }
 xmlhttp.open('GET','insert.php?&msg='+msg, true);
 xmlhttp.send();
 
 
}
//function used to empty chat when clear is pressed
function emptyChat(){
  <?php

  //made a connection to the database and then deleted the logs.
  $conn = mysqli_connect('localhost','root','', 'authentication');
  $sql = "DELETE * FROM logs";
  mysqli_query($conn, $sql);

  ?>
}

//used ajax to constantly reload the chatlogs
$(document).ready(function(e){
 $.ajaxSetup({cache:false});
 setInterval(function(){$('#chatlogs').load('logs.php');}, 2000);
});

  </script>
</head>
<body>
    <form name="form1">
      
        <table border="1" align="right" width="100%">
        <tr>
        <td width ="120">Your Chat Name:</td><td width="500px"><b><?php echo $_SESSION['username']; ?></b></td> <!-- this is where the user's login name would be displayed. -->
        <td width="50px">
        
        <button onclick= "emptyChat()">Clear</button></td>
        </tr>
        
      
        <td>
        <div margin_top = "5px"> Online Users:</div>

        <?php
          //code to access the database and list all the users
          $uname = (isset($_SESSION['username']) ? $_SESSION['username']:null);
        $con = mysqli_connect('localhost','root','', 'authentication');
          $result1 = mysqli_query($con, "SELECT username FROM users");

          //checks to see if ther are users
      if ($result1->num_rows > 0) {
      // output data of each row
        while($row = $result1->fetch_assoc()) {
        
         echo "<br>". $row["username"]. "<br>";

      }
      } else {
          echo "0 results";
      }
        ?>
        </td>

        <td>
        
      <div id="chatlogs">LOADING CHATLOGS PLEASE WAIT...</div>
      </td>
      
      </table>

      <div id="chatbox">
        <input type="text" name="msg" id="msg" placeholder="Enter message here">
        <a href= "#" onclick= "submitChat()" class= "button">Send</a><!--create the button that has an effect on the system-->
        <br/>
      </div>
  
    </form>


  <div><a href="logout.php">Logout</a></div> <!-- uses the logout.php to leave the home.php location-->
</body>
</html>