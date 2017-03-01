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

      function submitChat(){
 if(form1.msg.value == '' ){
  alert('Enter your message');
  return;
 }
 var msg = form1.msg.value;
 var xmlhttp = new XMLHttpRequest();
 
 xmlhttp.onreadystatechange = function(){
 if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
  document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
 
           }
 
 }
 xmlhttp.open('GET','insert.php?&msg='+msg, true);
 xmlhttp.send();
 
 
}

function emptyChat(){
  <?php
  $conn = mysqli_connect('localhost','root','', 'authentication');

  

  $sql = "DELETE * FROM logs";
  mysqli_query($conn, $sql);

  ?>
}
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
        <td width ="120">Your Chat Name:</td><td width="500px"><b><?php echo $_SESSION['username']; ?></b></td>
        <td width="50px">
        
        <button onclick= "emptyChat()">Clear</button></td>
        </tr>
        
      
        <td>
        <td>
        
      <div id="chatlogs"">LOADING CHATLOGS PLEASE WAIT...</div>
      </td>
      </td>
      </table>

      <div id="chatbox">
        <input type="text" name="msg" id="msg" placeholder="Enter message here">
        <a href= "#" onclick= "submitChat()" class= "button">Send</a>
        <br/>
      </div>
  
    </form>


  <div><a href="logout.php">Logout</a></div>
</body>
</html>