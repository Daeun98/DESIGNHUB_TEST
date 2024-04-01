<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//class Banner_model start
class Banner_m extends CI_Model
{
	function __construct()
	{
			parent::__construct();
	}

	function insert($arr)
	{
		$insert = array(
			'code' => $arr['code'],
			'name' => $arr['name'],
			'pageurl' => $arr['pageurl'],
			'used' => $arr['used'],
			'sorting' => $arr['sorting'],
			'wdate' => date("Y-m-d H:i:s")
		);

		$result = $this->db->insert("dh_banner",$insert);
		return $result;
	}

	function update($arr)
	{
		$data = array(
			'name' => $arr['name'],
			'pageurl' => $arr['pageurl'],
			'used' => $arr['used'],
			'sorting' => $arr['sorting'],
			'udate' => date("Y-m-d H:i:s")
		);

		$where = array(
			'idx' => $arr['idx']
		);

		$result = $this->db->update("dh_banner",$data,$where);
		return $result;
	}

	function grpdel($idx)
	{
		$s = "delete from dh_bannerlist where parent_idx = '".$idx."'";
		$q = $this->db->query($s);

		$data = array(
			'idx' => $idx
		);
		$result = $this->db->delete("dh_banner",$data);
		return $result;
	}

	function lists()
	{
		$sql = "select *,(select count(idx) from dh_bannerlist where parent_code = dh_banner.code) as num from dh_banner order by sorting asc, idx asc";
		$result = $this->db->query($sql);
		$row = $result->result();
		return $row;
	}

	function getrow($idx)
	{
		$sql = "select * from dh_banner where idx = '".$idx."'";
		$result = $this->db->query($sql);
		$row = $result->row();
		return $row;
	}

	function delist($idx)
	{
		$s = "select * from dh_bannerlist where parent_idx = '".$idx."'";
		$q = $this->db->query($s);
		$result = $q->result();
		return $result;
	}

	function dlrow($idx)
	{
		$s = "select * from dh_bannerlist where idx = '".$idx."'";
		$q = $this->db->query($s);
		$result = $q->row();
		return $result;
	}

	function sinsert($arr)
	{
		$data = array(
			'parent_idx' => $arr['parent_idx'],
			'parent_code' => $arr['parent_code'],
			'upfile1' => $arr['upfile1'],
			'upfile2' => $arr['upfile2'],
			'upfile1_real' => $arr['upfile1_real'],
			'upfile2_real' => $arr['upfile2_real'],
			'pageurl' => $arr['pageurl'],
			'sort' => $arr['sort'],
			'addinfo1' => $arr['addinfo1'],
			'addinfo2' => $arr['addinfo2'],
			'addinfo3' => $arr['addinfo3'],
			'addinfo4' => $arr['addinfo4'],
			'addinfo5' => $arr['addinfo5'],
			'wdate' => date("Y-m-d H:i:s")
		);
		$result = $this->db->insert("dh_bannerlist",$data);
		return $result;
	}

	function supdate($arr)
	{
		$data = array(
			'upfile1' => $arr['upfile1'],
			'upfile2' => $arr['upfile2'],
			'upfile1_real' => $arr['upfile1_real'],
			'upfile2_real' => $arr['upfile2_real'],
			'pageurl' => $arr['pageurl'],
			'sort' => $arr['sort'],
			'addinfo1' => $arr['addinfo1'],
			'addinfo2' => $arr['addinfo2'],
			'addinfo3' => $arr['addinfo3'],
			'addinfo4' => $arr['addinfo4'],
			'addinfo5' => $arr['addinfo5'],
			'udate' => date("Y-m-d H:i:s")
		);
		$where = array(
			'idx' => $arr['s_idx']
		);
		$result = $this->db->update("dh_bannerlist",$data, $where);
		return $result;
	}

	function sdelete($idx)
	{
		$data = array(
			'idx' => $idx
		);
		$result = $this->db->delete("dh_bannerlist",$data);
		return $result;
	}

	function s_list($parent_code)
	{
		$s = "select * from dh_bannerlist where parent_code = '".$parent_code."' order by sort desc, idx desc";
		$q = $this->db->query($s);
		$result = $q->result();
		return $result;
	}

	function s_row($idx)
	{
		$s = "select * from dh_bannerlist where idx = '".$idx."'";
		$q = $this->db->query($s);
		$result = $q->row();
		return $result;
	}

}
//class Banner_model end