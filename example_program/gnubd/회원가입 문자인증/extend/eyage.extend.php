<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function eyage_remain($smsId = null, $encCode = null)
{
    global $config;
    if ($smsId == null) $smsId = $config['cf_nct_sms_id'];
    if ($encCode == null) $encCode = $config['cf_nct_sms_key'];

    $data = json_decode(file_get_contents("http://sms.ypage.kr/api/remind_count/$smsId/$encCode"));
    if ($data->resultCode != 1) return false;
    return $data->remind_count;
}

function eyage_send($receiveContent, $smsHp, $smsId = null, $encCode = null, $callbackHp = null)
{
    global $config;

    if ($smsId == null) $smsId = $config['cf_nct_sms_id'];
    if ($encCode == null) $encCode = $config['cf_nct_sms_key'];
    if ($callbackHp == null) $callbackHp = $config['cf_nct_sms_sendnum'];
    if (eyage_remain() === false) return false;

    $data = http_build_query(array(
        "smsId" => $smsId,
        "encCode" => $encCode,
        "smsHp" => $smsHp,
        "callbackHp" => $callbackHp,
        "receiveContent" => $receiveContent
    ));

    $opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => 'Content-length: ' . strlen($data),
        'content' => $data
    ));

    $context = stream_context_create($opts);

    $response = file_get_contents('http://sms.ypage.kr/api/pension', false, $context);

    return $response;
}
