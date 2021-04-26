<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="cancelled";
$sql = "UPDATE payments SET STATUS=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
  echo "<script>alert('Purchase Successfully Cancelled');</script>";
echo "<script type='text/javascript'> document.location = 'canceled-purchases.php; </script>";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status='confirmed';

$sql = "UPDATE payments SET STATUS=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
echo "<script>alert('Purchase Successfully Confirmed');</script>";
echo "<script type='text/javascript'> document.location = 'confirmed-purchases.php'; </script>";
}


 ?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Car Rental Portal | New Purchases   </title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Purchase Details</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Purchase Info</div>
							<div class="panel-body">


<div id="print">
								<table border="1"  class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%"  >
				
									<tbody>

									<?php 
$pid=intval($_GET['pid']);
									$sql = "SELECT `tblusers`.*,`tblbrands`.`BrandName`,`tblvehicles`.`VehiclesTitle`,`payments`.`DATE_CREATED`,`payments`.`DATE_UPDATE`,`payments`.`message`,`payments`.`AMOUNT_TO_PAY`,`payments`.`IP_ADDRESS`,`payments`.`VehicleId` as `vid`,`payments`.`STATUS`,`payments`.`id`,`payments`.`TXN_ID`
									  from `payments` join `tblvehicles` on `tblvehicles`.`id`=`payments`.`VehicleId` join `tblusers` on `tblusers`.`EmailId`=`payments`.`userEmail` join `tblbrands` on `tblvehicles`.`VehiclesBrand`=`tblbrands`.`id` where `payments`.`ID`=:pid";
$query = $dbh -> prepare($sql);
$query -> bindParam(':pid',$pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
	<h3 style="text-align:center; color:red">#<?php echo htmlentities($result->TXN_ID);?> Purchase Details </h3>

		<tr>
											<th colspan="4" style="text-align:center;color:blue">User Details</th>
										</tr>
										<tr>
											<th>Trx No.</th>
											<td>#<?php echo htmlentities($result->TXN_ID);?></td>
											<th>Name</th>
											<td><?php echo htmlentities($result->FullName);?></td>
										</tr>
										<tr>											
											<th>Email Id</th>
											<td><?php echo htmlentities($result->EmailId);?></td>
											<th>Contact No</th>
											<td><?php echo htmlentities($result->ContactNo);?></td>
										</tr>
											<tr>											
											<th>Address</th>
											<td><?php echo htmlentities($result->Address);?></td>
											<th>City</th>
											<td><?php echo htmlentities($result->City);?></td>
										</tr>
											<tr>											
											<th>Country</th>
											<td><?php echo htmlentities($result->Country);?></td>
											<th>IP:</th>
											<td ><?php echo htmlentities(long2ip($result->IP_ADDRESS));?></td>
										</tr>

										<tr>
											<th colspan="4" style="text-align:center;color:blue">Purchase Details</th>
										</tr>
											<tr>											
											<th>Vehicle Name</th>
											<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></td>
											<th>Purchase Date</th>
											<td><?php echo htmlentities($result->DATE_CREATED);?></td>
										</tr>
										<tr>
										</tr>
<tr>
	<th colspan="3" style="text-align:center">Grand Total</th>
	<td><?php echo htmlentities(number_format($result->AMOUNT, 2));?></td>
</tr>
<tr>
<th>Purchase Status</th>
<td><?php 
if($result->STATUS=='initialize')
{
echo htmlentities('Not Confirmed yet');
} else if ($result->STATUS=='confirmed') {
echo htmlentities('Confirmed');
}
 else{
 	echo htmlentities('Cancelled');
 }
										?></td>
										<th>Last pdation Date</th>
										<td><?php echo htmlentities($result->DATE_UPDATE);?></td>
									</tr>

									<?php if($result->STATUS=='initialize'){ ?>
										<tr>	
										<td style="text-align:center" colspan="4">
				<a href="purchase-details.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm this booking')" class="btn btn-primary"> Confirm Purchase</a> 

<a href="purchase-details.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Cancel this Booking')" class="btn btn-danger"> Cancel Purchase</a>
</td>
</tr>
<?php } ?>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>
								<form method="post">
	   <input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;"  />
	</form>

							</div>
						</div>

					

					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	<script language="javascript" type="text/javascript">
function f3()
{
window.print(); 
}
</script>
</body>
</html>
<?php } ?>
