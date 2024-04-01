<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_Product extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('product_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index()
	{
		alert("/dh_product/lists/shop");
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보

		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk();
		}

		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트

		/* 카테고리 데이터 start */
		$cate_no = $this->input->get("cate_no");
		if($cate_no){
			$cate_no1 = explode("-",$cate_no);
			$cate_no1 = $cate_no1[0]; //1차카테고리

			$data['cate_list'] = $this->common_m->getList2("dh_category","where display=1 and depth=2 and cate_no like '".$cate_no1."-%'");
			$data['cate_stat1'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no1' and depth=1"); //1차 카테고리 정보
			$data['cate_stat'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no'"); //현재 카테고리 정보
		}
		/* 카테고리 데이터 end */


		/* 브랜드 카테고리 데이터 start */
		$brand_no = $this->input->get("brand_no");
		$data['brand_no'] = $brand_no;
		if($brand_no){
			$data['cate_stat'] = $this->common_m->getRow("dh_brand_cate","where idx='$brand_no'"); //현재 카테고리 정보
			$data['brand_list'] = $this->common_m->getList2("dh_brand_cate","where display=1 and level=1 order by sort");
		}
		/* 브랜드 카테고리 데이터 end */



		$this->{"{$method}"}($data);

	}


	function prod_list($data)
	{
		$brand = $this->uri->segment(3,'');


		/* 제품 데이터 start */

		$name = $this->input->get('name');
		$cate_no = $this->input->get('cate_no');

		$data['query_string'] = "?";
		$where_query = " where display=1";
		$order_query = " ranking asc, idx desc ";

		if($cate_no){
			$data['query_string'] .= "&cate_no=".$cate_no;
			$where_query .= " and cate_no like '$cate_no%'";
		}

		if($data['brand_no']){
			$data['query_string'] .= "&brand_no=".$data['brand_no'];
			$where_query .= " and brand_flag like '%/".$data['brand_no']."/%'";
		}


		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		$page = $this->uri->segment(2);

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='8'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page."/";
		$data['totalCnt'] = $this->common_m->getPageList('dh_goods','count','','',$where_query,$order_query); //게시판 리스트
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_goods','',$offset,$list_num,$where_query,$order_query,"*,(select data_txt from dh_data where flag_idx=dh_goods.idx order by idx limit 1) as b_name"); //게시판 리스트

		/* 제품 데이터 end */

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/product/";
		$view = "list";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}


	function prod_view($data)
	{
		$idx = $this->uri->segment(3);
		$result = $this->product_m->getView($idx); //제품 데이타
		$data['row'] = $result['row']; // 제품상세데이터
		if(empty($result['row']->idx)){ back('존재하지 않는 상품입니다.'); exit; }

		if($this->input->get("ajax")==1 && $this->input->get("option_idx")){
			$data['option_row']=$this->common_m->getRow("dh_goods_option","where idx='".$this->input->get("option_idx")."'");
			$this->load->view("/product/option_sel",$data);
		}else{


		$data['best_row'] = $result['best_row']; //추천상품 리스트
		$data['data_list'] = $result['data_list']; //제품 연관 데이타
		if(count($result['file_list']) > 0){
			$data['file_list'] = $result['file_list']; //추가 제품 이미지
		}else{
			$data['file_list']="";
		}

		//$data['best_prd'] = $this->product_m->getbestPrd($data['row']->best_prd,'bbs'); //게시판 or 추천제품 연동시

		$data['row']->icon_flag = explode('/',$data['row']->icon_flag);

		$data['option_flag_cnt'] = $this->common_m->getCount("dh_goods_option","where level=1 and goods_idx = '$idx' and flag=1");
		$data['option_flag_cnt2'] = $this->common_m->getCount("dh_goods_option","where level=1 and goods_idx = '$idx' and flag=0");

		for($kk=1;$kk<=3;$kk++){

			$data['option_row'.$kk] = $this->common_m->getRow("dh_goods_option","where level=1 and goods_idx = '$idx' and chk_num='".$kk."'");

			if(isset($data['option_row'.$kk]->code)){
				$data['option_list_cnt'.$kk] = $this->common_m->getCount("dh_goods_option","where level=2 and goods_idx = '$idx' and code='".$data['option_row'.$kk]->code."'");
				$data['option_list'.$kk] = $this->common_m->getList("dh_goods_option","where level=2 and goods_idx = '$idx' and code='".$data['option_row'.$kk]->code."'");
			}
		}

		$page = $this->uri->segment(2);

		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/product/";

		if($data['shop_info']['shop_use']=="y"){
			$view = "shop_view";
		}else{
			$view = "view";
		}
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
		}

	}


	public function getProduct()
	{
		$cate_no = $this->uri->segment(3);
		$goods_idx = $this->input->get("goods_idx");

		if($cate_no && $this->input->get("ajax")==1)
		{
			$data='<option value="">제품을 선택해주세요</option>';
			$result = $this->common_m->getList2("dh_goods","where cate_no='$cate_no'");
			foreach($result as $list){

				$selected = "";

				if($goods_idx && $goods_idx==$list->idx){
					$selected = "selected";
				}

				$data.='<option value="'.$list->idx.'" '.$selected.'>'.$list->name.'</option>';
			}

			echo $data;

		}
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */