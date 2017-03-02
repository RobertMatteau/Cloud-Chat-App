<!--

Robert Matteau
100522340
March 1, 2017

This file is where the chat messages that the users enter go into the database..



-->

<?php
session_start();

//gets teh username and message saved
$uname = (isset($_SESSION['username']) ? $_SESSION['username']:null);
$msg = (isset($_REQUEST['msg']) ? $_REQUEST['msg'] : null);


//sets the connection to the database
$con = mysql_connect('localhost','root','');
mysql_select_db('authentication',$con);

//query the mysql to insert the data
mysql_query("INSERT INTO logs (`username` , `msg`) VALUES ('$uname', '$msg')");


$result1 = mysql_query("SELECT * FROM logs ORDER by id DESC");

//extract the data from the table
while($extract = mysql_fetch_array($result1)) {
    echo "<span class = 'uname'>" . $extract['username'] . "</span>: <span class = 'msg'> " . $extract['msg'] . "</span><br/>";
}

?>
