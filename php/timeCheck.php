<?php
function get_time() { $t=explode(' ',microtime()); return (float)$t[0]+(float)$t[1]; }
$start = get_time(); // 속도 측정 시작

....

$end = get_time(); // 속도 측정 끝
$time = $end - $start;
echo '수행시간: ' . number_format($time,6) . " 초\n";
?>
