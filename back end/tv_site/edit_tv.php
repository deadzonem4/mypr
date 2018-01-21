 <?php include "inc-files/before_content.code"; ?>
 <div id="content">
<?php
$mysqli = new mysqli('localhost', 'root', '', $dbName); 
$mysqli->set_charset('utf8'); 

$result = $mysqli->query("SELECT tbl_tv.*, tbl_model.model FROM tbl_tv join tbl_model on tbl_tv.id_model=tbl_model.id_model where id_tv=".$_REQUEST['edit_id']);
$row = $result->fetch_assoc();

echo "<form action='exec_edit_tv.php' method='post'>";
echo "<input type='hidden' value='".$_REQUEST['edit_id']."' name='id_tv'>";
echo "<table border='1' align='center'>";
echo "<tr valign='top'>";
echo "<td width='33%'> марка: <b>".htmlspecialchars(stripslashes($row['model'])) . "</b><br>цена: <b><input type='text' value='".htmlspecialchars(stripslashes($row['price'])). "' name='price'></b><br> Инч: <b><input type='text' value='".htmlspecialchars(stripslashes($row['size'])). "' name='size'></b><br><hr><textarea rows='10' cols='30' name='moreinfo'>".htmlspecialchars(stripslashes($row['moreinfo']))."</textarea><br><input type='submit' value='Запис'></td><td>".($row['picture']?"<img src='pictures/".$row['picture']."'>":"Няма снимка!")."</td>";
echo "</tr>";
echo "</tv>";

echo "</form>";

$mysqli->close();
?>
 </div>
 <?php include "inc-files/after_content.code"; ?>
