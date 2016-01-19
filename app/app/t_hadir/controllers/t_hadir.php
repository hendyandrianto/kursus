<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class t_hadir extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('t_hadir_model');
  		$this->kacang->login();
		$menu = "trans";
		$this->kacang->validasi_menu($menu);
		$submenu = "Ketidakhadiran";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "t_hadir";
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
		$isi['namamenu'] = "Ketidakhadiran";
		$isi['page'] = "t_hadir";
		$isi['link'] = 't_hadir';
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
		$isi['action'] = "proses_t_hadir";
		$isi['tombolsimpan'] = "Simpan";
		$isi['tombolbatal'] = "Batal";
		$isi['halaman'] = "Data Ketidakhadiran";
		$isi['judul'] = "Halaman Data Ketidakhadiran";
		$isi['content'] = "t_hadir_view";
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
        $rResult = $this->t_hadir_model->data($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->t_hadir_model->data_total($sIndexColumn);
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
		$isi['namamenu'] = "Data Ketidakhadiran Siswa";
		$isi['kelas'] = "trans";
		$isi['namamenu'] = "Ketidakhadiran";
		$isi['page'] = "t_hadir";
		$isi['link'] = "t_hadir";
		$isi['tombolsimpan'] = "Simpan";
		$isi['tombolbatal'] = "Batal";
		$isi['option_thadir'][''] = "Pilih Jenis Ketidakhadiran";
		$cjns = $this->db->get_where('tbl_jenis_ketidakhadiran')->result();
		if(count($cjns)>0){
			foreach ($cjns as $rows) {
				$isi['option_thadir'][$rows->id] = $rows->ket;
			}
		}else{
			$isi['option_thadir'][""] = "Jenis Ketidakhadiran Tidak Tersedia";
		}
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
		$isi['halaman'] = "Add Data Ketidakhadiran Siswa";
		$isi['judul'] = "Halaman Add Data Ketidakhadiran Siswa";
		$isi['content'] = "t_hadir/form_thadir";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function proses_add(){
		$this->form_validation->set_rules('pegawai','Pegawai','required');
		$this->form_validation->set_rules('thadir','Jenis Ketidakhadiran','required');
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
			$jns = $this->antiinjection($this->input->post('thadir'));
			if($jns=='1'){
				$class = 'bg-orange';
			}else if($jns=='2'){
				$class = 'bg-red';
			}else{
				$class = 'bg-blue';
			}
			$ket = $this->antiinjection($this->input->post('ket'));
			$mulai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('mulai'))));
			$selesai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('selesai'))));
			$startx = new DateTIme($mulai);
			$endx = new DateTime($selesai);
			$lama = $endx->diff($startx);
			$lama = $lama->format("%d")+1;
			$event = array('kode'=>$nip,
				'tgl_mulai'=>$mulai,
				'jns'=>$jns,
				'kode'=>$nip,
				'ket'=>$nmguru . ' - ' . $ket,
				'className'=>$class,
				'tgl_selesai'=>$selesai,
				'lama'=>$lama,
				'dibuat_oleh'=>$this->session->userdata('kode'),
				'tanggal'=>date("Y-m-d"),
				'bulan'=>date("m",strtotime($selesai)));
			$this->db->insert('tbl_ketidakhadiran',$event);
			$ckdata = $this->db->query("SELECT view_kursus.expired,view_member.nama FROM view_member INNER JOIN view_kursus ON view_member.id_kursus = view_kursus.idna WHERE view_member.kode = '$nip' LIMIT 0,1")->result();
			foreach ($ckdata as $row) {
				$batas = $row->expired;
				$nama = $row->nama;
			}
			$newdate = date('Y-m-d', strtotime('+'.$batas.' days', strtotime($selesai)));
			$ckdata = $this->db->get_where('tbl_batas',array('kode_member'=>$nip))->result();
			if(count($ckdata)>0){
				$simpanex = array('tgl_expired'=>$newdate,
					'status'=>'1');
				$this->db->where('kode_member',$nip);
				$this->db->update('tbl_batas',$simpanex);
			}else{
				$simpanex = array('kode_member'=>$nip,
					'tgl_expired'=>$newdate,
					'status'=>'1');
				$this->db->insert('tbl_batas',$simpanex);
			}
			$this->kacang->batas('Batas Expired Member : ' . $nama ,''.$this->session->userdata('kode').'',$newdate,'bg-red');	
			redirect ('t_hadir','refresh');	
		}else{			
			redirect('t_hadir/add');
		}
	}
	public function getdata(){
		$hmm = $this->db->query("SELECT tgl_mulai as start,tgl_selesai as end,ket as title,jns,kode,className FROM tbl_ketidakhadiran")->result_array();
		if('IS_AJAX'){
			echo json_encode($hmm);
		}
	}
	public function hapus($kode=Null){
		$ckdata = $this->db->query("SELECT * FROM tbl_ketidakhadiran WHERE id = '$kode'")->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $key) {
				$kodex = $key->kode;
				$selesai = $key->tgl_selesai;
			}
			$ckdatax = $this->db->query("SELECT view_kursus.expired,view_member.nama FROM view_member INNER JOIN view_kursus ON view_member.id_kursus = view_kursus.idna WHERE view_member.kode = '$kodex' LIMIT 0,1")->result();
			foreach ($ckdatax as $row) {
				$batas = $row->expired;
				$nama = $row->nama;
			}
			$newdate = date('Y-m-d', strtotime('-'.$batas.' days', strtotime($selesai)));
			$ckdata = $this->db->get_where('tbl_batas',array('kode_member'=>$kodex))->result();
			if(count($ckdata)>0){
				$simpanex = array('tgl_expired'=>$newdate,
					'status'=>'1');
				$this->db->where('kode_member',$kodex);
				$this->db->update('tbl_batas',$simpanex);
			}else{
				$simpanex = array('kode_member'=>$kodex,
					'tgl_expired'=>$newdate,
					'status'=>'1');
				$this->db->insert('tbl_batas',$simpanex);
			}
			$this->kacang->batas('Batas Expired Member : ' . $nama ,''.$this->session->userdata('kode').'',$newdate,'bg-red');	
			$this->db->where('id',$kode);
			if($this->db->delete('tbl_ketidakhadiran')){
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
		$ckdata = $this->db->get_where('tbl_ketidakhadiran',array('id'=>$this->antiinjection($kode)))->result();
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
		$ckdata = $this->db->get_where('tbl_ketidakhadiran',array('id'=>$this->antiinjection($kode)))->result();
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
				$jns = $this->antiinjection($ckk->jns);
				$ckjns = $this->db->query("SELECT * FROM tbl_jenis_ketidakhadiran WHERE id = '$jns'")->result();
				if(count($ckjns)>0){
					foreach ($ckjns as $tok) {
						$isi['option_thadir'][$jns] = $tok->ket;
					}
				}else{
					$isi['option_thadir'][''] = "Data Jenis Ketidakhadiran Belum Tersedia";
				}
				$tes = explode("- ", $ckk->ket);
				$isi['default']['ket'] = $tes[1];
				$isi['default']['id'] = $ckk->id;
				$isi['default']['mulai'] = date("d-m-Y",strtotime($ckk->tgl_mulai));
				$isi['default']['selesai'] = date("d-m-Y",strtotime($ckk->tgl_selesai));
			}
			$thn = $this->session->userdata('id_thn_sess');
			$datpeg = $this->db->query("SELECT nama,nama_tipe,kode FROM view_member_kursus")->result();
			if(count($datpeg)>0){
				foreach ($datpeg as $row) {
					$isi['option_pegawai'][$row->kode] = "Nama : " . $row->nama . "  " . " Tipe Kursus : " . $row->nama_tipe; 
				}
			}else{
				$isi['option_pegawai'][''] = "Data Siswa Tidak Ditemukan";
			}
			$cjns = $this->db->get_where('tbl_jenis_ketidakhadiran')->result();
			if(count($cjns)>0){
				foreach ($cjns as $rows) {
					$isi['option_thadir'][$rows->id] = $rows->ket;
				}
			}else{
				$isi['option_thadir'][""] = "Jenis Ketidakhadiran Tidak Tersedia";
			}
			$this->session->set_userdata('idna',$kode);
			$isi['kelas'] = "trans";
			$isi['namamenu'] = "Ketidakhadiran";
			$isi['page'] = "t_hadir";
			$isi['link'] = "t_hadir";
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['halaman'] = "Edit Data Ketidakhadiran Siswa";
			$isi['judul'] = "Halaman Edit Data Ketidakhadiran Siswa";
			$isi['content'] = "t_hadir/form_thadir";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('pegawai','Pegawai','required');
		$this->form_validation->set_rules('thadir','Jenis Ketidakhadiran','required');
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
			$jns = $this->antiinjection($this->input->post('thadir'));
			if($jns=='1'){
				$class = 'bg-orange';
			}else if($jns=='2'){
				$class = 'bg-red';
			}else{
				$class = 'bg-blue';
			}
			$ket = $this->antiinjection($this->input->post('ket'));
			$mulai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('mulai'))));
			$selesai = $this->antiinjection(date("Y-m-d",strtotime($this->input->post('selesai'))));
			$startx = new DateTIme($mulai);
			$endx = new DateTime($selesai);
			$lama = $endx->diff($startx);
			$lama = $lama->format("%d")+1;
			$event = array('kode'=>$nip,
				'tgl_mulai'=>$mulai,
				'jns'=>$jns,
				'kode'=>$nip,
				'ket'=>$nmguru . ' - ' . $ket,
				'className'=>$class,
				'tgl_selesai'=>$selesai,
				'lama'=>$lama,
				'dibuat_oleh'=>$this->session->userdata('kode'),
				'tanggal'=>date("Y-m-d"),
				'bulan'=>date("m",strtotime($selesai)));
			$this->db->where('id',$this->session->userdata('idna'));
			$this->db->update('tbl_ketidakhadiran',$event);
			$ckdata = $this->db->get_where('tbl_ketidakhadiran',array('id'=>$this->session->userdata('idna')))->result();
			foreach ($ckdata as $key) {
				$kodex = $key->kode;
			}
			$ckdatax = $this->db->query("SELECT view_kursus.expired,view_member.nama FROM view_member INNER JOIN view_kursus ON view_member.id_kursus = view_kursus.idna WHERE view_member.kode = '$kodex' LIMIT 0,1")->result();
			foreach ($ckdatax as $row) {
				$batas = $row->expired;
				$nama = $row->nama;
			}
			$newdate = date('Y-m-d', strtotime('+'.$batas.' days', strtotime($selesai)));
			$ckdata = $this->db->get_where('tbl_batas',array('kode_member'=>$kodex))->result();
			if(count($ckdata)>0){
				$simpanex = array('tgl_expired'=>$newdate,
					'status'=>'1');
				$this->db->where('kode_member',$kodex);
				$this->db->update('tbl_batas',$simpanex);
			}else{
				$simpanex = array('kode_member'=>$kodex,
					'tgl_expired'=>$newdate,
					'status'=>'1');
				$this->db->insert('tbl_batas',$simpanex);
			}
			$this->kacang->batas('Batas Expired Member : ' . $nama ,''.$this->session->userdata('kode').'',$newdate,'bg-red');	
			$this->session->unset_userdata('idna');
			redirect ('t_hadir','refresh');	
		}else{			
			$this->add();
		}
	}
}
