<?php
include_once '../jpush/JPushClient.php';
$master_secret = '9affa52363188290fd136298';
$app_key='ac61ebcde40e2687712b059b';
$platform = '';
$apnsProduction = false;

$client = new JPushClient($app_key, $master_secret,86400);
//$client = new JpushClient($app_key,$master_secret,0,'android',false);
//$client = new JpushClient($app_key,$master_secret,0,'ios',false);


$extras = array();
$params = array("receiver_type" => 2,
    "sendno" => 1,
    "send_description" => "",
    "override_msg_id" => "");

$dsn = "mysql:host=10.103.26.159;dbname=check1n";
$mysqldb = new PDO($dsn,'enbandari','ss1013');
$logSql = "SELECT userid, updatetime from log ORDER BY updatetime DESC LIMIT 1;";
$lastLog = $mysqldb->query($logSql)->fetchAll();
//var_dump($lastLog);
if(count($lastLog) > 0){
    $lastTime = $lastLog[0]['updatetime'];
}else{
    $lastTime = date("Y-m-d H:i:s",time() - 300);
}

$db = new PDO('odbc:driver={microsoft access driver (*.mdb)};dbq=C:/Program Files/ZKTime5.0/att2000.mdb') or die("Connect Error");
$sql = "SELECT USERINFO.Badgenumber AS id,CHECKINOUT.CHECKTIME AS checktime FROM USERINFO,CHECKINOUT WHERE USERINFO.USERID=CHECKINOUT.USERID AND CHECKINOUT.CHECKTIME > #$lastTime# ORDER BY CHECKINOUT.CHECKTIME DESC;";
$data = $db->query($sql)->fetchAll();


foreach($data as $k=>$v){
    $userSql = "SELECT state from user WHERE userid = '".$v['id']."'";
    $states = $mysqldb->query($userSql)->fetchAll();
    if(count($states) > 0){
        if($states[0]['state'] == 0){
            $params["mes_title"] = $v['id'];
            $params["receiver_value"] = $v['id'];

            $msgResult3 = $client->sendNotification($v['checktime'], $params, $extras);
            if($msgResult3->getCode() == 0){
                $logIncSql = "INSERT INTO log (userid,updatetime) values('".$v['id']."','".$v['checktime']."')";
                $mysqldb->exec($logIncSql);
            }
        }
    }
}


