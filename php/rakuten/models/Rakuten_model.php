<?php

class rakuten_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->data_col_db = $this->load->database('data_col_db', true);
        $this->ople = $this->load->database('ople', true);
    }

    public function get_prd_list($job_shop_id,$flag)
    {
		//$date = "CONVERT(date,SYSUTCDATETIME())";
		$date = '\'2022-03-24\''; //임시

		$sql = "SELECT * FROM rakuten_xls WHERE flag != 0 AND LEFT(create_date,10) = ".$date." AND shop_id = '".$job_shop_id."'"; //당일 업로드 기준
		if($flag==0) $sql = "SELECT top 10 * FROM rakuten_xls WHERE flag = 0 AND LEFT(create_date,10) = ".$date." AND shop_id = '".$job_shop_id."'";;

        $rtn = rtn_query($sql, $this->data_col_db);

        return $rtn;
    }

	//상품 정보 추출
    public function get_prd_info($it_id='', $upc='')
    {
        $sql = "";
        $rtn = array();

        if ($it_id != '') $sql = "SELECT it_name_eng, desc_eng FROM channel_item.ople_item_data WHERE it_id = '".$it_id."' limit 1";
        else if ($upc != '') $sql = "SELECT it_name_eng, desc_eng FROM channel_item.ople_item_data WHERE sku = '".$upc."' limit 1";
        if ($sql != '') {
            $rs = rtn_query($sql, $this->ople);

            if( isset($rs[0]) ) $rtn = $rs[0];
            else echo "[get_prd_info] it_id : $it_id, upc : $upc".PHP_EOL;
        }

        return $rtn;
    }

	public function prd_img_update($vcode, $upc, $job_shop_id, $flag) {

		$shop_id2 = $job_shop_id;
		if($job_shop_id=='vitacafe') $shop_id2 ='sup-la';
		$img_url = 'https://image.rakuten.co.jp/'.$shop_id2.'/cabinet/upload_img4/'.strtolower(str_replace('https://img.ople.com/market_item/','',str_replace('/web/market_item/','',$upc)));

		$sql = "UPDATE rakuten_xls SET img_url = '".$img_url."', flag='1' WHERE shop_id = '".$job_shop_id."' AND vcode = '".$vcode."'";
		//echo $sql."<br/>";
        rtn_query($sql, $this->data_col_db);
	}

	public function rakuten_prd_insert($array,$job_shop_id) {
		$sql = "INSERT INTO rakuten_xls 
					(upc,it_id,vcode,item_name,price,set_qty,rakuten_sku,shop_id,flag,create_date)
				VALUES
					('".$array['C']."','".$array['A']."','".$array['B']."','".$array['E']."','".ROUND($array['G'])."','".$array['F']."','".$array['C']."-P".$array['F']."','".$job_shop_id."','0','".date('Y-m-d H:i:s')."');";

		rtn_query($sql, $this->data_col_db);
	}

	public function prd_log($vcode, $job_shop_id, $flag) {
		$sql = "UPDATE rakuten_xls SET flag = '".$flag."' WHERE shop_id = '".$job_shop_id."' AND vcode = '".$vcode."'";

        rtn_query($sql, $this->data_col_db);
	}
}

?>
