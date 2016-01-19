<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Migrasi extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->kacang->login();
		$menu = "trans";
		$this->kacang->validasi_menu($menu);
		$submenu = "Migrasi Kursus";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "migrasi";
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
		$isi['namamenu'] = "Migrasi Kursus";
		$isi['page'] = "migrasi";
		$isi['link'] = 'migrasi';
		$isi['option_jenis'][''] = "Pilih Jenis Kursus";
 		$ckkjenis = $this->db->get('tbl_tipe')->result();
 		if(count($ckkjenis)>0){
 			foreach ($ckkjenis as $row) {
 				$isi['option_jenis'][$row->id] = $row->nama;
 			}
 		}else{
 			$isi['option_jenis'][''] = "Data Jenis Kursus Belum Tersedia";
 		}
 		$isi['option_tipe'][''] = "Pilih Tipe Kursus";
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['action'] = "proses_migrasi";
		$isi['tombolsimpan'] = "Simpan";
		$isi['tombolbatal'] = "Batal";
		$isi['halaman'] = "Data Migrasi Kursus";
		$isi['judul'] = "Halaman Data Migrasi Kursus";
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
	public function get_tipe($kode=NULL){
		$return = "";
		$data = $this->db->query("SELECT * FROM tbl_subtipe where id_tipe='$kode'")->result();
		if(count($data)>0){
			$return = "<option value=''class=\"form-control selectpicker\" data-size=\"10\" id=\"kls\" data-parsley-required=\"true\" data-live-search=\"true\" data-style=\"btn-white\"> Pilih Tipe Kursus </option>";
			foreach ($data as $key) {
				$return .= '<option class="form-control selectpicker" name="tipe_na" id="id_tipena" data-size="10" data-parsley-required="true" data-live-search="true" data-style="btn-white" value="' . $key->id . '">' . $key->nama . '</option>'; 
			}
		}else{
			$return .= '<option class="form-control selectpicker" data-size="10" id="id_tipena" data-parsley-required="true" data-live-search="true" data-style="btn-white" value="">Data Tipe Kursus Belum Tersedia</option>'; 
		}
		print $return;
	}
	function proses_migrasi(){
		$kodetran = "MRAN-" . date("ymdhis");
		$kode = $this->input->post('kode');
		$tgl_bayar = date("Y-m-d H:i:s");
		$bayar = str_replace(".", "", $this->input->post('bayar'));
		$sisa = str_replace(".", "", $this->input->post('sisa'));
		$data = array('kode_trans'=>$kodetran,
			'kode_member'=>$kode,
			'tgl_bayar'=>$tgl_bayar,
			'bayar'=>"0",
			'sisa'=>$sisa);
		$this->db->insert('tbl_transaksi',$data);
		$edit = array('id_kursus'=>$this->input->post('tipe_na'));
		$this->kacang->log_aktivitas('Migrasi Member : ' . $kode,''.$this->session->userdata('kode').'','bg-blue');	
		$this->db->where('kode_member',$kode);
		$this->db->update('tbl_member_detil',$edit);
		redirect('migrasi','refresh');
	}
}
