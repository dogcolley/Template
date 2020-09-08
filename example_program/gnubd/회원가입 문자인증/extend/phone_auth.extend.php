<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$dir = "member";
if (G5_IS_MOBILE) {
    $skin = $config['cf_mobile_member_skin'];
} else {
    $skin = $config['cf_member_skin'];
}

if (preg_match('#^theme/(.+)$#', $skin, $match)) { // 테마에 포함된 스킨이라면
    $theme_path = '';
    $cf_theme = trim($config['cf_theme']);

    $theme_path = G5_PATH . '/' . G5_THEME_DIR . '/' . $cf_theme;
    if (G5_IS_MOBILE) {
        $skin_path = $theme_path . '/' . G5_MOBILE_DIR . '/' . G5_SKIN_DIR . '/' . $dir . '/' . $match[1];
        if (!is_dir($skin_path))
            $skin_path = $theme_path . '/' . G5_SKIN_DIR . '/' . $dir . '/' . $match[1];
    } else {
        $skin_path = $theme_path . '/' . G5_SKIN_DIR . '/' . $dir . '/' . $match[1];
    }
} else {
    if (G5_IS_MOBILE)
        $skin_path = G5_MOBILE_PATH . '/' . G5_SKIN_DIR . '/' . $dir . '/' . $skin;
    else
        $skin_path = G5_SKIN_PATH . '/' . $dir . '/' . $skin;
}

$phone_auth_skin_path = $skin_path;
$phone_auth_skin_url = str_replace(G5_PATH, G5_URL, $skin_path);