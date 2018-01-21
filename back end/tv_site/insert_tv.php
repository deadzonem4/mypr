<?php include "inc-files/before_content.code"; ?>
<div id="content">
<table align="center"><tr><td>
	<form action="exec_insert_tv.php" method="post" enctype="multipart/form-data">
	<u>Въвеждане на данни за нов телевизор:</u><br><br>
модел:
<?php
$mysqli = new mysqli('localhost', 'root', '', $dbName);
$mysqli->set_charset('utf8');

$result = $mysqli->query("SELECT * FROM tbl_model order by model");
echo "<select name='id_model'>";
echo "<option value = '0'>Изберете...</option>";
while($row = $result->fetch_assoc())
{
echo "<option value='".htmlspecialchars(stripslashes($row['id_model'])) . "'>".htmlspecialchars(stripslashes($row['model']))."</option>";
}
echo "</select>";
$mysqli->close();
?>
цена:<input type="text" name="price" value="">лв. <br>
размер:<input type="text" name="size" value="">инчове <br>
др. информация:<br><textarea name="moreinfo" rows="10" cols="40"></textarea><br>
снимка: <input type="file" name="imgFile"><br>
<input type="submit" value="Добави">
	</form>
	</table>
	</div>
<?php include "inc-files/after_content.code";?>