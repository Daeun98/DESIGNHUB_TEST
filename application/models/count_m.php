<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Count_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


		function total_count($year,$month,$day) //접속리포트
		{
		
			$referer = "";
			// 사용자 IP 얻어옴
			$user_ip=$_SERVER['REMOTE_ADDR'];
			if(isset($_SERVER['HTTP_REFERER'])){
				$referer = $_SERVER['HTTP_REFERER'];				
			}

			// 오늘의 날자 구함
			$today=mktime(0,0,0,$month,$day,$year);
			$yesterday=mktime(0,0,0,$month,$day,$year)-3600*24;

			// 이번달의 첫번째 날자 구함
			$month_start=mktime(0,0,0,$month,1,$year);

			// 이번달의 마지막 날자 구함
			$lastdate=01;
			while (checkdate($month,$lastdate,$year)): 
				$lastdate++;  
			endwhile;
			$lastdate=mktime(0,0,0,$month,$lastdate,$year);


			// 전체
			$sql = "select sum(unique_counter) as sum1, sum(pageview) as sum2 from dh_counter_main";
			$query = $this->db->query($sql);
			$row = $query->row();
			if($row){
				$count['total_hit'] = $row->sum1;
				$count['total_view'] = $row->sum2;
			}else{
				$count['total_hit'] = "0";
				$count['total_view'] = "0";
			}

			// 오늘 카운터 읽어오는 부분
			$sql = "select unique_counter, pageview from dh_counter_main where date='$today'";
			$query = $this->db->query($sql);
			$row = $query->row();
			if($row){
				$count['today_hit'] = $row->unique_counter;
				$count['today_view'] = $row->pageview;		
			}else{
				$count['today_hit'] = "0";
				$count['today_view'] = "0";
			}

			
			// 어제 카운터 읽어오는 부분
			$sql = "select unique_counter, pageview from dh_counter_main where date='$yesterday'";
			$query = $this->db->query($sql);
			$row = $query->row();
			if($row){
				$count['yesterday_hit'] = $row->unique_counter;
				$count['yesterday_view'] = $row->pageview;
			}else{
				$count['yesterday_hit'] = "0";
				$count['yesterday_view'] = "0";
			}

			
			// 최고 카운터 읽어오는 부분
			/*$sql = "select max(unique_counter) as max1, max(pageview) as max2 from dh_counter_main where no>1";
			$query = $this->db->query($sql);
			$row = $query->row();
			$count['max_hit'] = $row->max1;
			$count['max_view'] = $row->max2;

			// 최저 카운터 읽어오는 부분
			$sql = "select min(unique_counter) as min1, min(pageview) as min2 from dh_counter_main where no>1 and date<$today";
			$query = $this->db->query($sql);
			$row = $query->row();
			$count['min_hit'] = $row->min1;
			$count['min_view'] = $row->min2;*/


			return $count;
		}


		function today_count($year,$month,$day) //금일 접속 현황
		{
		
			$max=1;
			for($i=0;$i<24;$i++)
			{
			 $time1=mktime($i,0,0,$month,$day,$year);
			 $time2=mktime($i,59,59,$month,$day,$year);
			 
			 $sql = "select count(*) as cnt from dh_counter_ip where date>='$time1' and date<='$time2'";
			 $query = $this->db->query($sql);
			 $row = $query->row();
			 $time_count[$i]=$row->cnt;
			 if($max<$time_count[$i]) $max=$time_count[$i];
			}

			$data['max'] = $max;
			$data['time_count'] = $time_count;

			return $data;
		}


		function week_count($year,$month,$day) //주간별 통계
		{
		
			 $start_day=$day;
			 while(date('l',mktime(0,0,0,$month,$start_day,$year))!='Sunday')
			 {
				$start_day--;
			 }
			 $last_day=$day;
			 while(date('l',mktime(0,0,0,$month,$last_day,$year))!='Saturday')
			 {
				$last_day++;
			 }

			 $start_time=mktime(0,0,0,$month,$start_day,$year);
			 $last_time=mktime(23,59,59,$month,$last_day,$year);

			 
			 $sql = "select sum(unique_counter) as unique_counter, sum(pageview) as pageview from dh_counter_main where date>=$start_time and date<=$last_time";
			 $query = $this->db->query($sql);
			 $row = $query->row();

			 $count['week_hit']=$row->unique_counter;
			 $count['week_view']=$row->pageview;

			$max1=1;
			$max2=1;
			for($i=0;$i<7;$i++)
			{
			 $time=mktime(0,0,0,$month,$start_day+$i,$year);
			 $sql = "select unique_counter, pageview from dh_counter_main where date='$time'";
			 $query = $this->db->query($sql);
			 $row2 = $query->row();

			 if(isset($row2->unique_counter)){ $time_count1[$i]=$row2->unique_counter; }else{ $time_count1[$i]="0"; }
			 if($max1<$time_count1[$i]) $max1=$time_count1[$i];
			 if(isset($row2->pageview)){ $time_count2[$i]=$row2->pageview; }else{ $time_count2[$i]="0"; }
			 if($max2<$time_count2[$i]) $max2=$time_count2[$i];
			}

			$week=array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");

			$data['start_day'] = $start_day;
			$data['last_day'] = $last_day;
			$data['count'] = $count;
			$data['week'] = $week;
			$data['time_count1'] = $time_count1;
			$data['time_count2'] = $time_count2;
			$data['max1'] = $max1;
			$data['max2'] = $max2;

			return $data;
		}


		function month_count($year,$month,$day) //월간별 통계
		{
			
			// 이번달의 첫번째 날자 구함
			$month_start=mktime(0,0,0,$month,1,$year);

			// 이번달의 마지막 날자 구함
			$lastdate=01;
			while (checkdate($month,$lastdate,$year)): 
				$lastdate++;  
			endwhile;
			$lastdate = $lastdate-1;
			$lastdate=mktime(0,0,0,$month,$lastdate,$year);

			$sql = "select sum(unique_counter) as unique_counter, sum(pageview) as pageview from dh_counter_main where date>='$month_start' and date<='$lastdate'";
			$query = $this->db->query($sql);
			$row = $query->row();
			$total_month_counter[0] = $row->unique_counter;
			$total_month_counter[1] = $row->pageview;

			// 이번달 카운터 (각각)
			$sql = "select max(unique_counter) as unique_counter, max(pageview) as pageview from dh_counter_main where date>='$month_start' and date<='$lastdate'";
			$query = $this->db->query($sql);
			$row2 = $query->row();
			$max[0] = $row2->unique_counter;
			$max[1] = $row2->pageview;

			$sql = "select date, unique_counter, pageview from dh_counter_main where date>='$month_start' and date<='$lastdate'";
			$query = $this->db->query($sql);
			$result = $query->result();

			$data['total_month_counter'] = $total_month_counter;
			$data['max'] = $max;
			$data['result'] = $result;

			return $data;
		}

		function year_count($year,$month,$day)
		{
			$year_start=mktime(0,0,0,1,1,$year);
			$year_last=mktime(23,59,59,12,31,$year);
			$sql = "select sum(unique_counter) as unique_counter, sum(pageview) as pageview from dh_counter_main where date>='$year_start' and date<='$year_last'";
			$query = $this->db->query($sql);
			$row = $query->row();
			$total_year_counter[0] = $row->unique_counter;
			$total_year_counter[1] = $row->pageview;
			if(empty($start_day)){ $start_day = 0; }

				// 이번달 카운터 (각각)
			$max1=1;
			$max2=1;
				for($i=0;$i<7;$i++)
				{
				 $time=mktime(0,0,0,$month,$start_day+$i,$year);
				 $sql = "select unique_counter, pageview from dh_counter_main where date='$time'";
				 $query = $this->db->query($sql);
				 $row = $query->row();
				 if(isset($row->unique_counter)){ $temp[0] = $row->unique_counter; }else{ $temp[0]=0; }
				 if(isset($row->pageview)){ $temp[1] = $row->pageview; }else{ $temp[1]=0; }				 
				 $time_count1[$i]=$temp[0];
				 if($max1<$time_count1[$i]) $max1=$time_count1[$i];
				 $time_count2[$i]=$temp[1];
				 if($max2<$time_count2[$i]) $max2=$time_count2[$i];
				}


				$mmax=array("31","28","31","30","31","30","31","31","30","31","30","31");
				$max=1;
				$max2=1;
				for($i=0;$i<12;$i++)
				{
				 $sdate=mktime(0,0,0,$i+1,1,$year);
				 $edate=mktime(0,0,0,$i+1,$mmax[$i],$year);

				 $sql = "select sum(unique_counter) as unique_counter, sum(pageview) as pageview from dh_counter_main where date>='$sdate' and date<='$edate'";
				 $query = $this->db->query($sql);
				 $row = $query->row();
				 if(isset($row->unique_counter)){ $temp[0] = $row->unique_counter; }else{ $temp[0]=0; }
				 if(isset($row->pageview)){ $temp[1] = $row->pageview; }else{ $temp[1]=0; }		
				 $time_count1[$i]=$temp[0];
				 if($max1<$time_count1[$i]) $max1=$time_count1[$i];
				 $time_count2[$i]=$temp[1];
				 if($max2<$time_count2[$i]) $max2=$time_count2[$i];
				}

			$data['total_year_counter'] = $total_year_counter;
			$data['time_count1'] = $time_count1;
			$data['time_count2'] = $time_count2;
			$data['max1'] = $max1;
			$data['max2'] = $max2;

			return $data;
		}

		function referer_count($year,$month,$day)
		{
			// 오늘의 날자 구함
			$today=mktime(0,0,0,$month,$day,$year);
			$host='www.';
			$host .=$_SERVER['HTTP_HOST'];
			
			$sql = "select referer, hit from dh_counter_referer where date='$today' order by referer desc";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function keyword_count($year,$month,$day)
		{
			// 오늘의 날자 구함
			$today=mktime(0,0,0,$month,$day,$year);

			$sql = "select sum(hit) as total_cnt from dh_counter_referer where date='$today'";
			$query = $this->db->query($sql);
			$row = $query->row();
			$total_cnt = $row->total_cnt;

			$con_parameter = "p,q,query";
			$parameter = explode(",",$con_parameter);

			
			$sql = "select * from dh_counter_referer where date='$today' order by referer desc";
			$query = $this->db->query($sql);
			$result = $query->result();

			$key_list_tmp = Array();
			$no = 0;
			foreach ($result as $row){ 

				if($row->referer != ""){
				$ii=0;

					for($ii=0; $ii < count($parameter) && $parameter[$ii] != ""; $ii++){

						$key_start = strpos($row->referer, $parameter[$ii]."=");

						if($key_start > 0){
							$key_start = $key_start + strlen($parameter[$ii]."=");
							$key_end =  strpos($row->referer, "&", $key_start);
							if($key_end <= 0) $key_end = strlen($row->referer);

							$keyword = substr($row->referer, $key_start, $key_end-$key_start);
							$portal_tmp = explode("/",$row->referer);
							$portal = $portal_tmp[2];
							$keyword = str_replace("%u", "%", $keyword);
							$keyword = urldecode($keyword);
							//echo $keyword."<BR>".$portal."<BR><BR>";

							if(
								$portal == "m.cafe.daum.net" || 
								$portal == "m.cafe.daum.net" || 
								$portal == "m.search.daum.net" || 
								$portal == "k.daum.net" || 
								$portal == "k.daum.net"  || 
								$portal == "m.search.naver.com" || 
								$portal == "search.naver.com" || 
								$portal == "search.daum.net" || 
								$portal == "search.zum.com" || 
								$portal == "web.search.naver.com" || 
								$portal == "www.searchmobileonline.com" || 
								$portal == "m.k.daum.net" || 
								$portal == "local.daum.net" || 
								$portal == "www.google.co.kr"
							){
								//$keyword=mb_convert_encoding($keyword,"EUC-KR","UTF-8");
							}

							$key_list_tmp[$no]['name'] = $keyword;
							$key_list_tmp[$no]['cnt'] = $row->hit;
							$key_list_tmp[$no]['host'] = $row->referer;
							$key_list_tmp[$no]['portal'] = $portal;

							$no++;
						}

					}

				}

			}
			
			if(count($key_list_tmp) > 1) sort($key_list_tmp);

			$data['key_list_tmp'] = $key_list_tmp;
			$data['total_cnt'] = $total_cnt;

			return $data;
		}

		
		function count_add()
		{
			$referer = "";

			// 사용자 IP 얻어옴
			$user_ip=$_SERVER['REMOTE_ADDR'];
			$mydomain=$_SERVER['HTTP_HOST'];

			if(isset($_SERVER['HTTP_REFERER'])){
				$referer = $_SERVER['HTTP_REFERER'];				
			}

			if (stristr($referer,$mydomain)) { $referer="재방문"; }
			//홈페이지내에서 재접속
			if(empty($referer)) $referer="즐겨찾기 또는 직접방문";
			
			// 오늘의 날자 구함
			$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
			$yesterday=mktime(0,0,0,date("m"),date("d"),date("Y"))-60*60*24;
			$tomorrow=mktime(23,59,59,date("m"),date("d"),date("Y"));
			$time=time();

			
			//------------------- 카운터 테이블에 데이타 입력 부분 -------------------------------------------------------
			$query = $this->db->query("select count(no) as cnt from dh_counter_main where date='$today'");
			$check = $query->row()->cnt;


			if($check==0)
			{				
				$insert_array = array('date' => $today,'unique_counter' => '0','pageview' => '0');
				$this->db->insert("dh_counter_main",$insert_array);
			}
			
			// 지금 아이피로 접속한 사람이 오늘 처음 온 사람인지 검사
			$query = $this->db->query("select count(no) as cnt from dh_counter_ip where date>=$today and date<$tomorrow and ip='$user_ip'");
			$check = $query->row()->cnt;


			// 오늘 처음왔을때
			if($check==0)
			{
			 // 전체랑 오늘 카운터 올림
			 $this->db->query("update dh_counter_main set unique_counter=unique_counter+1, pageview=pageview+1 where date='$today'"); //no=1 or 

			 // 오늘 시간대별 ip 입력
			 $insert_array = array('date' => $time,'ip' => $user_ip);
			 $this->db->insert("dh_counter_ip",$insert_array);
			}
			// 오늘 한번 이상 온 상태일때
			else
			{
			 // 페이지뷰 올림
			 $this->db->query("update dh_counter_main set pageview=pageview+1 where date='$today'"); //no=1 or 
			}
			
			// referer 값 저장
			$query = $this->db->query("select count(no) as cnt from dh_counter_referer where date=$today and referer='$referer'");
			$check2 = $query->row()->cnt;

			 if($check2==0)
			 {
				 $insert_array = array('date' => $today,'referer' => $referer,'hit' => '1');
				 $this->db->insert("dh_counter_referer",$insert_array);
			 }
			 else
			 {
					$this->db->query("update dh_counter_referer set hit=hit+1 where date=$today and referer='$referer'");
			 }
		}
		
}