<HTML>
<HEAD>
<TITLE>fopen</TITLE>
</HEAD>
<BODY>
<?
	$myFile = fopen("data.txt", "r") or die("�� ���� ������� ����");
	echo '���� ������� ������ ��� ������';
	fclose($myFile);
	echo '���� ������';

	
?>
</BODY>
</HTML>