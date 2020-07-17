
<?php
include('navbar.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sample Project</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="mystyle.css">

  <script src="ckeditor/ckeditor.js"></script>
</head>
<body>

  <h3 align="center">Write your story</h3>
  
  <div class="container">
   

    <form  method="post"  id="new_story">
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
       
      <textarea id="editor1" class="form-control" style="display: none;" data-text="Enter comment...." ></textarea>
    </div>
    <br />
    <div class="row">
      <div class="col-sm-8">
        
        <label for="tag1">Tags:</label>
        <input type="text" class="form-inline getTags" id="tag1">
        <input type="text" class="form-inline getTags" id="tag2">
        <input type="text" class="form-inline getTags" id="tag3">
        <div id="suggesstion-box"></div>
      </div>
      <div class="col-sm-4">
        <button type="submit" class="btn btn-success" id="btnSubmit">Submit</button>
      </div>
    </div>
    
    <br/>
    
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>


  $(document).ready(function(){

    sectionDetails();
    CKEDITOR.replace( 'editor1');

    
    $('#new_story').on("submit", function(event){
     event.preventDefault()

     $("#btnSubmit").attr("disabled", true);
     $(".insert_option").attr("disabled", true);
     var desc = CKEDITOR.instances['editor1'].getData();
     var form_data = new FormData();
     form_data.append('flagreq',"insert_post");
     form_data.append("title", document.getElementById('title').value);
     form_data.append("section", document.getElementById('section').value);
     form_data.append("editor1",desc);

     form_data.append("tag1", document.getElementById('tag1').value);
     form_data.append("tag2", document.getElementById('tag2').value);
     form_data.append("tag3", document.getElementById('tag3').value);

     $.ajax({
      url:"backend_afterlogin.php",
      method:"POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      
      success:function(data)
      {   
       $.notify("Story added successfully", "success"); 
       document.getElementById("new_story").reset();
       CKEDITOR.instances.editor1.setData(' ');
       setTimeout(function(){window.location.replace("home"); }, 2000); 
       
     }
   });
     
     

   });  



//suggetion for tags

$(".getTags").keyup(function(){

  var values=$(this).val();

  $.ajax({
    type: "POST",
    url: "backend_afterlogin.php",
    data:{
     values:values,
     flagreq:'getTags',
   },
   beforeSend: function(){
    $(".getTags").css("background","#FFF");
  },
  success: function(data){
    $("#suggesstion-box").show();
    $("#suggesstion-box").html(data);
    $(".getTags").css("background","#FFF");

  }
});
});


//hide tag suggetion box

$(".getTags").focusout(function(){
  $("#suggesstion-box").hide();
  
});



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

//ADD A SECTION

function addsection() {

  
  var newOption = document.getElementById("newsection").value;
  if (newOption.length!=0) {
    $.ajax({  
      url:"backend_afterlogin.php",  
      method:"post",  
      data:{
        flagreq:'insertNewSection',
        newOption:newOption,
        contentType: false,
        cache: false,
        processData: false,  
      },  

      success:function(data){  
        var str = data;
        var n = str.search("inserted");
        sectionDetails();
        if (n < 0)

        {   
          $.notify("Option added", "success");
          
          document.getElementById("newsection").value = " ";
        }
        else{

          $.notify("Option already given", "error");
          
          document.getElementById("newsection").value = " ";
        }     

      }
      
    });

  }
  else{
    $.notify("write option before insert", "error");
    $('#newsection').focus();
  }
}



function changeFont(){
  var myFont = document.getElementById("input-font").value;
  document.execCommand('fontName', false, myFont);
}

function changeSize(){
  var mysize = document.getElementById("fontSize").value;
  document.execCommand('fontSize', false, mysize);
}


</script>


</body>
</html>













