    private function get_headers_info($url)
    {
        $rtn = array();

        $rtn_headers = get_headers($url);

        foreach($rtn_headers as $vl)
        {
            $tm_vl = explode(' ', $vl);
            if( array_search('HTTP/1.1', $tm_vl) !== false ) $rtn['status'] = trim($tm_vl[1]);
            if( array_search('Content-Type:', $tm_vl) !== false ) $rtn['type'] = trim($tm_vl[1]);
        }

        return $rtn['status'];
    }
