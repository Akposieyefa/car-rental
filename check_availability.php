<?php 
require_once("includes/config.php");


switch ($_POST['action']) {
	case 'remainder':
		setRemainder();
		break;

	default:
		# code...
		break;
}

// code user email availablity
if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "error : You did not enter a valid email.";
	}
	else {
		$sql ="SELECT EmailId FROM tblusers WHERE EmailId=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Email already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Email available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}

function setRemainder(){
	global $dbh;
	$arr = explode(" ", $_POST["interval"]);
	$time = time();
	$startTime =  date('Y-m-d H:i:s', $time);

	$timestamp=strtotime($_POST["interval"]);
	$scheduledTime =  date('Y-m-d H:i:s', $timestamp);

	if (!isset($_POST["myonoffswitchtrue"])) {
		$isChecked = 0;
	}
	else{
		$isChecked = 1;
	}
	  $sql = $dbh->query("INSERT INTO `tblremainder` (`VehicleId`, `PaymentId`, `userEmail`, `Duration`, `remainderTitle`, `status`, `startTime`, `scheduledTime`) VALUES ('{$_POST["vid"]}', '{$_POST["paymentId"]}', '{$_POST["userEmail"]}', '{$_POST["interval"]}', '{$_POST["title"]}', '$isChecked', '$startTime', '$scheduledTime')");
	  $lastInsertId = $dbh->lastInsertId();

	if ($lastInsertId) {
		$data =array(
	 		"status" => 200,
	 		"message" => 'Success: remainder set successfully!');
		echo json_encode($data);
	}
}

