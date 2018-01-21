 <?php include "inc-files/before_content.code"; ?>
 <div id="content">
<?php
if ((!isset($_SESSION["username"])) || ($_SESSION["usertype"]!=1))
{
	echo "<span style='background:red; color:white; font-size:28px'>Нямате права!</span></div></body></html>";
	exit;
}

$mysqli = new mysqli('localhost', 'root', '', $dbName); 
$mysqli->set_charset('utf8'); 

$result = $mysqli->query("SELECT * FROM tbl_tv where id_tv=".$_REQUEST['del_id']);
$row = $result->fetch_assoc();
if ($row['picture']) unlink("pictures/".$row['picture']);
$mysqli->query("delete FROM tbl_tv where id_tv=".$_REQUEST['del_id']);
echo "Данните за посочения телевизор са изтрити.<br>";

$mysqli->close();
?>
<script>setTimeout('self.location.href="list_tv.php"',2500)</script>
 </div>
 <?php include "inc-files/after_content.code"; ?>
