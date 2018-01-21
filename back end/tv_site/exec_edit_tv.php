 <?php include "inc-files/before_content.code"; ?>
 <div id="content">
<?php
if ((!isset($_SESSION["username"])) || ($_SESSION["usertype"]!=1))
{
	echo "<span style='background:red; color:white; font-size:28px'>Нямате права!</span></div></body></html>";
	exit;
}

$errMsg="";
if (empty($_POST["price"]))
	$errMsg .="Не е въведена цена!<br>";
else
	if (!is_numeric($_POST["price"])) $errMsg .="Некоректно въведена цена!<br>";
if ($errMsg) 
{
	echo "<span style='color:green'>".$errMsg."</span><br>";
	echo "<a href='edit_tv.php?edit_id=".$_POST["id_tv"]."'> Корекция на данните</a>";
}
else
{
	$mysqli = new mysqli('localhost', 'root', '', $dbName); 
	$mysqli->set_charset('utf8'); 

	$str_query="update tbl_tv set price=".$_POST["price"].", moreinfo='".$_POST["moreinfo"]."' where id_tv=".$_POST["id_tv"];
	$mysqli->query($str_query);
	echo "Данните са обновени...<br>";

	$mysqli->close();
}
?>
 </div>
 <?php include "inc-files/after_content.code"; ?>
