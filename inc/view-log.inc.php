<?

if(file_exists('log/path.log')){
	$res=file('log/path.log');
	echo "<ol>";
	foreach($res as $value){
		list($dt, $page, $ref)=explode('|',$value);
		
		echo "<li>$dt 	- 	$page 	-> 	$ref</li>";
	}
	echo "</ol>";
} else echo 'The file is not exist!';
