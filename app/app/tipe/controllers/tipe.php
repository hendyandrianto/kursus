<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class tipe extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->load->model('tipe_model');
  		$this->kacang->login();
		$menu = "ref_data";
		$this->kacang->validasi_menu($menu);
		$submenu = "Tipe Kursus";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "tipe";
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
		$isi['kelas'] = "ref_data";
		$isi['namamenu'] = "Tipe Kursus";
		$isi['page'] = "tipe";
		$isi['link'] = 'tipe';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Tipe Kursus";
		$isi['judul'] = "Halaman Data Tipe Kursus";
		$isi['content'] = "tipe_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function get_data(){
		$aColumns = array('idna','nama','nama_subtipe','h_daftar','h_pokok','durasi','pertemuan','expired','idna');
        $sIndexColumn = "idna";
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
        }
        $numbering = mysql_real_escape_string( $_GET['iDisplayStart'] );
        $page = 1;
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                    $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                        ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
                }
            }            
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" ){
                $sOrder = "";
            }
        }
        $sWhere = "";
        if ( $_GET['sSearch'] != "" ){
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
                if ( $sWhere == "" ){
                    $sWhere = "WHERE ";
                }
                else{
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            }
        }
        $rResult = $this->tipe_model->data($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->tipe_model->data_total($sIndexColumn);
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                if($i < 1)
                    $row[] = $numbering+$page.'|'.$aRow[ $aColumns[$i] ];
                else
                    $row[] = $aRow[ $aColumns[$i] ];
            }
            $page++;
            $output['aaData'][] = $row;
        }
        echo json_encode( $output );
	}
	public function add(){
		$isi['kelas'] = "ref_data";
		$isi['namamenu'] = "Tipe Kursus";
		$isi['page'] = "tipe";
		$isi['link'] = 'tipe';
		$isi['action'] = "proses_add";
		$isi['cek'] = "add";							
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal'] = 'Batal';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Tipe Kursus";
		$isi['judul'] = "Halaman Add Data Tipe Kursus";
		$isi['option_jenis'][''] = "Pilih Jenis Kursus";
		$ckdata = $this->db->get('tbl_tipe')->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $key) {
				$isi['option_jenis'][$key->id] = $key->nama;
			}
		}else{
			$isi['option_jenis'][''] = "Jenis Kursus Belum Tersedia";
		}
		$isi['content'] = "form_add";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function proses_add(){
		$this->form_validation->set_rules('jenis', 'Jenis Kursus', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('tipe', 'Tipe Kursus', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('h_daftar', 'Harga Pendaftaran', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('h_pokok', 'Harga Pokok', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('durasi', 'Durasi', 'htmlspecialchars|trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('pertemuan', 'Pertemuan', 'htmlspecialchars|trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('expire', 'Expire', 'htmlspecialchars|trim|required|xss_clean|is_natural');
		if($this->form_validation->run() == TRUE){
			$jenis = $this->input->post('jenis');
			$tipe = $this->input->post('tipe');
			$expire = $this->input->post('expire');
			$h_daftar = str_replace(".", "", $this->input->post('h_daftar'));
			$h_pokok = str_replace(".", "", $this->input->post('h_pokok'));
			$durasi = $this->input->post('durasi');
			$pertemuan = $this->input->post('pertemuan');
			$simpan = array('id_tipe'=>$jenis,
				'nama'=>$tipe,
				'ket'=>'',
				'h_daftar'=>$h_daftar,
				'h_pokok'=>$h_pokok,
				'durasi'=>$durasi,
				'pertemuan'=>$pertemuan,
				'expired'=>$expire);
			$this->db->insert('tbl_subtipe',$simpan);
			redirect('tipe','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function hapus($kode=Null){
		$ckdata = $this->db->get_where('tbl_subtipe',array('id_tipe'=>$kode))->result();
		if(count($ckdata)>0){
			$data['say'] = "NotOk";
		}else{
			$this->db->where('id',$kode);
			if($this->db->delete('tbl_tipe')){
				$data['say'] = "ok";
			}else{
				$data['say'] = "NotOk";
			}
		}
		if('IS_AJAX'){
		    echo json_encode($data); //echo json string if ajax request
		}  	
	}
	public function cekdata($kode=Null){
		$ckdata = $this->db->get_where('view_kursus',array('idna'=>$kode))->result();
		if(count($ckdata)>0){
			$data['say'] = "ok";
		}else{
			$data['say'] = "NotOk";
		}
		if('IS_AJAX'){
		    echo json_encode($data);
		}  	
	}
	public function edit($kode=Null){
		$ckdata = $this->db->get_where('view_kursus',array('idna'=>$kode))->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $key) {
				$isi['option_jenis'][$key->id] = $key->nama;
				$isi['default']['tipe'] = $key->nama_subtipe;
				$isi['default']['h_daftar'] = $key->h_daftar;
				$isi['default']['h_pokok'] = $key->h_pokok;
				$isi['default']['durasi'] = $key->durasi;
				$isi['default']['pertemuan'] = $key->pertemuan;
				$isi['default']['expire'] = $key->expired;
			}
			$this->session->set_userdata('idna',$kode);
			$ckdata = $this->db->get('tbl_tipe')->result();
			if(count($ckdata)>0){
				foreach ($ckdata as $key) {
					$isi['option_jenis'][$key->id] = $key->nama;
				}
			}else{
				$isi['option_jenis'][''] = "Jenis Kursus Belum Tersedia";
			}
			$isi['kelas'] = "ref_data";
			$isi['namamenu'] = "Tipe Kursus";
			$isi['page'] = "tipe";
			$isi['link'] = 'tipe';
			$isi['cek'] = 'edit';
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['judul'] = "Halaman Edit Data Tipe Kursus";
			$isi['content'] = "form_add";
			$isi['halaman'] = "Edit Data Tipe Kursus";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('jenis', 'Jenis Kursus', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('tipe', 'Tipe Kursus', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('h_daftar', 'Harga Pendaftaran', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('h_pokok', 'Harga Pokok', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('durasi', 'Durasi', 'htmlspecialchars|trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('pertemuan', 'Pertemuan', 'htmlspecialchars|trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('expire', 'Expire', 'htmlspecialchars|trim|required|xss_clean|is_natural');
		if($this->form_validation->run() == TRUE){
			$jenis = $this->input->post('jenis');
			$tipe = $this->input->post('tipe');
			$expire = $this->input->post('expire');
			$h_daftar = str_replace(".", "", $this->input->post('h_daftar'));
			$h_pokok = str_replace(".", "", $this->input->post('h_pokok'));
			$durasi = $this->input->post('durasi');
			$pertemuan = $this->input->post('pertemuan');
			$simpan = array('id_tipe'=>$jenis,
				'nama'=>$tipe,
				'ket'=>'',
				'h_daftar'=>$h_daftar,
				'h_pokok'=>$h_pokok,
				'durasi'=>$durasi,
				'pertemuan'=>$pertemuan,
				'expired'=>$expire);
			$this->db->where('id',$this->session->userdata('idna'));
			$this->db->update('tbl_subtipe',$simpan);
			$this->session->unset_userdata('idna');
			redirect('tipe','refresh');
		}else{
			redirect('error','refresh');
		}
	}
}
