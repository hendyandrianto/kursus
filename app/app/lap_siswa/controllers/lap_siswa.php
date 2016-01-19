<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lap_siswa extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->kacang->login();
		$menu = "laporan";
		$this->kacang->validasi_menu($menu);
		$submenu = "Laporan Data Siswa";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "lap_siswa";
			$this->kacang->hak_aksessubmenu($page);
		}
 	}
	public function index(){
		if($this->session->userdata('login')==TRUE){
			$this->_content();
		}else{
			redirect("login","refresh");
		}
	}
	function antiinjection($data){
		$filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	 	return $filter_sql;
	}
	public function _content(){
		$isi['kelas'] = "laporan";
		$isi['namamenu'] = "Laporan Data Siswa";
		$isi['page'] = "lap_siswa";
		$isi['link'] = 'lap_siswa';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Laporan Data Siswa";
		$isi['judul'] = "Halaman Laporan Data Siswa";
		$isi['content'] = "lap_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function cetak_menjahit(){
		$this->load->helper('pdf_helper');
		$this->load->view('cetak_datamenjahit',$isi);
	}
	public function cetak_mengemudi(){
		$this->load->helper('pdf_helper');
		$this->load->view('cetak_datamengemudi',$isi);
	}
}
