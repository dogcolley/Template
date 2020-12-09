<?php
include_once('./_common.php');


$api_key = 'fepJSfwFfWkHVTPFR3mUCMa13KRS9K%2BFL9LjNyRUtz2TEjrhpxuXWk8NjW%2F4pAT7Ub24UucDZKeVbHNTgCxgvQ%3D%3D';
$api_url = 'http://api.visitkorea.or.kr/openapi/service/rest/KorService/';


$areaArr[1]  = 9;  //서울
$areaArr[2]  = 12; //인천
$areaArr[3]  = 7;  //대전 
$areaArr[4]  = 6;  //대구
$areaArr[5]  = 5;  //광주
$areaArr[6]  = 8;  //부산
$areaArr[7]  = 11; //울산
$areaArr[8]  = 10; //세종
$areaArr[31] = 2;  //경기
$areaArr[32] = 1;  //강원
$areaArr[33] = 17; //충북
$areaArr[34] = 16; //충남
$areaArr[35] = 4;  //경북
$areaArr[36] = 3;  //경남
$areaArr[37] = 14; //전북
$areaArr[38] = 13; //전남
$areaArr[39] = 15; //제주도

if($mode == 'l'){
    $list_url = 'searchFestival';
    $list_query['ServiceKey'] = $api_key;
    $list_query['MobileOS'] = 'ETC';
    $list_query['MobileApp'] = 'TourAPI3.0_Guide';
    $list_query['numOfRows'] = $set_list_row;
    $list_query['pageNo'] = (int)$set_list_page+1;
    $list_query['eventStartDate'] = $set_list_start_date;
    $list_query['eventEndDate'] = $set_list_end_date;

    $query = '?';
    foreach($list_query as $key=>$value){
        $query.= $key.'='.$value.'&';
    }
    $curl_url = $api_url.$list_url.$query;
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL,$curl_url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec ($handle);
    curl_close ($handle); 
    $res_obj = simplexml_load_string($res);
    $json['list'] = $res_obj -> body -> items;
    $json['totalPage'] = $res_obj -> body -> numOfRows;
    $json['totalCount'] = $res_obj -> body -> totalCount;
    $json['curl'] = $res_obj;

}else if($mode == 'v'){
    $detail_url = 'detailCommon';
    $detail_query['ServiceKey'] = $api_key;
    $detail_query['contentTypeId'] = $content_type;
    $detail_query['contentId'] = $id;
    $detail_query['MobileOS'] = 'ETC';
    $detail_query['MobileApp'] = 'TourAPI3.0_Guide';
    $detail_query['defaultYN'] = 'Y';
    $detail_query['firstImageYN'] = 'Y';
    $detail_query['mapinfoYN'] = 'Y';
    $detail_query['areacodeYN'] = 'Y';
    $detail_query['addrinfoYN'] = 'Y';
    $detail_query['overviewYN'] = 'Y';
    $detail_query['catcodeYN'] = 'Y';
    $detail_query['transGuideYN'] = 'Y';

    $query = '?';
    foreach($detail_query as $key=>$value){
        $query.= $key.'='.$value.'&';
    }
    $curl_url = $api_url.$detail_url.$query;
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL,$curl_url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec ($handle);
    curl_close ($handle); 
    $res_obj = simplexml_load_string($res);
    $json['content'] = $res_obj -> body -> items -> item -> overview; 
}else if($mode =='i'){ //체크한 항목만 생성
    $ids = explode(',',$ids);
    for($i=0;$i < count($ids); $i++){

        $detail_url = 'detailCommon';
        $detail_query['ServiceKey'] = $api_key;
        $detail_query['contentTypeId'] = '15';
        $detail_query['contentId'] = $ids[$i];
        $detail_query['MobileOS'] = 'ETC';
        $detail_query['MobileApp'] = 'TourAPI3.0_Guide';
        $detail_query['defaultYN'] = 'Y';
        $detail_query['firstImageYN'] = 'Y';
        $detail_query['mapinfoYN'] = 'Y';
        $detail_query['areacodeYN'] = 'Y';
        $detail_query['addrinfoYN'] = 'Y';
        $detail_query['overviewYN'] = 'Y';
        $detail_query['catcodeYN'] = 'Y';
        $detail_query['transGuideYN'] = 'Y';
        
        $query = '?';
        foreach($detail_query as $key=>$value){
            $query.= $key.'='.$value.'&';
        }

        $curl_url = $api_url.$detail_url.$query;
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL,$curl_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec ($handle);
        curl_close ($handle);

        $res_obj = simplexml_load_string($res);
        $title = $res_obj -> body -> items -> item -> title; 
        $eventenddate = $res_obj -> body -> items -> item -> eventenddate; 
        $eventstartdate = $res_obj -> body -> items -> item -> eventstartdate; 
        $tel = $res_obj -> body -> items -> item -> tel; 
        $addr1 = $res_obj -> body -> items -> item -> addr1; 
        $addr2 = $res_obj -> body -> items -> item -> addr2; 
        $addr3 = $res_obj -> body -> items -> item -> addr3; 
        $mapx = $res_obj -> body -> items -> item -> mapx; 
        $mapy = $res_obj -> body -> items -> item -> mapy; 
        $content = addslashes("<div class='U_fst_con'>".($res_obj -> body -> items -> item -> overview)."</div>");
        $img = $res_obj -> body -> items -> item -> firstimage;
        $area = $res_obj -> body -> items -> item -> areacode;
        $sido_idx = $areaArr[(int)$area];
        
        $json['api_data'][] = $res_obj;

        $sql_common = "	
             fst_name = '$title'
            ,fst_start_dt = '$eventenddate'				
            ,fst_end_dt = '$eventstartdate'	
            ,fst_tel = '$tel'	
            ,fst_level = '3'	
            ,fst_addr1 = '$addr1'
            ,fst_addr2 = '$addr2'
            ,fst_addr3 = '$addr3'
            ,mb_id     = '$member[mb_id]'
            ,fst_rank  = '1000'
            ,fst_sort  = '1000'
            ,trm_idx_sido = '$sido_idx'
            ,fst_longitude = '$mapx'
            ,fst_latitude = '$mapy'
            ,fst_pc_content1 = '$content'
            ,fst_mobile_content1 = '$content</div>'
        ";
        //  ,trm_idx_sido = '$trm_idx_sido'
        //  ,trm_idx_gugun = '$trm_idx_gugun'

        $sql = "SELECT COUNT(*) AS cnt FROM {$g5['festival_table']} WHERE fst_name = '$title' "; 
        $ck = sql_fetch($sql);
        if($ck['cnt'] > 0){


            
        }else{
            //신규등록일때
            $sql_common = " mb_id = '{$member['mb_id']}' ,fst_status = 'ok', ".$sql_common;
            $sql = " INSERT INTO {$g5['festival_table']} SET {$sql_common} ";
            $json['sql_arr'][] = $sql;
            sql_query($sql,1);
            $fst_idx = sql_insert_id();
            
            $img_link = iconv('utf-8','euc-kr',$img);
            $ext = strtolower(pathinfo($img_link, PATHINFO_EXTENSION));
            $img = date("YmdHis").'.'.$ext;
            $fileLink = G5_DATA_PATH.'/festival/'.$fst_idx.'/'.$img;
            $filePath = '/data/festival/'.$fst_idx;

            // 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
            @mkdir(G5_DATA_PATH.'/festival', G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH.'/festival', G5_DIR_PERMISSION);
            @mkdir(G5_DATA_PATH.'/festival/'.$fst_idx, G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH.'/festival/'.$fst_idx, G5_DIR_PERMISSION);

            $fp = fopen($fileLink, "w"); 
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $img_link );
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
            fwrite($fp, $contents); 
            fclose($fp);

            $sql = " INSERT INTO   {$g5['file_table']} SET
                fle_db_table = 'festival',
                mb_id = '$member[mb_id]',
                fle_db_id = $fst_idx,
                fle_path = '$filePath',
                fle_name = '$img',
                fst_idx = $fst_idx,
                fle_status = 'ok'
            ";
            sql_query($sql,1);
        }
    }


}else if($mode =='a'){ //전체 생성

    $list_url = 'searchFestival';
    $list_query['ServiceKey'] = $api_key;
    $list_query['MobileOS'] = 'ETC';
    $list_query['MobileApp'] = 'TourAPI3.0_Guide';
    $list_query['numOfRows'] = 9999;
    $list_query['pageNo'] = 1;
    $list_query['eventStartDate'] = $set_list_start_date;
    $list_query['eventEndDate'] = $set_list_end_date;
    
    $query = '?';
    foreach($list_query as $key=>$value){
        $query.= $key.'='.$value.'&';
    }
    $curl_url = $api_url.$list_url.$query;
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL,$curl_url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec ($handle);
    curl_close ($handle); 
    $res_obj = simplexml_load_string($res);
    $json['list'] = $res_obj -> body -> items -> item;
    $json['totalPage'] = $res_obj -> body -> numOfRows;
    $json['totalCount'] = $res_obj -> body -> totalCount;
    
    
    
    for($i=0; $i < count($json['list']); $i++){
    
        $data = $json['list'][$i];
        $idx = $data -> contentid;
        $detail_url = 'detailCommon';
        $detail_query['ServiceKey'] = $api_key;
        $detail_query['contentTypeId'] = '15';
        $detail_query['contentId'] = $idx;
        $detail_query['MobileOS'] = 'ETC';
        $detail_query['MobileApp'] = 'TourAPI3.0_Guide';
        $detail_query['defaultYN'] = 'Y';
        $detail_query['firstImageYN'] = 'Y';
        $detail_query['mapinfoYN'] = 'Y';
        $detail_query['areacodeYN'] = 'Y';
        $detail_query['addrinfoYN'] = 'Y';
        $detail_query['overviewYN'] = 'Y';
        $detail_query['catcodeYN'] = 'Y';
        $detail_query['transGuideYN'] = 'Y';
        
        $query = '?';
        foreach($detail_query as $key=>$value){
            $query.= $key.'='.$value.'&';
        }
    
        $curl_url = $api_url.$detail_url.$query;
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL,$curl_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec ($handle);
        curl_close ($handle);
    
        $res_obj = simplexml_load_string($res);
        $title = $res_obj -> body -> items -> item -> title; 
        $eventenddate = $res_obj -> body -> items -> item -> eventenddate; 
        $eventstartdate = $res_obj -> body -> items -> item -> eventstartdate; 
        $tel = $res_obj -> body -> items -> item -> tel; 
        $addr1 = $res_obj -> body -> items -> item -> addr1; 
        $addr2 = $res_obj -> body -> items -> item -> addr2; 
        $addr3 = $res_obj -> body -> items -> item -> addr3; 
        $mapx = $res_obj -> body -> items -> item -> mapx; 
        $mapy = $res_obj -> body -> items -> item -> mapy; 
        $content = addslashes("<div class='U_fst_con'>".($res_obj -> body -> items -> item -> overview)."</div>");
        $img = $res_obj -> body -> items -> item -> firstimage;
        $area = $res_obj -> body -> items -> item -> areacode;
        $sido_idx = $areaArr[(int)$area];
        
        $sql_common = "	
             fst_name = '$title'
            ,fst_start_dt = '$eventenddate'				
            ,fst_end_dt = '$eventstartdate'	
            ,fst_tel = '$tel'	
            ,fst_level = '3'	
            ,fst_addr1 = '$addr1'
            ,fst_addr2 = '$addr2'
            ,fst_addr3 = '$addr3'
            ,fst_rank  = '1000'
            ,fst_sort  = '1000'
            ,trm_idx_sido = '$sido_idx'
            ,fst_longitude = '$mapx'
            ,fst_latitude = '$mapy'
            ,fst_pc_content1 = '$content'
            ,fst_mobile_content1 = '$content</div>'
        ";
    

        $sql = "SELECT COUNT(*) AS cnt FROM {$g5['festival_table']} WHERE fst_name = '$title' "; 
        $ck = sql_fetch($sql);
        if($ck['cnt'] > 0){
    
    
            
        }else{
            //신규등록일때
            $sql_common = " mb_id = '{$member['mb_id']}' ,fst_status = 'ok', ".$sql_common;
            $sql = " INSERT INTO {$g5['festival_table']} SET {$sql_common} ";
            $json['test_insert'][] = $sql;
            
            sql_query($sql,1);
            $fst_idx = sql_insert_id();
            
            $img_link = iconv('utf-8','euc-kr',$img);
            $ext = strtolower(pathinfo($img_link, PATHINFO_EXTENSION));
            $img = date("YmdHis").'.'.$ext;
            $fileLink = G5_DATA_PATH.'/festival/'.$fst_idx.'/'.$img;
            $filePath = '/data/festival/'.$fst_idx;
            // 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
            @mkdir(G5_DATA_PATH.'/festival', G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH.'/festival', G5_DIR_PERMISSION);
            @mkdir(G5_DATA_PATH.'/festival/'.$fst_idx, G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH.'/festival/'.$fst_idx, G5_DIR_PERMISSION);
    
            $fp = fopen($fileLink, "w"); 
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $img_link );
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
            fwrite($fp, $contents); 
            fclose($fp);
            $sql = " INSERT INTO   {$g5['file_table']} SET
                fle_db_table = 'festival',
                mb_id = '$member[mb_id]',
                fle_db_id = $fst_idx,
                fle_path = '$filePath',
                fle_name = '$img',
                fst_idx = $fst_idx,
                fle_status = 'ok'
            ";
            $json['test_file'][] = $sql;
            sql_query($sql,1);
        }
    }
}


echo json_encode($json);

?>