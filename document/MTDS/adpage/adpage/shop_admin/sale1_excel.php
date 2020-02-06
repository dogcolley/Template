<?
	include_once('./_common.php');

	if(!$gubun){
		alert("잘못된 접근입니다.");
	}

	$fr_month = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $fr_month);
	$to_month = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $to_month);

	$fr_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

	/*================================================================================
    php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
    =================================================================================*/

    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

    $fname = tempnam(G5_DATA_PATH, "tmp-orderlist.xls");
    $workbook = new writeexcel_workbook($fname);
    $worksheet = $workbook->addworksheet();

    // Put Excel data
	$data = array('주문년도','주문수','주문합계','쿠폰','무통장','가상계좌','계좌이체','카드입금','휴대폰','포인트입금','주문취소','미수금');

	$data = array_map('iconv_euckr', $data);

    $col = 0;
    foreach($data as $cell) {
        $worksheet->write(0, $col++, $cell);
    }

	if($gubun=="year"){
	
		$sql = " select od_id,
						SUBSTRING(od_time,1,4) as od_date,
						od_send_cost,
						od_settle_case,
						od_receipt_price,
						od_receipt_point,
						od_cart_price,
						od_cancel_price,
						od_misu,
						(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
						(od_cart_coupon + od_coupon + od_send_coupon) as couponprice
				   from {$g5['g5_shop_order_table']}
				  where SUBSTRING(od_time,1,4) between '$fr_year' and '$to_year'
				  order by od_time desc ";

	}elseif($gubun=="month"){

		$sql = " select od_id,
					SUBSTRING(od_time,1,7) as od_date,
					od_send_cost,
					od_settle_case,
					od_receipt_price,
					od_receipt_point,
					od_cart_price,
					od_cancel_price,
					od_misu,
					(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
					(od_cart_coupon + od_coupon + od_send_coupon) as couponprice
			   from {$g5['g5_shop_order_table']}
			  where SUBSTRING(od_time,1,7) between '$fr_month' and '$to_month'
			  order by od_time desc ";

	}elseif($gubun=="date"){

		$sql = " select od_id,
					SUBSTRING(od_time,1,10) as od_date,
					od_settle_case,
					od_receipt_price,
					od_receipt_point,
					od_cart_price,
					od_cancel_price,
					od_misu,
					(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
					(od_cart_coupon + od_coupon + od_send_coupon) as couponprice
			   from {$g5['g5_shop_order_table']}
			  where SUBSTRING(od_time,1,10) between '$fr_date' and '$to_date'
			  order by od_time desc ";

	}

	$result = sql_query($sql);

    unset($save);
    unset($tot);
	for($i=1, $j=0; $row=sql_fetch_array($result); $j++)
    {
		$row = array_map('iconv_euckr', $row);

        if ($j == 0)
            $save['od_date'] = $row['od_date'];

        if ($save['od_date'] != $row['od_date']) {

			$worksheet->write($i, 0, $save['od_date']);
			$worksheet->write($i, 1, number_format($save['ordercount']));
			$worksheet->write($i, 2, number_format($save['orderprice']));
			$worksheet->write($i, 3, number_format($save['ordercoupon']));
			$worksheet->write($i, 4, number_format($save['receiptbank']));
			$worksheet->write($i, 5, number_format($save['receiptvbank']));
			$worksheet->write($i, 6, number_format($save['receiptiche']));
			$worksheet->write($i, 7, number_format($save['receiptcard']));
			$worksheet->write($i, 8, number_format($save['receipthp']));
			$worksheet->write($i, 9, number_format($save['receiptpoint']));
			$worksheet->write($i, 10, number_format($save['ordercancel']));
			$worksheet->write($i, 11, number_format($save['misu']));

			$i++;

            unset($save);
            $save['od_date'] = $row['od_date'];
        }

        $save['ordercount']++;
        $save['orderprice']    += $row['orderprice'];
        $save['ordercancel']   += $row['od_cancel_price'];
        $save['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','무통장'))
            $save['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','가상계좌'))
            $save['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','계좌이체'))
            $save['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','휴대폰'))
            $save['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','신용카드'))
            $save['receiptcard']   += $row['od_receipt_price'];
        $save['receiptpoint']  += $row['od_receipt_point'];
        $save['misu']          += $row['od_misu'];

        $tot['ordercount']++;
        $tot['orderprice']    += $row['orderprice'];
        $tot['ordercancel']   += $row['od_cancel_price'];
        $tot['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','무통장'))
            $tot['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','가상계좌'))
            $tot['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','계좌이체'))
            $tot['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','휴대폰'))
            $tot['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == iconv('utf-8','euc-kr','신용카드'))
            $tot['receiptcard']   += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
        
	}

	if ($j == 0) {
    } else {
		$worksheet->write($i, 0, $save['od_date']);
		$worksheet->write($i, 1, number_format($save['ordercount']));
		$worksheet->write($i, 2, number_format($save['orderprice']));
		$worksheet->write($i, 3, number_format($save['ordercoupon']));
		$worksheet->write($i, 4, number_format($save['receiptbank']));
		$worksheet->write($i, 5, number_format($save['receiptvbank']));
		$worksheet->write($i, 6, number_format($save['receiptiche']));
		$worksheet->write($i, 7, number_format($save['receiptcard']));
		$worksheet->write($i, 8, number_format($save['receipthp']));
		$worksheet->write($i, 9, number_format($save['receiptpoint']));
		$worksheet->write($i, 10, number_format($save['ordercancel']));
		$worksheet->write($i, 11, number_format($save['misu']));
    }

	$i++;

	$worksheet->write($i, 0, iconv('utf-8','euc-kr','합 계'));
	$worksheet->write($i, 1, number_format($tot['ordercount']));
	$worksheet->write($i, 2, number_format($tot['orderprice']));
	$worksheet->write($i, 3, number_format($tot['ordercoupon']));
	$worksheet->write($i, 4, number_format($tot['receiptbank']));
	$worksheet->write($i, 5, number_format($tot['receiptvbank']));
	$worksheet->write($i, 6, number_format($tot['receiptiche']));
	$worksheet->write($i, 7, number_format($tot['receiptcard']));
	$worksheet->write($i, 8, number_format($tot['receipthp']));
	$worksheet->write($i, 9, number_format($tot['receiptpoint']));
	$worksheet->write($i, 10, number_format($tot['ordercancel']));
	$worksheet->write($i, 11, number_format($tot['misu']));

    $workbook->close();

	if($gubun=="year"){
		$file_name = iconv('utf-8','euc-kr',$fr_year.' ~ '.$to_year.' 연간 매출현황');
	}elseif($gubun=="month"){
		$file_name = iconv('utf-8','euc-kr',$fr_month." ~ ".$to_month." 월간 매출현황");
	}elseif($gubun=="date"){
		$file_name = iconv('utf-8','euc-kr',$fr_date." ~ ".$to_date." 일간 매출현황");
	}

    header("Content-Type: application/x-msexcel; name=\"".$file_name.".xls\"");
    header("Content-Disposition: inline; filename=\"".$file_name.".xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
    unlink($fname);

    exit;
?>