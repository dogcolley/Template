<?
	include_once('./_common.php');

	if(!$gubun){
		alert("잘못된 접근입니다.");
	}

	$date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $date);

	/*================================================================================
    php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
    =================================================================================*/

    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

    $fname = tempnam(G5_DATA_PATH, "tmp-orderlist.xls");
    $workbook = new writeexcel_workbook($fname);
    $worksheet = $workbook->addworksheet();

    // Put Excel data
	$data = array('주문번호','주문자','주문합계','쿠폰','무통장','가상계좌','계좌이체','카드입금','휴대폰','포인트입금','주문취소','미수금');

	$data = array_map('iconv_euckr', $data);

    $col = 0;
    foreach($data as $cell) {
        $worksheet->write(0, $col++, $cell);
    }

	$sql = " select od_id,
                mb_id,
                od_name,
                od_settle_case,
                od_cart_price,
                od_receipt_price,
                od_receipt_point,
                od_cancel_price,
                od_misu,
                (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where SUBSTRING(od_time,1,10) = '$date'
          order by od_id desc ";
	$result = sql_query($sql);

    unset($tot);
	for($i=1, $j=0; $row=sql_fetch_array($result); $i++,$j++)
    {
		$row = array_map('iconv_euckr', $row);

        $receipt_bank = $receipt_card = $receipt_vbank = $receipt_iche = $receipt_hp = 0;
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','무통장'))
            $receipt_bank = $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','가상계좌'))
            $receipt_vbank = $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','계좌이체'))
            $receipt_iche = $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','휴대폰'))
            $receipt_hp = $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','신용카드'))
            $receipt_card = $row['od_receipt_price'];


		$worksheet->write($i, 0, " ".$row['od_id']);
		$worksheet->write($i, 1, $row['od_name']);
		$worksheet->write($i, 2, number_format($row['orderprice']));
		$worksheet->write($i, 3, number_format($row['couponprice']));
		$worksheet->write($i, 4, number_format($receipt_bank));
		$worksheet->write($i, 5, number_format($receipt_vbank));
		$worksheet->write($i, 6, number_format($receipt_iche));
		$worksheet->write($i, 7, number_format($receipt_card));
		$worksheet->write($i, 8, number_format($receipt_hp));
		$worksheet->write($i, 9, number_format($row['od_receipt_point']));
		$worksheet->write($i, 10, number_format($row['od_cancel_price']));
		$worksheet->write($i, 11, number_format($row['od_misu']));

        $tot['orderprice']    += $row['orderprice'];
        $tot['ordercancel']   += $row['od_cancel_price'];
        $tot['coupon']        += $row['couponprice'] ;
        $tot['receipt_bank']  += $receipt_bank;
        $tot['receipt_vbank'] += $receipt_vbank;
        $tot['receipt_iche']  += $receipt_iche;
        $tot['receipt_card']  += $receipt_card;
        $tot['receipt_hp']    += $receipt_hp;
        $tot['receipt_point'] += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
	}

	$worksheet->write($i, 0, iconv('utf-8','euc-kr','합 계'));
	$worksheet->write($i, 1, "");
	$worksheet->write($i, 2, number_format($tot['orderprice']));
	$worksheet->write($i, 3, number_format($tot['coupon']));
	$worksheet->write($i, 4, number_format($tot['receipt_bank']));
	$worksheet->write($i, 5, number_format($tot['receipt_vbank']));
	$worksheet->write($i, 6, number_format($tot['receipt_iche']));
	$worksheet->write($i, 7, number_format($tot['receipt_card']));
	$worksheet->write($i, 8, number_format($tot['receipt_hp']));
	$worksheet->write($i, 9, number_format($tot['receipt_point']));
	$worksheet->write($i, 10, number_format($tot['ordercancel']));
	$worksheet->write($i, 11, number_format($tot['misu']));

    $workbook->close();

	$file_name = iconv('utf-8','euc-kr',$date." 일 매출현황");

    header("Content-Type: application/x-msexcel; name=\"".$file_name.".xls\"");
    header("Content-Disposition: inline; filename=\"".$file_name.".xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
    unlink($fname);

    exit;
?>