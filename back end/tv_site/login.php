<?php session_start(); ?>
<?php
$mysqli=new mysqli ('localhost','root', '','tv');
$mysqli->set_charset('utf8');
$result =$mysqli->query("SELECT * FROM tbl_users where username ='".$_POST["username"] . "' and passwd= '"  .$_POST["passwd"] . "'");
$mysqli -> close();
if ($row =$result ->fetch_assoc())
  {
  $_SESSION ["username"] =htmlspecialchars (stripslashes($row["username"]));
  
  $_SESSION ["usertype"] =htmlspecialchars (stripslashes($row["usertype"]));
  
  $_SESSION ["personname"] =htmlspecialchars (stripslashes($row["personname"]));
  }
  else  $_SESSION ["error"]="   Невалидно потребителски име и/или грешна парола";
  header ("Location:  .");
  exit;
  ?>