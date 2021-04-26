<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
// Code for change password	
if(isset($_POST['submit']))
{

$PaymentPublicKey=$_POST['PaymentPublicKey'];
$PaymentSecretKey=$_POST['PaymentSecretKey'];
$secretKey = "Bearer $PaymentSecretKey";
$user=$_SESSION['alogin'];	
die($secretKey);
$sql="update admin set PaymentSecretKey=:secretKey,PaymentPublicKey=:PaymentPublicKey where UserName:user";
$query = $dbh->prepare($sql);
$query->bindParam(':secretKey',$secretKey,PDO::PARAM_STR);
$query->bindParam(':PaymentPublicKey',$PaymentPublicKey,PDO::PARAM_STR);
$query->bindParam(':user',$user,PDO::PARAM_STR);
$query->execute();
$msg="Info Updateed successfully";
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
	
	<title>Car Rental Portal | Admin Create Brand</title>

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
					
						<h2 class="page-title">Update API Info</h2>

						<div class="row">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading">Form fields</div>
									<div class="panel-body">
										<form method="post" name="api" class="form-horizontal" onSubmit="return valid();">
										
											
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
				<?php $sql = $dbh ->query("SELECT PaymentSecretKey, PaymentPublicKey FROM admin");
  if($sql->rowCount() > 0)
{
	$results = $sql->fetchAll(PDO::FETCH_OBJ);
  foreach ($results as $result) {
				?>	
											

											<?php
											if($result->PaymentSecretKey !== ''){
												?>
												<div class="form-group">
												<label class="col-sm-4 control-label">Current Secret Key</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo htmlentities($result->PaymentSecretKey);?>" disabled>
												</div>
											</div>
											<?php
											}

											?>

											<?php
											if ($result->PaymentPublicKey !== '') {
												?>
												<div class="form-group">
												<label class="col-sm-4 control-label">Current Public Key</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo htmlentities($result->PaymentPublicKey);?>" disabled>
												</div>
											</div>

											<?php
											}

											?>
											
											<div class="form-group">
												<label class="col-sm-4 control-label"> New API Secret Key</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="PaymentSecretKey" id="PaymentSecretKey" value="" required>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-4 control-label"> New API Public Key</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="PaymentPublicKey" id="PaymentPublicKey" value="">
												</div>
											</div>

<?php }} ?>
											<div class="hr-dashed"></div>
											
										
								
											
											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">
								
													<button class="btn btn-primary" name="submit" type="submit">Update</button>
												</div>
											</div>

										</form>

									</div>
								</div>
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

</body>

</html>
<?php } ?>