<?php
include('navbar.php');
include('config.php');

$sqlAdmin = "SELECT id FROM tbl_admin where registration_id='$login_session_id'";

$resultAdmin = $conn->query($sqlAdmin);

if ($resultAdmin->num_rows <= 0) {


header("location:home.php");
   die(); 
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sample Project</title>
	 <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src=https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js" integrity="sha256-vucLmrjdfi9YwjGY/3CQ7HnccFSS/XRS1M/3k/FDXJw=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
	<div class="container-fuild">
<div class="row">
	<div class="col-sm-5">
<div class="form-group">
        <label for="selectAction" class="col-sm-4 control-label">Admin Privilages:</label>
        <div class="col-sm-5">
        <select class="form-control" id="selectAction" onchange="selectedAction()">
        	<option value="" disabled selected>Choose your option</option>
          <option value="1">Pick new Admin</option>
          <option value="2">Register New Admin</option>
          <option value="3">Block an user</option>
          <option value="4">User Details</option>
          <option value="5">Admin Details</option>
        </select>          
          
        </div>
</div>
<br>
<div class="form-group">

<button type="button"  class="btn btn-info " style="margin-left: 3%; margin-top: 2%;" onclick="storyDetails()">View all Story</button>
</div>
</div>
<div class="col-sm-6" id="showDetails">
	
</div>

</div>

</div>



<div class="modal fade in"  id="showDetailsModal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_headline" align="center">Profile Details
          <button type="button" class="close" data-dismiss="modal" style="outline: none">&times;</button></h4>
        </div>
        <div class="modal-body"  id="detailsShowPro">

          


          <div class="modal-footer">
            
           </div>
          </div>


      
        </div>

      </div>
   
  </div>

<script type="text/javascript">
  $(document).ready(function() {
	storyDetails();
$("#selectAction").select2();
	});
function selectedAction()
{
var actionId=document.getElementById('selectAction').value;

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'getRegisteredPersons',
        actionId:actionId,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

$('#showDetails').html(data); 

 $('#getDetailsForAdmin').DataTable(
{
"ordering": false,
"bInfo" : false,
"pageLength": 9,
}); 




}

});

};


//select from existing
function NewAdmin()
{
adminId=document.getElementById('selectNewAdmin').value;

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'ActiveNewAdmin',
        adminId:adminId,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
 var str = data;
$.notify(str, "info");


}
});
}

function registerNewAdminform(){
	
name=document.getElementById('name').value;
email=document.getElementById('email').value;
phoneNo=document.getElementById('phone').value;
password=document.getElementById('passwd').value;

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'registerNewAdmin',
        name:name,
        email:email,
        phoneNo:phoneNo,
        password:password,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
 var str = data;

$.notify(str, "info");

}
});



};

function showPassword()
{
var x = document.getElementById("passwd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }


}

function blockUser(){

 if (confirm("Are you sure?")){
var blockUserId=document.getElementById('getBlockUser').value;

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'blockUser',
        blockUserId:blockUserId,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
 var str = data;
$.notify(str, "info");

}
});

}
}

$(document).on('click','.viewAllTheDetails', function(){  
    
 var id=$(this).attr("id");
$("#showDetailsModal").modal();
$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'userProfileDetails',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

$('#detailsShowPro').html(data); 

}
});
});
$(document).on('click','.DeleteProfile', function(){  
  if (confirm("Are you sure?")){   
 
 var id=$(this).attr("id");
$("#showDetailsModal").modal("hide");
$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'userProfileDelete',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
$('#showDetails').html(data); 
 setTimeout(function(){location.reload(); }, 2000); 

}
});
}
});

//search
function searchAction(){

var search=document.getElementById('search').value;
  
 $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'profilesearch',
        search:search,
        contentType: false,
        cache: false,
        processData: false,  
      }, 
    success:function(data)
    {    $('#showDetails').html(data);  
         document.getElementById("search").value=' ';
   var maxLength = 300;
$(".show-read-more").each(function() {
  var myStr = $(this).text();
  if ($.trim(myStr).length > maxLength) {
    var newStr = myStr.substring(0, maxLength);
    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
    $(this).empty().html(newStr);
    $(this).append(' <p class="read-more">read more...</p>');
    
  }
});
   $('#searchTable').DataTable(
{
"lengthChange": false,
"ordering": false,
"bInfo" : false,
"searching": false,
"pageLength": 9,
});
     
    }
   });
}
//STORY SHOW FOR ADMIN
function storyDetails(){

 $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'getAllStoryData',
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

$('#showDetails').html(data);  
  var maxLength = 300;
$(".show-read-more").each(function() {
  var myStr = $(this).text();
  if ($.trim(myStr).length > maxLength) {
    var newStr = myStr.substring(0, maxLength);
    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
    $(this).empty().html(newStr);
    $(this).append(' <p class="read-more">read more...</p>');
    
  }
});

$('#showAllStoryForComment').DataTable(
{
"lengthChange": false,
"ordering": false,
"bInfo" : false,
"searching": false,
"pageLength": 9,
}); 

         }
    
});
};

//DETAILS SHOWINGS
$(document).on('click','.showForComment', function(){  
    {

        var id=$(this).attr("id");
        window.open( "view-story?storyNo="+id,'_blank');
      
    }
});


//unblock an admin
$(document).on('click','.unblockAdmin', function(){  
    
 var id=$(this).attr("id");

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'unblockAdmin',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

$('#showDetails').html(data);  
 setTimeout(function(){location.reload(); }, 2000); 
}
});
});

//block an admin
$(document).on('click','.blockAdmin', function(){  
    
 var id=$(this).attr("id");

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'blockAdmin',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
$('#showDetails').html(data);  
 setTimeout(function(){location.reload(); }, 2000); 
}
});
});
</script>

</body>
</html>