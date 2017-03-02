<!--

Robert Matteau
100522340
March 1, 2017

This file is where the Chat system looks to take the data from the logs tabel to load into the display


-->

<?php

//creates a connection
$con = mysql_connect('localhost','root','');
mysql_select_db('authentication',$con);


//querys the data
$myQuery = "SELECT * FROM logs ORDER BY id DESC";
$result1 = mysql_query($myQuery);

//echos the results
while($extract = mysql_fetch_array($result1)) {

    echo "<span class = 'uname'>" . $extract['username'] . "</span>: <span class = 'msg'> " . $extract['msg'] . "</span><br/><br/>";

}
?>﻿