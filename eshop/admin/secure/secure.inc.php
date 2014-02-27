<?
define("FILE_NAME", ".htpaswwd");
//funkciya kotoraya generiruet hash parolya s pomosh'yu funkcii sha1
function getHash($hash, $salt, $iterCount){
	for($i=0; $i<$iterCount; $i++){
		$hash=sha1($hash.$salt);
	}
	return $hash;
}

//funkciya kotoraya sohranyaet hash v fayl
function saveHash($user, $hash, $salt, $iterCount){
	$str="$user:$hash:$salt:$iterCount".PHP_EOL;
	if(file_put_contents(FILE_NAME, $str, FILE_APPEND)){
		return true;
	} else {
		return false;
	}
}

//funkciya proveryayush'aya nalichie pol'zovatelya v spiske
function userExists($login){
	if(!is_file(FILE_NAME))
		return false;
	$users=file(FILE_NAME);
	foreach($users as $user){
		if(strpos($user, $login)!==false)
		return $user;
	}
	return false;
}

//funkciya kotoraya zavershaet seans pol'zovatelya
function logOut(){
	session_destroy();
	header("Location: secure/login.php");
	exit;
}