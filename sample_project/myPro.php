<?php
include('navbar.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sample Project</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  




  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <style type="text/css">
   
    .updateProbtn{


      float: right;

    }




  </style>

</head>
<body>

  <div class="container-fluid proBdy">
    <div class="row">
      <div class="col-sm-5" id="showProDetail">
       
       
      </div>	
      <div class="col-sm-7" id="showMyStory"></div>


    </div>




  </div>

  <div class="modal fade in"  id="UpdateModal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_headline" align="center">Update Profile Details
            <button type="button" class="close" data-dismiss="modal" style="outline: none">&times;</button></h4>
          </div>
          <div class="modal-body inputform">

            <form method="post"  id="updateProForm">
              <div class="form-group">


                <input type="hidden" name="idNo" id="idNo">
                <label for="fullname"><b>Name</b></label>
                <input type="text" class="form-control" placeholder="Enter Name" id="fullname" name="fullname" required>

                <label for="email"><b>Email</b></label>
                <input type="text" class="form-control" placeholder="Enter Email" id="email" name="email" required>

                <label for="birthday">Birthday:</label>
                <input type="date" class="form-control" id="birthday" id="birthday" name="birthday">

                <label for="phone">Phone number:</label>
                <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{11}" disabled>

                <label for="gender">Choose a gender:</label>
                <select id="gender" class="form-control" name="gender" id="gender" form="new_registration">
                  <option value="M" selected>Male</option>
                  <option value="F">Female</option>
                </select>

                <label for="img">Select image:</label>
                <input type="file" class="form-control" id="img" name="img" accept="image/*" capture>

                
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success updateProbtn" >Submit</button>
                </div>
              </div>


            </form>
          </div>

        </div>
      </div>
    </div>
    <!-- modal for full story show -->
    <div class="modal" id="showStoryModal" style="width: auto;">
      
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />


    <script type="text/javascript">
     
      $(document).ready(function() {   
       ProDetails();
       storyDetails();



     });


      function ProDetails(){

       $.ajax({  
        url:"backend_afterlogin.php",  
        method:"post",  
        data:{
          flagreq:'getProData',
          contentType: false,
          cache: false,
          processData: false,  
        },  

        success:function(data){  
         
         $('#showProDetail').html(data);  
         
       }
       
     });
     };



     function storyDetails(){

       $.ajax({  
        url:"backend_afterlogin.php",  
        method:"post",  
        data:{
          flagreq:'getStoryData',
          contentType: false,
          cache: false,
          processData: false,  
        },  

        success:function(data){  
          $('#showMyStory').html(data);  
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
            "lengthChange": false,
            "ordering": false,
            "bInfo" : false,
            "searching": false,
            "pageLength": 9,
          }); 

        }
        
      });
     };



     $(document).on('click','.updateProfile', function(){  
      {

        var id=$(this).attr("id");
        $('#idNo').val(id);
        $("#UpdateModal").modal()
        $.ajax({  
          url:"backend_afterlogin.php",  
          method:"POST",  
          data:{
            id:id,
            flagreq:'fetchProDetails',
            contentType: false,
            cache: false,
            processData: false,  


          },  
          success:function(data){  
            
            $('#fullname').html(data);




          }
        });
      }
    });

     $('#updateProForm').on("submit", function(event){ 
      event.preventDefault();

      var form_data = new FormData();
      form_data.append('flagreq',"update_request");

      form_data.append("fullname", document.getElementById('fullname').value);

      form_data.append("email", document.getElementById('email').value);

      form_data.append("birthday", document.getElementById('birthday').value);

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

$.ajax({
  url: "backend_afterlogin.php",
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
      $.notify("Profile details updated", "success");
      document.getElementById("updateProForm").reset();
      
      setTimeout(function(){location.reload(); }, 1000); 
    }
    else{

      $.notify("Something went wrong", "error");
      

    }
  }

});
});

     $(document).on('click', '.fullStory', function(){  
      var storyId = $(this).attr("id");  


      $.ajax({  
        url:"backend_afterlogin.php",  
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
//update story
$(document).on('click','.updateStorybtn', function(){  
  {

    var id=$(this).attr("id");
    window.open( "update-story?storyNo="+id,'_blank');
    
  }
});


//delete story
$(document).on('click','.deleteStorybtn', function(){  
  
 if (confirm("Are you sure?")){
  var id=$(this).attr("id");
  $.ajax({  
    url:"backend_afterlogin.php",  
    method:"POST",  
    data:{
      id:id,
      flagreq:'deleteStory',
      contentType: false,
      cache: false,
      processData: false,  


    },  
    success:function(data){  
      $.notify(data,"info");
      storyDetails();

      $("#showStoryModal").modal("hide");

    }
  });
}
});

function searchAction(){

  var search=document.getElementById('search').value;
  
  $.ajax({  
    url:"backend_afterlogin.php",  
    method:"post",  
    data:{
      flagreq:'getprofilestory',
      search:search,
      contentType: false,
      cache: false,
      processData: false,  
    }, 
    success:function(data)

    {    

      $('#showMyStory').html(data);  
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
</script>


</body>
</html>