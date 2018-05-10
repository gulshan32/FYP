<?php

	session_start();
	require_once("connection.php");
	$name=$_POST['name'];
	$pass=$_POST['pass'];

	$q="select * from student where sname='$name' AND pass='$pass'";
	$result=mysqli_query($con,$q);
	if(mysqli_num_rows($result)==1)
	{	
		$row=mysqli_fetch_array($result);
		$sid=$row['sid'];

		$_SESSION['sid']=$sid;
		header('location:student.php');
	}

?>