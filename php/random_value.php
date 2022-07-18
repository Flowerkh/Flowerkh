<?php
function generator()
{
    $len = 8;
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789';
    srand((double)microtime()*1000000);

    $i = 0;
    $str = '';

    while ($i < $len) {
        $num = rand() % strlen($chars);
        $tmp = substr($chars, $num, 1);
        $str .= $tmp;
        $i++;
    }
    $str = preg_replace('/([0-9A-Z]{6})/', '\1', $str);

    return $str;
}
?>
