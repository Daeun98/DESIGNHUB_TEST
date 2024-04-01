<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Total extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
		$this->load->helper('form');
		if(!$this->input->get('file_down')){
			ob_start(); 
			@header("Content-Type: text/html; charset=utf-8");
		}
	}
	
	
	public function index()
	{
		$this->main();
	}

	
	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{							
		$dev_arr = $this->common_m->adm_devel_array(); // 헤더와 풋터가 적용되지 않을 메소드 가져오기
		$arr = in_array($method, $dev_arr);

		
		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능 

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);
			
		}else{

			if(!$arr && $this->input->get("ajax")!=1){ //해더 & 풋터가 적용되는 경우
			
				if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID')){ 
					alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
				}

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


	public function excel_download() //엑셀 다운 - 모든 컨트롤러에 적용
	{
		$cont = $this->input->get('cont'); //컨트롤러이름
		$id = $this->input->get('id');
		$flag = $this->input->get('flag');
		$this->{$cont}($flag,'1');
	}


	public function cnt($data)
	{
		$num = $this->uri->segment(3);

		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$day = $this->input->get('day');
		
		if($year==""){ $year=date("Y"); }
		if($month==""){ $month=date("m"); }
		if($day==""){ $day=date("d"); }

		$data['year'] = $year;
		$data['month'] = $month;
		$data['day'] = $day;

		switch($num){
			case 1 :
				$data['count'] = $this->count_m->total_count($year,$month,$day);
				break;
			case 2 :
				$data['count'] = $this->count_m->total_count($year,$month,$day);
				$re_row = $this->count_m->today_count($year,$month,$day);
				$data['max'] = $re_row['max'];
				$data['time_count'] = $re_row['time_count'];
				break;
			case 3 :
				$re_row = $this->count_m->week_count($year,$month,$day);
				$data['start_day'] = $re_row['start_day'];
				$data['last_day'] = $re_row['last_day'];
				$data['count'] = $re_row['count'];
				$data['week'] = $re_row['week'];
				$data['time_count1'] = $re_row['time_count1'];
				$data['time_count2'] = $re_row['time_count2'];
				$data['max1'] = $re_row['max1'];
				$data['max2'] = $re_row['max2'];
				break;
			case 4 :
				$re_row = $this->count_m->month_count($year,$month,$day);
				$data['total_month_counter'] = $re_row['total_month_counter'];
				$data['max'] = $re_row['max'];
				$data['list'] = $re_row['result'];
				break;
			case 5 :
				$re_row = $this->count_m->year_count($year,$month,$day);
				$data['total_year_counter'] = $re_row['total_year_counter'];
				$data['time_count1'] = $re_row['time_count1'];
				$data['time_count2'] = $re_row['time_count2'];
				$data['max1'] = $re_row['max1'];
				$data['max2'] = $re_row['max2'];
				break;
			case 6 :
				$re_row = $this->count_m->referer_count($year,$month,$day);
				$data['list'] = $re_row;
				break;
			case 7 :
				$re_row = $this->count_m->keyword_count($year,$month,$day);
				$data['key_list_tmp'] = $re_row['key_list_tmp'];
				$data['total_cnt'] = $re_row['total_cnt'];
				break;
		}

		$this->load->view("/dhadm/count/search",$data);
		$this->load->view("/dhadm/count/".$num,$data);
	}
}