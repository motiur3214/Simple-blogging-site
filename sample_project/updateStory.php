<?php

include('navbar_1.php');
include('config.php');
$storyId=$_GET['storyNo'];

$stmt = "SELECT body FROM tbl_story WHERE id = '$storyId'";
  $result = $conn->query($stmt);
$row = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Sample_Project</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src=https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="mystyle.css">
 <script src="ckeditor/ckeditor.js"></script>
</head>
<body>
<div class="container" id="updateData">
<?php	
echo'<input type="hidden" class="storyNo"  id="'.$storyId.'"/>';
?>
<form  method="post"  id="update_story">
  <div class="form-group">
    <div class="row">
      <div class="col-sm-6">
    <label for="title">Title:</label>
    <input type="text" class="form-control" id="title" required>
    </div>
    <div class="col-sm-6">
      <div class="col-sm-4" id="sectionData">
     
  </div>
  <div class="col-sm-8">
    <div class="col-sm-8">
    <label for="newsection">Add a section:</label>
    <input type="text" id="newsection" class="form-control">
   <p>Find the new option in section dropdown menu</p>
    </div>
    <div class="col-sm-4">
      
       <button type="button" class="btn btn-info insert_option" onclick="addsection()">Insert option</button>
    </div>
  </div>
    </div>
    </div>
  </div>
  <div class="form-group">
   
    <textarea id="editor1"  style="display: none;"  class="form-control" data-text="Enter comment...."  >
    	<?php echo $row['body'] ?>
    </textarea>
  </div>
  <br />
   <div class="row">
    <div class="col-sm-8">
   
    </div>
    <div class="col-sm-4">
    <button type="submit" style="float: right;" class="btn btn-success" id="btnSubmit">Submit</button>
    </div>
   </div>
  
   <br/>
  
    </form>

	
</div>


<script type="text/javascript">
	$(document).ready(function(){
      sectionDetails();
      CKEDITOR.replace( 'editor1');
      afterclickUpdate();
});

//get section option
function sectionDetails(){

 $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'getSecData',
        contentType: false,
        cache: false,
        processData: false,  
      },  

success:function(data){  
       
       $('#sectionData').html(data);  
         

         }
    
});
};

 function afterclickUpdate()
    {

   var id = document.getElementsByClassName("storyNo")[0].id;
      
       
        $.ajax({  
            url:"backend_afterlogin.php",  
            method:"POST",  
            data:{
              id:id,
              flagreq:'fetchStoryDetailsForUpdate',
              contentType: false,
              cache: false,
              processData: false,  


            },  
            success:function(data){  
                  
                    $('#title').html(data);




                }
            });
    }
$('#update_story').on("submit", function(event){
 event.preventDefault();
var id=document.getElementsByClassName("storyNo")[0].id;
  $("#btnSubmit").attr("disabled", true);
  $(".insert_option").attr("disabled", true);
  var desc = CKEDITOR.instances['editor1'].getData();
  var form_data = new FormData();
  form_data.append('flagreq',"update_post");
  form_data.append("title", document.getElementById('title').value);
  form_data.append("postId", id);
  form_data.append("section", document.getElementById('section').value);
  form_data.append("editor1",desc);

  

   $.ajax({
    url:"backend_afterlogin.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
       
    success:function(data)
    {   
       $.notify("Story updated successfully", "success"); 
         document.getElementById("update_story").reset();
        CKEDITOR.instances.editor1.setData(' ');
    setTimeout(function(){window.location.replace("view-story?storyNo="+id); }, 2000); 
     
    }
   });
  
 

 });  

</script>
</body>
</html>