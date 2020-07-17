  
<style>
  <?php
include 'mystyle.css'; ?>
</style>
<?php

include('session.php');


$sql = "SELECT image, name FROM tbl_registration where phone='$login_session'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   

 $row = $result->fetch_assoc();
        $imageSource=$row["image"];
        $name=$row["name"];


}
//check admin
$sqlAdmin = "SELECT id FROM tbl_admin where registration_id='$login_session_id'";
$resultAdmin = $conn->query($sqlAdmin);

//check for blocked user
$sqlblockUser = "SELECT id FROM tbl_blocked_user where  registration_id='$login_session_id'";
$resultblockUser = $conn->query($sqlblockUser);
$conn = null;
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <?php
    echo'<figure><img src="'.$imageSource.'" alt="no image" class="avatar">
     <figcaption>'.$name.'</figcaption></figure>'
     ?>
    </div>
    <ul class="nav navbar-nav">
      
    <li><a href="home">Home</a></li>
      <li><a href="myPro">My Profile/ My Story</a></li>
 
 <?php
if ($resultblockUser->num_rows< 1) {
   ?>   
<li><a href="new-story">New Story</a></li>
<?php
}

if ($resultAdmin->num_rows > 0) {
   ?>
       <li><a href="adminPanel">Admin Panel</a></li>
 
<?php
 
}
?>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

    </ul>
   
     
  </div>
</nav>