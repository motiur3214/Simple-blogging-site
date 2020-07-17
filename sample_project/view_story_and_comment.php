<?php
$storyId=$_GET['storyNo'];
include('navbar_1.php');
include('config.php');

$sqlblockUser = "SELECT id FROM tbl_blocked_user where registration_id='$login_session_id'";
$resultblockUser = $conn->query($sqlblockUser);
$UserNameRow = $resultblockUser->fetch_assoc();

if ($resultblockUser->num_rows >0) {
 header("location:home");
 }
//admincheck
$sqlAdmin = "SELECT id FROM tbl_admin where registration_id='$login_session_id'";
$resultAdmin = $conn->query($sqlAdmin);



$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
<title>Sample Project</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src=https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	 <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

  <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>

	<div class="container">
	<?php	
echo'<input type="hidden" class="storyNo"  id="'.$storyId.'"/>';
?><div class="row">
<div class="col-sm-11" id="showingStory"></div>

<?php
if ($resultAdmin->num_rows >0) {
	?>
<div class="col-sm-1" style="margin-top: 2%; "><button type="button" class="btn btn-danger" 
id="blockStory"><span style="font-size:.8em !important;">Block Story</span></button> </div>
<?php
}
?>
</div>
<div id="commentBox">
<textarea rows="4" cols="50"   id="commentInput" required></textarea><br>	
<button type="button" class="btn btn-success" id="submitComment" >Submit</button>
</div>
<div id="showComments" ></div>

	</div>

<script type="text/javascript">
	
	$(document).ready(function() {

storyDetails();
		});

	//Show full Story
function storyDetails(){
	 var id = document.getElementsByClassName("storyNo")[0].id;
 

 $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'getfullStory',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
	 $('#showingStory').html(data);
	 allComments();
}
});
};


$(document).on('click','#submitComment', function(){  
    
    if (document.getElementById('commentInput').value!='') {
var id = document.getElementsByClassName("storyNo")[0].id;

var commentValue=document.getElementById('commentInput').value;

   $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'inputComment',
        id:id,
        commentValue:commentValue,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
	 
	 $('#showComments').html(data);
document.getElementById('commentInput').value=' ';
}
});
}else{

	alert("Please write a comment first...");
    $('#commentInput').focus();
}
});

	//Show All comments
function allComments(){
	 var id = document.getElementsByClassName("storyNo")[0].id;
 

 $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'allCommentShow',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

	 $('#showComments').html(data);
	 $('#commentTable').DataTable(
{
"lengthChange": false,
"ordering": false,
"bInfo" : false,
"searching": false,
}); 
}
});
};

$(document).on('click','#blockStory', function(){ 

if (confirm("Are you sure?")){
var id = document.getElementsByClassName("storyNo")[0].id;
 $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'blockStoryRequest',
        id:id,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

$.notify(data,"info");
setTimeout(function(){window.location.replace("home"); }, 2000);
}
});
}
});

//delete comment
$(document).on('click','.removeComment', function(){  
if (confirm("Are you sure?")){
var commentId=$(this).attr("id");

$.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'deleteComment',
        commentId:commentId,
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  

$.notify(data,"info");
storyDetails();


}
});

}
});




</script>
</body>
</html>