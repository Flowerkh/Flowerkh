$ip_list = array(
        '47.176.39.',
    '211.214.213.',
    '14.37.149.',
    '192.168.20.225'
);

function strposa($haystack, $needles=array(), $offset=0) {
    foreach($needles as $needle) {
        if(strpos($haystack, $needle, $offset) !== false) return true;
    }
    return false;
}

if(!strpos($_SERVER['HTTP_HOST'],'www.ople.com') !== false) {
    if(!strposa($_SERVER['REMOTE_ADDR'],$ip_list)) {
        echo "<script>location.href='https://www.ople.com'</script>";
    }
}
