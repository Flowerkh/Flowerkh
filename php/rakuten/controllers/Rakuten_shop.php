<?php

class Rakuten_shop extends CI_Controller
{
	//요청오는 상점 id (nowfoods, vitacafe)
    //private $job_shop_id = "nowfoods";
    private $job_shop_id = "vitacafe";

    // $sky_mode > 111 : rakuten_sku 생성안함, 1 : rakuten_sku 자동생성
    private $sku_mode = 0;
    private $img_url_list = array("https://img.ople.com/market_item/{VCODE}.jpg"
                                , "https://img.ople.com/job_marketimg/vcode/{VCODE}.jpg"
                                , "https://img.ople.com/market_item/{UPC}.jpg"
                                , "https://img.ople.com/ople/item/{IT_ID}_s");

    public function __construct()
    {
        parent::__construct();

        $this->load->model('rakuten/rakuten_model');
		$this->load->helper('javascript');
    }

    public function index()
    {
		if(!$this->session->has_userdata('openmarket_user_id')) redirect(site_url('rakuten/intro/login'));

		$data['container'] = "rakuten/item_add";
        $data['left_menu'] = 'rakuten/left_menu';

        $this->load->view('rakuten/template', $data);
    }

	/* 대량등록 csv 생성 용 엑셀 업로드 폼 */
    public function uploadItemDataForm(){
        $this->load->view("rakuten/upload_insert_item");
    }

	/* 상품 등록 초기 세팅 */
    public function uploadItemData() {

        //엑셀 파일 업로드하는 action
        if(!$_FILES['excel']['tmp_name'] || !file_exists($_FILES['excel']['tmp_name'])){
            alert('file upload error!! 0001!');
            exit;
        }

        $column_num         = 1;
        $upload_time		= date("YmdHis");

        $config['upload_path']		= "./uploads/rakuten_item_insert";
        $config['overwrite']		= true;
        $config['encrypt_name']		= false;
        $config['max_filename']		= 0;
        $config['allowed_types']	= 'xls|xlsx';
        $config['file_name']		= 'rakuten_prd_list';


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('excel')) {
            alert('failed upload\n'.$this->upload->display_errors());
            exit;
        }

        $file_info = $this->upload->data();
        $file_path = $file_info['full_path'];
        if(!file_exists($file_path)) {
            alert('file upload error!! 0002!');
            exit;
        }

        // data action
        $this->load->library('pxl/PHPExcel');
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
        $objReader->setReadDataOnly(true);
        $objReader->setReadDataOnly(true); //데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
        $objExcel = $objReader->load($file_path);
        $objExcel->setActiveSheetIndex(0);

        $sheetData	= $objExcel->getActiveSheet()->toArray(null,true,true,true);
        unset($objExcel);

        if(count($sheetData) - $column_num < 1){
            alert('유효 데이터가 없습니다.');
            exit;
        }

		unset($sheetData[1]);
		unset($sheetData[2]);	

        $fail_id_arr = array();
        $success_id_arr = array();

		$count = 0;

        foreach (array_values($sheetData) as $row) {
			if($row['A']=='') continue;
			$this->rakuten_model->rakuten_prd_insert($row,$this->job_shop_id);

			$count++;
        }
        alert($count.'개 등록 완료하였습니다.');
    }


	//이미지 업로드용 zip 생성
    public function make_img()
    {
        ini_set('memory_limit','-1');
        ini_set('max_execution_time', 0);
        ini_set('default_socket_timeout','6000');

        $ftp_server = "115.68.184.248";
        $ftp_username ="gecl";
        $ftp_password = "qwe123qwe!@#";
		$z_flg = 0;

        ob_start();
        $this->benchmark->mark('code_start');
        //$zip_name = "rakuten_img_".date("YmdHis").".zip";

        $file_path = "./uploads/rakuten_item_insert/rakuten_image/";

        $this->load->library('zip');
		
        $rtn = $this->rakuten_model->get_prd_list($this->job_shop_id, 0);

        $connection = ssh2_connect($ftp_server, 22);
		ssh2_auth_password($connection, $ftp_username, $ftp_password);

		//이미지 파일 생성
        foreach($rtn AS $row) 
		{
            $prd_info = $this->rakuten_model->get_prd_info($row['it_id'], $row['upc']);
            $image_path = "";

            foreach($this->img_url_list as $iv)
            {
                $img_url = str_replace("{VCODE}", $row['vcode'], $iv);
                $img_url = str_replace("{UPC}", $row['upc'], $img_url);
                $img_url = str_replace("{IT_ID}", $row['it_id'], $img_url);

                if($this->get_headers_info($img_url) == 200)
                {
					echo $img_url."<br/>";
                    $image_path = $img_url;
                    break;
                }
            }

            if($image_path != '')
            {
                $new_img_file = $file_path.strtolower(str_replace('https://img.ople.com/market_item/','',$image_path));

                $image_path = str_replace('https://img.ople.com','/web', $image_path);
                ssh2_scp_recv($connection, $image_path, $new_img_file);
				//생성된 이미지 DB update
				$this->rakuten_model->prd_img_update($row['vcode'],$image_path,$this->job_shop_id,1);

                ob_flush();
                flush();

                $z_flg = 1;
            }
        }

		echo "<br/>file upload success!!";

        $this->benchmark->mark('code_end');
        echo "<br/>".$this->benchmark->elapsed_time('code_start', 'code_end').PHP_EOL;

        ob_flush();
        flush();

        ob_end_clean();
    }

	//이미지 업로드 체크
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

	public function csv_output() {
		$file_path = "./uploads/rakuten_item_insert/";
		$file_name = "item.csv";
		$csv = array();

		$fp = fopen($file_path.$file_name,'w');
		$rtn = $this->rakuten_model->get_prd_list($this->job_shop_id,1);

		//csv 컬럼 명
		//https://navi-manual.faq.rakuten.net/item/000034706
		$fields = array('コントロールカラム','商品管理番号（商品URL）','商品番号','全商品ディレクトリID','商品名','販売価格','PC用販売説明文','商品画像URL','在庫タイプ','在庫数','在庫数表示','カタログID','倉庫指定','商品情報レイアウト');
		foreach( $fields as $k => $v ) {
			$fields[$k] = mb_convert_encoding($v,'Shift-JIS','UTF-8');
		}
//
        fputcsv($fp, $fields);

		if(!empty($rtn)) {
			//csv data 삽입
			foreach ($rtn as $row) {
				$prd_info = $this->rakuten_model->get_prd_info($row['it_id'], $row['upc']);
				$this->rakuten_model->prd_log($row['vcode'], $this->job_shop_id, 3);
				//영문 이름 없을 시 로그 기록
				if($prd_info['it_name_eng'] == '')
				{
					$this->rakuten_model->prd_log($row['vcode'], $this->job_shop_id, 90);
					continue;
				}

				$prd_name  = mb_convert_encoding(str_replace('"','""',str_replace(array('\r\n','\r'),'\n',$prd_info['it_name_eng'])),'Shift-JIS','UTF-8');
				$caption  = mb_convert_encoding(str_replace(array('\r\n','\n','\r'),PHP_EOL,$prd_info['desc_eng']),'Shift-JIS','UTF-8');
				//대문자는 등록이 불가능하여 소문자로 변환 후 csv 다운로드
				$fields = array('n', strtolower(strtolower($row['rakuten_sku'])), strtolower($row['rakuten_sku']), '550091', $prd_name, $row['price'], $caption, $row['img_url'], '1', '99999' ,'1', $row['upc'],'1','4');
				fputcsv($fp, $fields);
			}
			alert('Success create csv');
		} else {
			alert('No data! error 10001');
		}
		fclose($fp);

		exit;
	}
}
?>
