<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Bonus extends CI_Controller {
	public function index()
	{
		$this->load->library('session');
		$this->load->database();
		if ($this->session->userdata("login")) {
			$this->load->view('v_bonus_add');			
		}else{
			$this->load->view('v_login');			
		}
	}

	public function add()
	{
		$this->load->library('session');
		$this->load->database();
		$totalBonus=$this->input->post("nominal");
		$nama=$this->input->post("nama");
		$persenBonus=$this->input->post("persenBonus");
		$nominalBonus=$this->input->post("nominalBonus");
		$jmlData=$this->input->post("jmlData");
		$data = array('nominal' =>$totalBonus ,"createdUserID"=>$this->session->userdata("userID") );
		if ($this->db->insert("log_bonus",$data)) {
			$cek=$this->db->query("SELECT * from log_bonus order by ID DESC limit 1")->row();
			for ($i=0; $i <$jmlData ; $i++) { 
				$dataD = array('headerID'=>$cek->ID,'nama'=>$nama[$i],'persenBonus'=>$persenBonus[$i],'nominalBonus' =>$nominalBonus[$i]);
				$this->db->insert("log_bonus_detail",$dataD);
			}
			$msg['msg']="good";
		}else{
			$msg['msg']="error";
		}
		echo json_encode($msg);
	}

	public function addDetail()
	{
		$this->load->library('session');
		$this->load->database();
		$headerID=$this->input->post("headerID");
		$nama=$this->input->post("nama1");
		$persenBonus=$this->input->post("persenBonus1");
		$nominalBonus=$this->input->post("nominalBonus1");
		$cek=$this->db->query("SELECT * from log_bonus order by ID DESC limit 1")->row();
		$dataD = array('headerID'=>$headerID,'nama'=>$nama,'persenBonus'=>$persenBonus,'nominalBonus' =>$nominalBonus);
		if($this->db->insert("log_bonus_detail",$dataD)){
			$msg['msg']="good";					
		}else{
			$msg['msg']="error";					
		}
		echo json_encode($msg);
	}

	public function detail()
	{
		$this->load->library('session');
		$this->load->database();
		$ID=$this->uri->segment(3);
		if ($this->session->userdata("login")) {
			$data['bonus']=$this->db->query("SELECT * from log_bonus where ID='".$ID."'")->row();
			$data['listBonus']=$this->db->query("SELECT * from log_bonus_detail where headerID='".$ID."'")->result();
			$this->load->view('v_bonus_detail',$data);			
		}else{
			$this->load->view('v_login');			
		}
	}

	public function showModalEdit()
	{
		$this->load->database();	
		$ID=$this->input->post("ID");
		$qData=$this->db->query("SELECT * from log_bonus_detail where ID='".$ID."'")->row();
		$data['nama']=$qData->nama;
		$data['persenBonus']=$qData->persenBonus;
		$data['nominalBonus1']=number_format($qData->nominalBonus);
		$data['nominalBonus']=$qData->nominalBonus;
		echo json_encode($data);
	}

	public function editData()
	{
		$this->load->library('session');
		$this->load->database();	
		$ID=$this->input->post("ID");
		$nama=$this->input->post("nama1");
		$persenBonus=$this->input->post("persenBonus1");
		$nominalBonus=$this->input->post("nominalBonus1");
		$data = array('nama' =>$nama,"persenBonus"=>$persenBonus,"nominalBonus"=>$nominalBonus , );
		$this->db->where("ID",$ID);
		$up=$this->db->update("log_bonus_detail",$data);
		if ($up=true) {
			$data['msg']="good";
		}else{
			$data['msg']="error";
		}
		echo json_encode($data);
	}

	public function delData()
	{
		$this->load->library('session');
		$this->load->database();	
		$ID=$this->input->post("ID");
		if ($this->db->delete("log_bonus_detail",array("ID"=>$ID))) {
			$data['msg']="good";
		}else{
			$data['msg']="error";
		}
		echo json_encode($data);
	}
	

}
