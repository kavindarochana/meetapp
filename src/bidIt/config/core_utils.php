<?php

//const API_LOG_PATH = '/opt/bidit/logs/api_logs/';
//const AUDIT_LOG_PATH = '/opt/bidit/logs/audit_logs/';

function getRealIpAddr()
{
    try {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $temp = explode(",", $ip);
        if (isset($temp[1])) {$ip = trim($temp[1]);
        } else {
            $ip = trim($temp[0]);
        }
    } catch (Exception $e) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function api_log()
{
    $csv_line = func_get_args();
    $date = date('Y/m/d H:i:s');
    $ip = getRealIpAddr();
    $userAgent = apache_request_headers();

    array_unshift($csv_line, $date, $ip, @$userAgent['User-Agent']);

    $data = implode($csv_line, '|');
    $data = str_replace("\n", "@@", $data);
    $log_file = Yii::$app->params['api_log'] . date("ymd") . '_api' . ".log";

    @file_put_contents($log_file, "$data\n", FILE_APPEND);

}

function audit_log()
{
    $csv_line = func_get_args();
    $date = date('Y/m/d H:i:s');
    $ip = getRealIpAddr();

    array_unshift($csv_line, $date, $ip);

    $data = implode($csv_line, '|');
    $data = str_replace("\n", "@@", $data);
    $log_file = Yii::$app->params['audit_log'] . date("ymd") . '_audit' . ".log";

    @file_put_contents($log_file, "$data\n", FILE_APPEND);

}

function query_log()
{
    $csv_line = func_get_args();
    $date = date('Y/m/d H:i:s');
    

    array_unshift($csv_line, $date);

    $data = implode($csv_line, '|');
    $data = str_replace("\n", "@@", $data);
    $log_file = Yii::$app->params['query_log'] . date("ymd") . '_query' . ".log";

    @file_put_contents($log_file, "$data\n", FILE_APPEND);

}


function wallet_log()
{
    $csv_line = func_get_args();
    $date = date('Y/m/d H:i:s');

    array_unshift($csv_line, $date);

    $data = implode($csv_line, '|');
    $data = str_replace("\n", "@@", $data);
    $log_file = Yii::$app->params['wallet_log'] . date("ymd") . '_wallet' . ".log";

    @file_put_contents($log_file, "$data\n", FILE_APPEND);

}