<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Alert extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('alert_model');
  		$this->kacang->login();
		$menu = "trans";
		$this->kacang->validasi_menu($menu);
		$submenu = "Alert Tagihan";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "alert";
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
		$isi['namamenu'] = "Alert Tagihan";
		$isi['page'] = "alert";
		$isi['link'] = 'alert';
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
		$isi['action'] = "proses_alert";
		$isi['tombolsimpan'] = "Simpan";
		$isi['tombolbatal'] = "Batal";
		$isi['halaman'] = "Data Alert Tagihan";
		$isi['judul'] = "Halaman Data Alert Tagihan";
		$isi['content'] = "alert_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function get_data(){
		$aColumns = array('id','nama','ket','tgl_mulai','tgl_selesai','id');
        $sIndexColumn = "id";
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
        $rResult = $this->alert_model->data($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->alert_model->data_total($sIndexColumn);
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
		$isi['namamenu'] = "Data Alert Tagihan Siswa";
		$isi['kelas'] = "trans";
		$isi['namamenu'] = "Alert Tagihan";
		$isi['page'] = "alert";
		$isi['link'] = "alert";
		$isi['tombolsimpan'] = "Simpan";
		$isi['tombolbatal'] = "Batal";
		$isi['option_pegawai'][''] = "Pilih Siswa";
		$thn = $this->session->userdata('id_thn_sess');
		$datpeg = $this->db->query("SELECT nama,nama_tipe,kode FROM view_member_kursus")->result();
		if(count($datpeg)>0){
			foreach ($datpeg as $row) {
				$isi['option_pegawai'][$row->kode] = "Nama : " . $row->nama . "  " . " Kelas : " . $row->nama_tipe; 
			}
		}else{
			$isi['option_pegawai'][''] = "Data Siswa Tidak Ditemukan";
		}
		$isi['action'] = "proses_add";
		$isi['halaman'] = "Add Data Alert Tagihan Siswa";
		$isi['judul'] = "Halaman Add Data Alert Tagihan Siswa";
		$isi['content'] = "alert/form_alert";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function proses_add(){
		$this->form_validation->set_rules('pegawai','Pegawai','required');
		$this->form_validation->set_rules('ket','Keterangan','required');
		$this->form_validation->set_rules('mulai','Mulai','required');
		$this->form_validation->set_rules('selesai','Selesai','required');
		if ($this->form_validation->run() == TRUE){
			date_default_timezone_set('Asia/Jakarta');
			$nip = $this->antiinjection($this->input->post('pegawai'));
			$ckguru = $this->db->query("SELECT * FROM view_member_kursus WHERE kode = '$nip'")->result();
			foreach ($ckguru as $hmm){
				$nmguru = $hmm->nama . " " . $hmm->nama_tipe;
			}
			$class = 'bg-red';
			$ket = $this->antiinjection($this->input->post('ket'));
			$mulai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('mulai'))));
			$selesai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('selesai'))));
			$startx = new DateTIme($mulai);
			$endx = new DateTime($selesai);
			$lama = $endx->diff($startx);
			$lama = $lama->format("%d")+1;
			$event = array('kode'=>$nip,
				'tgl_mulai'=>$mulai,
				'jns'=>"",
				'kode'=>$nip,
				'ket'=>$nmguru . ' - ' . $ket,
				'className'=>$class,
				'tgl_selesai'=>$selesai,
				'lama'=>$lama,
				'dibuat_oleh'=>$this->session->userdata('kode'),
				'tanggal'=>date("Y-m-d"),
				'bulan'=>date("m",strtotime($selesai)),
				'status_tagihan'=>'1');
			$this->db->insert('tbl_alert',$event);
			// $this->kacang->batas('Tagihan Member : ' . $hmm->nama ,''.$this->session->userdata('kode').'',$newdate,'bg-red');	
			redirect ('alert','refresh');	
		}else{			
			redirect('alert/add');
		}
	}
	public function getdata(){
		$hmm = $this->db->query("SELECT tgl_mulai as start,tgl_selesai as end,ket as title,jns,kode,className FROM tbl_alert")->result_array();
		if('IS_AJAX'){
			echo json_encode($hmm);
		}
	}
	public function hapus($kode=Null){
		$ckdata = $this->db->query("SELECT * FROM tbl_alert WHERE id = '$kode'")->result();
		if(count($ckdata)>0){
			$this->db->where('id',$kode);
			if($this->db->delete('tbl_alert')){
				$data['say'] = "ok";
			}else{
				$data['say'] = "NotOk";
			}
		}else{
			$data['say'] = "NotOk";
		}
		if('IS_AJAX'){
		    echo json_encode($data); //echo json string if ajax request
		}  	
	}
	public function cekdata($kode=Null){
		$ckdata = $this->db->get_where('tbl_alert',array('id'=>$this->antiinjection($kode)))->result();
		if(count($ckdata)>0){
			$data['say'] = "ok";
		}else{
			$data['say'] = "NotOk";
		}
		if('IS_AJAX'){
		    echo json_encode($data); //echo json string if ajax request
		}  	
	}
	public function edit($kode=Null){
		$ckdata = $this->db->get_where('tbl_alert',array('id'=>$this->antiinjection($kode)))->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $ckk) {
				$nip = $this->antiinjection($ckk->kode);
				$ckguru = $this->db->query("SELECT nama,nama_tipe,kode FROM view_member_kursus WHERE kode = '$nip'")->result();
				if(count($ckguru)>0){
					foreach ($ckguru as $row) {
						$isi['option_pegawai'][$nip] = "Nama Siswa : " . $row->nama . "  " . " Tipe Kursus : " . $row->nama_tipe; 
					}
				}else{
					$isi['option_pegawai'][$nip] = "Data Siswa Tidak Ditemukan";
				}
				$tes = explode("- ", $ckk->ket);
				$isi['default']['ket'] = $tes[1];
				$isi['default']['id'] = $ckk->id;
				$isi['default']['mulai'] = date("d-m-Y",strtotime($ckk->tgl_mulai));
				$isi['default']['selesai'] = date("d-m-Y",strtotime($ckk->tgl_selesai));
			}
			$datpeg = $this->db->query("SELECT nama,nama_tipe,kode FROM view_member_kursus")->result();
			if(count($datpeg)>0){
				foreach ($datpeg as $row) {
					$isi['option_pegawai'][$row->kode] = "Nama : " . $row->nama . "  " . " Tipe Kursus : " . $row->nama_tipe; 
				}
			}else{
				$isi['option_pegawai'][''] = "Data Siswa Tidak Ditemukan";
			}
			$this->session->set_userdata('idna',$kode);
			$isi['kelas'] = "trans";
			$isi['namamenu'] = "Alert Tagihan";
			$isi['page'] = "alert";
			$isi['link'] = "alert";
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['halaman'] = "Edit Data Alert Tagihan Siswa";
			$isi['judul'] = "Halaman Edit Data Alert Tagihan Siswa";
			$isi['content'] = "alert/form_alert";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('pegawai','Pegawai','required');
		$this->form_validation->set_rules('ket','Keterangan','required');
		$this->form_validation->set_rules('mulai','Mulai','required');
		$this->form_validation->set_rules('selesai','Selesai','required');
		if ($this->form_validation->run() == TRUE){
			date_default_timezone_set('Asia/Jakarta');
			$nip = $this->antiinjection($this->input->post('pegawai'));
			$ckguru = $this->db->query("SELECT * FROM view_member_kursus WHERE kode = '$nip'")->result();
			foreach ($ckguru as $hmm){
				$nmguru = $hmm->nama . " " . $hmm->nama_tipe;
			}
			$class = 'bg-red';
			$ket = $this->antiinjection($this->input->post('ket'));
			$mulai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('mulai'))));
			$selesai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('selesai'))));
			$startx = new DateTIme($mulai);
			$endx = new DateTime($selesai);
			$lama = $endx->diff($startx);
			$lama = $lama->format("%d")+1;
			$event = array('kode'=>$nip,
				'tgl_mulai'=>$mulai,
				'jns'=>"",
				'kode'=>$nip,
				'ket'=>$nmguru . ' - ' . $ket,
				'className'=>$class,
				'tgl_selesai'=>$selesai,
				'lama'=>$lama,
				'dibuat_oleh'=>$this->session->userdata('kode'),
				'tanggal'=>date("Y-m-d"),
				'bulan'=>date("m",strtotime($selesai)));
			$this->db->where('id',$this->session->userdata('idna'));
			$this->db->update('tbl_alert',$event);
			// $this->kacang->batas('Edit Tagihan Member : ' . $nama ,''.$this->session->userdata('kode').'',$newdate,'bg-red');	
			$this->session->unset_userdata('idna');
			redirect ('alert','refresh');	
		}else{			
			$this->add();
		}
	}
}
