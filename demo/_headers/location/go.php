<?
$url = strip_tags($_GET["liha"]);
if ($url) {
	header("Location: $url");
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Куда отправимся</title>
</head>

<body>
<form action="<?=$_SERVER["PHP_SELF"]?>">
	Куда отправимся:
	<select name="liha" size="1">
		<option value="http://www.google.ru">Гугл</option>
		<option value="http://www.yandex.ru">Яндекс</option>
		<option value="http://www.rambler.ru">Рамблер</option>
	</select>
	<input type="submit" value="GO!">
</form>

</body>
</html>
