<?php include "inc-files/before_content.code"; ?><style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<div id="content">
<?php
$mysqli = new mysqli ('localhost' , 'root', '', $dbName);
$mysqli->set_charset('utf8');
$result = $mysqli -> query("SELECT tbl_tv.*, tbl_model.model FROM tbl_tv join tbl_model on
tbl_tv.id_model=tbl_model.id_model where id_tv=".$_REQUEST['show_id']);
$row = $result ->fetch_assoc();
echo "<table border='1' align='center' height='300' width='800'>";
echo "<tr align='top'>";
echo "<td width='250'> модел: <b>".htmlspecialchars(stripslashes($row['model'])) . "</b><br> цена: <b>".htmlspecialchars
(stripslashes($row['price'])) . "</b> лв. <br>  инч: <b>".htmlspecialchars(stripslashes($row['size'])) . "</b><br> Допълнителна информация:</b><hr><span style='font-size:16px'><pre>".
htmlspecialchars(stripslashes($row['moreinfo'])) .
"</pre></span></td><td>".($row['picture']?"<img src='pictures/".$row['picture']."'>":"Не е намерена снимка").
"</td>";
echo "</tr>";
echo "</table>";
echo "<a href='javascript:history.back()' title='Връщане към предходната страница'> Обратно към списъка</а>";
$mysqli->close();
?>
</div>
<?php include "inc-files/after_content.code"; ?>