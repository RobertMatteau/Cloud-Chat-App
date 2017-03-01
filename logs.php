<?php


$con = mysql_connect('localhost','root','');
mysql_select_db('authentication',$con);

$myQuery = "SELECT * FROM logs ORDER BY id DESC";
$result1 = mysql_query($myQuery);

while($extract = mysql_fetch_array($result1)) {

    echo "<span class = 'uname'>" . $extract['username'] . "</span>: <span class = 'msg'> " . $extract['msg'] . "</span><br/><br/>";

}
?>﻿