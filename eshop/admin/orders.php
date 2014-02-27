<?php
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/db.inc.php";
?>
<html>
<head>
	<title>Поступившие заказы</title>
</head>
<body>
<h1>Поступившие заказы:</h1>
<?php
$orders=getOrders();
foreach($orders as $order){
$sum=0;
?>
<hr>
<h2>Заказ номер: <?= $order['orderid']?></h2>
<p><b>Заказчик</b>: <?= $order['name']?></p>
<p><b>Email</b>: <?= $order['email']?></p>
<p><b>Телефон</b>: <?= $order['phone']?></p>
<p><b>Адрес доставки</b>: <?= $order['address']?></p>
<p><b>Дата размещения заказа</b>: <?= date('d-m-Y H:i:s',$order['date'])?></p>

<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
</tr>
<?
$i=1;
foreach($order['goods'] as $data){
?>
<tr>
	<td align="center"><?= $i++?></td>
	<td align="center"><?= $data['title']?></td>
	<td align="center"><?= $data['author']?></td>
	<td align="center"><?= $data['pubyear']?></td>
	<td align="center"><?= $data['price']?></td>
	<td align="center"><?= $data['quantity']?></td>
</tr>

<?
	$sum+=$data['price']*$data['quantity'];
	}
?>
</table>

<p>Всего товаров в заказе на сумму: <?= $sum?> руб.</p>
<?
}
?>

</body>
</html>