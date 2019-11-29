<?php
	include("./_common.php");

	$gu = $_POST['gu'];	// 넘어온 오브젝트
	$idx = $_POST['idx'];	// 넘어온 오브젝트
	$val = $_POST['val'];	// 넘오온 값
	$hol_date = $_POST['hol_date'];

	if($gu == "h_state"){

		$row = sql_query("delete from reservation_hol where h_date = '$hol_date'");
		echo "[";
		echo "{'code' : '$row'}";
		echo "]";

	}else{

		$row = sql_query("update g5_write_reservation set wr_15 = '$val' where wr_id = '$idx'");
		echo "[";
		echo "{'code' : '$row'}";
		echo "]";

	}
?>