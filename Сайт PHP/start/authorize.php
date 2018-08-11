<?php
session_start(); 
?>

<?php

  if ($_POST) { 

  $user_name = $_POST['user_name'];
  $user_pass = $_POST['user_pass'];

  $host = "localhost";

  $log_owner = "owner";
  $pas_owner = "owner";
  $log_sale = "sale";
  $pas_sale = "sale";
  $log_man = "manager";
  $pas_man = "manager";
  if(($user_name == $log_owner)  &&  ($user_pass == $pas_owner)){ 
   $_SESSION['status'] = 'owner'; 
     header("Location:../owner/owner.php");
     exit(); 
    }
  else {
    $rez = 0;
    header("Location: index2.php?b=".$rez); 
  }
    
  if(($user_name == $log_sale)  &&  ($user_pass == $pas_sale)){ 
    $_SESSION['status'] = 'sale';
     header("Location:../sale/sale.php");
     exit(); 
    }
  else {
    $rez = 0;
    header("Location: index2.php?b=".$rez); 
  } 

    
  if(($user_name == $log_man)  &&  ($user_pass == $pas_man)){ 
   $_SESSION['status'] = 'manager';
     header("Location:../manager/manager.php");
     exit(); 
    }
  else {
    $rez = 0;
    header("Location: index2.php?b=".$rez); 
  }
  } 
?> 


