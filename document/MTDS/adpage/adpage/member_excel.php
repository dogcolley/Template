<?
	include_once('./_common.php');

	/*================================================================================
    php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
    =================================================================================*/

    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

    $fname = tempnam(G5_DATA_PATH, "tmp-orderlist.xls");
    $workbook = new writeexcel_workbook($fname);
    $worksheet = $workbook->addworksheet();

    // Put Excel data
	$data = array('아이디','회원등급','이름','이메일','휴대폰번호','전화번호','우편번호','주소', '회원가입일');

	$data = array_map('iconv_euckr', $data);

    $col = 0;
    foreach($data as $cell) {
        $worksheet->write(0, $col++, $cell);
    }

	$result = sql_query("select * from {$g5['member_table']} where (1) and mb_level < 10 order by mb_no");
	for($i=1; $row=sql_fetch_array($result); $i++)
    {
		$row = array_map('iconv_euckr', $row);

		if($row['mb_level'] == "2"){
			$m_text = "새내기";
		}elseif($row['mb_level'] == "3"){
			$m_text = "골드";
		}elseif($row['mb_level'] == "4"){
			$m_text = "VIP";
		}else{
			$m_text = "비회원";
		}

		$m_text = iconv('utf-8', 'euc-kr', $m_text);

		$worksheet->write($i, 0, $row['mb_id']);
        $worksheet->write($i, 1, $m_text);
        $worksheet->write($i, 2, $row['mb_name']);
        $worksheet->write($i, 3, $row['mb_email']);
        $worksheet->write($i, 4, ' '.$row['mb_hp']);
		$worksheet->write($i, 5, ' '.$row['mb_tel']);        
        $worksheet->write($i, 6, ' '.$row['mb_zip1'].$row['mb_zip2']);
        $worksheet->write($i, 7, print_address($row['mb_addr1'], $row['mb_addr2'], $row['mb_addr3'], $row['mb_addr_jibeon']));
        $worksheet->write($i, 8, $row['mb_datetime']);	
	}

    $workbook->close();

    header("Content-Type: application/x-msexcel; name=\"member-".date("ymd", time()).".xls\"");
    header("Content-Disposition: inline; filename=\"member-".date("ymd", time()).".xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
    unlink($fname);

    exit;
?>