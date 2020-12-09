<?php
include_once('./_common.php');


$sidoIdx = [];
$sidoName = [];
$gugunIdx = [];
$gugunNmae = [];
$status = 'e';


if(($_GET['mode'] == 'all' || $_GET['mode'] == 'sido')){
    for($i=0;$i<count($g5['sigungu_onlytop_idx']);$i++){
        $sidoIdx[] = $g5['sigungu_onlytop_idx'][$i];
    }
    for($i=0;$i<count($sidoIdx);$i++){
        $sidoName[] = $g5['sigungu_name'][$sidoIdx[$i]];
    }
    $status = 's';
}

if(($_GET['mode'] == 'all' || $_GET['mode'] == 'gugun') && $set_sido_idx){
    $insSido = $g5['sigungu_key'] = gugun_row($set_sido_idx);
    $insSido = $insSido[$set_sido_idx];
    $gugunIdx = explode(',',$insSido['down_idxs2']);
    $gugunName = explode(',',$insSido['down_names2']);
}
$json['test'] = $insSido;
$json['status'] = $status;
$json['sidoIdx'] = $sidoIdx;
$json['sidoName'] = $sidoName;
$json['gugunIdx'] = $gugunIdx;
$json['gugunName'] = $gugunName;

echo json_encode($json);
