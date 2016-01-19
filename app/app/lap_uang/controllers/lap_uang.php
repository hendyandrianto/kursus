<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lap_uang extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->kacang->login();
		$menu = "laporan";
		$this->kacang->validasi_menu($menu);
		$submenu = "Laporan Keuangan";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "lap_uang";
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
		$isi['namamenu'] = "Laporan Keuangan";
		$isi['page'] = "lap_uang";
		$isi['link'] = 'lap_uang';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Laporan Keuangan";
		$isi['judul'] = "Halaman Laporan Keuangan";
		$isi['content'] = "lap_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function cekdata($tgl=NULL){
		$data['say'] = "ok";
		if('IS_AJAX'){
		    echo json_encode($data); //echo json string if ajax request
		}
	}
	public function cek_data($mulai=NULL,$selesai=NULL){
		$data['say'] = "ok";
		if('IS_AJAX'){
		    echo json_encode($data); //echo json string if ajax request
		}
	}
	public function perperiode($mulai=NULL,$selesai=NULL,$tipe=NULL){
		$this->load->helper('pdf_helper');
		$isi['awal'] = $mulai;
		$isi['akhir'] = $selesai;
		$isi['tipe'] = $tipe;
		$this->load->view('cetak_perperiodena',$isi);
	}
	public function pertanggal($tgl=NULL,$tipe=NULL){
		$this->load->helper('pdf_helper');
		$isi['tgl'] = $tgl;
		$isi['tipe'] = $tipe;
		$this->load->view('cetak_pertanggalna',$isi);
	}
}
