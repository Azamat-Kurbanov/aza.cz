<?php
header('Content-Type: text/html; charset=utf-8');
//nastroyki BD
define('DB_HOST', 'aza.cz');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'eshop');
define('ORDERS_LOG', 'orders.log');

//korzina pokupatelya
$basket=array();

//kolichestvo tovarov v korzine pokupatelya
$count=0;

//soedinenie s bazoy dannyh
$link=mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die('Connecting error'.mysqli_connect_error());

basketInit();