function euckr_encode($param){
    foreach($param AS $key => $data){
        $result_euckr[] = urlencode($data);
    }
    return $result_euckr;
}

$param = ("한글", "test");
$jec_test = json_encode(euckr_encode($param));

$result = urldecode($jec_test);
