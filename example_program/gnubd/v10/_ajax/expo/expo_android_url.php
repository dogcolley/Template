<?
	include_once('../../../common.php');
	header('Access-Control-Allow-Origin: *'); 

	$DATA = json_decode(file_get_contents("php://input"), true);
	$token = $DATA['token'];

	if($token){
		$version = sql_fetch("SELECT * FROM  g5_push_config WHERE config_key = 'android_url' ");
		echo $version['config_value'];
	}else{
		echo 'err';
	}
?>