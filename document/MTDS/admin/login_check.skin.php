<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 자신만의 코드를 넣어주세요.
if ($mb[mb_id] == "admin")
	goto_url("../adpage");
else if ($mb[mb_id] == "super")
	goto_url("../adm");
?>
