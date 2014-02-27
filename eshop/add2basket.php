<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
	if(!isset($_GET['id'])){
		echo 'Proizoshla oshibka pri dobavlenii tovara v korzinu';
		exit;
	}else{
		$id=clearNum($_GET['id']);
		add2Basket($id);
		header('Location: catalog.php');
		exit;
	}
?>