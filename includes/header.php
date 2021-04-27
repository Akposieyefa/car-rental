<?php
if (isset($_SESSION['login'])) {
  resetRemainder();
}

function resetRemainder() {
  global $dbh;
  $sql = $dbh->query("SELECT id,Duration, scheduledTime FROM `tblremainder` WHERE `userEmail`='{$_SESSION["login"]}'");
  $results = $sql->fetchAll(PDO::FETCH_OBJ);
  foreach ($results as $result) {
    $id = $result->id;
    $scheduledTime = $result->scheduledTime;
    $time = time();
    $now =  date('Y-m-d H:i:s', $time);

    if ($scheduledTime == $now) {
      $timestamp=strtotime($result->Duration);
      $scheduledTime =  date('Y-m-d H:i:s', $timestamp);
      $sql = $dbh->query("UPDATE `tblremainder` SET `scheduledTime`='$scheduledTime' WHERE `id`='$id'");
    }
  }
  
}

function checkRemainder() {
  global $dbh;
  $sql = $dbh->query("SELECT remainderTitle,Duration,status FROM `tblremainder` WHERE `userEmail`='{$_SESSION["login"]}' AND `status`=1");
  if ($sql->rowCount()>0) {
    $results = $sql->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $result) {

     echo $result->remainderTitle. ": every"." ".$result->Duration. " is <b>Active</b>";
    }
    //Remainder exist
  }
}

function countRemainder() {
  global $dbh;
  $sql = $dbh->query("SELECT count(*) FROM `tblremainder` WHERE `userEmail`='{$_SESSION["login"]}' AND `status`=1");
  $result = $sql->fetchColumn();
  return $result;
}

?>
<header>
  <div class="default-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo"> <a href="index.php"><h4>Car Sales/Rental Services</h4></a> </div>
        </div>
        <div class="col-sm-9 col-md-10">
          <div class="header_info">
         <?php
         $sql = "SELECT EmailId,ContactNo from tblcontactusinfo";
$query = $dbh -> prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
foreach ($results as $result) {
$email=$result->EmailId;
$contactno=$result->ContactNo;
}
?>   

            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
              <p class="uppercase_text">For Support Mail us : </p>
              <a href="mailto:<?php echo htmlentities($email);?>"><?php echo htmlentities($email);?></a> </div>
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
              <p class="uppercase_text">Service Helpline Call Us: </p>
              <a href="tel:<?php echo htmlentities($contactno);?>"><?php echo htmlentities($contactno);?></a> </div>
            <div class="social-follow">
            
            </div>
   <?php   if(strlen($_SESSION['login'])==0)
	{	
?>
 <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login / Register</a> </div>
<?php }
else{ 

echo "Welcome To Car rental portal";
 } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <?php
if (isset($_SESSION['login'])) {
  $res = countRemainder();
  ?>
  <li class="nav-item"><a href="#remainderBox" data-toggle="modal" data-dismiss="modal"><i class="fa fa-bell"></i><span class="badge badge-sm badge-danger"><?php echo $res; ?></span></a></li>
<?php
  
}
?>
            
            <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i> 
<?php 
$email=$_SESSION['login'];
$sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
	{

	 echo htmlentities($result->FullName); }}?>
   <i class="fa fa-angle-down" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
           <?php if($_SESSION['login']){?>
            <li><a href="profile.php">Profile Settings</a></li>
              <li><a href="update-password.php">Update Password</a></li>
            <li><a href="my-booking.php">My Booking</a></li>
            <li><a href="my-order.php">My Purchases</a></li>
            <li><a href="my-remainder.php">My Remainder</a></li>
            <li><a href="post-testimonial.php">Post a Testimonial</a></li>
          <li><a href="my-testimonials.php">My Testimonial</a></li>
            <li><a href="logout.php">Sign Out</a></li>
            <?php } ?>
          </ul>
            </li>
          </ul>
        </div>
        <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
          <form action="search.php" method="post" id="header-search-form">
            <input type="text" placeholder="Search..." name="searchdata" class="form-control" required="true">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a>    </li>          	 
          <li><a href="page.php?type=aboutus">About Us</a></li>
          <li><a href="car-listing.php">Car Listing</a>
          <li><a href="page.php?type=faqs">FAQs</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation end --> 
</header>
<div class="modal fade" id="remainderBox" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <?php if (isset($_SESSION['login'])) {
                
                ?>
                <ul class="list-group">
                <li class="list-group-item active"><?php echo $res = checkRemainder(); ?></li>
              </ul>
              <?php
              }
              ?>
              
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>