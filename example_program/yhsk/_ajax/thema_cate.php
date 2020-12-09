<?php
$sub_menu = "970100";
include_once("./_common.php");

if($_GET['mode'] == 'r'){
    //auth_check($auth[$sub_menu],"r",true); 가능하면 true 안되면
    $result = sql_query("SELECT * FROM {$g5['thema_cate_table']}");
    $list = [];
    while($row = sql_fetch_array($result)){
        $list[] = $row;
    }
    $json['list'] = $list;
    $json['status'] = 'ok';
}else if($_GET['mode'] == 'w'){
    //auth_check($auth[$sub_menu],"w");
    $query = sql_query("INSERT INTO {$g5['thema_cate_table']} SET 
        tmc_name = '{$_GET['setCate']}',
        tmc_reg_date = NOW()
    ");

    if($query)
        $json['status'] = 'ok';
    else 
        $json['status'] = 'err';
}else if($_GET['mode'] == 'u'){
    //auth_check($auth[$sub_menu],"w");
    $query = sql_query("UPDATE {$g5['thema_cate_table']} SET 
        tmc_name = '{$_GET['setCate']}',
        tmc_update_date = NOW()
        WHERE tmc_idx = {$_GET['idx']}
    ");
    
    if($query)
        $json['status'] = 'ok';
    else 
        $json['status'] = 'err';


}else if($_GET['mode'] == 'd'){
    //auth_check($auth[$sub_menu],"d");
    $query = sql_query("DELETE FROM {$g5['thema_cate_table']}  
        WHERE tmc_idx = {$_GET['idx']}
    ");

    if($query)
        $json['status'] = 'ok';
    else 
        $json['status'] = 'err';
}else if($_GET['mode'] == 'l'){
    //auth_check($auth[$sub_menu],"r",true); 가능하면 true 안되면
    $result = sql_query("SELECT * FROM {$g5['thema_cate_table']}");
    $list = [];
    while($row = sql_fetch_array($result)){
        $list[] = $row;
    }
    $json['list'] = $list;
    $json['status'] = 'ok';
}else if($_GET['mode'] == 'c'){
    $result = sql_query("SELECT * FROM {$g5['thema_cate_table']}");
    while($row = sql_fetch_array($result)){
        $json['cateIdx'][] = $row['tmc_idx'];
        $json['cateName'][] = $row['tmc_name'];
    }
}

echo json_encode($json);
