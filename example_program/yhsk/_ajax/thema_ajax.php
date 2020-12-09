<?php
include_once('./_common.php');


$AXIOS = json_decode(file_get_contents("php://input"), true);

if(!$AXIOS){
    if($_GET)
        $AXIOS = $_GET;
    else if($_POST)
        $AXIOS = $_POST;
}

if($AXIOS['mode']=='i'){
    $trm_idx_sido = $AXIOS['data']['trm_idx_sido'];
    $trm_idx_gugun = $AXIOS['data']['trm_idx_gugun'];
    $tmc_idx = $AXIOS['data']['tmc_idx'];
    $tm_use = $AXIOS['data']['tm_use'];
    $tm_sort = $AXIOS['data']['tm_sort'];
    $tm_subject = $AXIOS['data']['tm_subject'];
    $tm_content = $AXIOS['data']['tm_content'];
    $tm_basic = $AXIOS['data']['tm_basic'];

    //base64추출 방식  //$src="(data:image\/[^;]+;base64[^"]+);
    $re = '/src="(data:image\/[^;]+;base64[^"]+)"/';
    preg_match_all($re, $tm_content, $base64_arr, PREG_SET_ORDER, 0);

    $sql = "INSERT INTO {$g5['thema_table']} SET
        trm_idx_sido = '{$trm_idx_sido}',
        trm_idx_gugun = '{$trm_idx_gugun}',
        tmc_idx = '{$tmc_idx}',
        tm_use = '{$tm_use}',
        tm_sort = '{$tm_sort}',
        tm_subject = '{$tm_subject}',
        tm_basic = '{$tm_basic}',
        tm_reg_date = NOW()
    ";
    sql_query($sql);
    $tm_idx = sql_insert_id();

    if($base64_arr){
        //data dir make 
        if(!@is_dir(G5_THEMA_DATA_PATH)){
            @mkdir(G5_THEMA_DATA_PATH, G5_DIR_PERMISSION);
            @chmod(G5_THEMA_DATA_PATH, G5_DIR_PERMISSION);
        }

        if(!@is_dir(G5_THEMA_DATA_PATH.'/'.$tm_idx)){
            @mkdir(G5_THEMA_DATA_PATH.'/'.$tm_idx, G5_DIR_PERMISSION);
            @chmod(G5_THEMA_DATA_PATH.'/'.$tm_idx, G5_DIR_PERMISSION);
        }


        for($i=0;$i < count($base64_arr);$i++){
            $get_img_arr = explode(';',$base64_arr[$i][1]);
            $get_img_arr2 = explode(',',$get_img_arr[1]);

            $data = base64_decode($get_img_arr2[1]);
            $extension = explode('/',$get_img_arr[0]);
            $file_name = uniqid();//.'.'.$extension[1];

            $file_path = G5_THEMA_DATA_PATH.'/'.$tm_idx.'/'.$file_name;
            $file_url = G5_THEMA_DATA_URL.'/'.$tm_idx.'/'.$file_name;
            $success = file_put_contents($file_path, $data);
            $tm_content = str_replace($base64_arr[$i][1],$file_url, $tm_content);
        }
    }
    
    //컨텐츠 업데이트
    $sql = "UPDATE {$g5['thema_table']} SET
        tm_content = '{$tm_content}'
        WHERE tm_idx = {$tm_idx}
    ";
    sql_query($sql);
    $json['idx'] = $tm_idx; 
}else if($AXIOS['mode']=='f'){
    $tm_idx = $AXIOS['idx'];
    $imagetemp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_path = G5_THEMA_DATA_PATH.'/'.$tm_idx.'/'.$file_name;
    $file_url = G5_THEMA_DATA_URL.'/'.$tm_idx.'/'.$file_name;
    //data dir make 
    if(!@is_dir(G5_THEMA_DATA_PATH)){
        @mkdir(G5_THEMA_DATA_PATH, G5_DIR_PERMISSION);
        @chmod(G5_THEMA_DATA_PATH, G5_DIR_PERMISSION);
    }
    if(!@is_dir(G5_THEMA_DATA_PATH.'/'.$tm_idx)){
        @mkdir(G5_THEMA_DATA_PATH.'/'.$tm_idx, G5_DIR_PERMISSION);
        @chmod(G5_THEMA_DATA_PATH.'/'.$tm_idx, G5_DIR_PERMISSION);
    }
    if(is_uploaded_file($imagetemp)) {
        move_uploaded_file($imagetemp, $file_path.$imagename);
    }
    $sql = "UPDATE {$g5['thema_table']} SET
        tm_thumbnail = '{$file_url}'
        WHERE tm_idx = {$tm_idx}
    ";
    sql_query($sql);
}else if($AXIOS['mode']=='l' || $AXIOS['mode']=='c'){

    $ch_txt = $AXIOS['search_txt'];
    $ch_arr = [];

    if($AXIOS['search_col'])
        $ch_arr = explode(',',$AXIOS['search_col']);

    if($ch_txt || $AXIOS['search_col'])
        $ch_text = " WHERE ";

    for($j=0;$j < count($ch_arr);$j++){
        if($ch_arr[$j]=='tm_use_y'){
            $ch_text .= " tm_use = '1' OR ";
        }else if($ch_arr[$j]=='tm_use_n'){
            $ch_text .= " tm_use = '0' OR ";
        }else if($ch_arr[$j]=='trm_idx_sido'){
            $ch_text .= $ch_arr[$j]." = '".$AXIOS['sido_idx']."' OR ";
        }else if($ch_arr[$j]=='trm_idx_gugun'){
            $ch_text .= $ch_arr[$j]." = '".$AXIOS['gugun_idx']."' OR ";
        }else if($ch_arr[$j]=='tmc_idx'){
            $ch_text .= $ch_arr[$j]." = '".$AXIOS['cate_idx']."' OR ";
        }else if($ch_txt){
            $ch_text .= $ch_arr[$j].' LIKE  "%'.$ch_txt.'%" OR ';
        }
    } 

    if($ch_arr){
        $ch_text = substr($ch_text , 0, -3);
    }else if($ch_txt){
        $ch_text .= "tm_subject LIKE '%{$ch_txt}%' ";
    }

    $now_page = $set_list_page * $set_list_row;
    $sql = "SELECT * FROM {$g5['thema_table']} {$ch_text} ORDER BY tm_idx DESC LIMIT $now_page, $set_list_row ";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++) {
        $json['list'][] = $row;
    }    

    if($i==0){
        $now_page = ($set_list_page-1) * $set_list_row;
        $sql = "SELECT * FROM {$g5['thema_table']} {$ch_text} LIMIT $now_page, $set_list_row";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $json['list'][] = $row;
        }   
    }

    $sql = "SELECT COUNT(*) as cnt FROM {$g5['thema_table']}  {$ch_text} ";
    $cnt = sql_fetch($sql);
    $json['totalList'] = $cnt['cnt'];
}else if($AXIOS['mode']=='d'){
    $idx = $AXIOS['idx'];
    $sql = "DELETE FROM {$g5['thema_table']} WHERE tm_idx= {$idx}";
    $json['sql']= $sql;
    $result = sql_query($sql);
}else if($AXIOS['mode']=='u'){
    $trm_idx_sido    = $AXIOS['data']['trm_idx_sido'];
    $trm_idx_gugun   = $AXIOS['data']['trm_idx_gugun'];
    $tmc_idx         = $AXIOS['data']['tmc_idx'];
    $tm_use          = $AXIOS['data']['tm_use'];
    $tm_sort         = $AXIOS['data']['tm_sort'];
    $tm_subject      = $AXIOS['data']['tm_subject'];
    $tm_content      = $AXIOS['data']['tm_content'];
    $tm_basic        = $AXIOS['data']['tm_basic'];
    $tm_idx          = $AXIOS['data']['tm_idx'];
    //base64추출 방식  //$src="(data:image\/[^;]+;base64[^"]+);
    $re = '/src="(data:image\/[^;]+;base64[^"]+)"/';
    preg_match_all($re, $tm_content, $base64_arr, PREG_SET_ORDER, 0);

    if($base64_arr){
        //data dir make 
        if(!@is_dir(G5_THEMA_DATA_PATH)){
            @mkdir(G5_THEMA_DATA_PATH, G5_DIR_PERMISSION);
            @chmod(G5_THEMA_DATA_PATH, G5_DIR_PERMISSION);
        }

        if(!@is_dir(G5_THEMA_DATA_PATH.'/'.$tm_idx)){
            @mkdir(G5_THEMA_DATA_PATH.'/'.$tm_idx, G5_DIR_PERMISSION);
            @chmod(G5_THEMA_DATA_PATH.'/'.$tm_idx, G5_DIR_PERMISSION);
        }


        for($i=0;$i < count($base64_arr);$i++){
            $get_img_arr = explode(';',$base64_arr[$i][1]);
            $get_img_arr2 = explode(',',$get_img_arr[1]);

            $data = base64_decode($get_img_arr2[1]);
            $extension = explode('/',$get_img_arr[0]);
            $file_name = uniqid();//.'.'.$extension[1];

            $file_path = G5_THEMA_DATA_PATH.'/'.$tm_idx.'/'.$file_name;
            $file_url = G5_THEMA_DATA_URL.'/'.$tm_idx.'/'.$file_name;
            $success = file_put_contents($file_path, $data);
            $tm_content = str_replace($base64_arr[$i][1],$file_url, $tm_content);
        }
    }
    
    //컨텐츠 업데이트
    $sql = "UPDATE {$g5['thema_table']} SET
        trm_idx_sido = '{$trm_idx_sido}',
        trm_idx_gugun = '{$trm_idx_gugun}',
        tmc_idx = '{$tmc_idx}',
        tm_use = '{$tm_use}',
        tm_sort = '{$tm_sort}',
        tm_subject = '{$tm_subject}',
        tm_basic = '{$tm_basic}',
        tm_reg_date = NOW(),
        tm_content = '{$tm_content}'
        WHERE tm_idx = {$tm_idx}
    ";
    sql_query($sql);
}

echo json_encode($json);
?>