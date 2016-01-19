<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {
public function __construct(){
  	parent::__construct();

	}
	function login($username,$password){
		$this->db->select('*');
		$this->db->from('tbl_username');
		$this->db->where("username",$username);
		$this->db->where("password",$password);
		$query=$this->db->get();
		if($query->num_rows()>0){
		  	foreach($query->result() as $rows){
		  		if($rows->level=='0'){
		  			$newdata = array('level'=>$rows->level,
		  				'login'=>TRUE,
		  				'kode'=>$rows->id,
		  				'foto'=>$rows->foto,
		  				'nama'=>$rows->nama);
		  		}else{
		  			$cekmenu = $this->db->get_where('tbl_usermenu',array('kode'=>$rows->id))->result();	
		  			if(!empty($cekmenu)){
		  				foreach ($cekmenu as $key) {
		  					$hak = $key->menu;
		  					$hax = $key->menux;
		  				}
		  			}else{
		  				$hak = "";
		  				$hax = "";
		  			}
		  			$newdata = array('level'=>$rows->level,
		  				'login'=>TRUE,
		  				'kode'=>$rows->id,
		  				'foto'=>$rows->foto,
		  				'nama'=>$rows->nama,
		  				'priv'=>$hak,
		  				'privx'=>$hax);
		  		}
	  		}
			$this->session->set_userdata($newdata);
			return true;
	 	}
		return false;
	}
}