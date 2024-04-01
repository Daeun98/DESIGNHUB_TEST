<!doctype html>
<html lang="ko">
 <head>
  <title><?=$shop_info['shop_name']?> 관리자모드</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
<? include $_SERVER['DOCUMENT_ROOT']."/_data/lib/post_api.php"; ?>

	<!-- 달력 가져오기-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="/_dhadm/js/jquery.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="/_dhadm/js/cal.js"></script>
	<!-- 달력 가져오기-->

 </head>

 <body>
 <!--Wrap-->
 <div id="wrap" class="<? echo isset($shop_info['skin']) ? $shop_info['skin'] : "";?>">


	<!--Header-->
	<div id="header">
		<div id="title" class="roboto-c"><a href="<?=cdir()?>/basic/setup"><img src="/_dhadm/image/common/dh_sm.png" alt="DesignHub" class="mid mr10" width="35" height="25"><?=$this->session->userdata('ADMIN_NAME')?></a></div>
		<div id="gnb-wrap">
			<ul id="gnb">
				<?=$menu[1]?>
			</ul>

			<ul id="tnb">
				<!-- <li><a href="#" title="관리자 설정"><img src="/_dhadm/image/common/admin.png" alt="관리자 설정"></a></li> -->
				<? if($this->session->userdata('ADMIN_LEVEL') < 2){ ?>
				<li><a href="<?=cdir()?>/dhadm/menu" title="환경 설정"><img src="/_dhadm/image/common/setting.png" alt="환경 설정"></a></li>
				<?}?>
			</ul>
		</div>
	</div><!--END Header-->



	<!--Container-->
	<div id="container">
		<!-- Left Side Wrap -->
		<div id="side">
			<!-- 업체 정보 및 HOME/LOGOUT -->
			<div id="profile">
				<p class="logo"><img src="<? echo isset($shop_info['logo_image']) ? "/_data/file/".$shop_info['logo_image'] : "/_dhadm/image/common/profile.png";?>" alt="@업체명"></p>
				<ul class="nav opensans">
					<li><a href="/" target="_blank">WEBSITE</a></li>
					<li><a href="<?=cdir()?>/dhadm/logout">LOGOUT</a></li>
				</ul>
			</div><!-- END 업체 정보 및 HOME/LOGOUT -->

			<h1 class="setting">
				<? echo isset($menu['lv1']->nm) ? $menu['lv1']->nm : ""; ?>
			</h1>

			<!-- SNB -->
			<ul id="snb">
				<? echo isset($menu[2]) ? $menu[2] : ""; ?>
			</ul><!-- END SNB -->


			<!-- <p class="mt30 pl20"><span class="btn-download"><a href="#">관리자 이용가이드 다운로드</a></span></p> -->
		</div><!-- END Left Side Wrap -->


		<!-- Content -->
		<div id="content">
			<!-- inner -->
			<div class="inner <?=$inner_class?>">

				<? if($inner_class!="dashboard"){ ?>

				<div class="adm-title">
					<h2>
					<?
					$menu_name = "메뉴없음";

					if(isset($menu['lv2']->nm)){
						$menu_name = $menu['lv2']->nm;
					}else if(isset($menu['lv1']->nm)){
						$menu_name = $menu['lv1']->nm;
					}

					if($this->input->get("edit")==1 && $this->input->get("idx")){ $menu_name = str_replace("목록","수정",$menu_name); $menu_name = str_replace("등록","수정",$menu_name); $menu_name = str_replace("추가","수정",$menu_name);}

					if($menu_name=="주문관리"){ $menu_name .= " (전체)"; }
					echo $menu_name;
					?></h2>
					<p class="page-path opensans"><a href="/html/dhadm/basic_setup">HOME</a> &gt; <? echo isset($menu['lv1']->nm) ? $menu['lv1']->nm : ""; ?> <? echo isset($menu['lv2']->nm) ? " &gt; ".$menu['lv2']->nm : ""; ?></p>
				</div>

				<?}?>




