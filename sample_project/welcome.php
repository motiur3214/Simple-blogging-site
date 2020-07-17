<!DOCTYPE html>
<html lang="en">
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
  <link rel="stylesheet" type="text/css" href="mystyle.css">
    
	<style type="text/css">
		.loginBtn {
			background:none;
			color: tomato;
			border:none;
			margin:0;
			padding:0;
			cursor: pointer;
		}
		

	</style>


</head>
<body>
	<div class="container-fluid">
		<p id="showme"></p>
		<div class="row">
			<div class="col-sm-8" >
     <h2 style="text-align: center;">Recent Stories</h2>
<div id="recentStoryShow" style="padding-right: 5%">
	
</div>

			</div>

			<div class="col-sm-4">

				<h2>Registration/login</h2>
				<p>Please fill in this form to create an account or <button class="loginBtn" data-toggle="modal" data-target="#loginModal">Sign in</button></p>
				<hr>
				<form method="post"  id="new_registration">
					<div class="form-group">



						<label for="fullname"><b>Name</b></label>
						<input type="text" class="form-control" placeholder="Enter Name" id="fullname" name="fullname" required>

						<label for="email"><b>Email</b></label>
						<input type="text" class="form-control" placeholder="Enter Email" id="email" name="email" required>

						<label for="birthday">Birthday:</label>
						<input type="date" class="form-control" id="birthday" id="birthday" name="birthday">

						<label for="phone">Enter your phone number:</label>
						<input type="tel" class="form-control" id="phone" name="phone"  placeholder="0171xxxxxxx" pattern="[0-9]{11}">

						<label for="gender">Choose a gender:</label>
						<select id="gender" class="form-control" name="gender" id="gender" form="new_registration">
							<option value="M" selected>Male</option>
							<option value="F">Female</option>
						</select>

						<label for="img">Select image:</label>
						<input type="file" class="form-control" id="img" name="img" accept="image/*" capture>

						<label for="psw"><b>Password</b></label>
						<input type="password" class="form-control" placeholder="Enter Password"  id="psw" name="psw" required>

						<label for="psw-repeat"><b>Repeat Password</b></label>
						<input type="password" class="form-control" placeholder="Repeat Password" id="psw-repeat"  name="psw-repeat" required>
						<hr>

						<p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
						<button type="submit" class="registerbtn">Register</button>
					</div>


				</form>
			</div>
		</div>
	</div>




	<!-- Modal for Sign in -->
	<div class="modal" id="loginModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_headline">Sign in</h4>
					<button type="button" class="close" data-dismiss="modal" style="outline: none">&times;</button>
				</div>
				<div class="modal-body inputform">

					<form method="post" id="loginForm">

						
<div class="form-group">
							<label for="phoneLogin">Enter your phone number:</label>
							<input type="tel"  id="phoneLogin" class="form-control" name="phoneLogin" placeholder="0171xxxxxxx" pattern="[0-9]{11}">											
</div>
<div class="form-group">
							<label for="pswL">Password</label>
							<input type="password"  id="pswL"  class="form-control" placeholder="Enter Password" name="pswL" required>
							</div>
						
						<p></p>
						<div class="modal-footer">
							<button type="submit" class=" btn btn-success" >Confirm</button>
						</div>	

					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end of Modal -->

<!-- modal for full story show -->

    <div id="showStoryModal" class="modal" style="width:auto;">
  
</div>
	
  
  <!-- end of modal -->
<script type="text/javascript">
	


$(document).ready(function() {
  storyDetails();
 // 
$('#new_registration').on("submit", function(event){ 
	event.preventDefault();

	var form_data = new FormData();
	form_data.append('flagreq',"insert_request");
	form_data.append("fullname", document.getElementById('fullname').value);

	form_data.append("email", document.getElementById('email').value);

	form_data.append("birthday", document.getElementById('birthday').value);

	form_data.append("phone", document.getElementById('phone').value);

	form_data.append("gender", document.getElementById('gender').value);


	if( document.getElementById('img').files.length !== 0 ){

    if( document.getElementById('img').files[0].size < 800000 ){
    
    var name = document.getElementById('img').files[0].name;

    var fileSize = document.getElementById('img').files[0].size;

     //alert(fileSize);
    
     var ext = name.split('.').pop().toLowerCase();
     if(jQuery.inArray(ext, ['jpg','jpeg','png']) == -1) 
     {
        alert("Invalid Image File");
    }
    form_data.append("img", document.getElementById('img').files[0]);
}
else{

    alert("file size should be less then 800 kb");
    return false;

}
   }
  if (document.getElementById('psw-repeat').value == document.getElementById('psw').value ) {
  	form_data.append("psw", document.getElementById('psw').value);
	
	$.ajax({
		url: "backend.php",
		type: 'post',
		data:form_data,

		contentType: false,
		cache: false,
		processData: false,
		success:function(data){

			var str = data;
			var n = str.search("Unsuccessful");



			if (n < 0)

		{   
			$.notify("Registration Successful. Login to explore more", "success");
			 document.getElementById("new_registration").reset();
			
		}
		else{

			$.notify("Given email or phone number already exits", "error");
			

		}
	}

});
  }
else
{
 
 $.notify("password does not match", "warning");

}


});

// login

   $('#loginForm').on("submit", function(event){ 
                event.preventDefault();

                var phone   = $('#phoneLogin').val();
                var phoneNo =  phone.substring(1);

                var passW   = $('#pswL').val();

                $.ajax({
                    url: "backend.php",
                    type: 'post',
                    data: {
                // merchant_name: merchantName,
                
                phoneNo: phoneNo,
                passW:passW,
                flagreq:'loginRequest',
            },
            success:function(data){
              
            
              document.getElementById("loginForm").reset();
              var str = data;
			  var n = str.search("invalid");
			  var m = str.search("register");

			if (n < 0){
                    window.location.replace("home");
}else{
	$.notify("Your Login phone no or Password is invalid", "error");
}

if(m > 0){

alert("please register first to login");

}

   }

      });

            });

});

//recent Story Show
function storyDetails(){

 $.ajax({  
      url:"backend.php",  
      method:"post",  
      data:{
        flagreq:'getStoryData',
        contentType: false,
        cache: false,
        processData: false,  
        "pageLength": 9,
      },  

success:function(data){  
$('#recentStoryShow').html(data);  
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

$('#showStory').DataTable(
{
"ordering": false,
"bInfo" : false,
}); 

         }
    
});
};

//full story show
$(document).on('click', '.fullStory', function(){  
  var storyId = $(this).attr("id");  


$.ajax({  
            url:"backend.php",  
            method:"POST",  
            data:{
              storyId:storyId,
              flagreq:'fullStoryShow',
              contentType: false,
              cache: false,
              processData: false,  


            },  
            success:function(data){  
                  
                    $('#showStoryModal').html(data);




                }
            });

});


</script>



</body>
</html>