<?
$dt=date('d-m-Y H:i:s');
$page=$_SERVER['REQUEST_URI'];
$ref=$_SERVER['HTTP_REFERER'];
$path="$dt|$page|$ref".PHP_EOL;

$handle=fopen('log/'.PATH_LOG, 'a+');
fwrite($handle, $path);
fclose($handle);

