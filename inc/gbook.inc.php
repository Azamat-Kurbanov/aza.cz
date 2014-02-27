<?
//Osnovnie nastroyki
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASSWORD','');
define('DB_NAME', 'gbook');
$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
function clearStr($data){
	global $link;
	return mysqli_real_escape_string($link,trim(strip_tags($data)));
}

//Сохранение записи в БД
if($_SERVER['REQUEST_METHOD']=='POST'){
	$name=clearStr($_POST['name']);
	$email=clearStr($_POST['email']);
	$msg=clearStr($_POST['msg']);

	$sql="INSERT INTO msgs (name, email, msg)
					VALUES ('$name','$email', '$msg')";
	mysqli_query($link, $sql) or die(mysqli_error());
}

//Удаление записи из БД
if(isset($_GET['del'])){
	$del=abs((int)$_GET['del']);
	if($del){
		$sql="DELETE FROM msgs WHERE id=$del";
		mysqli_query($link, $sql) or die(mysqli_error());
	}
}

?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" value="Отправить!" />

</form>
<!-- Вывод записей из БД -->
<?
$sql="SELECT id, name, email, msg, UNIX_TIMESTAMP(datetime) as dt
				FROM msgs ORDER BY id DESC";
$data=mysqli_query($link, $sql) or die(mysqli_error($link));
mysqli_close($link);
?>
<p>Всего записей в гостевой книге:<?=$row['id']?> количество записей</p>
<?
while($row=mysqli_fetch_array($data, MYSQLI_ASSOC)){
?>
<hr>
<p>
	<a href="mailto:<?=$row['email']?>"><?=$row['name']?></a> <?=date('d-m-Y H:i:s',$row['dt'])?> написал<br />
	<?= nl2br($row['msg'])?>
</p>
<p align='right'>
	<a href='<?=$_SERVER['REQUEST_URI']?>&del=<?=$row['id']?>'>Delete</a>
</p>
<?	
}
?>
<!-- Вывод записей из БД -->
