	<?php include "inc-files/before_content.code"; error_reporting( error_reporting() & ~E_NOTICE ); ?>
	<div id="content">
<?php
if ((!isset($_SESSION["username"])) ||($_SESSION["usertype"]!=1))
{
	echo"<h1>Нямате необходимите права!</h1>
	</div></body></html>";
	exit;
}
$errMsg="";
if ($_POST["id_model"]==0) $errMsg .="Не е избран модел!<br>";
if (empty ($_POST["price"]))
	$errMsg .="Не е въведена цена!<br>";
else
	if (!is_numeric($_POST["price"])) $errMsg.="Некоректно въведена цена!<br>";
if($errMsg){
	echo"<span style='color:green'>".$errMsg."</span><br>";
	echo"<a href='insert_tv.php'>Ново въвеждане</а>";
	}
else
{
	$mysqli= new mysqli('localhost', 'root', '', $dbName);
	$mysqli->set_charset('utf8');
	$str_query="INSERT INTO tbl_tv(id_model, price, moreinfo,size) VALUES('".$_POST["id_model"]."','".$_POST["price"]."','".$_POST["moreinfo"]."','".$_POST["size"]."')";
	$mysqli->query($str_query);
	echo "Данните са записани в базата...<br>";
	
	$fileErr=$_FILES["imgFile"]["error"]>0;
		if ($fileErr)
		{
		echo "Не е заредена снимка.<br>";
		}
	else
		{
		$allowedExt = array("gif", "jpeg", "jpg", "png");
		$arrName = explode(".", $_FILES["imgFile"]["name"]);
		$ext = end($arrName);
		if (in_array($ext, $allowedExt) && ($_FILES["imgFile"]["size"] < 2000000))
		{
			$idTv=$mysqli->insert_id;
			$picName="Pic".$idTv.".".$ext;
			move_uploaded_file($_FILES["imgFile"]["tmp_name"], "pictures/".$picName);
			$str_query="update tbl_tv set picture='".
			$picName."' where id_tv=".$idTv;
			$mysqli->query($str_query);
			echo "Снимката е качена...<br>";
			}
			else
			{
				echo "Неправилен Image-файл!<br>";
			}
		}
	$mysqli->close();
}
?>
</div>
<?php include "inc-files/after_content.code"; ?>
			