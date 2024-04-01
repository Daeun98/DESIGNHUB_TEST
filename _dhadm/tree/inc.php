<?
include($_SERVER['DOCUMENT_ROOT']."/html/config.php");
require_once(dirname(__FILE__) . '/class.db.php');
require_once(dirname(__FILE__) . '/class.tree.php');
if(isset($_GET['operation'])) {
	
	$fs = new tree(db::get('mysql://'.$username.':'.$password.'@'.$hostname.'/'.$database), array('structure_table' => 'dh_menu_data', 'data_table' => 'dh_menu', 'data' => array('nm')));
	try {
		$rslt = null;
		switch($_GET['operation']) {
			case 'analyze':
				var_dump($fs->analyze(true));
				die();
				break;
			case 'get_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$temp = $fs->get_children($node);
				$rslt = array();
				foreach($temp as $v) {
					$rslt[] = array('id' => $v['id'], 'text' => $v['nm'], 'children' => ($v['rgt'] - $v['lft'] > 1));
				}
				break;
			case "get_content":
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
				$node = explode(':', $node);
				if(count($node) > 1) {
					$rslt = array('content' => 'Multiple selected');
				}
				else {
					$temp = $fs->get_node((int)$node[0], array('with_path' => true));		
					
					if($temp['cls']=='dashboard'){
						$dashboard = "checked";
					}else{
						$general = "checked";
					}

					$lvlup_menu = str_replace("관리자메뉴/","",implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])));

					if($temp['status']==1){ $checked="checked"; }else{ $checked=""; }

					$txt = '<table class="adm-table"><caption>메뉴관리테이블</caption><colgroup><col style="width:120px;"><col></colgroup><tbody>';
					$txt .= '<tr><th>상단메뉴</th><td>'.$lvlup_menu.'</td></tr><tr><th>메뉴명</th><td><input type="text" name="nm" value="'.$temp['nm'].'"></td></tr>';
					$txt .= '<tr><th>URL</th><td><input type="text" name="url" value="'.$temp['url'].'"><span class="ft-xs ml10"></span></td></tr>';
					$txt .= '<tr><th>사용여부</th><td><input type="checkbox" name="status" value="1" '.$checked.'></td></tr>';
					$txt .= '<tr><th>접근권한</th><td>';

					$sql = "select * from dh_admin_user where idx=1";
					$result = mysql_query($sql);
					$row = mysql_fetch_object($result);

					$txt .= '<input type="checkbox" checked disabled> <label for="emp">'.$row->name.'</label>';

					$sql = "select * from dh_admin_user where level > 1 order by idx";
					$result = mysql_query($sql);
					while($row = mysql_fetch_object($result)){
						$emp = explode(",",$temp['emp']);
						if(in_array($row->idx,$emp)){
							$emp = "checked";
						}

						$txt .= '<input type="checkbox" name="emp[]" id="emp'.$row->idx.'" value="'.$row->idx.'" '.$emp.'> <label for="emp'.$row->idx.'">'.$row->name.'</label>';
					}
					$txt .= '</td></tr>';
					$txt .= '<tr><th>페이지타입</th><td><input type="radio" name="cls" '.$general.' id="cls1" value=""><label for="cls1">일반</label><input type="radio" name="cls" id="cls2" value="dashboard" '.$dashboard.'><label for="cls2">Dashboard</label>';
					$txt .= '</tbody></table>';
					$txt .= '<p class="align-c mt30"><input type="button" class="btn-xl btn-ok menu_frm" value="확인" onclick="menu_add('.$temp['id'].')"></p>';
					$rslt = array('content' => $txt);
					//$rslt = array('content' => 'Selected: /' . implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])). '/'.$temp['nm']);
				}
				break;
			case 'create_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$temp = $fs->mk($node, isset($_GET['position']) ? (int)$_GET['position'] : 0, array('nm' => isset($_GET['text']) ? $_GET['text'] : 'New node'));
				$rslt = array('id' => $temp);
				break;
			case 'rename_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$rslt = $fs->rn($node, array('nm' => isset($_GET['text']) ? $_GET['text'] : 'Renamed node'));
				break;
			case 'delete_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$rslt = $fs->rm($node);
				break;
			case 'move_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
				$rslt = $fs->mv($node, $parn, isset($_GET['position']) ? (int)$_GET['position'] : 0);
				break;
			case 'copy_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
				$rslt = $fs->cp($node, $parn, isset($_GET['position']) ? (int)$_GET['position'] : 0);
				break;
			default:
				throw new Exception('Unsupported operation: ' . $_GET['operation']);
				break;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
	}
	catch (Exception $e) {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
		header('Status:  500 Server Error');
		echo $e->getMessage();
	}
	die();
}

?>