<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {
	public function __construct(){
  		parent::__construct();
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
			$this->load->view('error/error_view');
		}else{
			redirect('login','refresh');
		}
	}
}
