<?php

	session_start();
	require_once("connection.php");
	$name=$_POST['name'];
	$pass=$_POST['pass'];

	$q="select * from teacher where tname='$name' AND pass='$pass'";
	$result=mysqli_query($con,$q);
	if(mysqli_num_rows($result)==1)
	{	
		$row=mysqli_fetch_array($result);
		$tid=$row['tid'];

		$_SESSION['tid']=$tid;
		header('location:teacher.php');
	}

?>