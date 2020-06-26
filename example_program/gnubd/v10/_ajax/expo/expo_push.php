<?
	include_once('../../../../common.php');
	header('Access-Control-Allow-Origin: *'); 

	$DATA = json_decode(file_get_contents("php://input"), true);
	$token = $DATA['token'];

	sql_query("INSERT INTO `g5_push_android` (`mb_id`,`ad_token`,`ad_datetime`) VALUES ('geust','".$token."' , NOW())", false);
?>
