<?php
	// подключение библиотек
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/db.inc.php";
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$title=clearStr($_POST['title']);
		$author=clearStr($_POST['author']);
		$pubyear=clearNum($_POST['pubyear']);
		$price=clearNum($_POST['price']);
	}
	
	if(!addItemToCatalog($title, $author, $pubyear, $price)){
		echo 'Proizoshla oshibka pri dobavlenii tovara v katalog';
	} else {
		header("Location:add2cat.php");
		exit;
	}
	
?>