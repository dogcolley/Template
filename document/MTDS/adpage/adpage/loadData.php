<?php
	include("./_common.php");

	$code = $_POST['code'];	// 넘오온 값
	$bo_table = $_POST['bo_table'];	// 넘오온 값

	echo "[";
	if(strlen($code) == "2"){
		$list2 = sql_query("select * from g5_shop_category where length(ca_id) = 4 and ca_id like '$code%' order by ca_id asc");
	}elseif(strlen($code) == "4"){
		$list2 = sql_query("select * from g5_shop_category where length(ca_id) = 6 and ca_id like '$code%' order by ca_id asc");
	}
	for ($i=0; $row=sql_fetch_array($list2); $i++){
		if($i>0){echo ",";}
		echo "{'code' : '$row[ca_id]', 'name' : '$row[ca_name]'}";
	}
	echo "]";
?>