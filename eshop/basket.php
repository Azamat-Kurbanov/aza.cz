<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
?>
<html>
<head>
	<title>Корзина пользователя</title>
</head>
<body>
	<h1>Ваша корзина</h1>
<?php
if($count==0){
	echo "Ваша корзина пуста! Вернитесь в <a href='catalog.php'>каталог.</a>";
	exit;
}else{
	echo "Вернутся в <a href='catalog.php'>каталог.</a>";
}
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
	$goods=myBasket();
	$i=1;
	$sum=0;
	if($goods){
	foreach($goods as $item){
		$author=$item['author'];
		$title=$item['title'];
		$pubyear=$item['pubyear'];
		$price=$item['price'];
		$quantity=$item['quantity'];
		$id=$item['id'];
	echo <<<HTML
	<tr>
		<td align='center'>$i</td>
		<td align='center'>$title</td>
		<td align='center'>$author</td>
		<td align='center'>$pubyear</td>
		<td align='center'>$price</td>
		<td align='center'>$quantity</td>
		<td align='center'><a href="delete_from_basket.php?id=$id">Удалить</a></td>
	</tr>
HTML;
	$i++;
	$sum+=$quantity*$price;
	}
}
?>
</table>

<p>Всего товаров в корзине на сумму: <?=$sum?> руб.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='orderform.php'" />
</div>

</body>
</html>







