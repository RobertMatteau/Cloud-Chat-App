<!--

Robert Matteau
100522340
March 1, 2017

This file is where the users can logout from teh home.php



-->

<?php
	session_start();

	//destroys the session
	session_destroy();

	//unsets the username vale
	unset($_SESSION['username']);

	//changes the location
	header("location: register.php");


?>