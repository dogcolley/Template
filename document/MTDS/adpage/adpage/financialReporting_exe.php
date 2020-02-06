<?php
	include("./_common.php");

	$reg_date = G5_TIME_YMDHIS;

	if($w=="u"){

		$sql = "update financialReporting set f_year = '$f_year', gubun = '$gubun', title = '$title', price = '$price' where idx = '$idx'";

		sql_query($sql);

		alert("수정 되었습니다.","financialReporting_form.php?w=u&idx=$idx&gopage=$gopage$qtr");

	}else{
		$sql = "insert into financialReporting set f_year = '$f_year', gubun = '$gubun', title = '$title', price = '$price', reg_date = '$reg_date'";

		sql_query($sql);

		alert("등록 되었습니다.","financialReporting.php");

	}
?>