<?php
include_once('./_common.php');

if (isset($_POST["phone"]) && $_POST["phone"] != "") {
    switch ($_POST["type"]) {
        case "send":
            $code = sprintf("%06d", rand(0, 999999));
            $_SESSION["_AUTH_TOKEN"] = md5($code . time());
            sql_query(" insert into " . G5_TABLE_PREFIX . "phone_auth VALUES(null, '" . $_SESSION["_AUTH_TOKEN"] . "', '" . $code . "', '" . date("Y-m-d H:i:s") . "', false) ", false);
            eyage_send("요청하신 인증번호는 [$code] 입니다.", $_POST["phone"]);
            die($_SESSION["_AUTH_TOKEN"]);
            break;
        case "check":
            if($_POST["_token"] != $_SESSION["_AUTH_TOKEN"]) die("Fail");
            $find = sql_query(" SELECT * FROM " . G5_TABLE_PREFIX . "phone_auth WHERE auth_token = '" . $_REQUEST["_token"] . "' and auth_code = '" . $_POST["code"] . "' ");
            $cnt = sql_num_rows($find);
            if ($cnt < 1) die("Fail");
            $data = sql_fetch_array($find);
            if (strtotime($data["auth_datetime"]) + 300 < time()) die("Fail");
            if ($data["auth_expired"] == true) die("Fail");
            sql_query(" UPDATE " . G5_TABLE_PREFIX . "phone_auth set auth_expired = true WHERE auth_token = '" . $_REQUEST["_token"] . "' and auth_code = '" . $_POST["code"] . "' ", false);
            die("OK");
            break;
        default:
            alert_close("잘못된 요청입니다.");
    }
} else {
    include_once($phone_auth_skin_path . '/phone_auth.skin.php');
}