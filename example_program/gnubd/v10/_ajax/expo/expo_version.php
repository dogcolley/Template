<?
	include_once('../../../../common.php');
	header('Access-Control-Allow-Origin: *'); 

	$DATA = json_decode(file_get_contents("php://input"), true);
	$token = $DATA['token'];

	if($token){
		$version = sql_fetch("SELECT * FROM  g5_push_config WHERE config_key = 'version' ");
		$android_url = 	sql_fetch("SELECT * FROM  g5_push_config WHERE config_key = 'anroid_update_url' ");
		$json['version'] = $version['config_value'];
		$json['state'] = 'ok';
		$json['android_url'] = $android_url['config_value'];
	}else{
		$json['state'] = 'ok';
	}
	$json = json_encode($json);
	echo $json;
?>
