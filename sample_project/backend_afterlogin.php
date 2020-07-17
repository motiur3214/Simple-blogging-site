<?php
include("session.php");
include('config.php');

extract($_POST);


if($_POST["flagreq"] == 'getProData')
{

$stmt = "SELECT * FROM tbl_registration WHERE phone = '$login_session'";
  $result = $conn->query($stmt);
 if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {

if ($row['gender']=='M') {
$gender="Male";
  }
  else{
    $gender="Female";
  }
$date=date_create($row['birthday']);
$showDate=date_format($date,"d/m/Y");

$proDetail='<table class="table table responsive" style="margin-top:7%;">
    
  <tbody>
    <tr>
<th></th>
<td><img src="'.$row['image'].'" height="150" width="225" class="img-thumbnail" /></td>
    </tr>
    <tr>
<th>Name:</th>
<td>'.$row['name'].'</td>

    </tr>
<tr>
  <th>Email:</th>
  <td>'.$row['email'].'</td>

    </tr>
<tr>
    <th>Phone No:</th>
  <td>0'.$row['phone'].'</td>  


    </tr>
<tr>
  <th>Gender:</th>
<td>'.$gender.'</td>

</tr>
<tr>
    <th>Birthday:</th>
  <td>'.$showDate.'</td>  


    </tr>
<tr>
 <th></th>   
<td align="right"><button id="'.$row['id'].'" class="btn btn-info updateProfile">Update</button></td>



    </tr>


  </tbody>



  </table>';


 echo $proDetail; 
}
}
$conn=null;
}



//FETCH profile Details for update modal


if($_POST["flagreq"] == 'fetchProDetails')
{
$idNo = trim($_POST['id']);
$idNo = mysqli_real_escape_string($conn, $idNo);
$response = array();
$stmt = "SELECT * FROM tbl_registration WHERE phone = '$login_session'";
  $result = $conn->query($stmt);
 if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {
          $response=$row;
    }

echo '<script>';
  echo '$("#fullname").val("'.$response['name'].'");';
  echo '$("#email").val("'.$response['email'].'");';             
  echo '$("#birthday").val("'.$response['birthday'].'");';
  echo '$("#phone").val("0'.$response['phone'].'");';
  echo '$("#gender").val("'.$response['gender'].'");'; 
  echo '</script>';

}

echo json_encode($response);
$conn=null;
}



//profile update request
if($_POST["flagreq"] == 'update_request')
{

$fullname = trim($_POST['fullname']);
$fullname = mysqli_real_escape_string($conn, $fullname);

$email = trim($_POST['email']);
$email = mysqli_real_escape_string($conn, $email);

$birthday = trim($_POST['birthday']);
$birthday = mysqli_real_escape_string($conn, $birthday);



$gender = trim($_POST['gender']);
$gender = mysqli_real_escape_string($conn, $gender);


if($_FILES["img"]["name"] != '' )
  {
    $test = explode('.', $_FILES["img"]["name"]);
    
    $ext = end($test);
    $name = rand(100, 999) . '.' . $ext;
    $location = './pro_image/' . $name; 
    // $_SERVER[DOCUMENT_ROOT]."/returnOrder/".$files["name"];
    
    move_uploaded_file($_FILES["img"]["tmp_name"], $location);


}else
  
 {
  $stmt = "SELECT image FROM tbl_registration WHERE phone = '$login_session'";
  $result = $conn->query($stmt);
  $row = $result->fetch_assoc();
  $location=$row['image'];
 }


  $updateQuery = $conn->prepare(" UPDATE tbl_registration SET name=?, email=?, birthday=?, gender=?, image=?, creationTime=NOW() 
    WHERE phone = '$login_session'");

 $updateQuery->bind_param("sssss", $fullname, $email, $birthday, $gender, $location);
 
 if($updateQuery->execute()){

echo "success";
    }
 
  else  {
    echo "Unsuccessful";
    }
   $conn = null;


}

//get section values
if($_POST["flagreq"] == 'getSecData')
{
$stmt = "SELECT sectionName FROM tbl_section ";
  $result = $conn->query($stmt);
  $output='';
 if ($result->num_rows > 0) {
   // output data of each row
  $output.='<label for="section">Select a section:</label>
     <select id="section" class="form-control" required>
     <option disabled selected value>-select an option-</option>';
   foreach ($result as $row ) {
     # code...
  
          
     $output.='<option>'.$row['sectionName'].'</option>';

    }


     
    
  $output.='</select>';

echo $output;
}
$conn=null;
}

//insert new section
if($_POST["flagreq"] == 'insertNewSection')
{

$newOption = trim($_POST['newOption']);
$newOption = mysqli_real_escape_string($conn, $newOption);
echo $newOption;
$stmt ="SELECT sectionName FROM tbl_section WHERE sectionName ='$newOption'";

$result = $conn->query($stmt);
 
if ($result->num_rows > 0) {
echo "inserted";
}else{



$insertQuery = $conn->prepare("INSERT INTO tbl_section (sectionName, addedBy, creationTime)VALUES(?,?, NOW())");

$insertQuery->bind_param("ss", $newOption, $login_session_email);
if($insertQuery->execute()){

echo "success";
    }
 
  else  {
    echo "Unsuccessful: ";
    }
  
}
 $conn = null;

}


//suggetion for tags
if($_POST["flagreq"] == 'getTags')
{

$values = trim($_POST["values"]);
$output='';
$values = mysqli_real_escape_string($conn, $values);
$stmt ="SELECT DISTINCT  tag_name FROM tbl_tags WHERE tag_name like '".$values."%' ORDER BY tag_name LIMIT 0,6";

  $result = $conn->query($stmt);
 
 if ($result->num_rows > 0) {

$output.='<ul class="list-horizontal" id="tag_list" >';

foreach($result as $tag_list) {

$output.='<li>'.$tag_list["tag_name"].'</li>';

}
$output.='</ul>';

}
echo $output;
$conn=null;
}



//insert post with section and tags
if($_POST["flagreq"] == 'insert_post')
{
$title = trim($_POST['title']);
$title = mysqli_real_escape_string($conn, $title);
$section = trim($_POST['section']);
$section = mysqli_real_escape_string($conn, $section);
$editor1 = trim($_POST['editor1']);
$tag1 = trim($_POST['tag1']);
$tag1 = mysqli_real_escape_string($conn, $tag1);
$tag1=strtolower($tag1);
$tag2 = trim($_POST['tag2']);
$tag2 = mysqli_real_escape_string($conn, $tag2);
$tag2=strtolower($tag2);
$tag3 = trim($_POST['tag3']);
$tag3 = mysqli_real_escape_string($conn, $tag3);
$tag3=strtolower($tag3);
if ($tag1=='') {
  $tag1="notag";
}
if ($tag2=='') {
  $tag2="notag";
}
if ($tag3=='') {
  $tag3="notag";
}
//fetch all tagNmae
$tagAarry= array();
$tagIdQuery = "SELECT tag_name FROM `tbl_tags`";
$resultTag= $conn->query($tagIdQuery);

while($row = $resultTag->fetch_assoc()) {
          $tagAarry[]=$row['tag_name'];
  
}
//insert new tags
if(!array_search($tag1,$tagAarry)){

    $insertTagQuery = $conn->prepare("INSERT INTO tbl_tags (tag_name,userId,creationTime) VALUES(?,?,NOW())");

 $insertTagQuery->bind_param("si", $tag1,$login_session);
 if($insertTagQuery->execute()){

echo "success";
    }
}
if (!array_search($tag2,$tagAarry)) {
   $insertTagQuery = $conn->prepare("INSERT INTO tbl_tags (tag_name,userId,creationTime) VALUES(?,?,NOW())");

 $insertTagQuery->bind_param("si", $tag2,$login_session);
 if($insertTagQuery->execute()){

echo "success";
    }
}
if (!array_search($tag3,$tagAarry)) {
   $insertTagQuery = $conn->prepare("INSERT INTO tbl_tags (tag_name,userId,creationTime) VALUES(?,?,NOW())");

 $insertTagQuery->bind_param("si", $tag3,$login_session);
 if($insertTagQuery->execute()){

echo "success";
    }
}
else
{
    echo "already have";
}

$selectedTagAarry= array();
$selectedTagIdQuery = "SELECT tag_id FROM tbl_tags WHERE tag_name='$tag1' OR tag_name='$tag2' OR tag_name='$tag3'";
$selectedTagResult= $conn->query($selectedTagIdQuery);

while($row = $selectedTagResult->fetch_assoc()) {
          $selectedTagAarry[]=$row['tag_id'];
  
}
//user id fetch
$userIdQuery = "SELECT id FROM tbl_registration WHERE phone = '$login_session'";
  $result = $conn->query($userIdQuery);
  $row = $result->fetch_assoc();
  $userId=$row['id'];
//section id fetch
  $sectionIdQuery = "SELECT id FROM tbl_section WHERE sectionName = '$section'";
  $resultSection = $conn->query($sectionIdQuery);
  $rowSection = $resultSection->fetch_assoc();
  $sectionId=$rowSection['id'];

//story insert
$insertStoryQuery = $conn->prepare("INSERT INTO tbl_story (title, body, user_id, section_id, creationTime) VALUES(?, ?, ?, ?, NOW())");

 $insertStoryQuery->bind_param("ssii", $title, $editor1, $userId, $sectionId);
 if($insertStoryQuery->execute()){

echo "success";
    }
 
  else  {
    echo "Unsuccessful: ";
    }

  $storyIdQuery = "SELECT id FROM tbl_story WHERE user_id='$userId' ORDER BY id DESC LIMIT 1";
  $storyIdresult = $conn->query($storyIdQuery);
  $rowstoryId = $storyIdresult->fetch_assoc();
  $storyId=$rowstoryId['id'];

//insert into story tags table for tagging
  foreach ($selectedTagAarry as $key) {
    # code...
  
$insertStoryTagQuery = $conn->prepare("INSERT INTO tbl_story_tags (story_id,tag_id) VALUES(?, ?)");

 $insertStoryTagQuery->bind_param("ii", $storyId, $key);
 if($insertStoryTagQuery->execute()){

echo "success";
    }
 
  else  {
    echo "Unsuccessful: ";
    }
}
   $conn = null;

}


//show story in profile
if($_POST["flagreq"] == 'getStoryData')
{


$output='';
$fetchStoryQuery = "SELECT id, title, body, creationTime, blocked_flag FROM tbl_story WHERE user_id='$login_session_id' ORDER BY id DESC";
  $fetchStoryQuery = $conn->query($fetchStoryQuery);


$output.='<table class="table table-responsive" frame="box" id="showStory" style="background-color:#FFFAF9;">
<thead><tr>
<th></th> </tr></thead>
<tbody>';
foreach ($fetchStoryQuery as $row) {
$date=$row['creationTime'];

$date=date_create($date);
$showDate=date_format($date,"d/m/Y H:i:s");
if($row['blocked_flag']==1){
  $bl='blocked';
}else{
  $bl='';
}
$output.='<tr>
<td><h5 style="text-align:center;"><b>'.$row['title'].'</b></h5><span style="color:tomato; font-size:.8em; float:right;">'.$bl.'</span></td> </tr>';
$output.='<tr style="font-size:.9em">
<td height="100" id="showBody" class="show-read-more">'.$row['body'].'</td></tr>
<tr style="font-size:.8em;">
<td>
<div class="row">
<div class="col-sm-6"><b>Posted on:</b>'.$showDate.'</div>
<div class="col-sm-6" align="right"><button type="button" name="detailStory"  id="'.$row['id'].'" 
class="btn btn-info fullStory" data-toggle="modal" data-target="#showStoryModal">Details</button></div>
</div>
</td>
</tr>';

}
$output.='</tbody>
</table>';
echo $output;

$conn=null;
}


//show full story
if($_POST["flagreq"] == 'fullStoryShow')
{

$storyId = trim($_POST['storyId']);
$storyId = mysqli_real_escape_string($conn, $storyId);
$output='';
$fetchFullStoryQuery = "SELECT title,body FROM tbl_story WHERE id='$storyId'";
$fetchFullStoryQuery = $conn->query($fetchFullStoryQuery);
$fulStoryRow = $fetchFullStoryQuery->fetch_assoc();
//tag show
$tagCount=array();
$fetchTagQuery = "SELECT tag_id FROM tbl_story_tags WHERE story_id='$storyId'";
$fetchTagQuery = $conn->query($fetchTagQuery);
if ($fetchTagQuery->num_rows > 0) {
   while($rowTag = $fetchTagQuery->fetch_assoc()) {
          $tagCount[]=$rowTag['tag_id'];
    }

}
$tagCountName=array();
foreach ($tagCount as $tagNameRow) {

$fetchTagNameQuery = "SELECT tag_name FROM tbl_tags WHERE tag_id='$tagNameRow'";
$fetchTagNameQuery = $conn->query($fetchTagNameQuery);
if ($fetchTagNameQuery->num_rows > 0) {
   while($rowTagName = $fetchTagNameQuery->fetch_assoc()) {
          $tagCountName[]=$rowTagName['tag_name'];
    }

}
}
if(isset($tagCountName[0])){
  $tag1=$tagCountName[0];


}else
{
  $tag1='';
}
if(isset($tagCountName[1])){
  $tag2=$tagCountName[1];
}else
{
  $tag2='';
}
if(isset($tagCountName[2])){
  $tag3=$tagCountName[2];
}else
{
  $tag3='';
}

if(isset($tagCountName[1]) and $tagCountName[0]=='notag'){
  $tag1='';
}
if(isset($tagCountName[2]) and $tagCountName[0]=='notag'){
  $tag1='';
}



$output.='<div class="modal-dialog" style="width: 90%; height:97%;">
      <div class="modal-content" style="height: 97%; overflow:auto;" >

       
        <div class="modal-header">
          <h2 class="modal-title" id="modal_headline">'.$fulStoryRow['title'].'
          <button type="button" class="close" data-dismiss="modal" style="outline: none">&times;</button></h2><p align="right" style="font-size:.8em; color:grey;">'.$tag1.' '.$tag2.' '.$tag3.'</p>
        </div>
        <div class="modal-body">

            <div>'.$fulStoryRow['body'].'</div>
             
<div class="modal-footer"><button type="button" id="'.$storyId.'" class="btn btn-warning updateStorybtn">Update</button>  <button type="button" id="'.$storyId.'" class="btn btn-danger deleteStorybtn">Delete</button> </div>
          
        </div>
      </div>
    </div>';
echo $output;
$conn=null;
}


//show stroy for commenting

if($_POST["flagreq"] == 'getAllStoryData')
{
$sqlblockUser = "SELECT id FROM tbl_blocked_user where registration_id='$login_session_id'";
$resultblockUser = $conn->query($sqlblockUser);
$UserNameRow = $resultblockUser->fetch_assoc();
if ($resultblockUser->num_rows >0) {
    echo '<h1 style="text-align:center; color:tomato;">You are blocked by ADMIN';
 }else{

$output='';
$fetchStoryQuery = "SELECT id, title, body, creationTime, user_id FROM tbl_story WHERE blocked_flag<>1 ORDER BY id DESC ";
$fetchStoryQuery = $conn->query($fetchStoryQuery);

$output.='<table class="table table-responsive" frame="box" id="showAllStoryForComment" style="background-color:#F8FCFF;">

<thead><tr>
<th></th> </tr></thead>
<tbody>';


foreach ($fetchStoryQuery as $row) {
$date=$row['creationTime'];
$date=date_create($date);
$showDate=date_format($date,"d/m/Y H:i:s");
$nameID=$row['user_id'];


$userNameFetch=$row['user_id'];

$storyIId=$row['id'];
//fetch other things
$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$userNameFetch'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();



 $output.='<tr>
    <td ><h5 align="center">'.$row['title'].'<b></h5></td>
  </tr>'; 
  $output.='<tr style="font-size:.9em;">
    <td height="100" id="showBody" class="show-read-more">'.$row['body'].'</td>
  </tr>
<tr style="font-size:.8em;">
<td>
<div class="row">
<div class="col-sm-6"><b>Posted on:</b>'.$showDate.'<br>'.$UserNameRow['name'].'</div>
<div class="col-sm-6" align="right"><button type="button" name="detailStory" id="'.$row['id'].'"  
class="btn btn-info showForComment">Details</button></div>
</div>
</td>
</tr>';



}

$output.='</tbody></table>';
echo $output;
$conn=null;
}
}
//for comment purpose
if($_POST["flagreq"] == 'getfullStory')
{
$output='';
$storyId = trim($_POST['id']);
$storyId = mysqli_real_escape_string($conn, $storyId);
$fetchFullStoryQuery = "SELECT title, body, user_id,creationTime FROM tbl_story WHERE id='$storyId' 
AND blocked_flag<>1";

$fetchFullStoryQuery = $conn->query($fetchFullStoryQuery);
$fulStoryRow = $fetchFullStoryQuery->fetch_assoc();
$date=$fulStoryRow['creationTime'];
$date=date_create($date);
$showDate=date_format($date,"d/m/Y H:i:s");
if ($fetchFullStoryQuery->num_rows >0) {
//get posted by
$userNameFetch=$fulStoryRow['user_id'];
$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$userNameFetch'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();




//get tag list
$tagCount=array();
$fetchTagQuery = "SELECT tag_id FROM tbl_story_tags WHERE story_id='$storyId'";
$fetchTagQuery = $conn->query($fetchTagQuery);
if ($fetchTagQuery->num_rows > 0) {
   while($rowTag = $fetchTagQuery->fetch_assoc()) {
          $tagCount[]=$rowTag['tag_id'];
    }

}
$tagCountName=array();
foreach ($tagCount as $tagNameRow) {

$fetchTagNameQuery = "SELECT tag_name FROM tbl_tags WHERE tag_id='$tagNameRow'";
$fetchTagNameQuery = $conn->query($fetchTagNameQuery);
if ($fetchTagNameQuery->num_rows > 0) {
   while($rowTagName = $fetchTagNameQuery->fetch_assoc()) {
          $tagCountName[]=$rowTagName['tag_name'];
    }

}
}
if(isset($tagCountName[0])){
  $tag1=$tagCountName[0];


}else
{
  $tag1='';
}
if(isset($tagCountName[1])){
  $tag2=$tagCountName[1];
}else
{
  $tag2='';
}
if(isset($tagCountName[2])){
  $tag3=$tagCountName[2];
}else
{
  $tag3='';
}

if(isset($tagCountName[1]) and $tagCountName[0]=='notag'){
  $tag1='';
}
if(isset($tagCountName[2]) and $tagCountName[0]=='notag'){
  $tag1='';
}
$output.='
          <div class="story-header">
          <h3 style="text-align:center;">'.$fulStoryRow['title'].'</h3><p align="right" style="font-size:.8em; color:grey;"><b style="font-size: 1.1em;">Tags:</b> '.$tag1.' '.$tag2.' '.$tag3.'</p></div>
        <div class="story-body" style="font-size:1em;">

            '.$fulStoryRow['body'].'<p style=" text-align:right;font-size:.8em !important; color:grey"><b>Posted by:</b> '.$UserNameRow['name'].'<br>'.$showDate.'</p></div>';
echo $output;

}



$conn= null;
}
//comment input request
if($_POST["flagreq"] == 'inputComment')
{
$output='';
$storyId = trim($_POST['id']);
$storyId = mysqli_real_escape_string($conn, $storyId);
$commentValue = trim($_POST['commentValue']);
$commentValue = mysqli_real_escape_string($conn, $commentValue);

$fetchFullStoryQuery = "SELECT id FROM tbl_story WHERE id='$storyId' AND blocked_flag=1";
$fetchFullStoryQuery = $conn->query($fetchFullStoryQuery);
$fulStoryRow = $fetchFullStoryQuery->fetch_assoc();

if ($fetchFullStoryQuery->num_rows >0) {
echo'this story is blocked...can not be commented';
}else{
$insertCommentQuery = $conn->prepare("INSERT INTO tbl_comments (comment_body, comment_by, post_id , comment_time) VALUES(?, ?, ?, NOW())");

 $insertCommentQuery->bind_param("ssi", $commentValue, $login_session_id, $storyId);
 if($insertCommentQuery->execute()){

$fetchCommentsQuery = "SELECT comment_id, comment_body, comment_by, comment_time FROM tbl_comments WHERE post_id='$storyId' ORDER BY comment_id DESC ";
$fetchCommentsQuery = $conn->query($fetchCommentsQuery);

$output.='<table class="table table-responsive" id="commentTable">
<thead> <tr> <th></th> </tr></thead>
<tbody>'; 

foreach ($fetchCommentsQuery as $row) {

$userNameFetch=$row['comment_by'];

$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$userNameFetch'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();

$sqlAdmin = "SELECT id FROM tbl_admin where registration_id='$login_session_id'";
$resultAdmin = $conn->query($sqlAdmin);

if ($resultAdmin->num_rows <= 0) {
$rmvbtn=" ";
}else{
$rmvbtn='<button type="button" style="float:right; color:tomato;" class="glyphicon glyphicon-remove removeComment" id="'.$row['comment_id'].'"></button>';

}

$output.='<tr style="font-size:.9em;">
     <td height="60" ><p>'.$rmvbtn.'</p>'.$row['comment_body'].'</td>
  </tr>'; 
  $output.='<tr>
   <td style="text-align:right; font-size:0.8em;">'.$UserNameRow['name'].'<br>'.$row['comment_time'].'</td>
  </tr>';
}
$output.='</tbody></table>';

echo $output;
 }
 
  else  {
    echo "Unsuccessful: ";
    }
}
   $conn = null;
}

//showing comments for the post

if ($_POST["flagreq"] == 'allCommentShow') {

$output='';
$storyId = trim($_POST['id']);

$storyId = mysqli_real_escape_string($conn, $storyId);

$fetchFullStoryQuery = "SELECT id FROM tbl_story WHERE id='$storyId' AND blocked_flag=1";
$fetchFullStoryQuery = $conn->query($fetchFullStoryQuery);


if ($fetchFullStoryQuery->num_rows >0) {
  echo" ";
}

  else{
  $fetchCommentsQuery = "SELECT comment_id ,comment_body, comment_by, comment_time FROM tbl_comments WHERE post_id='$storyId' ORDER BY comment_id DESC ";

$fetchCommentsQuery = $conn->query($fetchCommentsQuery);



$output.='<table class="table table-responsive" id="commentTable">
<thead> <tr> <th></th> </tr></thead>
<tbody>'; 

foreach ($fetchCommentsQuery as $row) {

$userNameFetch=$row['comment_by'];

$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$userNameFetch'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();

$sqlAdmin = "SELECT id FROM tbl_admin where registration_id='$login_session_id'";
$resultAdmin = $conn->query($sqlAdmin);

if ($resultAdmin->num_rows <= 0) {
$rmvbtn=" ";
}else{
$rmvbtn='<button type="button" style="float:right; color:tomato;" class="glyphicon glyphicon-remove removeComment" id="'.$row['comment_id'].'"></button>';

}

$output.='<tr style="font-size:.9em;">
     <td height="60" ><p>'.$rmvbtn.'</p>'.$row['comment_body'].'</td>
  </tr>'; 
  $output.='<tr>
   <td style="text-align:right; font-size:0.8em;">'.$UserNameRow['name'].'<br>'.$row['comment_time'].'</td>
  </tr>';
}
$output.='</tbody></table>';

echo $output;
}
$conn=null;
}

if ($_POST["flagreq"] == 'getAllSectionData') {

$output='';
$sqlblockUser = "SELECT id FROM tbl_blocked_user where registration_id='$login_session_id'";
$resultblockUser = $conn->query($sqlblockUser);
$UserNameRow = $resultblockUser->fetch_assoc();
if ($resultblockUser->num_rows >0) {
    echo $output;
 }else{
$fetchSectionQuery="SELECT sectionName,id FROM tbl_section";
$fetchSectionQuery = $conn->query($fetchSectionQuery);

$output.='<h4>Story Section</h4><div class="form-group">
<select class="form-control" id="sectionSelection" onchange="selectedSection()">
<option value="" disabled selected>Choose your option</option>';
foreach ($fetchSectionQuery as $getSection) {

$output.='<option value="'.$getSection['id'].'">'.$getSection['sectionName'].'</option>';
}
$output.='</select></div>';
echo $output;

$conn=null;
}}


//show stroies of selected section

if($_POST["flagreq"] == 'getSelectedStory')
{
$sectionId = trim($_POST['sectionId']);
$sectionId = mysqli_real_escape_string($conn, $sectionId);



$output='';
$fetchStoryQuery = "SELECT id, title, body, creationTime, user_id FROM tbl_story WHERE section_id='$sectionId' ";
$fetchStoryQuery = $conn->query($fetchStoryQuery);

$output.='<table class="table table-responsive" frame="box" id="sectionStory" style="background-color:#FFFAF9;">

<thead><tr>
<th></th> </tr></thead>
<tbody>';


foreach ($fetchStoryQuery as $row) {
$date=date_create($row['creationTime']);


$showDate=date_format($date,"d/m/Y H:m:s");
$userNameFetch=$row['user_id'];

$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$userNameFetch'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();

 $output.='<tr>
    <td ><h5 style="text-align:center;"><b>'.$row['title'].'<b></h5></td>
  </tr>'; 
  $output.='<tr style="font-size:.9em;">
    <td height="100" id="showBody" class="show-read-more">'.$row['body'].'</td>
  </tr>
<tr style="font-size:.8em;">
<td>
<div class="row">
<div class="col-sm-6"><b>Posted on:</b>'.$showDate.'<br>'.$UserNameRow['name'].'</div>
<div class="col-sm-6" align="right"><button type="button" name="detailStory" id="'.$row['id'].'"  
class="btn btn-info showForComment">Details</button></div>
</div>
</td>
</tr>';



}

$output.='</tbody></table>';
echo $output;
$conn=null;
}
//admin panel actions starts

//fetch registered users for admin selection
if($_POST["flagreq"] == 'getRegisteredPersons')
{
$actionId = trim($_POST['actionId']);
$actionId = mysqli_real_escape_string($conn, $actionId);
$output='';
if ($actionId==1) {

$fetchUserQuery="SELECT name, id FROM tbl_registration WHERE id<>'$login_session_id'";
$fetchUserQuery = $conn->query($fetchUserQuery);

$output.='<div class="form-group">
        <label for="selectNewAdmin" class="col-sm-4 control-label">Admin Selection:</label>
        <div class="col-sm-4">
        <select class="form-control" id="selectNewAdmin" onchange="NewAdmin()">
<option value="" disabled selected>Choose your option</option>';
foreach ($fetchUserQuery as $getUser) {

$output.='<option value="'.$getUser['id'].'">'.$getUser['name'].'</option>';
}
$output.='</select></div></div>';
echo $output ;

}
if ($actionId==2) {

  echo'<form class="form-inline" method="post" onsubmit="registerNewAdminform()">
     <div class="form-group">
      <label class="sr-only" for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter Name"  name="name" required="required">
    </div>
    <div class="form-group">
      <label class="sr-only" for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter Email"  name="email" required="required">
    </div>
    <div class="form-group">
      <label class="sr-only" for="phone">Phone:</label>
      <input type="tel" class="form-control" id="phone" placeholder="Enter phone Number"  name="phone" required="required">
    </div>
    <div class="form-group">
      <label class="sr-only" for="pwd">Password:</label>
      <input type="password" class="form-control" id="passwd" placeholder="Enter password" name="pwd" required="required">
       <input type="submit"  style="margin-top:1%;"  class="btn btn-success"/>
    </div><br>
    <div class="checkbox" >
      <label><input type="checkbox" onclick="showPassword()">Show Password</label>
    
   
    </div>
  </form>';
}

if ($actionId==3) {
$checkExistenceQuery="SELECT id, name FROM tbl_registration where id<>'$login_session_id'";

$checkExistenceQuery = $conn->query($checkExistenceQuery);

$output.='<div class="form-group">
        <label for="selectNewAdmin" class="col-sm-4 control-label">Block User:</label>
        <div class="col-sm-4">
        <select class="form-control"  id="getBlockUser" onchange="blockUser()">
<option value="" disabled selected>Choose User</option>';
foreach ($checkExistenceQuery as $getUser) {

$output.='<option value="'.$getUser['id'].'">'.$getUser['name'].'</option>';
}
$output.='</select></div></div>';
echo $output ;
}
if($actionId==4)

{
$output='';

$alltheUser="SELECT * FROM tbl_registration WHERE id<>'$login_session_id'";

$alltheUser = $conn->query($alltheUser);

$output.='<table class="table table-responsive table-striped" id="getDetailsForAdmin">
<thead><tr>
<th>Name<th>
<th>Email<th>
<th>Phone No<th>
<th>Status<th>
<th>Details<th>
</tr></thead><tbody>';
foreach ($alltheUser as $getUser) {

  $getStatus=$getUser['id'];

$fetchBlockUserQuery="SELECT id FROM tbl_blocked_user WHERE registration_id='$getStatus'";
$fetchBlockUserQuery = $conn->query($fetchBlockUserQuery);

if ($fetchBlockUserQuery->num_rows > 0) {

$status="Blocked";
  }
else{
  $status="Active";
}

$output.='<tr>
           <td>'.$getUser['name'].'<td>
           <td>'.$getUser['email'].'<td>
           <td>0'.$getUser['phone'].'<td>
           <td>'.$status.'<td>
           <td><button type="button" style="font-size:1em;" name="details"  id="'.$getUser['id'].'" class="btn btn-info viewAllTheDetails">Details</button><td>
          </tr>';

}
echo $output;
}

if ($actionId==5) {


$output='';
$fetchAdminUserQuery="SELECT registration_id FROM tbl_admin where registration_id<>'$login_session_id'";
$fetchAdminUserQuery = $conn->query($fetchAdminUserQuery);
$unblockRow = $fetchAdminUserQuery->fetch_assoc();

$output.='<table class="table table-responsive table-striped" id="getAdminDetails">
<thead><tr>
<th>Name<th>
<th>Email<th>
<th>Phone No<th>
<th>Status<th>
<th>Block Admin</th>
<th>Details<th>';
foreach ($fetchAdminUserQuery as $getAdmin) {
$getStatusHead=$getAdmin['registration_id'];
$fetchBlockUserQuery="SELECT id FROM tbl_blocked_user WHERE registration_id='$getStatusHead'";
$fetchBlockUserQuery = $conn->query($fetchBlockUserQuery);

if ($fetchBlockUserQuery->num_rows > 0) {
  $output.='<th>Unblock</th>';
}
}
$output.='</tr></thead><tbody>';
foreach ($fetchAdminUserQuery as $getAdmin) {

$getStatus=$getAdmin['registration_id'];

$alltheAdmin="SELECT * FROM tbl_registration WHERE id='$getStatus'";

$alltheAdmin = $conn->query($alltheAdmin); 
$adminNameRow = $alltheAdmin->fetch_assoc();

$fetchBlockUserQuery="SELECT id FROM tbl_blocked_user WHERE registration_id='$getStatus'";
$fetchBlockUserQuery = $conn->query($fetchBlockUserQuery);

if ($fetchBlockUserQuery->num_rows > 0) {

$status="Blocked";
$anotherBtn='<td><button type="button" style="font-size:1em;" name="unblock"  id="'.$getAdmin['registration_id'].'" class="btn btn-success unblockAdmin">Unblock</button><td>';
  }
else{
  $status="Active";
  $anotherBtn='';
}
$output.='<tr>
           <td>'.$adminNameRow['name'].'<td>
           <td>'.$adminNameRow['email'].'<td>
           <td>0'.$adminNameRow['phone'].'<td>
           <td>'.$status.'<td>
           <td><button type="button" style="font-size:1em;" name="blockAdmin"  id="'.$getAdmin['registration_id'].'" class="btn btn-danger blockAdmin">Block</button>
          <td><button type="button" style="font-size:1em;" name="details"  id="'.$getAdmin['registration_id'].'" class="btn btn-info viewAllTheDetails">Details</button>
          <td>'.$anotherBtn.'</td>
          </tr>';

}
echo $output;


}



$conn=null;
}


if($_POST["flagreq"] == 'ActiveNewAdmin')
{

$adminId = trim($_POST['adminId']);
$adminId = mysqli_real_escape_string($conn, $adminId);

$checkExistenceQuery="SELECT id FROM tbl_admin WHERE registration_id='$adminId'";
$checkExistenceQuery = $conn->query($checkExistenceQuery);


if ($checkExistenceQuery->num_rows > 0) {

echo"Already an admin";
  }

  else{

$insertAdminQuery = $conn->prepare("INSERT INTO tbl_admin (registration_id, added_by, creation_time) VALUES(?, ?, NOW())");

 $insertAdminQuery->bind_param("is", $adminId, $login_session_id);
 if($insertAdminQuery->execute())
 {
  echo "Successfully added";
 }
 else
 {
  echo "Unsuccess";

 }
}
$conn=null;
}
//newadminregistration
if($_POST["flagreq"] == 'registerNewAdmin')
{
$name = trim($_POST['name']);
$name = mysqli_real_escape_string($conn, $name);
$email = trim($_POST['email']);
$email = mysqli_real_escape_string($conn, $email);
$phoneNo = trim($_POST['phoneNo']);
$phoneNo = mysqli_real_escape_string($conn, $phoneNo);
$phoneNo=substr($phoneNo,1);
$password = trim($_POST['password']);
$password = mysqli_real_escape_string($conn, $password);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$insertAdminReQuery = $conn->prepare("INSERT INTO tbl_registration (name, phone, email, password, creationTime)VALUES(?,?,?,?, NOW())");

$insertAdminReQuery->bind_param("siss", $name, $phoneNo, $email, $hashed_password);
if($insertAdminReQuery->execute()){

$fetchUserPhnQuery="SELECT id FROM tbl_registration WHERE phone='$phoneNo'";
$fetchUserPhnQuery = $conn->query($fetchUserPhnQuery);
$UserIDRow = $fetchUserPhnQuery->fetch_assoc();

$adminIDinput=$UserIDRow['id'];
$insertAdminQuery = $conn->prepare("INSERT INTO tbl_admin (registration_id, added_by, creation_time)VALUES(?,?, NOW())");

$insertAdminQuery->bind_param("ii", $adminIDinput, $login_session_id);
if($insertAdminQuery->execute()){

echo "successfully added";
}
 }
 
else  {
 echo "User Exist ";
     }
   


   $conn = null;



}
//block a user
if($_POST["flagreq"] == 'blockUser')
{

$blockUserId = trim($_POST['blockUserId']);
$blockUserId = mysqli_real_escape_string($conn, $blockUserId);

$insertAdminQuery = $conn->prepare("INSERT INTO tbl_blocked_user (registration_id, blocked_by, creation_time)VALUES(?,?, NOW())");

$insertAdminQuery->bind_param("ii", $blockUserId, $login_session_id);
if($insertAdminQuery->execute()){

echo "successfully blocked";
}
 
 
else  {
 echo "error ";
     }
$conn=null;
}

//block story request
if($_POST["flagreq"] == 'blockStoryRequest')
{

$storyId = trim($_POST['id']);
$storyId = mysqli_real_escape_string($conn, $storyId);
$flagB=1;
$updateQuery = $conn->prepare(" UPDATE tbl_story SET blocked_flag=?,blocked_by=?  
    WHERE id = '$storyId'");

 $updateQuery->bind_param("ii",$flagB, $login_session_id);
 
 if($updateQuery->execute()){


echo "successfully blocked";
}
 
 
else  {
 echo "error";
     }

$conn=null;
}

//get profile details
if($_POST["flagreq"] == 'userProfileDetails')
{

$Proid = trim($_POST['id']);
$Proid = mysqli_real_escape_string($conn, $Proid);

$stmt = "SELECT * FROM tbl_registration WHERE id = '$Proid'";
  $result = $conn->query($stmt);
 if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {

if ($row['gender']=='M') {
$gender="Male";
  }
  else{
    $gender="Female";
  }
$date=date_create($row['birthday']);
$showDate=date_format($date,"d/m/Y");

$proDetail='<table class="table table responsive">
    
  <tbody>
    <tr>
<th></th>
<td><img src="'.$row['image'].'" height="150" width="225" class="img-thumbnail" alt=" No image" /></td>
    </tr>
    <tr>
<th>Name:</th>
<td>'.$row['name'].'</td>

    </tr>
<tr>
  <th>Email:</th>
  <td>'.$row['email'].'</td>

    </tr>
<tr>
    <th>Phone No:</th>
  <td>0'.$row['phone'].'</td>  


    </tr>
<tr>
  <th>Gender:</th>
<td>'.$gender.'</td>

</tr>
<tr>
    <th>Birthday:</th>
  <td>'.$showDate.'</td>  


    </tr>
<tr>
 <th></th>   
<td align="right"><button id="'.$row['id'].'" class="btn btn-info DeleteProfile">Delete</button></td>



    </tr>


  </tbody>



  </table>';


echo $proDetail; 
 $conn=null;
}}}

//comment delete
if ($_POST["flagreq"] == 'deleteComment') {

$commentId = trim($_POST['commentId']);
$commentId = mysqli_real_escape_string($conn, $commentId);

$sql = "DELETE FROM tbl_comments WHERE comment_id='$commentId'";

if ($conn->query($sql) === TRUE) {
    echo "comment deleted successfully";
  }
}


//user delete
if($_POST["flagreq"] == 'userProfileDelete')
{

$Proid = trim($_POST['id']);
$Proid = mysqli_real_escape_string($conn, $Proid);
$output='';
// sql to delete a record
$sql = "DELETE FROM tbl_registration WHERE id='$Proid'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

  }

//story fetch update
if($_POST["flagreq"] == 'fetchStoryDetailsForUpdate')
{

$Storyid = trim($_POST['id']);
$Storyid = mysqli_real_escape_string($conn, $Storyid);

$response = array();
$stmt = "SELECT title,section_id  FROM tbl_story WHERE id = '$Storyid'";
  $result = $conn->query($stmt);
 if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {
          $response=$row;
    }
    $getSection=$response['section_id'];
$stmtSection = "SELECT sectionName FROM tbl_section WHERE id = '$getSection'";
  $resultSection = $conn->query($stmtSection);
   $rowSection = $resultSection->fetch_assoc();

  echo '<script>';
  echo '$("#title").val("'.$response['title'].'");';
  echo '$("#section").val("'.$rowSection['sectionName'].'");';


  echo '</script>';

}

echo json_encode($response);

}


if($_POST["flagreq"] == 'update_post')
{
$title = trim($_POST['title']);
$title = mysqli_real_escape_string($conn, $title);
$postId = trim($_POST['postId']);
$postId = mysqli_real_escape_string($conn, $postId);
$section = trim($_POST['section']);
$section = mysqli_real_escape_string($conn, $section);
$editor1 = trim($_POST['editor1']);

//section id fetch
  $sectionIdQuery = "SELECT id FROM tbl_section WHERE sectionName = '$section'";
  $resultSection = $conn->query($sectionIdQuery);
  $rowSection = $resultSection->fetch_assoc();
  $sectionId=$rowSection['id'];

//story insert
$insertStoryQuery = $conn->prepare("UPDATE tbl_story SET title=?, body=?, section_id=?, creationTime=NOW() WHERE id='$postId'");




 $insertStoryQuery->bind_param("ssi", $title, $editor1, $sectionId);
 if($insertStoryQuery->execute()){

echo "success";
    }
 
  else  {
    echo "Unsuccessful: ";
    }


}

if($_POST["flagreq"] == 'deleteStory')
{
$id = trim($_POST['id']);
$id = mysqli_real_escape_string($conn, $id);

$sql = "DELETE FROM tbl_story WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "story deleted successfully";
  }

}

//search
if($_POST["flagreq"] == 'getSearchResult')
{
$output='';
$search = trim($_POST['search']);
$search = mysqli_real_escape_string($conn, $search);

//tagg
$fetchTagNameQuery = "SELECT tag_id FROM tbl_tags WHERE tag_name LIKE '%$search%'";
$fetchTagNameQuery = $conn->query($fetchTagNameQuery);
$rowTagId = $fetchTagNameQuery->fetch_assoc();
$tagID=$rowTagId['tag_id'];

//sec
$fetchSecQuery = "SELECT id FROM tbl_section WHERE sectionName LIKE '%$search%'";
$fetchSecQuery = $conn->query($fetchSecQuery);
$rowSecId = $fetchSecQuery->fetch_assoc();
$secID=$rowSecId['id'];


$fetchStoryIdQuery = "SELECT DISTINCT id FROM ((SELECT story_id AS id FROM tbl_story_tags WHERE tag_id='$tagID') UNION (SELECT id AS id FROM tbl_story WHERE section_id='$secID')UNION(SELECT id AS id FROM tbl_story WHERE title LIKE '%$search%')UNION(SELECT id AS id FROM tbl_story WHERE body LIKE '%$search%'))tbl_story ORDER BY id DESC";
$fetchStoryIdQuery = $conn->query($fetchStoryIdQuery);

$output.='<table class="table table-responsive" frame="box" id="searchTable" style="background-color:#FFFAF9;">

<thead><tr>
<th></th> </tr></thead>
<tbody>';


foreach ($fetchStoryIdQuery as $rowStory) {
  
$iid=$rowStory['id'];
$fetchStory = "SELECT * FROM tbl_story WHERE id='$iid'";
$fetchStory = $conn->query($fetchStory);
$rowStoryView = $fetchStory->fetch_assoc();

$date=date_create($rowStoryView['creationTime']);
$showDate=date_format($date,"d/m/Y H:m:s");
$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$iid'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();


 $output.='<tr>
    <td ><h5 style="text-align:center;"><b>'.$rowStoryView['title'].'<b></h5></td>
  </tr>'; 
  $output.='<tr style="font-size:.9em;">
    <td height="100" id="showBody" class="show-read-more">'.$rowStoryView['body'].'</td>
  </tr>
<tr style="font-size:.8em;">
<td>
<div class="row">
<div class="col-sm-6"><b>Posted on:</b>'.$showDate.'<br>'.$UserNameRow['name'].'</div>
<div class="col-sm-6" align="right"><button type="button" name="detailStory" id="'.$iid.'"  
class="btn btn-info showForComment">Details</button></div>
</div>
</td>
</tr>';
}
$output.='</tbody></table>';
echo $output;
$conn=null;


}



//unblock a admin
if($_POST["flagreq"] == 'unblockAdmin')
{
$output='';
$id = trim($_POST['id']);
$id = mysqli_real_escape_string($conn, $id);
$sql = "DELETE FROM tbl_blocked_user WHERE registration_id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Unblocked successfully";
  }

}

//block a admin
if($_POST["flagreq"] == 'blockAdmin')
{
$output='';
$id = trim($_POST['id']);
$id = mysqli_real_escape_string($conn, $id);

$insertAdminQuery = $conn->prepare("INSERT INTO tbl_blocked_user (registration_id, blocked_by, creation_time)VALUES(?,?, NOW())");

$insertAdminQuery->bind_param("ii", $id, $login_session_id);
if($insertAdminQuery->execute()){

echo "Successfully blocked";
}
}


//search from profile
if($_POST["flagreq"] == 'getprofilestory')
{
$output='';
$search = trim($_POST['search']);
$search = mysqli_real_escape_string($conn, $search);

//tagg
$fetchTagNameQuery = "SELECT tag_id FROM tbl_tags WHERE tag_name LIKE '%$search%'";
$fetchTagNameQuery = $conn->query($fetchTagNameQuery);
$rowTagId = $fetchTagNameQuery->fetch_assoc();
$tagID=$rowTagId['tag_id'];

//sec
$fetchSecQuery = "SELECT id FROM tbl_section WHERE sectionName LIKE '%$search%'";
$fetchSecQuery = $conn->query($fetchSecQuery);
$rowSecId = $fetchSecQuery->fetch_assoc();
$secID=$rowSecId['id'];


$fetchStoryIdQuery = "SELECT DISTINCT id FROM ((SELECT story_id AS id FROM tbl_story_tags WHERE tag_id='$tagID') UNION (SELECT id AS id FROM tbl_story WHERE section_id='$secID')UNION(SELECT id AS id FROM tbl_story WHERE title LIKE '%$search%')UNION(SELECT id AS id FROM tbl_story WHERE body LIKE '%$search%'))tbl_story ORDER BY id DESC";
$fetchStoryIdQuery = $conn->query($fetchStoryIdQuery);

$output.='<table class="table table-responsive" frame="box" id="searchTable" style="background-color:#FFFAF9;">

<thead><tr>
<th></th> </tr></thead>
<tbody>';


foreach ($fetchStoryIdQuery as $rowStory) {
  
$iid=$rowStory['id'];
$fetchStory = "SELECT * FROM tbl_story WHERE id='$iid'";
$fetchStory = $conn->query($fetchStory);
$rowStoryView = $fetchStory->fetch_assoc();

$date=date_create($rowStoryView['creationTime']);
$showDate=date_format($date,"d/m/Y H:m:s");
$fetchUserQuery="SELECT name FROM tbl_registration WHERE id='$iid'";
$fetchUserQuery = $conn->query($fetchUserQuery);
$UserNameRow = $fetchUserQuery->fetch_assoc();


 $output.='<tr>
    <td ><h5 style="text-align:center;"><b>'.$rowStoryView['title'].'<b></h5></td>
  </tr>'; 
  $output.='<tr style="font-size:.9em;">
    <td height="100" id="showBody" class="show-read-more">'.$rowStoryView['body'].'</td>
  </tr>
<tr style="font-size:.8em;">
<td>
<div class="row">
<div class="col-sm-6"><b>Posted on:</b>'.$showDate.'<br>'.$UserNameRow['name'].'</div>
<div class="col-sm-6" align="right"><button type="button" name="detailStory"  id="'.$iid.'" 
class="btn btn-info fullStory" data-toggle="modal" data-target="#showStoryModal">Details</button></div>
</div>
</td>
</tr>';
}
$output.='</tbody></table>';
echo $output;
$conn=null;


}




?>