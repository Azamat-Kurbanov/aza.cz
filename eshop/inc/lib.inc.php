<?php
//funkciya sohranyaet noviy tovar v katalog
function addItemToCatalog($title, $author, $pubyear, $price){
	global $link;
	$sql="INSERT INTO catalog (title, author, pubyear, price)
						VALUES (?, ?, ?, ?)";
	if(!$stmt=mysqli_prepare($link, $sql))
		return false;
	mysqli_stmt_bind_param($stmt, "ssii", $title, $author, $pubyear, $price);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return true;
}

//funkciya dlya filtrovaniya tekstovyh dannyh
function clearStr($data){
	global $link;
	return mysqli_real_escape_string($link, trim(strip_tags($data)));
}

//funkciya dlya filtrovaniya chislovyh dannyh
function clearNum($data){
	return abs((int)$data);
}

//funkciya dlya vyborki tovarov iz kataloga
function selectAllItems(){
	global $link;
	$sql="SELECT id, title, author, pubyear, price
			FROM catalog";
	if(!$result=mysqli_query($link, $sql))
			return false;
	$items=mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	return $items;
}

//funkciya kotoraya sohranyaet korzinu s tovarami v kuki
function saveBasket(){
	global $basket;
	$basket=base64_encode(serialize($basket));
	setcookie('basket', $basket, 0x7FFFFFFF);
}

//funkciya kotoraya sozdaet libo zagrujaet v peremennuyu $basket korzinu s tovarami, libo sozdaet novuyu korzinu s identifikatorom zakaza
function basketInit(){
	global $basket, $count;
	if(!isset($_COOKIE['basket'])){
		$basket=array('orderid'=>uniqid());
		saveBasket();
	}else{
		$basket=unserialize(base64_decode($_COOKIE['basket']));
		$count=count($basket)-1;
	}
}

//funkciya kotoraya dobavlyaet tovar v korzinu pol'zovatelya
function add2Basket($id){
	global $basket;
	$basket[$id]=1;
	saveBasket();
}

//funkciya kotoraya vozvrash'aet vsyu korzinu v vide associativnogo massiva
function myBasket(){
	global $link, $basket;
	$goods=array_keys($basket);
	array_shift($goods);
	$ids=implode(',', $goods);
	$sql="SELECT id, author, title, pubyear, price
					FROM catalog
					WHERE id IN ($ids)";
	if(!$result=mysqli_query($link, $sql))
		return false;
	$items=result2Array($result);
	mysqli_free_result($result);
	return $items;
}

//funkciya kotoraya prinimaet rezul'tat vypolneniya funkcii myBasket i vozvrash'aet associativniy massiv tovarov, dopolnenniy ih kolichestvom
function result2Array($data){
	global $basket;
	$arr=array();
	while($row=mysqli_fetch_assoc($data)){
		$row['quantity']=$basket[$row['id']];
		$arr[]=$row;
	}
	return $arr;
}

//funkciya kotoraya udalyaet tovar iz korziny
function deleteItemFromBasket($id){
	global $basket;
	unset($basket[$id]);
	saveBasket();
}

//funkciya kotoraya peresohranyaet tovary iz korziny v tablicu bazy dannyh i prinimaet v kachestve argumenta datu i vremya zakaza v vide vremennoy metki
function saveOrder($datetime){
	global $link, $basket;
	$goods=myBasket();
	$stmt=mysqli_stmt_init($link);
	$sql="INSERT INTO orders (title, author, pubyear, price, quantity, orderid, datetime)
					VALUES (?, ?, ?, ?, ?, ?, ?)";
	if(!mysqli_stmt_prepare($stmt, $sql))
			return false;
	foreach($goods as $item){
		mysqli_stmt_bind_param($stmt, "ssiiisi", $item['title'], $item['author'], $item['pubyear'], $item['price'], $item['quantity'], $basket['orderid'], $datetime);
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	setcookie('basket','',time()-3600);
	return true;
}


//funkciya kotoraya vozvrash'aet mnogomerniy massiv s informaciey o vseh zakazah, vklyuchaya personal'nie dannie pokupatelya i spisok ego tovarov
function getOrders(){
	global $link;
	if(!is_file(ORDERS_LOG))
		return false;
	//poluchaem v vide massiva personal'nie dannie pol'zovateley iz fayla
	$orders=file(ORDERS_LOG);
	//massiv kotoriy budet vozvrash'en funkciey 
	$allorders=array();
	foreach($orders as $order){
		list($name, $email, $phone, $address, $orderid, $date)=explode('|', $order);
		//promejutochniy massiv dlya hraneniya informacii o konkretnom zakaze
		$orderinfo=array();
		$orderinfo['name']=$name;
		$orderinfo['email']=$email;
		$orderinfo['address']=$address;
		$orderinfo['orderid']=$orderid;
		$orderinfo['date']=$date;
		//SQL zapros dlya vyborki iz tablicy orders vseh tovarov dlya konkretnogo pokupatelya
		$sql="SELECT title, author, pubyear, price, quantity
						FROM orders
						WHERE orderid='$orderid' AND datetime='$date'";
		//poluchenie rezul'tata vyborki 
		if(!$result=mysqli_query($link, $sql))
			return false;
		$items=mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		//sohranenie rezul'tata v promejutochnom massive
		$orderinfo['goods']=$items;
		//dobavlenie promejutochnogo massiva v vozvrash'aemiy massiv
		$allorders[]=$orderinfo;
	}
	return $allorders;
}