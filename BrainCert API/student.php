<?php
	require_once("connection.php");

session_start();
if(isset($_SESSION['sid'])){

	$sid=$_SESSION['sid'];
	echo "Welcome Student";
?>

	<form action="" method="POST">
		<input type="submit" name="jl" value="Join Live Class">
	</form>

<?php
if(isset($_POST['jl'])){
	
	$q="select * from class c JOIN teacher_student ts on c.tid=ts.tid having ts.sid='$sid'";
	$result=mysqli_query($con,$q);
	$row=mysqli_fetch_array($result);
	$cid=$row['cid'];

	$url="https://api.braincert.com/v2/getclasslaunch?apikey=myVdYnTDnMCLT1vKJhhY";


	$curl=curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "class_id=".$cid."&userId=".$sid."&userName=Asad Aftab Khanzada&isTeacher=0&courseName=PHP&lessonName=PHP Lessons&lessonTime=60&isRecord=0");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($curl);
	$response=json_decode($response,true);
?>

<h2>Student</h2>
<iframe allow="camera; microphone" src="<?php echo $response['launchurl']; ?>" height="600" style="width:100%;"></iframe>


<?php 
}}
else {
	header('location:index-student.php');
}
