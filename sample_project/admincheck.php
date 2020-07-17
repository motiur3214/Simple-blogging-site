<?php  
include('session.php');
include('config.php');

$sqlAdmin = "SELECT id FROM tbl_admin where registration_id='$login_session_id'";
$resultAdmin = $conn->query($sqlAdmin);

if ($resultAdmin->num_rows <= 0) {


header("location:home");
   die(); 
}
$conn = null;


?>