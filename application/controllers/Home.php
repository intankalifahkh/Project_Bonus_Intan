<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Home extends CI_Controller {
	public function index()
	{
		$this->load->library('session');
		$this->load->database();
		if ($this->session->userdata("login")) {
			$qList=$this->db->query("SELECT * from log_bonus order by createdDate DESC");
			$data['listBonus']=$qList->result();
			$this->load->view('v_home',$data);			
		}else{
			$this->load->view('v_login');			
		}
	}

	public function login()
	{
		$this->load->library('session');
		$this->load->database();

		$username=$this->input->post("username");
		$password=md5($this->input->post("password"));
		$cek=$this->db->query("SELECT * from log_login where username='".$username."' and password='".$password."'")->row();
		if (!empty($cek->ID)) {
			$dataS = array('userID' =>$cek->ID ,"username"=>$cek->username,"password"=>$cek->password,"groupID"=>$cek->groupID,"login"=>"1" );
			$this->session->set_userdata($dataS);
			$data['msg']="good";
		}else{
			$data['msg']="username atau password salah!";
		}
		echo json_encode($data);
	}

	public function logout()
	{
		$this->load->library('session');
		$this->session->unset_userdata("login");
		$data['msg']="good";
		echo json_encode($data);
		
	}

	public function delData()
	{
		$this->load->library('session');
		$this->load->database();	
		$ID=$this->input->post("ID");
		if ($this->db->delete("log_bonus_detail",array("headerID"=>$ID))) {
			if ($this->db->delete("log_bonus",array("ID"=>$ID))) {
				$data['msg']="good";
			}else{
				$data['msg']="error";
			}
		}else{
			$data['msg']="error";
		}
		echo json_encode($data);
	}

	public function showModalEdit()
	{
		$this->load->database();	
		$ID=$this->input->post("ID");
		$qData=$this->db->query("SELECT * from log_bonus where ID='".$ID."'")->row();
		$data['nominal1']=number_format($qData->nominal);
		$data['nominal']=$qData->nominal;
		echo json_encode($data);
	}

	public function editData()
	{
		$this->load->library('session');
		$this->load->database();	
		$ID=$this->input->post("ID");
		$nominal=$this->input->post("nominal");
		foreach ($this->db->query("SELECT * from log_bonus_detail where headerID='".$ID."'")->result() as $key) {
			$bonus=($nominal*$key->persenBonus)/100;
			$dataD = array('nominalBonus' =>$bonus , );
			$this->db->where("ID",$key->ID);
			$this->db->update("log_bonus_detail",$dataD);
		}
		$data = array('nominal' =>$nominal ,"modifiedUserID"=>$this->session->userdata("userID") );
		$this->db->where("ID",$ID);
		$up=$this->db->update("log_bonus",$data);
		if ($up=true) {
			$data['msg']="good";
		}else{
			$data['msg']="error";
		}
		echo json_encode($data);
	}

}
