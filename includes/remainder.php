<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<script type="text/javascript">

 /* ===== Enable Before/After Send Ajax (on element  ====== */

  let beforeSend = function (btnId, btnClass, text){
    document.getElementById(btnId).innerHTML = text;
    const button = document.querySelector(btnClass);
    button.disabled=true;
  }

  let afterSend = function (btnId, btnClass, text, classEl){
    document.getElementById(btnId).innerHTML = text;
    const button = document.querySelector(btnClass);
    button.classList.add(classEl);   
    //button.disabled=false;   
  }

const valid = () => {
  let action = document.querySelector("#action").value;
  let vid = document.querySelector("#vid").value;
  let paymentId = document.querySelector("#paymentId").value;
  let userEmail = document.querySelector("#userEmail").value;
  let interval = document.querySelector("#interval").value;
  let title = document.querySelector("#title").value;
  var myonoffswitch=document.getElementById("myonoffswitch").checked;
  let statusMsg = document.getElementById("status-msg");

  beforeSend("submit-btn", ".submit-btn", "please wait...");
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
           const response = JSON.parse(this.responseText);
           if (response.status == 200) {
            statusMsg.innerHTML ="<span class='text-success'>"+response.message+"</span>";
           }else if(response.status == 403){
            statusMsg.innerHTML ="<span class='text-danger'>"+response.message+"</span>";
           }else{
            statusMsg.innerHTML ="<span class='text-danger'>"+response.message+"</span>";
           }
        }
      }
  };
  xhttp.open("POST", "check_availability.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action="+action+"&vid="+vid+"&paymentId="+paymentId+"&userEmail="+userEmail+"&interval="+interval+"&title="+title+"&myonoffswitch"+myonoffswitch);

  xhttp.onload = function() {
    afterSend("submit-btn", ".submit-btn", "Done!", ".active-btn");
  };
  return false;
}
</script>

<div class="modal fade" id="remainderform" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Set Remainder on Car Check-up</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <div class=" text-center mt-3" id="status-msg"></div>
              <form  method="post" name="remainder" onSubmit="return valid();">
                <input type="hidden" name="action" id="action" value="remainder" required="">
                <input type="hidden" name="vid" id="vid" value="<?php echo $result->vid; ?>" required>
                <input type="hidden" name="paymentId" id="paymentId" value="<?php echo $result->id; ?>" required>
                <input type="hidden" name="userEmail" id="userEmail" value="<?php echo $_SESSION['login']; ?>" required>
                <div class="form-group">
                  <label>Car Check Interval:</label>
                  <select class="form-control" name="interval" id="interval" required>
                    <option value="7 days">7 days</option>
                    <option value="14 days">14 days</option>
                    <option value="21 days">21 days</option>
                    <option value="25 days">25 days</option>
                    <option value="1 month">30 month</option>
                    <option value="2 month">2 month</option>
                    <option value="3 month">3 month</option>
                    <option value="6 month">6 month</option>
                    <option value="1 year">1 year</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="title" id="title" placeholder="Remainder Title" maxlength="50" required="required">
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                   On / Off the Remainder
                  </label>
                
                <div class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                    <label class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>

                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-block submit-btn" name="remainder" id="submit-btn">Set Remainder</button>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>