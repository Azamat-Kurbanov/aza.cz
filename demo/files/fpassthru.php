<?
	$myFile = fopen("data.txt", "r") or die("Не могу открыть файл");
	fread($myFile);
	fpassthru($myFile);
	fclose($myFile);
?>
