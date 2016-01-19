<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set_menu extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		$this->load->model('dashboard/dashboard_model');
 	}
	public function index(){
		if($this->session->userdata('login')==TRUE){
			$this->_content();
		}else{
			redirect("login","refresh");
		}
	}
	public function _content(){
		if($this->session->userdata('login')==TRUE){
	 		if($this->session->userdata('level')=='0'){	
				$isi['kelas'] = "tools";
				$isi['namamenu'] = "Set Menu";
				$isi['page'] = "set_menu";
				$isi['link'] = 'set_menu';
				$isi['actionhapus'] = 'hapus';
				$isi['actionedit'] = 'edit';
				$isi['halaman'] = "Data Setting Menu";
				$isi['judul'] = "Halaman Data Setting Menu";
				$isi['content'] = "menu_view";
				$this->load->view("dashboard/dashboard_view",$isi);
			}else{
				redirect('error','refresh');
			}
		}else{
			redirect('login','refresh');
		}
	}
	public function ubah_status($jns=Null,$id=Null){
		if($this->session->userdata('login')==TRUE){
	 		if($this->session->userdata('level')=='0'){	
				if($jns=="aktiv"){
					$data = array('status'=>'0');
				}else{
					$data = array('status'=>'1');
				}
				$this->db->where('menu_id',$id);
				$this->db->update('tbl_menu_pro',$data);
			}else{
				redirect('error','refresh');
			}
		}else{
			redirect('login','refresh');
		}	
	}
	public function ubah_submenu($jns=Null,$id=Null){
		if($this->session->userdata('login')==TRUE){
	 		if($this->session->userdata('level')=='0'){	
				if($jns=="aktiv"){
					$data = array('sstatus'=>'0');
				}else{
					$data = array('sstatus'=>'1');
				}
				$this->db->where('smenu_id',$id);
				$this->db->update('tbl_submenu_pro',$data);
			}else{
				redirect('error','refresh');
			}
		}else{
			redirect('login','refresh');
		}	
	}
	public function ubah_submenux($jns=Null,$id=Null){
		if($this->session->userdata('login')==TRUE){
	 		if($this->session->userdata('level')=='0'){	
				if($jns=="aktiv"){
					$data = array('sstatusx'=>'0');
				}else{
					$data = array('sstatusx'=>'1');
				}
				$this->db->where('smenu_id',$id);
				$this->db->update('tbl_submenux_pro',$data);
			}else{
				redirect('error','refresh');
			}
		}else{
			redirect('login','refresh');
		}	
	}
	public function ubah_level($jns=Null,$id=Null){
		if($this->session->userdata('login')==TRUE){
	 		if($this->session->userdata('level')=='0'){	
				if($jns=="aktiv"){
					$data = array('sstatusx'=>'0');
				}else{
					$data = array('sstatusx'=>'1');
				}
				$this->db->where('smenu_id',$id);
				$this->db->update('tbl_submenux_pro',$data);
			}else{
				redirect('error','refresh');
			}
		}else{
			redirect('login','refresh');
		}	
	}
}
