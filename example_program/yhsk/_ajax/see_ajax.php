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
    $tm_basic = $AXIOS['data']['tm_basic'];

    $sql = "INSERT INTO {$g5['thema_table2']} SET
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
    $sql = "SELECT * FROM {$g5['thema_table2']} {$ch_text} ORDER BY tm_idx DESC LIMIT $now_page, $set_list_row ";
    $result = sql_query($sql);

    $json['test_sql'] = $sql;


    for($i=0; $row=sql_fetch_array($result); $i++) {
        $json['list'][] = $row;
    }    

    if($i==0){
        $now_page = ($set_list_page-1) * $set_list_row;
        $sql = "SELECT * FROM {$g5['thema_table2']} {$ch_text} LIMIT $now_page, $set_list_row";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $json['list'][] = $row;
        }   
    }

    $sql = "SELECT COUNT(*) as cnt FROM {$g5['thema_table2']} {$ch_text}";
    $cnt = sql_fetch($sql);
    $json['totalList'] = $cnt['cnt'];

}else if($AXIOS['mode']=='d'){
    $idx = $AXIOS['idx'];
    $sql = "DELETE FROM {$g5['thema_table2']} WHERE tm_idx= {$idx}";
    $json['sql']= $sql;
    $result = sql_query($sql);
}else if($AXIOS['mode']=='u'){
    $trm_idx_sido    = $AXIOS['data']['trm_idx_sido'];
    $trm_idx_gugun   = $AXIOS['data']['trm_idx_gugun'];
    $tmc_idx         = $AXIOS['data']['tmc_idx'];
    $tm_use          = $AXIOS['data']['tm_use'];
    $tm_sort         = $AXIOS['data']['tm_sort'];
    $tm_subject      = $AXIOS['data']['tm_subject'];
    $tm_basic        = $AXIOS['data']['tm_basic'];
    $tm_idx          = $AXIOS['data']['tm_idx'];

    //컨텐츠 업데이트
    $sql = "UPDATE {$g5['thema_table2']} SET
        trm_idx_sido = '{$trm_idx_sido}',
        trm_idx_gugun = '{$trm_idx_gugun}',
        tmc_idx = '{$tmc_idx}',
        tm_use = '{$tm_use}',
        tm_sort = '{$tm_sort}',
        tm_subject = '{$tm_subject}',
        tm_basic = '{$tm_basic}'
        WHERE tm_idx = {$tm_idx}
    ";
    sql_query($sql);
    $json['sql'] = $sql;
}

echo json_encode($json);
?>