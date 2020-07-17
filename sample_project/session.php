<?php
   include('config.php');
   session_set_cookie_params(0);
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($conn,"select id, phone, email from tbl_registration where phone = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $login_session_id=$row['id'];
   $login_session = $row['phone'];
   $login_session_email = $row['email'];
   if(!isset($_SESSION['login_user'])){
      header("location:welcome");
      die();
   }
?>