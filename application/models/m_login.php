<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model {

	var $tabel_user="user";
	
	
	function __construct()
	{
	
	parent::__construct();
	}

	
	public function validasi(){
	$this->db->where('user_name',$this->input->post('username'));
	$this->db->where('user_password',md5($this->input->post('password')));
	$sql_login=$this->db->get($this->tabel_user);
	
		if($sql_login->num_rows==1){
		return $sql_login->result_array();
		}
	}



}
?>