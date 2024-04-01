<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
    $this->load->model('count_m');
		$this->load->helper('form');
		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$dev_arr = $this->common_m->adm_devel_array(); // 헤더와 풋터가 적용되지 않을 메소드 가져오기
		$arr = in_array($method, $dev_arr);

		if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID')){
			alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
		}

		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);

		}else{

			if(!$arr && $this->input->get("ajax")!=1){ //해더 & 풋터가 적용되는 경우

				$data['admin'] = $this->common_m->getRow("dh_admin_user","where userid='".$this->session->userdata('ADMIN_USERID')."'"); //접속한 user 정보
				$data['menu']  = $this->admin_m->menu(); //메뉴 갖고오기
				$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
				if($this->input->post('skin',TRUE)){ $data['shop_info']['skin'] = $this->input->post('skin',TRUE);	} //환경 설정 시 스킨 적용

				if(isset($data['menu']['lv2']->url)){
					$data['return_url'] = cdir().$data['menu']['lv2']->url."/m";
				}else{
					$data['return_url'] = cdir().$data['menu']['lv1']->url."/m";
				}

				/* 각 페이지의 header inner 클래스 가져오기 start*/
				if(isset($data['menu']['lv2']->cls)){
					$class = $data['menu']['lv2']->cls;
					$url = $data['menu']['lv2']->url;
				}else{
					$class = $data['menu']['lv1']->cls;
					$url = $data['menu']['lv1']->url;
				}
				if($class==""){	$class="adm-wrap"; } // header 안의 inner 기본 클래스
				$data['inner_class'] = $class;
				/* 각 페이지의 header inner 클래스 가져오기 end*/


				/* 페이지 권한 start */
				if($this->session->userdata('ADMIN_LEVEL') > 1){
					$menu_row = $this->common_m->getRow2("dh_menu_data", "where sgm!=1 and url='$url'");
					$menu_url = "";
					if(isset($menu_row->emp)){
						$emp_row = explode(",",	$menu_row->emp);
						if(in_array($this->session->userdata('ADMIN_IDX'),$emp_row)){
							$menu_url = $menu_row->url;
						}
					}

					if($menu_url==""){
						back('페이지 권한이 없습니다.');
					}
				}
				/* 페이지 권한 설정 end */


				$this->load->view('/dhadm/header',$data); //헤더 삽입

				$this->{"{$method}"}($data);

				$this->load->view('/dhadm/footer'); //풋터 삽입


			}else{ //헤더 & 풋터가 적용되지 않을 메소드

				if( method_exists($this, $method))
				{
					$this->{"{$method}"}();
				}

			}

		}

	}



	public function excel_download($data='') //엑셀 다운 - 모든 컨트롤러에 적용
	{
		$cont = $this->input->get('cont'); //컨트롤러이름
		$flag = $this->input->get('flag'); //구분자
		$this->{$cont}($data,'1',$flag);
	}


	public function count1($data='')
	{
		$year=$this->input->get("year");
		$month=$this->input->get("month");
		$lan=$this->input->get("lan");

		$qry="";

		$where_query="where g.idx=t.goods_idx and t.trade_code = dt.trade_code and dt.trade_stat in (2,3,4) $qry group by g.idx";
		//$where_query .= "and goods_idx=g.idx and level=2 and trade_stat in (2,3,4)";
		$order_query="sell_cnt desc";

		$data['query_string'] = "?";
		/*
		if($year){
			$data['query_string'].="&year=".$year;

			if($month){
				$data['query_string'].="&month=".$month;

				if(strlen($month)==1){ $month = "0".$month; }
				$f_where.=" and trade_day like '".$year."-".$month."%'";
			}else{
				$f_where.=" and trade_day like '".$year."-%'";
			}
		}
		*/

		$f = "g.idx,
		g.cate_no,
		g.name,
		(select title from dh_category where SubString_Index(g.cate_no,'-',1)=dh_category.cate_no ) as cate_name1,
		(select title from dh_category where g.cate_no=dh_category.cate_no) as cate_name2,
		count(t.goods_cnt) as sell_cnt";

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber=1; }
		$list_num='30'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/m";
		$data['totalCnt'] = $this->common_m->getPageList('dh_goods g, dh_trade_goods t, dh_trade dt','count','','',$where_query,$order_query,$f); //게시판 리스트
		$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_goods g, dh_trade_goods t, dh_trade dt','',$offset,$list_num,$where_query,$order_query,$f); //게시판 리스트

		$data['year'] = $year;
		$data['month'] = $month;
		$this->load->view('/dhadm/report/1',$data);
	}


	public function count2($data='')
	{
		$year=$this->input->get("year");
		$month=$this->input->get("month");

		$data['year'] = $year;
		$data['month'] = $month;

		$data['query_string'] = "?";
		$where_query=" where trade_stat in (2,3,4) and total_price > 0";
		$order_query=" idx desc";

		if($year){
			$data['query_string'].="&year=".$year;

			if($month){
				$data['query_string'].="&month=".$month;

				if(strlen($month)==1){ $month = "0".$month; }
				$where_query.=" and trade_day like '".$year."-".$month."%'";
			}else{
				$where_query.=" and trade_day like '".$year."-%'";
			}
		}

		$data['total_price'] = $this->common_m->getSum("dh_trade","total_price",$where_query);

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='30'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/m";
		$data['totalCnt'] = $this->common_m->getPageList2('dh_trade','count','','',$where_query,$order_query); //총개수
		$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);

		$result = $this->common_m->getPageList2('dh_trade','',$offset,$list_num,$where_query,$order_query); //리스트
		$data['list'] = $result['list'];
		$data['goods_arr'] = $result['goods_arr'];
		/* 페이징 end */

		$this->load->view('/dhadm/report/2',$data);
	}

}