<?php
require_once(dirname(__FILE__) . '/inc.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Title</title>
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.min.css" />
		<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
		<style>
		html, body { background:#ebebeb; font-size:0.9em; margin:0; padding:0; }
		#container2 { min-width:320px; margin:0px auto 0 auto; background:white; border-radius:0px; padding:0px; overflow:hidden; }
		#tree { float:left; min-width:319px; overflow:auto; padding:0px 0; }
		#data { margin-left:350px; } 
		input[type="button"], button, a.button {
			display:inline-block;
			height:30px; line-height:30px;
			border:0;
			font-size:12px;
			padding:0 15px;
			background:#4b4b4b;
			color:#fff;
			cursor:pointer;
		}
		/* #data textarea { margin:0; padding:0; height:100%; width:100%; border:0; background:white; display:block; line-height:18px; }
		#data, #code { font: normal normal normal 12px/18px 'Consolas', monospace !important; } */
		</style>
	</head>
<?
if($_GET['DHadminMd5ValString']=='201210'){
?>
	<body class="skin-indigo adm-wrap">
		<form action="post" name="menu_edit_form" id="menu_edit_form">
		<input type="hidden" name="id" id="id" value="">
		<div id="container2" role="main">
			<div id="tree"></div>
			<div id="data">
				<h3 class="icon-pen">메뉴설정</h3>
				<div class="cont">
				<table class="adm-table">
					<caption>메뉴관리테이블</caption>
					<colgroup>
						<col style="width:120px;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>상단메뉴</th>
							<td>관리자메뉴</td>
						</tr>
						<tr>
							<th>메뉴명</th>
							<td><input type="text" name="nm" value="기본설정"></td>
						</tr>
						<tr>
							<th>URL</th>
							<td><input type="text" name="url" value="basic_setup"><span class="ft-xs ml10">( /dhadm/html 뒤에 올 값을 입력해주세요 )</span></td>
						</tr>
						<tr>
							<th>사용여부</th>
							<td><input type="checkbox" name="status" value="1" checked></td>
						</tr>
						<tr>
							<th>접근권한</th>
							<td><select name="empower">
									<option value="2">업체관리자</option>
									<option value="1">슈퍼관리자</option>
								 </select>								
							</td>
						</tr>
						<tr>
							<th>페이지타입</th>
							<td><input type="radio" name="cls" id="cls1" checked><label for="cls1">일반</label> 
								<input type="radio" name="cls" id="cls2"><label for="cls2">Dashboard</label>
							</td>
						</tr>
						<tr>
							<th>새 컨트롤러</th>
							<td><input type="text" name="cont"></td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt30"><input type="button" class="btn-xl btn-ok menu_frm" value="확인"></p>
				<div>
			</div>
		</div>
		</form>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
		<script src="jstree.min.js"></script>
		<script>
		$(function () {
			$(window).resize(function () {
				var h = Math.max($(window).height() - 0, 420);
				$('#container2, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
			}).resize();

			$('#tree')
				.jstree({
					'core' : {
						'data' : {
							'url' : '?operation=get_node',
							'data' : function (node) {
								return { 'id' : node.id };
							}
						},
						'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
					},
					'force_text' : true,
					'plugins' : ['state','dnd','contextmenu','wholerow']
				})
				.on('delete_node.jstree', function (e, data) {
					$.get('?operation=delete_node', { 'id' : data.node.id })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('create_node.jstree', function (e, data) {
					$.get('?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
						.done(function (d) {
							data.instance.set_id(data.node, d.id);
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('rename_node.jstree', function (e, data) {
					$.get('?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('move_node.jstree', function (e, data) {
					$.get('?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent, 'position' : data.position })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('copy_node.jstree', function (e, data) {
					$.get('?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent, 'position' : data.position })
						.always(function () {
							data.instance.refresh();
						});
				})
				.on('changed.jstree', function (e, data) {
					if(data && data.selected && data.selected.length) {
						$.get('?operation=get_content&id=' + data.selected.join(':'), function (d) {
							$('#data .cont').html(d.content).show();
						});
					}
					else {
						$('#data .content').hide();
						$('#data .default').html('Select a file from the tree.').show();
					}
				});
		});

		function menu_add(id)
		{
			var form = document.menu_edit_form;
			form.id.value = id;

			if(form.nm.value==""){
				alert("메뉴 이름을 입력해주세요.");
				form.nm.focus();
			}else if(form.url.value==""){
				alert("url을 입력해주세요.");
				form.url.focus();
			}else{
				$("#menu_edit_form").attr("method","post");
				$("#menu_edit_form").attr("action","/html/dhadm/menu/m");
				$("#menu_edit_form").attr("target","_parent");
				$("#menu_edit_form").submit();
			}
			return;
		}
		</script>

	</body>
<? }else{ ?>
잘못된 접근입니다.
<?}?>
</html>

