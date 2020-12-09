<?php

/* 
여행 생각용 추가 작업

서론 : 테이블추가,컬럼추가,설정에 따른 파일 경로 변경 

site_type 컬럼 값
0:전체
1:별별시장
2:여행생각

1. config_table 추가
2. 기존테이블에 site_type추가
3. 새로운테이블 생성
*/

define('SITE_TYPE', $bbsj ? 1 : 2);
define('G5_IMG_URL2',        G5_IMG_URL.'/bbsk');

define('G5_THEMA_DIR'  , 'front');
define('G5_MUKBANG_DIR', 'front');
define('G5_DATA_PATH2' , G5_DATA_PATH.'/quill');
define('G5_DATA_URL2'  , '/data/quill');

define('G5_THEMA_PATH'      , G5_PATH.'/'.G5_THEMA_DIR);
define('G5_THEMA_URL'       , G5_URL.'/'.G5_THEMA_DIR);
define('G5_THEMA_SKIN_PATH' , G5_IS_MOBILE ? G5_THEME_PATH.'/mobile/skin/front/basic' : G5_THEME_PATH.'/skin/front/basic');
define('G5_THEMA_AJAX_URL'  , G5_THEMA_URL.'/_ajax');
define('G5_THEMA_JS_URL'    , G5_THEMA_URL.'/_js');
define('G5_THEMA_LIB_PATH'  , G5_THEME_PATH.'/_lib');
define('G5_THEMA_DATA_PATH' , G5_DATA_PATH2.'/thema');
define('G5_THEMA_DATA_URL'  , G5_DATA_URL2.'/thema');
define('G5_THEMA_DATA_PATH2', G5_DATA_PATH2.'/option');
define('G5_THEMA_DATA_URL2' , G5_DATA_URL2.'/option');

define('G5_MUKBANG_PATH',              G5_PATH.'/'.G5_MUKBANG_DIR);
define('G5_MUKBANG_URL',               G5_URL.'/'.G5_MUKBANG_DIR);
define('G5_MUKBANG_THEME_PATH',        G5_THEME_PATH.'/'.G5_MUKBANG_DIR);
define('G5_MUKBANG_THEME_URL',         G5_THEME_URL.'/'.G5_MUKBANG_DIR);
define('G5_MUKBANG_THEME_MOBILE_PATH', G5_THEME_MOBILE_PATH.'/'.G5_MUKBANG_DIR);
define('G5_MUKBANG_THEME_MOBILE_URL',  G5_THEME_URL.'/'.G5_MOBILE_DIR.'/'.G5_MUKBANG_DIR);

$g5['mukbang_table']      = PROJ_TABLE_PREFIX.'mukbang';
$g5['thema_table']        = PROJ_TABLE_PREFIX.'thema';
$g5['thema_list_table']   = PROJ_TABLE_PREFIX.'thema_list';
$g5['thema_cate_table']   = PROJ_TABLE_PREFIX.'thema_cate';
$g5['thema_table2']       = PROJ_TABLE_PREFIX.'thema2';
$g5['thema_list_table2']  = PROJ_TABLE_PREFIX.'thema_list2';

//db 갱신 시작
if($g5['site_name'] == '여행생각'){
    $bbskUpdate = false;

    //config check
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['config_table']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        $sql = "CREATE TABLE {$g5[config_table]} AS SELECT * FROM g5_config";
        sql_query($sql,false);
        $bbskUpdate = true;
    }

    //mukbag_table check
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['mukbang_table']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        sql_query("CREATE TABLE {$g5['mukbang_table']} AS SELECT * FROM {$g5['youtube_table']} WHERE 1=2");
        $bbskUpdate = true;
    }

    //thema_table check
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['thema_table']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        sql_query("CREATE TABLE `g5_1_thema` (
            `tm_idx` BIGINT(20) NOT NULL AUTO_INCREMENT,
            `trm_idx_sido` INT(11) NOT NULL DEFAULT '0',
            `trm_idx_gugun` INT(11) NOT NULL DEFAULT '0',
            `tmc_idx` INT(11) NOT NULL DEFAULT '0',
            `tm_use` INT(11) NOT NULL DEFAULT '0',
            `tm_sort` INT(11) NOT NULL DEFAULT '0',
            `tm_subject` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tm_basic` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tm_content` TEXT(65535) NOT NULL COLLATE 'utf8_general_ci',
            `tm_reg_date` DATE NOT NULL DEFAULT '0000-00-00',
            `tm_update_date` DATE NOT NULL DEFAULT '0000-00-00',
            `tm_thumbnail` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            PRIMARY KEY (`tm_idx`) USING BTREE
        )");
        $bbskUpdate = true;
    }

    //thema_list_table
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['thema_list_table']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        sql_query("CREATE TABLE `g5_1_thema_list` (
            `tml_idx` BIGINT(20) NOT NULL AUTO_INCREMENT,
            `tm_idx` BIGINT(20) NOT NULL,
            `tml_use` INT(11) NOT NULL DEFAULT '0',
            `tml_sort` INT(11) NOT NULL DEFAULT '0',
            `tml_subject` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci',
            `tml_name` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci',
            `tml_basic` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tml_content` MEDIUMTEXT NOT NULL COLLATE 'utf8_general_ci',
            `tml_table` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tml_table_idx` BIGINT(20) NOT NULL DEFAULT '0',
            `tml_date` DATE NOT NULL DEFAULT '0000-00-00',
            `trm_idx_gugun` INT(11) NULL DEFAULT NULL,
            `site_type` TINYINT(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`tml_idx`) USING BTREE,
            INDEX `tm_idx` (`tm_idx`) USING BTREE,
            CONSTRAINT `tm_idx` FOREIGN KEY (`tm_idx`) REFERENCES `bbsj_test`.`g5_1_thema` (`tm_idx`) ON UPDATE NO ACTION ON DELETE CASCADE
        )");
        $bbskUpdate = true;
    }

    //cate thema_list_table
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['thema_cate_table']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        sql_query("CREATE TABLE `g5_1_thema_cate` (
            `tmc_idx` BIGINT(20) NOT NULL AUTO_INCREMENT,
            `tmc_name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tmc_reg_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            `tmc_update_date` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY (`tmc_idx`) USING BTREE
        )");
        $bbskUpdate = true;
    }

    //thema_table2 check
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['thema_table2']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        sql_query("CREATE TABLE `g5_1_thema2` (
            `tm_idx` BIGINT(20) NOT NULL AUTO_INCREMENT,
            `trm_idx_sido` INT(11) NOT NULL DEFAULT '0',
            `trm_idx_gugun` INT(11) NOT NULL DEFAULT '0',
            `tmc_idx` INT(11) NOT NULL DEFAULT '0',
            `tm_use` INT(11) NOT NULL DEFAULT '0',
            `tm_sort` INT(11) NOT NULL DEFAULT '0',
            `tm_subject` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tm_basic` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tm_reg_date` DATE NOT NULL DEFAULT '0000-00-00',
            `tm_update_date` DATE NOT NULL DEFAULT '0000-00-00',
            `site_type` TINYINT(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`tm_idx`) USING BTREE
        )");
        $bbskUpdate = true;
    }

    //thema_list_table2
    $CHECKTABLE = sql_query("SHOW TABLES LIKE '{$g5['thema_list_table2']}' ", false);
    if($CHECKTABLE -> num_rows == 0){
        sql_query("CREATE TABLE `g5_1_thema_list2` (
            `tml_idx` BIGINT(20) NOT NULL AUTO_INCREMENT,
            `tm_idx` BIGINT(20) NOT NULL,
            `tml_use` INT(11) NOT NULL DEFAULT '0',
            `tml_sort` INT(11) NOT NULL DEFAULT '0',
            `tml_table` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tml_name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
            `tml_table_idx` BIGINT(20) NOT NULL DEFAULT '0',
            `tml_date` DATE NOT NULL DEFAULT '0000-00-00',
            `trm_idx_gugun` INT(11) NULL DEFAULT NULL,
            `site_type` TINYINT(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`tml_idx`) USING BTREE,
            INDEX `tm_idx` (`tm_idx`) USING BTREE,
            CONSTRAINT `FK_g5_1_thema_list2_bbsj_test.g5_1_thema2` FOREIGN KEY (`tm_idx`) REFERENCES `bbsj_test`.`g5_1_thema2` (`tm_idx`) ON UPDATE NO ACTION ON DELETE CASCADE
        )");
        $bbskUpdate = true;
    }
    
    //g5_member SET ADD COLUMN site_type
    $CHECKCOLUMNS = sql_query("SHOW COLUMNS FROM {$g5['member_table']} WHERE `Field` = 'site_type'");
    if($CHECKCOLUMNS -> num_rows == 0){
        sql_query("ALTER TABLE ${g5['member_table']} ADD COLUMN `site_type` TINYINT NOT NULL DEFAULT 1");
        $bbskUpdate = true;
    }
    
    //g5_5_benner SET ADD COLUMN site_type
    $CHECKCOLUMNS = sql_query("SHOW COLUMNS FROM {$g5['banner_table']} WHERE `Field` = 'site_type'");
    if($CHECKCOLUMNS -> num_rows == 0){
        sql_query("ALTER TABLE ${g5['banner_table']} ADD COLUMN `site_type` TINYINT NOT NULL DEFAULT 1");
        $bbskUpdate = true;
    }
    
    //g5_1_* SET ADD COLUMN site_type
    /*Tables_in_bbsj_www 이부분이 테스트용이랑 실서버랑 달라서 주석 처리했어용
    $TABLES = sql_query("SHOW TABLES  LIKE '%".PROJ_TABLE_PREFIX."%' ", false);
    while($row =sql_fetch_array($TABLES)){
        $SETTABLE = $row['Tables_in_bbsj_www (%g5_1_%)'];
        $CHECKCOLUMNS = sql_query("SHOW COLUMNS FROM {$SETTABLE} WHERE `Field` = 'site_type'");
        if($CHECKCOLUMNS -> num_rows == 0){
            sql_query("ALTER TABLE {$SETTABLE} ADD COLUMN `site_type` TINYINT NOT NULL DEFAULT 0");
            $bbskUpdate = true;
        }
    }
    */

    //data dir make 
    if(!@is_dir(G5_DATA_PATH2)){
        @mkdir(G5_DATA_PATH2, G5_DIR_PERMISSION);
        @chmod(G5_DATA_PATH2, G5_DIR_PERMISSION);
        //mkdir(G5_DATA_PATH2,707,true);
    }

    if($bbskUpdate)
        alert('새로운 모델로 갱신됩니다.');
}

//setting 함수를 가져와서 value 와 key값을 저장한 arr로 변환
$insArr = explode(',',$g5['setting']['set_site_type']);
for($i=0;$i<count($insArr);$i++){
    $insArr2 = explode('=',$insArr[$i]);
    $set_site[$insArr2[0]] = $insArr2[1];
}

//setting 중 option을 뿌려주는부분
function set_site_select($setValue){
    GLOBAL $set_site;
    $option = '';
    foreach($set_site as $key => $value){
        if($setValue == $key) $selected='selected';
        else $selected = '';
        $option .='<option '.$selected.' value="'.$key.'">'.$value.'</option>';
    }
    return $option;
} 

//검색시에 url은 유지되고 사이트만 검색하게 해야되요!
function mv_site_ch($mode,$url){
    $a = ''; //tag
    return $a;
}

//area검색용
function find_area_arr($arr,$ch_txt){
    foreach ($arr as $key => $val) {
        if ($val['trm_name'] === $ch_txt) {
            return $key;
        }
    }
    return null;
}

//navi maker
function p_echo_navi($url=null,$sido=null,$gugun=null){
    global $g5;
    global $member;

    $tag = '';
    $tag .= '<div class="U_area_wrap" >';
    
    if($member['mb_level'] > 6  && !G5_IS_MOBILE)
        $tag .= '<a class="U_admin_btn" href="'.G5_BBS_URL.'/board.php?bo_table=yhsk_navi">네비이미지관리</a>';

    for($i=0;$i<count($g5['sigungu_onlytop_idx']);$i++){
        $sidoIdx[] = $g5['sigungu_onlytop_idx'][$i];
    }
    
    $tag .= '<div class="U_gugun_wrap U_area_box">';
    $tag .= '<ul class="sido_navi">';
    $tag .= '<li class="tab_list">';
    $tag .= '<div class="li_gugun_box">';
    $tag .= '<ul class="top_li_gugun">';
    $tag .= '</ul>';
    $tag .= '</div>';
    $tag .= '</li>';


    $query_string=getenv("QUERY_STRING"); 
    $query_arr = explode('&',$query_string);
    $query_new = '';
    foreach($query_arr as $value){
        if(strpos($value, 'trm_idx_gugun') !== 0 && strpos($value, 'trm_idx_sido') !== 0 && $value !== '')
            $query_new .=  $value.'&';
    }

    
    
    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) 	
        $pp = 'https://';
    else 
        $pp = 'http://';

    $searchName = 'view.php';
    if(strpos($_SERVER["PHP_SELF"], $searchName) !== false) {  
        GLOBAL $before;
        $link = G5_THEMA_URL.'/'.$before.'.php?'.$query_new;;       
    }else{
        $link = $pp.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"].'?'.$query_new;
    }
    

    for($i=0;$i<count($sidoIdx);$i++){
        $J_gugun[] = gugun_row($sidoIdx[$i]);
        $tag .= '<li class="tab_list">';
        $tag .= '<div class="li_gugun_box">';
        $tag .= '<ul class="top_li_gugun">';
            $cnt = 0;
            foreach($J_gugun[$i] as $key => $value){
                if($cnt !== 0)
                    $tag .= '<li class="gugun_ajax_li"><a href="'.$link.'trm_idx_sido='.$setSidoIdx.'&trm_idx_gugun='.$value['trm_idx'].'">'.$value['trm_name'].'</a></li>';
                else 
                    $setSidoIdx = $value['trm_idx'];
                $cnt ++;
            }
        $tag .= '</ul>';
        $tag .= '</div>';
        $tag .= '</li>';
    }
    $tag .= '</ul>';
    $tag .= '</div>';
    

    $tag .= '<div class="U_sido_wrap U_area_box">';
    $tag .= '<ul class="sido_navi">';
    for($i=0;$i<count($J_gugun);$i++){
        $J_sido[] = array_shift($J_gugun[$i]);
    }

    $tag .= '<li class="tab_list">';
    $tag .= '<div class="li_bg_box">';
    $tag .= '<img class="tab_list_bg" src="'.G5_IMG_URL2.'/sido_navi01.jpg" alt="sido_navi01">';
    $tag .= '<a href="'.$link.'">전체</a>';
    $tag .= '</div>';
    $tag .= '</li>';

    foreach($J_sido as $key => $value){
        $set_bo_table = 'yhsk_navi';
        $result = sql_fetch("SELECT * FROM {$g5['write_prefix']}{$set_bo_table} WHERE wr_1 = {$value['trm_idx']}");
        $thumb = get_list_thumbnail($set_bo_table, $result['wr_id'], 300, 300, false, true);
        if($thumb['src']) {
            $img_url = 'src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" ';
        } else {
            $img_url = 'src="'.G5_IMG_URL2.'/sido_navi01.jpg" alt="sido_navi01"';
        }

        $tag .= '<li class="tab_list">';
        $tag .= '<div class="li_bg_box">';
        $tag .= '<img class="tab_list_bg" '.$img_url.' >';
        $tag .= '<a href="'.$link.'trm_idx_sido='.$value['trm_idx'].'">'.$value['trm_name'].'</a>';
        $tag .= '</div>';
        $tag .= '</li>';

        //if($value['trm_idx'] == $sido)
            
    }

    $tag .= '</ul>';
    $tag .= '</div>';
    $tag .= '</div>';


    if($sido){
        $tag .= '<div class="U_sido_br">';
        $tag .= banner200('yhsk_sido_'.$sido.(G5_IS_MOBILE ? '_m' : '' ));
        $tag .= '</div>';
    }

    return $tag;
}


function echo_thumbnail($table,$idx,$thumb_width,$thumb_height,$arr = false){
    GLOBAL $g5;

    $case0 = true;
    $col_idx_name = 'fle_db_id';
    switch($table){
        case $g5['store_table'] :
            $fle_db_table = 'store';
            $idx_name = 'sto_idx';
        break;
        case $g5['sijang_table'] : 
            $fle_db_table = 'sijang';
            $idx_name = 'sij_idx';
        break;
        case $g5['festival_table'] : 
            $fle_db_table = 'festival';
            $idx_name = 'fst_idx';
        break;
        case $g5['room_table'] :
            $fle_db_table = 'room';
            $idx_name = 'rom_idx';
            $col_idx_name = $idx_name;
        break;
        case $g5['alley_table'] : 
            $fle_db_table = 'alley';
            $idx_name = 'aly_idx';
        break;
        case $g5['tour_table'] : 
            $fle_db_table = 'tour';
            $idx_name = 'tou_idx';      
        break;
        case $g5['food_table'] : 
            $fle_db_table = 'food';
            $idx_name = 'fle_type';
            $col_idx_name = $idx_name;      
        break;
        case $g5['thema_table'] :
            $case0 =false; 
            $sql = " SELECT * FROM {$g5['thema_table']} WHERE  tm_idx = '{$idx}' ";
            $file = sql_fetch($sql);
            $file_name = end(explode('/',$file['tm_thumbnail']));
            $FILE_PATH = G5_PATH.str_replace($file_name,'','/'.$file['tm_thumbnail']);
            $thumbf = thumbnail($file_name,$FILE_PATH,$FILE_PATH,$thumb_width,$thumb_height,false,true,'center');
            $thumbf_url = G5_URL.str_replace($file_name,'','/'.$file['tm_thumbnail']).'/'.$thumbf;
            $file['fle_thumbnail'] = $thumbf_url;
            $img_url = ($thumbf) ? $file['fle_thumbnail'] : G5_URL.'/_img/no_image.jpg';
        break;
     }
     if($case0 && !$arr){
        $sql = " SELECT * FROM {$g5['file_table']} WHERE fle_db_table = '{$fle_db_table}' AND {$col_idx_name} = '{$idx}' AND fle_status = 'ok'  ORDER BY fle_sort, fle_idx LIMIT 1 ";
        $file = sql_fetch($sql);
        $thumbf = thumbnail($file['fle_name'],G5_PATH.$file['fle_path'],G5_PATH.$file['fle_path'],$thumb_width,$thumb_height,false,true,'center');
        $thumbf_url = G5_DATA_URL.'/'.( $g5['food_table'] == $table ? 'store/'.$file['fle_db_id'].'/' : '' ).$fle_db_table.'/'.$idx.'/'.$thumbf;
        $thumbf_path = G5_DATA_PATH.'/'.$fle_db_table.'/'.$idx.'/'.$thumbf;
        $file['fle_thumbnail'] = $thumbf_url;
        $img_url = ($thumbf) ? $file['fle_thumbnail'] : G5_URL.'/_img/no_image.jpg';
     }else if($case0 && $arr){
        $sql = " SELECT * FROM {$g5['file_table']} WHERE fle_db_table = '{$fle_db_table}' AND  {$col_idx_name}  = '{$idx}' AND fle_status = 'ok'  ORDER BY fle_sort, fle_idx ";
        $result = sql_query($sql);
        while($file=sql_fetch_array($result)){
            $thumbf = thumbnail($file['fle_name'],G5_PATH.$file['fle_path'],G5_PATH.$file['fle_path'],$thumb_width,$thumb_height,false,true,'center');
            $thumbf_url = G5_DATA_URL.'/'.$fle_db_table.'/'.$idx.'/'.$thumbf;
            $thumbf_path = G5_DATA_PATH.'/'.$fle_db_table.'/'.$idx.'/'.$thumbf;
            $file['fle_thumbnail'] = $thumbf_url;
            $img_url[] = ($thumbf) ? $file['fle_thumbnail'] : G5_URL.'/_img/no_image.jpg';
        }
     }


     return $img_url;
}

$toggleCounter = 800;
function echo_list($row=1,$total=24,$type='',$sido=null,$gugun=null,$blank=true,$ajax=false,$css=0,$id="",$idx=null,$stotype = '',$ch=null){
    GLOBAL $toggleCounter;
    //$row = 몇출출력
    //$total = 한번에 가져올게 몇개인지 만약 $ajax = true면 무시하고 새값으로 바뀜
    //$type = 대상테이블
    //$sido = 시도 idx
    //$gugun = 구군 idx
    //$blank = 새창
    //$ajax = $ajax통신으로 사용할지 정함
    //$css = type은 0 , 1 두개 존재
    //$id = 테크에 넣어줄아이디
    //$idx = 볼생각에 들어가는 묶음 아이디 
    //$stotype = store의 경우 호출할때 타입 0 1 2 에 따라 다름
    //$ch = '검색단어'
    //$ajaxHTML = 'ajax로 데이터를 뽑아 날때만 쓰는거 이부분을 추가한 이유는 똑같은 제어문을 반복해서 쓰지 않기 위해서'
    //$devicCol = 
    GLOBAL $g5;

    $sql_ch = '';// 검색부분 가공부분

    if(G5_IS_MOBILE){
        $devicCol = 2;
    }else{
        $devicCol = 4;
    }
    $one_page_num = $row * $devicCol; // <= 원하는개수;


    switch($type){
       case $g5['store_table'] :
            $col_idx = 'sto_idx';
            $col_subject = 'sto_name';
            $col_basic = 'sto_sub_name';
            $col_address = 'trm_idx_gugun';
            $col_sort = 'sto_sort';
            $sql_ch = ' WHERE sto_status = "ok" ';
            if($stotype == '0'){
                $sql_ch .= " AND sto_set_type = 0";
                $before_type = 'see';
            }

            else if($stotype == '1'){
                $sql_ch .= " AND sto_set_type = 1";
                $before_type = 'see';
            }
            else if($stotype == '2'){
                $sql_ch .= " AND sto_set_type = 2";
                $before_type = 'see';
            }

            else if($stotype == '3'){
                $sql_ch .= " AND sto_food_use = 1";
                $before_type = 'eat';
            }
            else {
                $before_type = 'see';
            }

        break;
        case $g5['room_table'] : 
            $col_idx = 'rom_idx';
            $col_subject = 'rom_name';
            $col_basic = 'rom_sub_name';
            $col_address = 'trm_idx_gugun';
            $col_sort = 'rom_sort';
            $sql_ch = ' WHERE rom_status = "ok" ';
            $before_type = 'sleep';
        break;
        case $g5['festival_table'] : 
            $col_idx = 'fst_idx';
            $col_subject = 'fst_name';
            $col_basic = 'fst_sub_name';
            $col_address = 'trm_idx_gugun';
            $col_sort = 'fst_sort';
            $sql_ch = ' WHERE fst_status = "ok" ';
            $before_type = 'play';
        break;
        case $g5['mukbang_table']  : 
            $col_idx = 'ytb_idx';
            $col_subject = 'ytb_title';
            $col_basic = 'ytb_sub_title';
            $col_address = 'trm_idx_gugun';
            $col_sort = 'ytb_sort';
            $sql_ch = ' WHERE ytb_status = "ok" ';
            $col_thumb = 'ytb_thumb1_name';
            $before_type = 'eat';
        break;
        case $g5['thema_list_table2'] : 
            $col_idx = 'tml_table_idx';
            $col_subject = 'tml_name';
            $col_basic = 'tml_basic';
            $col_address = 'trm_idx_gugun';
            $col_table = 'tml_table';
            $col_sort = 'tml_sort';
            $sql_ch = '';
            $before_type = 'see';
        break;
        case $g5['thema_table'] : 
            $col_idx = 'tm_idx';
            $col_subject = 'tm_subject';
            $col_basic = 'tm_basic';
            $col_address = 'trm_idx_gugun';
            $col_sort = 'tm_sort';
            $sql_ch = '';
            $before_type = 'leave';
        break;
        case $g5['thema_table2'] : 
            $col_idx = 'tml_table_idx';
            $col_subject = 'tml_name';
            //$col_basic = 'tml_basic';
            $col_address = 'trm_idx_gugun';
            $col_table = 'tml_table';
            $col_sort = 'tml_sort';
            $sql_ch = '';
            $before_type = 'see';
        break;
    }
    
    if($sido || $gugun ){

        if($sql_ch == '')
            $sql_ch .=  " WHERE ";
        else 
            $sql_ch .=  " AND ";

        if($sido)
            $sql_ch .= "trm_idx_sido = '{$sido}'";

        if($sido && $gugun)
            $sql_ch .= " AND ";

        if($gugun)
            $sql_ch .= " trm_idx_gugun = '{$gugun}' ";
    }

    if($g5['thema_table2']  == $type){
        $sql_table = $g5['thema_list_table2'];
        if($idx){
            if($sql_ch)
                $sql_ch = " AND tm_idx = {$idx}";
            else 
                $sql_ch = " WHERE tm_idx = {$idx}";
            $theam_row = sql_fetch("SELECT * FROM {$g5['thema_table2']} WHERE tm_idx = {$idx}");
        }
    }else{
        $sql_table = $type;
    }

    if($ajax){
        $num = $row * $devicCol * 3; // 3페이지를 로드하고 1->2페이지로 갈때 다음페이지를 로드해온다. 
        $sql_limit = "LIMIT 0, {$num}";
    }else{
        $sql_limit = "LIMIT 0, {$total}";
    }

    $sql_order = " ORDER BY {$col_sort} DESC";

    if($ch){
        if($sql_ch)
            $sql_ch .= " AND {$col_subject} LIKE '%{$ch}%'";
        else 
            $sql_ch .= " WHERE {$col_subject} LIKE '%{$ch}%'";
    }


    if($sql_ch){
        $sql_ch .= " AND (site_type = '0' OR site_type = '2')";
    }else{
        $sql_ch .= " WHERE (site_type = '0' OR site_type = '2')";
    }
    
    $sql = "SELECT 
        ".($col_idx ? $col_idx.',' : ' ')."
        ".($col_subject ? $col_subject.',' : ' ')."
        ".($col_basic ? $col_basic.',' : ' ')."
        ".($col_thumb ? $col_thumb.',' : ' ')."
        ".($col_address ? $col_address : ' ')."
        ".($col_table ? ','.$col_table : ' ')."
    FROM {$sql_table} {$sql_ch} {$sql_order} {$sql_limit} "; //$sql 가공부분
    $arr = [];
 
    //for($i=0;$i<10;$i++){
        $result = sql_query($sql);
        while($data=sql_fetch_array($result)){
            $arr[] = $data; 
        }
    //}
    //echo "<div>sql : {$sql}</div>";
    
    $tag = '';

    if(count($arr) < 1 && $g5['thema_table2']  == $type && $idx)
        return '<div id="'.$id.'"></div><script>$(function(){  $("#'.$id.'").parent().next().remove();$("#'.$id.'").parent().remove(); })</script>';
    if(count($arr) < 1)
        return '<div class="U_list_empty">목록이 없습니다.</div>';

    $total_item = count($arr);


    if($theam_row && !$ajax){
        //table은 thema2
        $tag .= '<header class="type2">';
        $tag .= '<h2 class="tit">'.$theam_row['tm_subject'].'<div class="blue_point">'.$theam_row['tm_basic'].'</div></h2>';
        $tag .= '<div class="the_btn"><a href="'.G5_THEMA_URL.'/see.php?idx='.$idx.'">더보기 <div class="blue_point">&gt;</div></a></div>';
        $tag .= '</header>';
    }
    
    $tag .= '<div id="'.$id.'" class="bx-wrapper U_list ">';
    if($css==0){ // type==0 기본 형
        if(!G5_IS_MOBILE)$tag .='<div class="bx-viewport">';
        $tag .='<ul class="U_slider_ul01 J_slider_ul">';
        for($i=0;$i<count($arr);$i++){
        //이미지 구하기 &&  url 구하기
        if($type ==  $g5['thema_table']){
            $url = G5_THEMA_URL.'/leave_view.php?before='.$before_type.'&idx='.$arr[$i][$col_idx];
            $img = echo_thumbnail($g5['thema_table'],$arr[$i][$col_idx],270,190);
        }else if($type == $g5['thema_table2'] || $type ==  $g5['thema_list_table2'] ){
            $url = G5_THEMA_URL.'/view.php?before='.$before_type.'&table='.$arr[$i]['tml_table'].'&idx='.$arr[$i][$col_idx];
            $img = echo_thumbnail($arr[$i]['tml_table'],$arr[$i][$col_idx],270,190);
        }else if($type == $g5['mukbang_table'] ){
            $url = G5_THEMA_URL.'/view.php?before='.$before_type.'&table='.$type.'&idx='.$arr[$i][$col_idx];
            $img =  G5_DATA_URL.'/mukbang/'.$arr[$i][$col_idx].'/'.$arr[$i][$col_thumb];
        }else{
            $url = G5_THEMA_URL.'/view.php?before='.$before_type.'&table='.$type.'&idx='.$arr[$i][$col_idx];
            $img = echo_thumbnail($type,$arr[$i][$col_idx],270,190);
        }

        if(G5_IS_MOBILE)
            $m_style= 'style="margin-right:10px"';

        if($i == 0 ||  ($i % $one_page_num == 0) || G5_IS_MOBILE)
            $js_tag .='<li class="U_slider_li01 slide bx-clone" '.$m_style.' >';
        
        if(!G5_IS_MOBILE)$js_tag .='<div class="list_div">';
        $js_tag .='<a href="'.$url.'" '.($blank ? 'target="_blank"': '').' >';
        $js_tag .='<div class="list_bg"><img src="'.$img.'" alt="test_list01"></div>';
        $js_tag .= $g5['mukbang_table'] == $type ? '<div class="you_btn"></div>' : '' ;
        $js_tag .='<div class="list_textcon">';
        $js_tag .='<div class="list_font list_tit">'.$arr[$i][$col_subject].'</div>';
        $js_tag .='<div class="list_font list_subtit">'.$arr[$i][$col_basic].'</div>';
        $js_tag .='<div class="list_font list_local">'.$g5['sigungu_up_names'][$arr[$i][$col_address]].'</div>';
        $js_tag .='</div>';
        $js_tag .='</a>';
        if(!G5_IS_MOBILE)$js_tag .='</div>';
        if(($i+1) % $one_page_num == 0 || G5_IS_MOBILE)
            $js_tag .='</li>';
        }
        $tag .=$js_tag;
        $tag .='</ul>';
        if(!G5_IS_MOBILE)$tag .='</div>';
    }else if($css==1){ // type==1 테마형(떠날생각) 리스트
        if(!G5_IS_MOBILE)$tag .='<div class="bx-wrapper">';
        if(!G5_IS_MOBILE)$tag .='<div class="bx-viewport">';

        $tag .='<ul class="leave_theme_con U_slider_ul02 J_slider_ul">';
        for($i=0;$i<count($arr);$i++){

        //이미지 구하기 &&  url 구하기
        if($type ==  $g5['thema_table']){
            $url = G5_THEMA_URL.'/leave_view.php?before='.$before_type.'&idx='.$arr[$i][$col_idx];
            $img = echo_thumbnail($g5['thema_table'],$arr[$i][$col_idx],270,330);
        }else if($type == $g5['thema_table2'] || $type ==  $g5['thema_list_table2'] ){
            $url = G5_THEMA_URL.'/view.php?before='.$before_type.'&table='.$arr[$i]['tml_table'].'&idx='.$arr[$i][$col_idx];
            $img = echo_thumbnail($arr[$i]['tml_table'],$arr[$i][$col_idx],270,330);
        }else{
            $url = G5_THEMA_URL.'/view.php?before='.$before_type.'&table='.$type.'&idx='.$arr[$i][$col_idx];
            $img = echo_thumbnail($type,$arr[$i][$col_idx],270,330);
        }
            

        if($i == 0 ||  ($i % $one_page_num == 0) || G5_IS_MOBILE)
            $js_tag .='<li class="leave_theme_li slide bx-clone">';

        if(!G5_IS_MOBILE)
            $js_tag .='<div class="leave_theme_div">';

        $js_tag .='<a href="'.$url.'" '.($blank ? 'target="_blank"': '').' >';
        $js_tag .='<img class="leave_theme_bg" src="'.$img.'" alt="main_theme01">';
        $js_tag .='<div class="leave_theme_textcon">';
        $js_tag .='<div class="leave_theme_tit">'.$arr[$i][$col_subject].'</div>';
        $js_tag .='<div class="leave_theme_subtit">'.$arr[$i][$col_basic].'</div>';
        $js_tag .='</div>';
        $js_tag .='</a>';
        
        if(!G5_IS_MOBILE)
            $js_tag .='</div>';

        if(($i+1) % $one_page_num == 0 || G5_IS_MOBILE)
            $js_tag .='</li>';
        }

        $tag .=$js_tag;
        $tag .='</ul>';
        if(!G5_IS_MOBILE)$tag .='</div>';
        if(!G5_IS_MOBILE)$tag .='</div>';
    }

    $tag .= '</div>';
    $tag .= PHP_EOL;
    $tag .= '<script>'.PHP_EOL;

    if(G5_IS_MOBILE){
        //$tag .= 'console.log(totalSliderArr);';
        //$tag .= 'console.log(window);';
        $tag .= 'if(typeof totalSliderArr !== "object"){';
        $tag .= 'var totalSliderArr = new Object();}';
        $tag .= 'totalSliderArr.'.$id.' =  false;';
        //$tag .= 'console.log(totalSliderArr);';
     }

    $tag .= '$(document).ready(function(){'.PHP_EOL;
    
    if(G5_IS_MOBILE){
    $tag .= 'function J_slider_'.$id.'_fn (){'.PHP_EOL;
    }   

    $tag .= 'var J_slider_'.$id.'_num = '.$total_item.PHP_EOL;
    $tag .= 'var J_slider_'.$id.'_fixed = false'.PHP_EOL;
    $tag .= 'var J_slider_'.$id.'_tag = '."'".$js_tag."'".PHP_EOL;
    $tag .= 'var J_slider_'.$id.'_wrap = $( "#'.$id.'");'.PHP_EOL;;
    
    if(G5_IS_MOBILE){
        $tag .= 'var bx_width = J_slider_'.$id.'_wrap.width();'.PHP_EOL;
        $tag .= 'var bxli_wid = parseInt(bx_width)/2.6;'.PHP_EOL;

        if($css==1){
        $tag .= 'var bxli_height01 = 330*bxli_wid;'.PHP_EOL;
        $tag .= 'var bxli_height =  parseInt(bxli_height01)/270;'.PHP_EOL;
        $tag .= 'J_slider_'.$id.'_wrap.find(".leave_theme_li").css("width",bxli_wid).css("height",bxli_height);'.PHP_EOL;
        }else{
        $tag .= 'var bxli2_height01 = 190*bxli_wid;'.PHP_EOL;
        $tag .= 'var bxli2_height =  parseInt(bxli2_height01)/270;'.PHP_EOL;
        $tag .= 'J_slider_'.$id.'_wrap.find(".U_slider_li01").css("width",bxli_wid);'.PHP_EOL;
        $tag .= 'J_slider_'.$id.'_wrap.find(".list_bg").css("height",bxli2_height);'.PHP_EOL;
        }
    }
    
    $tag .= 'var J_slider_'.$id.' = $( "#'.$id.' .J_slider_ul").bxSlider({'.PHP_EOL;
    if(G5_IS_MOBILE){
        $tag .= 'mode:"horizontal",'.PHP_EOL;
        $tag .= 'slideMargin:"10",'.PHP_EOL;
        $tag .= 'maxSlides:10,'.PHP_EOL;
        $tag .= 'minSlides:2,'.PHP_EOL;
        $tag .= 'slideWidth:bxli_wid,'.PHP_EOL;
    }else{
        $tag .= 'maxSlides:1,'.PHP_EOL;
        $tag .= 'minSlides:1,'.PHP_EOL;
        $tag .= 'slideMargin:40,'.PHP_EOL;
        $tag .= 'slideWidth:1200,'.PHP_EOL;
    }

    $tag .= 'infiniteLoop:false,'.PHP_EOL;
    $tag .= 'hideControlOnEnd:'.($ajax ? 'true' : 'true').','.PHP_EOL;
    $tag .= 'controls:'.($ajax ? 'true' : 'true').','.PHP_EOL;
    if(G5_IS_MOBILE)
    $tag .= 'touchEnabled : true,'.PHP_EOL;
    else
    $tag .= 'touchEnabled : false,'.PHP_EOL;
    if(G5_IS_MOBILE){
    $tag .= 'onSliderLoad : function(){ var toss = true; totalSliderArr.'.$id.'=true;';
    $tag .= 'console.log(totalSliderArr);';
    $tag .= 'for( key in totalSliderArr ) { ';
    $tag .= 'if(!totalSliderArr[key])toss = false;'.PHP_EOL;
    $tag .= '}'.PHP_EOL;
    $tag .= 'if(toss)'.PHP_EOL;
    $tag .= ' setTimeout(function(){$(".index_con").css({height:"auto",overflow:"revert"});$(".J_loding").removeClass("J_loding")},1000);'.PHP_EOL;
    $tag .= '},'.PHP_EOL;
    }
    $tag .= 'onSlideAfter:function(currentIndex){'.PHP_EOL;
    $tag .= 'var set_next = J_slider_'.$id.'_wrap.find(".bx-next")'.PHP_EOL;
    $tag .= 'set_next.removeClass("U_hide");'.PHP_EOL;
    $tag .= '},';
    $tag .= 'pager:false,'.PHP_EOL;
    $tag .= 'onSlideNext:function($sliderEl, oldIndex, newIndex){'.PHP_EOL;
    $tag .= 'var thisSlider = this'.PHP_EOL;
    $tag .= 'var set_next = J_slider_'.$id.'_wrap.find(".bx-next")'.PHP_EOL;
    $tag .= 'set_next.addClass("U_hide");'.PHP_EOL;
    
    if($ajax){
        //$tag .= 'alert(oldIndex +" // "+ newIndex +" // "+ (oldIndex == (J_slider_'.$id.'.getSlideCount() / 2)-2) );';    
    if(!G5_IS_MOBILE)
        $tag .= 'if(oldIndex+2 == J_slider_'.$id.'.getSlideCount() && !J_slider_'.$id.'_fixed){'.PHP_EOL;
    else 
        $tag .= 'if(oldIndex == (J_slider_'.$id.'.getSlideCount() / 2) -2 && !J_slider_'.$id.'_fixed){'.PHP_EOL;
        
        $tag .= '   J_slider_'.$id.'_wrap.addClass("U_loding")'.PHP_EOL;
        $tag .= '   J_slider_'.$id.'_fixed = true;'.PHP_EOL; 
        $tag .= '   $.ajax({';
        $tag .= '   url     : "'.G5_THEMA_AJAX_URL.'/get_list_ajax.php",'.PHP_EOL; 
        $tag .= '   data    : {'.PHP_EOL;
        $tag .= "       row     : '{$row}',".PHP_EOL;
        $tag .= "       col     : '{$devicCol}',".PHP_EOL;
        $tag .= "       table   : '{$type}',".PHP_EOL;
        $tag .= "       idx     : '{$idx}',".PHP_EOL;
        $tag .= "       total   : J_slider_".$id."_num,".PHP_EOL;
        $tag .= "       gugun   : '{$gugun}',".PHP_EOL;
        $tag .= "       sido    : '{$sido}',".PHP_EOL;
        $tag .= "       ch      : '{$ch}',".PHP_EOL;
        $tag .= "       css     : '{$css}',".PHP_EOL;
        $tag .= "       stotype : '{$stotype}',".PHP_EOL;
        $tag .='    },'.PHP_EOL;
        $tag .= '   type: "GET",'.PHP_EOL;
        $tag .= '   dataType: "html",'.PHP_EOL;
        $tag .= '   }).done(function(data){'.PHP_EOL;
        $tag .= '       if(data.trim().length > 0){'.PHP_EOL; 
        $tag .= '          thisSlider.destroySlider()'.PHP_EOL;
        $tag .= '          J_slider_'.$id.'_tag += data;'.PHP_EOL;
        $tag .= '          J_slider_'.$id.'_num += '.($devicCol * $row * 3).';'.PHP_EOL;
        $tag .= '          $(thisSlider).append(J_slider_'.$id.'_tag)'.PHP_EOL;
        if(G5_IS_MOBILE){
            if($css==1){
                $tag .= 'J_slider_'.$id.'_wrap.find(".leave_theme_li").css("width",bxli_wid).css("height",bxli_height);'.PHP_EOL;
            }else{
                $tag .= 'J_slider_'.$id.'_wrap.find(".U_slider_li01").css("width",bxli_wid);'.PHP_EOL;
                $tag .= 'J_slider_'.$id.'_wrap.find(".list_bg").css("height",bxli2_height);'.PHP_EOL;
            }
        }
        $tag .= '          thisSlider.reloadSlider()'.PHP_EOL;
        $tag .= '          thisSlider.goToSlide(newIndex)'.PHP_EOL;
        $tag .= '          J_slider_'.$id.'_fixed = false;'.PHP_EOL; 
        $tag .= '      }else{'.PHP_EOL; 
        $tag .= '          //$(thisSlider).append(J_slider_'.$id.'_tag)'.PHP_EOL;
        $tag .= '          //thisSlider.reloadSlider()'.PHP_EOL;
        $tag .= '          //thisSlider.goToSlide(newIndex)'.PHP_EOL;
        $tag .= '      }'.PHP_EOL; 
        $tag .= '      setTimeout(function(){J_slider_'.$id.'_wrap.removeClass("U_loding")},1000)'.PHP_EOL; 
        $tag .= '   });'.PHP_EOL;
        $tag .= '}else{ }'.PHP_EOL;
    }
    $tag .= '},'.PHP_EOL;
    $tag .= '});'.PHP_EOL;

    if(G5_IS_MOBILE){
        $tag .= '}'.PHP_EOL;
        $tag .= 'setTimeout(function(){J_slider_'.$id.'_fn();$(window).resize(J_slider_'.$id.'_fn)},'.$toggleCounter.')'.PHP_EOL;
        $toggleCounter = (int)$toggleCounter+100;
    }

    $tag .= '});'.PHP_EOL;
    $tag .= '</script>';
    return $tag;
} 


function echo_food_list($idx){
    GLOBAL $g5;
    $set_table = $g5['food_table'];
    $col_idx = 'fod_idx';
    $sql = "SELECT * FROM {$set_table} WHERE sto_idx = {$idx}";
    $result = sql_query($sql);
    $arr = array();
    while($row=sql_fetch_array($result)){
        $row['img_url'] = echo_thumbnail($set_table,$row[$col_idx],240,240);
        $arr[] = $row; 
    }
    return $arr;
}

?>

