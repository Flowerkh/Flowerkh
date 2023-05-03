<?PHP
function masking($str, $type) {
    if($type == 'name'){
        $str_len = mb_strlen($str, 'UTF-8');
        $masking_str = mb_substr($str, 0, 1, 'UTF-8').str_repeat('*', $str_len-1);
    } else if($type == 'celphoneNumber'){
        $str_len = mb_strlen($str, 'UTF-8');
        switch($str_len) {
            case 10:
                $masking_str = mb_substr($str,0,3)."-".mb_substr($str,3,1)."**"."-".mb_substr($str,7,2)."**";
                break;
            case 11:
                $masking_str = mb_substr($str,0,3)."-".mb_substr($str,3,2)."**"."-".mb_substr($str,7,2)."**";
                break;
            default:
                $masking_str = mb_substr($str,0,3)."-".mb_substr($str,4,2)."**"."-".mb_substr($str,9,2)."**";
        }
    } else if($type == 'birthday'){
        $masking_str = mb_substr($str,0,4)."-**-**";
    }
    return $masking_str;
}
?>
