<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('member_m');
    $this->load->model('product_m');
    $this->load->model('board_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index($data)
	{
		$this->main($data);
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보
		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트

		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk();
		}

		$dev_arr = $this->common_m->devel_array();
		$arr = in_array($method, $dev_arr);


		if($arr){ //개발 페이지 일때

		$this->{"{$method}"}($data);


		}else{ //기타 디자인페이지 일때 자동 출력

			$p = $this->uri->segment(2);
			if($p){
				$url = $this->common_m->get_page($p);
				$this->load->view($url,$data);
			}else{

				$this->{"{$method}"}($data);
			}

		}

		if(!$this->session->userdata('CART')){ //장바구니 카트 no 생성
			$this->common_m->cart_init();
		}
	}


	public function main($data)
	{
		$this->count_m->count_add();

		$data['main_list'] = $this->common_m->getList2("dh_bbs_data","where code='main' order by idx desc"); //메인화면리스트 가져오기
		$data['goods_list1'] = $this->common_m->getList2("dh_goods","where display=1 and display_flag like '%main/%' and cate_no='1-4' order by ranking, idx desc limit 8","*,(select data_txt from dh_data where flag_idx=dh_goods.idx order by idx limit 1) as b_name"); //wear 카테고리의 제품
		$data['goods_list2'] = $this->common_m->getList2("dh_goods","where display=1 and display_flag like '%main/%' and ( cate_no='2-5' or cate_no='2-6' or cate_no='2-7' ) order by ranking, idx desc limit 8","*,(select data_txt from dh_data where flag_idx=dh_goods.idx order by idx limit 1) as b_name"); //HARNESS & LEAD & COLLAR 카테고리의 제품 가져오기 2-5 / 2-6 /2-7

		$data['brand_cnt'] = $this->common_m->getCount("dh_brand_cate","where display=1","idx");
		$data['brand_list'] = $this->common_m->getList2("dh_brand_cate","where display=1 order by sort asc,idx desc");

		//인스타그램

		$token = "";
		if($token){
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$token,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data['token_result'] = json_decode($response);
		}

		// 인스타그램END


		$this->load->view('/html/main',$data);
		$data['popup'] = $this->common_m->popup_list('where'); //팝업 불러오기
		$this->load->view('/common/popup',$data);
	}


	function file_down()
	{
		$mode = $this->uri->segment(3);
		$file_num = $this->input->get("file_down");

		$idx = $this->input->get('idx');
		$file = $this->common_m->file_down_m($mode, $idx, $file_num);


		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$file['file2']);
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		flush();
		readfile($file['file']);
	}


	public function facebook_ret()
	{
		$data['shop_info'] = $this->common_m->shop_info();
		$page = $this->uri->segment(2);
		$this->load->view('/common/'.$page,$data);
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */