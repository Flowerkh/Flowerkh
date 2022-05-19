<table border=1>

<?php

$list= array(); 
$list[] = array('wr_1' =>'삼', 'wr_2' =>9, 'wr_3' => 10);
$list[] = array('wr_1' =>'사', 'wr_2' => 11, 'wr_3' => 12);
$list[] = array('wr_1' =>'일', 'wr_2' => 1, 'wr_3' => 2);
$list[] = array('wr_1' =>'이',  'wr_2' =>5, 'wr_3' => 6);
$list[] = array('wr_1' =>'일', 'wr_2' =>3, 'wr_3' => 4);
$list[] = array('wr_1' =>'삼',  'wr_2' =>7, 'wr_3' => 8);

$tr = array(); $tr_html = '';

foreach ($list as $k => $v)  
   $tr[$v['wr_1']][] = "<tr><td>{$v['wr_1']}</td><td>{$v['wr_2']}</td><td>{$v['wr_3']}</td></tr>";

foreach ($tr as $k => $v) {
    $rows = count($v);

    if ($rows > 1) {
        $v = preg_replace('#<tr><td>.+?</td>#', '<tr>', $v); 
        $v[0] = preg_replace('/<tr>/', "<tr><td rowspan=\"$rows\">$k</td>", $v[0]);
    }
    $tr_html .= implode('', $v);
} 

echo $tr_html;
?>

</table>
