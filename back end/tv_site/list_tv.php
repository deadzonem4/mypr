<?php include "inc-files/before_content.code"; ?>
<script type="text/javascript">
function removeTv(num)
{
if (confirm("Изтриване на телевизор !?"))
	self.location.href="exec_delete_Tv.php?del_id="+num;
	}
	</script>
	<div id="content">
	<?php
	$mysqli = new mysqli('localhost','root', '',$dbName);
	$mysqli->set_charset('utf8');
	$strQuery="SELECT tbl_tv.*, tbl_model.model FROM tbl_tv join tbl_model on tbl_tv.id_model=tbl_model.id_model order by model";
	$result = $mysqli->query($strQuery);
	echo "<table border='1' align='center' width='600' >";
	if (isset($_SESSION["username"]) && $_SESSION["usertype"]==1)
	{
		echo "<tr><th> модел </th> <th> цена </th> <colspan='2'> <th> операции </th> </tr>";
		while($row = $result -> fetch_assoc())
		{
		echo "<tr>";
		echo "<td> <a href='show_tv.php?show_id=".$row['id_tv']."' title='Подробна информация'>" .htmlspecialchars(stripslashes($row['model'])) . " </a></td><td>
		".htmlspecialchars(stripslashes($row['price'])). "лв. </td><td> <a href='edit_tv.php?edit_id=".$row['id_tv']."' title='Промяна на цената и на допълнителната информация'> 
		редактиране </a> </td><td><a href='javascript:removeTv(".$row['id_tv'].")' title='Изтриване на данните'> изтриване</a></td>";
		echo "</tr>";
		}
	}		
		else
		{
		echo "<tr><th>модел </th> <th> цена</th></tr>";
		while($row = $result -> fetch_assoc())
		{
		echo "<tr>";
		echo "<td> <a href='show_tv.php?show_id=".$row['id_tv']."' title='Подробна информация'>" .htmlspecialchars(stripslashes($row['model'])) . " </a></td><td>
		".htmlspecialchars(stripslashes($row['price'])). "лв. </td>";
		echo "</tr>";
		}
	}
echo "</table>";
$mysqli->close();
?>
</div>
<?php include "inc-files/after_content.code"; ?>
		