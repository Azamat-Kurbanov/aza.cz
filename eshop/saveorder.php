<?php
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name=clearStr($_POST['name']);
		$email=clearStr($_POST['email']);
		$phone=clearStr($_POST['phone']);
		$addres=clearStr($_POST['address']);
		$orderid=$basket['orderid'];
		$dt=time();
		
		$order="$name|$email|$phone|$address|$orderid|$dt".PHP_EOL;
		file_put_contents("admin/".ORDERS_LOG, $order, FILE_APPEND);
	}
	
	saveOrder($dt);
?>
<html>
<head>
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>