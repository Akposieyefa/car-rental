<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>

<title>Car Rental | Vehicle Details</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Listing-Image-Slider-->

<?php 
$vhid=intval($_GET['vhid']);
$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:vhid";
$query = $dbh -> prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$_SESSION['brndid']=$result->bid;  
?>  

<section id="listing_img_slider">
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4);?>" class="img-responsive"  alt="image" width="900" height="560"></div>
  <?php if($result->Vimage5=="")
{

} else {
  ?>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>
<!--/Listing-Image-Slider-->


<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>$<?php echo htmlentities(number_format($result->Price, 2));?> </p>
         
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="main_features">
          <ul>
          
            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->ModelYear);?></h5>
              <p>Reg.Year</p>
            </li>
            <li> <i class="fa fa-cogs" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->FuelType);?></h5>
              <p>Fuel Type</p>
            </li>
       
            <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->SeatingCapacity);?></h5>
              <p>Seats</p>
            </li>
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap"> 
            <!-- Nav tabs -->
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle Overview </a></li>
          
              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accessories</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content"> 
              <!-- vehicle-overview -->
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                
                <p><?php echo htmlentities($result->VehiclesOverview);?></p>
              </div>
              
              
              <!-- Accessories -->
              <div role="tabpanel" class="tab-pane" id="accessories"> 
                <!--Accessories-->
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Accessories</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Air Conditioner</td>
<?php if($result->AirConditioner==1)
{
?>
                      <td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?> 
   <td><i class="fa fa-close" aria-hidden="true"></i></td>
   <?php } ?> </tr>

<tr>
<td>AntiLock Braking System</td>
<?php if($result->AntiLockBrakingSystem==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
                    </tr>

<tr>
<td>Power Steering</td>
<?php if($result->PowerSteering==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   

<tr>

<td>Power Windows</td>

<?php if($result->PowerWindows==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   
 <tr>
<td>CD Player</td>
<?php if($result->CDPlayer==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Leather Seats</td>
<?php if($result->LeatherSeats==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Central Locking</td>
<?php if($result->CentralLocking==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Power Door Locks</td>
<?php if($result->PowerDoorLocks==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
                    </tr>
                    <tr>
<td>Brake Assist</td>
<?php if($result->BrakeAssist==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php  } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Driver Airbag</td>
<?php if($result->DriverAirbag==1)
{
?>
<td class="text-success"><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
 </tr>
 
 <tr>
 <td>Passenger Airbag</td>
 <?php if($result->PassengerAirbag==1)
{
?>
<td class="text-success"><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Crash Sensor</td>
<?php if($result->CrashSensor==1)
{
?>
<td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
<?php }} ?>
   
      </div>
      
      <!--Side-Bar-->
      <aside class="col-md-4">
      
        <div class="share_vehicle">
          <p>Share: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
        </div>
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Buy Now</h5>
            <p class="text-small">Order Summary.</p>
          </div>
          <style type="text/css">
.cart-item {
  display: flex;
  justify-content: space-around;
  align-items: center;
}




          </style>
          <form method="post" action="paystack/init.php">
            <div class="form-group">
              <div class="cart-item">
                <div class="col-4">
                <img class="img-fluid" height="65.72" width="65.72" src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>">
              </div>
                
                <div class="col-8">
                      <div class="row d-flex justify-content-center"><b>$ <?php echo htmlentities(number_format($result->Price, 2));?></b></div>
                      <div class="row d-flex text-muted justify-content-center"><?php echo htmlentities($result->VehiclesTitle);?></div>
                      <div class="row d-flex justify-content-center"><?php echo htmlentities($result->BrandName);?></div>
                  </div>
              </div>
              <hr>
                <div class="">
                    <span class="col text-left cost-details-title">Subtotal</span>
                    <span class="col text-right" style="float: right;">$ <?php echo htmlentities(number_format($result->Price, 2));?></span>
                </div>
                <div class="">
                    <span class="col text-left cost-details-title">Delivery</span>
                    <span class="col text-right"style="float: right;">Free</span>
                </div>
                <div class="">
                    <span class="col text-left cost-details-title"><b>Total to pay</b></span>
                    <span class="col text-right" style="float: right;"><b>$ <?php echo htmlentities(number_format($result->Price, 2));?></b></span>
                </div>

              <input type="hidden" class="form-control" name="VehicleId" value="<?php echo $vhid; ?>" required>
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" name="userEmail" value="<?php echo $_SESSION['login']; ?>" required>
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" name="amount" value="<?php echo $result->Price ?>" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="Leave a Message" required></textarea>
            </div>
          <?php if($_SESSION['login'])
              {?>
              <div class="form-group">
                <input type="submit" class="btn"  name="submit" value="Buy Now">
              </div>
              <?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login To Purchase</a>

              <?php } ?>
          </form>
          <p class="text-muted text-center">Complimentary Shipping & Returns</p> 
        </div>
      </aside>
      <!--/Side-Bar--> 
    </div>
    
    <div class="space-20"></div>
    <div class="divider"></div>
    
    <!--Similar-Cars-->
    <div class="similar_cars">
      <h3>Similar Cars</h3>
      <div class="row">
<?php 
$bid=$_SESSION['brndid'];
$sql="SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,tblvehicles.Vimage1 from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.VehiclesBrand=:bid";
$query = $dbh -> prepare($sql);
$query->bindParam(':bid',$bid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>      
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></a></h5>
              <p class="list-price">$<?php echo htmlentities($result->PricePerDay);?></p>
          
              <ul class="features_list">
                
             <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity);?> seats</li>
                <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear);?> model</li>
                <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType);?></li>
              </ul>
            </div>
          </div>
        </div>
 <?php }} ?>       

      </div>
    </div>
    <!--/Similar-Cars--> 
    
  </div>
</section>
<!--/Listing-detail--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>