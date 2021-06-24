<?php
$isDev = $_GET['isDev'];
$week = date("w");
$day = date("d");
$hour = date("H");
$min = date("i");

$cronList = array(
    "everyMonth" => array(
        # 매월 실행(KEY:dHi)
        "010530" => array(
            "key"=>"key",
            "name"=>"크론 등록명",
            "isLog"=>FALSE,
            "url"=>"크론 경로"
        ),
    ),
    "everyWeek" => array(
        # 매주 실행(KEY:wHi)
        /* 별도로 실행되도록 요청
      "20130"=>array(
            "key"=>"key",
            "name"=>"크론 등록명",
            "isLog"=>FALSE,
            "url"=>"크론 경로"
      ),
        */
    ),
    "everyDay" => array(
        # 매일 실행(KEY:Hi)
        /*
        "0110"=>array(
            "key"=>"key",
            "name"=>"크론 등록명",
            "isLog"=>FALSE,
            "url"=>"크론 경로"
        ),
        */
    ),
);

$procList['everyMonth'] = isset($cronList['everyMonth'][$day . $hour . $min]) ? $cronList['everyMonth'][$day . $hour . $min] : array();
$procList['everyWeek'] = isset($cronList['everyWeek'][$week . $hour . $min]) ? $cronList['everyWeek'][$week . $hour . $min] : array();
$procList['everyDay'] = isset($cronList['everyDay'][$hour . $min]) ? $cronList['everyDay'][$hour . $min] : array();

if ($isDev) {
    $procList['everyDay'] = $cronList['everyDay'][$isDev];
}

foreach ($procList as $period => $cronList) {
    if (COUNT($cronList) > 0) {
        $options = array(
            "http" => array(
                "header" => "Content-type:application/x-www-form-urlencoded\r\n",
                "method" => "POST",
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($cronList['url'], false, $context);

        if ($cronList['isLog']) {
            $result = ($result) ? $result : 0;
            $logList[] = "INSERT INTO 'log 기록 테이블' SET ~ regdate=NOW() ";
        }

        if ($isDev) {
            echo "<xmp>";
            print_r($result);
            echo "</xmp>";
        }
    }
}

if (COUNT($logList) > 0) {
    include "/connect.php";

    foreach ($logList as $sql) mysql_query($sql, $connect);
}

exit;
?>
