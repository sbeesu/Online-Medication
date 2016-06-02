<?php 
//Start session
session_start();
echo "<script>alert('Succefully logged out');</script>";
	// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
	
	echo "<script>window.location = '/db-project/login.php';</script>";
	exit();
?>