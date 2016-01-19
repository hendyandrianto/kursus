<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
  		parent::__construct();
  		$this->load->model('login_model');
 	}
 	function antiinjection($data){
		$filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	 	return $filter_sql;
	}
	public function index(){
		if($this->session->userdata('login')==TRUE){
			redirect("dashboard","refresh");
		}else{
			$this->load->view('login/login_view');
		}
	}
	public function do_login(){
		$this->form_validation->set_rules('txtuser','Username','htmlspecialchars|trim|required|min_length[1]|xss_clean');
        $this->form_validation->set_rules('txtpass','Password','htmlspecialchars|trim|required|min_length[1]|xss_clean');
		if ($this->form_validation->run()==TRUE){
			$username = $this->input->post('txtuser');
			$password = md5($this->input->post('txtpass'));
			$data['response'] = 'false';
			$result = $this->login_model->login($username,$password);	
			if($result==TRUE){
				$data['response'] = 'true';
			}
		}else{
			$data['response'] = 'false';
		}
		if('IS_AJAX'){
		    echo json_encode($data);
		}  	
	}
}
