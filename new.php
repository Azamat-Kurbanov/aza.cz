<?
function recursion($a) {
if ($a < 20) {
echo "$a\n";
$a++;
recursion($a);
}
}
recursion(0);
?>