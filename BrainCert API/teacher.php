<?php
	require_once("connection.php");

session_start();
if(isset($_SESSION['tid'])){

	$tid=$_SESSION['tid'];
	echo "Welcome  Teacher";
?>
	<form action="" method="POST">
		<input type="submit" name="sc" value="Schdule a Class">
	</form>

	<form action="" method="POST">
		<input type="submit" name="lc" value="Launch Class">
	</form>

<?php
if(isset($_POST['sc'])){
	
	$url="https://api.braincert.com/v2/schedule?apikey=myVdYnTDnMCLT1vKJhhY";
	$curl=curl_init();
	$data=array("title"=>"Test Class","timezone"=>"90","start_time"=>"10:43AM","end_time"=>"11:00AM","date"=>"2018-04-18");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($curl);
	$response=json_decode($response,true);
	print_r($response);
	$cid=$response['class_id'];

	$q="insert into class(cid,tid) values ($cid,$tid)";
	$result=mysqli_query($con,$q);
	if($result){
		echo "Your Class Is Now Schduled";
	}

}
if(isset($_POST['lc'])){
	
	$q="select cid from class where tid='$tid'";
	$result=mysqli_query($con,$q);
	$row=mysqli_fetch_array($result);
	$cid=$row['cid'];

	$url="https://api.braincert.com/v2/getclasslaunch?apikey=myVdYnTDnMCLT1vKJhhY";

	$curl=curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS,"class_id=".$cid."&userId=".$tid."&userName=Hasnain Abid Khanzada&isTeacher=1&courseName=PHP&lessonName=PHP Lessons&lessonTime=60&isRecord=0");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($curl);
	$response=json_decode($response,true);

?>
<h2>Teacher</h2>

<iframe allow="camera; microphone" src="<?php echo $response['launchurl']; ?>" height="600" style="width:100%;"></iframe>


<?php 
}}
else {
	header('location:index-teacher.php');
}
