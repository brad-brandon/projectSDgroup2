<?php
session_start();
include "user.php";
$_SESSION['username']=$_POST['username'];  
$_SESSION['password']=$_POST['password'];  

$username=$_POST['username']; 
$password=$_POST['password']; 

$isValidUser = validatePassword($username,$password);

if($isValidUser)
	{
		$userType=getUserType($username);
		if($userType =='CUSTOMER')
		{
			header("location:../customerMenu.php");
		}
		else
		{
			header("location:../staffMenu.php");
		
		}
	}
else {
	echo "Wrong Username or Password";
	echo '<br><a href="../login.php">Try Again?</a>';
	}
?>