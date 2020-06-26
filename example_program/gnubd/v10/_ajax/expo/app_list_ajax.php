<?
include_once('../../../../common.php');

file_get_contents("php://input");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: https://6veek.codesandbox.io");
$mode = $_GET['mode'];

if($mode == 'ad_list'){
	$pageNow = $_GET['page'];
	$pageRow = $_GET['pageRow'] ? $_GET['pageRow'] : 10 ;
	$piceNow = $_GET['pagePieceNow'];
	$pageSS = ($pageNow - 1) * $pageRow;
	//$pageSE = ($pageNow) * $pageRow;

	//get adroid_token_list 
	$sql = "SELECT COUNT(*) AS cnt FROM g5_push_android";
	$qry = sql_fetch ($sql);
	$pageItems = $qry['cnt'];

	$sql = "SELECT * FROM g5_push_android ORDER BY ad_datetime DESC LIMIT $pageSS , $pageRow "; //GROUP BY ad_token  LIMIT 0 , 15
	$qry = sql_query ($sql);
	for ($i=0; $row=sql_fetch_array($qry); $i++){
		$ad_tk_list[] = $row;
	}
	//$json['sql'] = $sql;
	$json['list'] = $ad_tk_list;
	$json['pageItems'] = $pageItems;
	$json = json_encode($json);
	echo $json;
}else if($mode == 'config_insert'){
	if(sql_query("INSERT INTO `g5_push_config` (`config_os`, `config_key`, `config_value`, `config_tit`, `config_description`, `config_use`) VALUES ('".$_GET['os']."', '".$_GET['key']."', '".$_GET['value']."', '".$_GET['tit']."', '".$_GET['des'].".', '1')")){
		$json['state'] = 'success';
	}else{
		$json['state'] = 'err';
	}
	$json = json_encode($json);
	echo $json;
}else if($mode == 'config_chage'){
    $sql = " update `g5_push_config`
                set  config_os = '".$_GET['os']."',
                     config_key = '".$_GET['key']."',
                     config_value = '".$_GET['value']."',
                     config_tit = '".$_GET['tit']."',
                     config_description = '".$_GET['des']."'
              where  config_id = '".$_GET['idx']."' ";
	$json['sql']= $sql;
    if(sql_query($sql)){
		$json['state'] = 'success';
	}else{
		$json['state'] = 'err';
	}
	$json = json_encode($json);
	echo $json;
}else if($mode == 'config_delate'){
	if(sql_query("DELETE FROM `g5_push_config` WHERE config_id = '".$_GET['idx']."'")){
		$json['state'] = 'success';
	}else{
		$json['state'] = 'err';
	}
	$json = json_encode($json);
	echo $json;
}else if($mode == 'config_get'){
	//get push config
	$sql = "SELECT * FROM g5_push_config ORDER BY config_os";
	$qry = sql_query ($sql);
	for ($i=0; $row=sql_fetch_array($qry); $i++){
		$config_id[] = $row['config_id'];
		$config_key[] = $row['config_key'];
		$config_val[] = $row['config_value'];
		$config_des[] = $row['config_description'];
		$config_tit[] = $row['config_tit'];
		$config_os[] = $row['config_os'];
	}
	$json['config_id'] = $config_id;
	$json['config_key'] = $config_key;
	$json['config_val'] = $config_val;
	$json['config_des'] = $config_des;
	$json['config_tit'] = $config_tit;
	$json['config_os'] = $config_os;
	$json = json_encode($json);
	echo $json;
}else{
	
}

?>