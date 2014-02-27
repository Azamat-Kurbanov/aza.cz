<?
if($link=mysqli_connect('localhost','root','','web')) echo 'Soedinenie uspeshno';
	else echo 'Soedinenie neuspeshno';
mysqli_close($link);
?>