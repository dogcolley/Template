<?php
include_once('./_common.php');

$AXIOS = json_decode(file_get_contents("php://input"), true);

if(!$AXIOS){
    if($_GET)
        $AXIOS = $_GET;
    else if($_POST)
        $AXIOS = $_POST;
}

$json['$AXIOS'] = $AXIOS;
$json['$_GET'] = $_GET;

$mode = $AXIOS['mode'];
$row = $AXIOS['row'];
$cnt = $AXIOS['cnt'];
$table = $AXIOS['table'];

if($mode == 'c'){
    $target = $row * $cnt;
    switch($table){
        case 'g5_1_store': 
            $col = 'sto';
        break;
        case 'g5_1_sijang': 
            $col = 'sij';
        break;
        case 'g5_1_tour': 
            $col = 'tou';
        break;
        case 'g5_1_room': 
            $col = 'rom';
        break;
        case 'g5_1_alley': 
            $col = 'aly';
        break;
        case 'g5_1_festival': 
            $col = 'fst';
        break;
    }
    
    $Whe0 = "{$col}_status";
    $Col1 = "{$col}_idx";
    $Col2 = "{$col}_name";
    $chS = " WHERE {$Whe0} = 'ok' ";
    
    if($ch){
       $ch =  $chS .= " AND {$Col2} LIKE '%{$ch}%' ";
    }

    $sql = "SELECT {$Col1}, {$Col2} FROM {$table} {$ch} LIMIT {$target} , {$row}";
    $json['sql'] = $sql;
    $result = sql_query($sql);
    for($i=0; $row=sql_fetch_array($result); $i++) {
        $json['idx'][] = $row[$Col1];
        $json['name'][] = $row[$Col2];
    }    

}else if($mode == 'i'){
    $tm_idx = $AXIOS['data']['tm_idx'];
    $tml_use = $AXIOS['data']['tml_use'];
    $tml_sort = $AXIOS['data']['tml_sort'];
    $tml_table = $AXIOS['data']['tml_table'];
    $tml_table_idx = $AXIOS['data']['tml_table_idx'];
    $tml_name = $AXIOS['data']['tml_name'];

    switch($tml_table){
        case 'g5_1_store': 
            $Col0 = 'sto_idx';
            $Col1 = 'sto_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_sijang': 
            $Col0 = 'sij_idx';
            $Col1 = 'sij_sub_name';
            $Col2 = 'trm_idx_gugun';  
        break;
        case 'g5_1_tour': 
            $Col0 = 'tou_idx';
            $Col1 = 'tou_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_room': 
            $Col0 = 'rom_idx';
            $Col1 = 'rom_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_alley': 
            $Col0 = 'aly_idx';
            $Col1 = 'aly_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_festival': 
            $Col0 = 'fst_idx';
            $Col1 = 'fst_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
    }

    $og_row = sql_fetch("SELECT {$Col1}, {$Col2} FROM {$tml_table} WHERE {$Col0} = {$tml_table_idx}");
    $tml_basic = $og_row[$Col1];
    $trm_idx_gugun = $og_row[$Col2];

    $sql = "INSERT INTO {$g5['thema_list_table2']} SET
        tm_idx = '{$tm_idx}',
        tml_name = '{$tml_name}',
        tml_use = '{$tml_use}',
        tml_sort = '{$tml_sort}',
        tml_table_idx = '{$tml_table_idx}',
        tml_table = '{$tml_table}',
        trm_idx_gugun = '{$trm_idx_gugun}',
        tml_date = NOW()
    ";
    sql_query($sql);
    $json['sql_test'] = $sql;
}else if($mode == 'u'){
    $tm_idx         = $AXIOS['data']['tm_idx'];
    $tml_use        = $AXIOS['data']['tml_use'];
    $tml_sort       = $AXIOS['data']['tml_sort'];
    $tml_table      = $AXIOS['data']['tml_table'];
    $tml_table_idx  = $AXIOS['data']['tml_table_idx'];
    $tml_name       = $AXIOS['data']['tml_name'];
    $tml_idx        = $AXIOS['data']['tml_idx'];
    

    switch($tml_table){
        case 'g5_1_store': 
            $Col0 = 'sto_idx';
            $Col1 = 'sto_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_sijang': 
            $Col0 = 'sij_idx';
            $Col1 = 'sij_sub_name';
            $Col2 = 'trm_idx_gugun';  
        break;
        case 'g5_1_tour': 
            $Col0 = 'tou_idx';
            $Col1 = 'tou_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_room': 
            $Col0 = 'rom_idx';
            $Col1 = 'rom_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_alley': 
            $Col0 = 'aly_idx';
            $Col1 = 'aly_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
        case 'g5_1_festival': 
            $Col0 = 'fst_idx';
            $Col1 = 'fst_sub_name';
            $Col2 = 'trm_idx_gugun';
        break;
    }

    $og_row = sql_fetch("SELECT {$Col1}, {$Col2} FROM {$tml_table} WHERE {$Col0} = {$tml_table_idx}");
    $tml_basic = $og_row[$Col1];
    $trm_idx_gugun = $og_row[$Col2];

    //컨텐츠 업데이트
    $sql = "UPDATE {$g5['thema_list_table2']} SET
        tm_idx          = '{$tm_idx}',
        tml_name        = '{$tml_name}',
        tml_use         = '{$tml_use}',
        tml_sort        = '{$tml_sort}',
        tml_table_idx   = '{$tml_table_idx}',
        tml_table       = '{$tml_table}',
        tml_basic = '{$tml_basic}',
        trm_idx_gugun = '{$trm_idx_gugun}'
        WHERE tml_idx   =  {$tml_idx}
    ";
    sql_query($sql);

}else if($mode == 'l'){
    $idx = $AXIOS['idx'];
    $sql = "SELECT * FROM {$g5['thema_list_table2']} WHERE tm_idx= {$idx} ORDER BY tml_sort";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++) {
        $json['list'][] = $row;
    }   

}else if($mode == 'd'){
    $idx = $AXIOS['idx'];
    $sql = "DELETE FROM {$g5['thema_list_table2']} WHERE tml_idx= {$idx}";
    $result = sql_query($sql);
    $json['sql_test'] = $sql;
}

echo json_encode($json);
?>