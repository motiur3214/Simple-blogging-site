
<?php

extract($_POST);
include('config.php');
session_set_cookie_params(0);
session_start();

//registration
if($_POST["flagreq"] == 'insert_request')
{
  
$fullname = trim($_POST['fullname']);
$fullname = mysqli_real_escape_string($conn, $fullname);

$email = trim($_POST['email']);
$email = mysqli_real_escape_string($conn, $email);

$birthday = trim($_POST['birthday']);
$birthday = mysqli_real_escape_string($conn, $birthday);

$phone = trim($_POST['phone']);
$phone = mysqli_real_escape_string($conn, $phone);

$gender = trim($_POST['gender']);
$gender = mysqli_real_escape_string($conn, $gender);

$psw = trim($_POST['psw']);
$psw = mysqli_real_escape_string($conn, $psw);

$hashed_password = password_hash($psw, PASSWORD_DEFAULT);



if($_FILES["img"]["name"] != '' )
  {
    $test = explode('.', $_FILES["img"]["name"]);
    
    $ext = end($test);
    $name = rand(100, 999) . '.' . $ext;
    $location = './pro_image/' . $name; 
    // $_SERVER[DOCUMENT_ROOT]."/returnOrder/".$files["name"];
    
    move_uploaded_file($_FILES["img"]["tmp_name"], $location);


  }


 else{
 	$location="noImage";
 }


  $insertQuery = $conn->prepare("INSERT INTO tbl_registration (name, email, phone, birthday, gender, password, image, creationTime)VALUES(?,?,?,?,?,?,?, NOW())");

 $insertQuery->bind_param("ssissss", $fullname, $email, $phone, $birthday, $gender, $hashed_password, $location);
 if($insertQuery->execute()){

echo "success";
    }
 
  else  {
    echo "Unsuccessful: ";
    }
   $conn = null;
 


  
}


//login

if($_POST["flagreq"] == 'loginRequest')
{


$phone = trim($_POST['phoneNo']);
$phone = mysqli_real_escape_string($conn, $phone);
 $passW =trim($_POST['passW']);
 $passW = mysqli_real_escape_string($conn, $passW);
 
   $stmt = "SELECT phone, password FROM tbl_registration WHERE phone = '$phone'";
  $result = $conn->query($stmt);

   if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {
        $row["phone"];
          echo $row["phone"];
         $hashed_password=$row["password"];
         
         if(password_verify($passW, $hashed_password)) {
  
    
         $_SESSION['login_user'] = $phone;
         
         header("location: home");
      }else {
         
         $error = "invalid";
         echo($error);
     }
} 
}else {
    echo "register";
 }

}

//recent story for welcome page
if($_POST["flagreq"] == 'getStoryData')
{


$output='';
$fetchStoryQuery = "SELECT id, title, body, creationTime FROM tbl_story WHERE blocked_flag<>1 ORDER BY id DESC ";
$fetchStoryQuery = $conn->query($fetchStoryQuery);

$output.='<table class="table table-responsive" frame="box" id="showStory" style="background-color:#FAF4F9 ;">

<thead><tr>
<th></th> </tr></thead>
<tbody>';


foreach ($fetchStoryQuery as $row) {
$date=$row['creationTime'];
$date=date_create($date);
$showDate=date_format($date,"d/m/Y H:i:s");

$output.='<tr>
    <td ><h5 style="text-align:center;"><b>'.$row['title'].'<b></h5></td>
  </tr>'; 
  $output.='<tr style="font-size:.9em;">
    <td height="100" id="showBody" class="show-read-more">'.$row['body'].'</td>
  </tr>
<tr style="font-size:.8em;">
<td>
<div class="row">
<div class="col-sm-6"><b>Posted on:</b>'.$showDate.'</div>
<div class="col-sm-6" align="right"><button type="button" name="detailStory" id="'.$row['id'].'"  
class="btn btn-info fullStory" data-toggle="modal" data-target="#showStoryModal">Details</button></div>
</div>
</td>
</tr>';



}

$output.='</tbody></table>';
echo $output;
}

//show full story
if($_POST["flagreq"] == 'fullStoryShow')
{

$storyId = trim($_POST['storyId']);
$storyId = mysqli_real_escape_string($conn, $storyId);
$output='';
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

$fetchFullStoryQuery = "SELECT title,body FROM tbl_story WHERE id='$storyId'";
$fetchFullStoryQuery = $conn->query($fetchFullStoryQuery);
$fulStoryRow = $fetchFullStoryQuery->fetch_assoc();
$output.='<div class="modal-dialog" style="width: 90%; height:97%;">
    <div class="modal-content" style="height: 97%; overflow:auto;" >

      <div class="modal-header">
        <h2 class="modal-title" style="text-align:center;">'.$fulStoryRow['title'].'
        <button data-dismiss="modal" type="button" class="close" style="outline:none">&times;</button></h2><p align="right" style="font-size:.8em; color:grey;">'.$tag1.' '.$tag2.' '.$tag3.'</p>
      </div>
        <div class="modal-body">

            <div>'.$fulStoryRow['body'].'</div>
             
</div>
    </div>
  </div>';
echo $output;
}
?>

