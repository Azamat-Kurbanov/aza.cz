<?
$dir=opendir('.');
echo "<ul>";
while($name=readdir($dir)){
	if(is_dir($name)){
		echo "<li><b>[".$name."]</b></li>";
	} else echo "<li>".$name."</li>";
}
echo "</ul>";
closedir($dir);
?>