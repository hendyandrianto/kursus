<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cetak extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->kacang->login();
		$menu = "trans";
		$this->kacang->validasi_menu($menu);
		$submenu = "Cetak Izajah";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "cetak";
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
		$isi['kelas'] = "trans";
		$isi['namamenu'] = "Cetak Izajah";
		$isi['page'] = "cetak";
		$isi['link'] = 'cetak';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['action'] = "proses_bayar";
		$isi['tombolsimpan'] = "Bayar";
		$isi['tombolbatal'] = "Batal";
		$isi['halaman'] = "Data Cetak Izajah";
		$isi['judul'] = "Halaman Data Cetak Izajah";
		$isi['option_prestasi'][''] = "Pilih Prestasi";
		$ckprestasi = $this->db->get('tbl_status_izajah')->result();
		foreach ($ckprestasi as $row) {
			$isi['option_prestasi'][$row->id] = $row->status;
		}
		$isi['content'] = "form_add";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	function get_member(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$query = $this->db->query("SELECT tbl_member.kode,tbl_member.nama,tbl_member.foto,tbl_subtipe.nama as nama_tipe,tbl_member_detil.id_kursus,tbl_transaksi.sisa FROM tbl_member INNER JOIN tbl_member_detil ON tbl_member.kode = tbl_member_detil.kode_member INNER JOIN tbl_subtipe ON tbl_member_detil.id_kursus = tbl_subtipe.id INNER JOIN tbl_transaksi ON tbl_member.kode = tbl_transaksi.kode_member WHERE tbl_member.nama LIKE '$keyword%' ORDER BY tbl_transaksi.tgl_bayar DESC LIMIT 0,1")->result();
		if( ! empty($query) ){
		    $data['response'] = 'true';
		    $data['message'] = array();
		    foreach( $query as $row ){
                $data['message'][] = array('id'=>$row->kode,
                    'value' => $row->nama . " | " . $row->nama_tipe,
					'nama'=>strtoupper($row->nama),
					'foto'=>$row->foto,
					'kode'=>$row->kode,
					'nama_tipe'=>strtoupper($row->nama_tipe),
					'sisa'=>$row->sisa);
            }
		}
		if('IS_AJAX'){
            echo json_encode($data);
        }     
	}
	function cek_data(){
		$kode = $this->input->post('kode');
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		if(count($ckdata)>0){
			$data['response'] = 'true';
		}else{
			$data['response'] = 'false';
		}
		if('IS_AJAX'){
            echo json_encode($data);
        }     
	}
	function cetak_data($kode=NULL,$status=NULL,$no=NULL,$mulai=NULL,$selesai=NULL){
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		if(count($ckdata)>0){
			$isi['no'] = $no;
			$isi['kode'] = $kode;
			$isi['status'] = $status;
			$isi['mulai'] = $mulai;
			$isi['selesai'] = $selesai;
			$this->load->helper('pdf_helper');
			$this->load->view('cetak_data',$isi);
		}else{
			redirect('error','refresh');
		}
	}
}
