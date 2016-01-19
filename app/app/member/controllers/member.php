<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class member extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->load->model('member_model');
  		$this->kacang->login();
		$menu = "master";
		$this->kacang->validasi_menu($menu);
		$submenu = "Data Siswa";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "member";
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
	public function ubah_status($jns=Null,$id=Null){
		if($jns=="aktif"){
			$data = array('status'=>'0');
		}else{
			$data = array('status'=>'1');
		}
		$this->db->where('kode_member',$id);
		$this->db->update('tbl_member_detil',$data);
	}
	public function _content(){
		$isi['kelas'] = "master";
		$isi['namamenu'] = "Data Siswa";
		$isi['page'] = "member";
		$isi['link'] = 'member';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Siswa";
		$isi['judul'] = "Halaman Data Siswa";
		$isi['content'] = "member_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function caridetil($kode=NULL){
		$ckdata = $this->db->get_where('tbl_transaksi',array('kode_member'=>$kode))->result();
		if(count($ckdata)>0){
			$ckursus = $this->db->query("SELECT tbl_subtipe.nama FROM tbl_member_detil INNER JOIN tbl_subtipe ON tbl_member_detil.id_kursus = tbl_subtipe.id WHERE tbl_member_detil.kode_member = '$kode'")->result();
			foreach ($ckursus as $key) {
				$isi['kursusna'] = $key->nama;
			}
			$isi['kode'] = $kode;
			$isi['kelas'] = "master";
			$isi['namamenu'] = "Data Siswa";
			$isi['page'] = "member";
			$isi['link'] = 'member';
			$isi['actionhapus'] = 'hapus';
			$isi['actionedit'] = 'edit';
			$isi['halaman'] = "Data Siswa";
			$isi['judul'] = "Halaman Data Siswa";
			$this->load->view("member/history_bayar",$isi);				
		}else{
			redirect('error','refresh');
		}
	}
	public function get_data(){
		$aColumns = array('kode','foto','nama','alamat','no_hp','nama_tipe','quota','status','kode');
        $sIndexColumn = "kode";
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
        $rResult = $this->member_model->data_member($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->member_model->data_total($sIndexColumn);
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
		$isi['kelas'] = "master";
		$isi['namamenu'] = "Data Siswa";
		$isi['page'] = "member";
		$isi['link'] = 'member';
		$isi['action'] = "proses_add";
		$isi['cek'] = "add";							
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal'] = 'Batal';
		$isi['halaman'] = "Data Siswa";
		$isi['judul'] = "Halaman Add Data Siswa";
		$isi['content'] = "form_add";
		$ahhhhhh = $this->db->query("SELECT SUBSTR(MAX(kode),-6) as nona FROM tbl_member")->result();
 		foreach ($ahhhhhh as $zzz) {
 			$xx = substr($zzz->nona, 3, 6); 
 		}
 		if($xx==''){
 			$newID = 'M-0001';
 		}else{
 			$noUrut = (int) substr($xx, 1, 4);
 			$noUrut++;
 			$newID = "M-" . sprintf("%04s", $noUrut);
 		}
 		$isi['kode'] = $newID;
 		$isi['option_agama'][''] = "Pilih Agama";
 		$ckagama = $this->db->get('tbl_agama')->result();
 		if(count($ckagama)>0){
 			foreach ($ckagama as $row) {
 				$isi['option_agama'][$row->id] = $row->agama;
 			}
 		}else{
 			$isi['option_agama'][''] = "Data Agama Belum Tersedia";
 		}
 		$isi['option_pendidikan'][''] = "Pilih Pendidikan Terakhir";
 		$ckpendidikan = $this->db->get('tbl_pendidikan')->result();
 		if(count($ckpendidikan)>0){
 			foreach ($ckpendidikan as $key) {
 				$isi['option_pendidikan'][$key->id] = $key->nama;
 			}
 		}else{
 			$isi['option_pendidikan'][''] = "Data Pendidikan Belum Tersedia";
 		}
 		$isi['option_pekerjaan'][''] = "Pilih Pekerjaan";
 		$ckpekerjaan = $this->db->get('tbl_pekerjaan')->result();
 		if(count($ckpekerjaan)>0){
 			foreach ($ckpekerjaan as $Xxx) {
 				$isi['option_pekerjaan'][$Xxx->id] = $Xxx->nama;
 			}
 		}else{
 			$isi['option_pekerjaan'][''] = "DAta Pekerjaan Belum Tersedia";
 		}
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
 		$isi['option_bank'][''] = "Pilih Bank";
 		$isi['option_jkartu'][''] = "Pilih Jenis Kartu";
 		$bank = $this->db->get('tbl_bank')->result();
		foreach($bank as $row){
			$isi['option_bank'][$row->kode]=$row->nama_bank;
		}
		$jkartu = $this->db->get('tbl_kartukredit')->result();
		foreach($jkartu as $row){
			$isi['option_jkartu'][$row->kode_kartu]=$row->jenis_kartu;
		}
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function proses_foto($kode){
		$ahhhhhh = $this->db->query("SELECT SUBSTR(MAX(kode),-6) as nona FROM tbl_member")->result();
 		foreach ($ahhhhhh as $zzz) {
 			$xx = substr($zzz->nona, 3, 6); 
 		}
 		if($xx==''){
 			$newID = 'M-0001';
 		}else{
 			$noUrut = (int) substr($xx, 1, 4);
 			$noUrut++;
 			$newID = "M-" . sprintf("%04s", $noUrut);
 		}
		$filename = 'foto/member/' . $newID . '.jpg';
		$input_con = file_get_contents('php://input');
		$result = file_put_contents($filename,$input_con);
		$url = base_url()  . $filename;
	}
	public function get_harga($kode){
		$data = $this->db->query("SELECT * FROM view_kursus WHERE idna = '$kode'")->result();
		if(count($data)>0){
			foreach($data as $key){
				$obeng  = $key->h_daftar . "|" . $key->h_pokok;
			}	
		}else{
			$obeng = '';
		}
		echo $obeng;
	}
	public function get_tipe($kode=NULL){
		$return = "";
		$data = $this->db->query("SELECT * FROM tbl_subtipe where id_tipe='$kode'")->result();
		if(count($data)>0){
			$return = "<option value=''class=\"form-control selectpicker\" data-size=\"10\" id=\"kls\" data-parsley-required=\"true\" data-live-search=\"true\" data-style=\"btn-white\"> Pilih Tipe Kursus </option>";
			foreach ($data as $key) {
				$return .= '<option class="form-control selectpicker" id="id_tipena" data-size="10" data-parsley-required="true" data-live-search="true" data-style="btn-white" value="' . $key->id . '">' . $key->nama . '</option>'; 
			}
		}else{
			$return .= '<option class="form-control selectpicker" data-size="10" id="id_tipena" data-parsley-required="true" data-live-search="true" data-style="btn-white" value="">Data Tipe Kursus Belum Tersedia</option>'; 
		}
		print $return;
	}
	public function proses_add(){
		$this->form_validation->set_rules('kode', 'Kode Member', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('nama', 'Nama', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('nama_ortu', 'Nama Orangtua', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('tempat', 'Tempat Lahir', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('sex', 'Jenis Kelamin', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('agama', 'Agama', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('pendidikan', 'Pendidikan', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('nope', 'No Handphone', 'htmlspecialchars|trim|required|min_length[1]|xss_clean|is_natural');
		$this->form_validation->set_rules('jenis', 'Jenis Kursus', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('tipe', 'Tipe Kursus', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('h_daftar', 'Harga Pendaftaran', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('h_pokok', 'Harga Pokok', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('subtotal', 'Subtotal', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('diskon', 'Diskon', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('totalnax', 'Total Biaya Pendidikan', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('bayar', 'Bayar', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('bayarna', 'Bayarna', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('sisa', 'Sisa', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$kode = $this->input->post('kode');
			$nama = $this->input->post('nama');
			$nama_ortu = $this->input->post('nama_ortu');
			$tempat = $this->input->post('tempat');
			$tgllahir = date("Y-m-d",strtotime($this->input->post('tgllahir')));
			$sex = $this->input->post('sex');
			$agama = $this->input->post('agama');
			$pendidikan = $this->input->post('pendidikan');
			$pekerjaan = $this->input->post('pekerjaan');
			$nope = $this->input->post('nope');
			$alamat = $this->input->post('alamat');
			$jenis = $this->input->post('jenis');
			$tipe = $this->input->post('tipe');
			$h_daftar = str_replace(".", "", $this->input->post('h_daftar'));
			$h_pokok = str_replace(".", "", $this->input->post('h_pokok'));
			$subtotal = str_replace(".", "", $this->input->post('subtotal'));
			$diskon = str_replace(".", "", $this->input->post('diskon'));
			$total = str_replace(".", "", $this->input->post('totalnax'));
			$bayarna = str_replace(".", "", $this->input->post('bayarna'));
			$sisa = str_replace(".", "", $this->input->post('sisa'));
			$cbayar = $this->input->post('bayar');
			switch($cbayar){	
				case "0":
					$namabank = "";
					$jeniskartu = "";
					$no_kartu = "";
					$bankasal = "";
					$rekasal = "";
					$banktujuan = "";
					$rektujuan = "";
					break;
				case "1":
					$namabank = $this->input->post('dbank');
					$jeniskartu = "";
					$no_kartu = $this->input->post('nokartud');
					$bankasal = "";
					$rekasal = "";
					$banktujuan = "";
					$rektujuan = "";
					break;
				case "2":
					$namabank = $this->input->post('kbank');
					$jeniskartu = $this->input->post('jkartu');
					$no_kartu = $this->input->post('nokartuk');
					$bankasal = "";
					$rekasal = "";
					$banktujuan = "";
					$rektujuan = "";
					break;
				case "3" :
					$namabank = "";
					$jeniskartu = "";
					$no_kartu = "";
					$bankasal = $this->input->post('tbanka');
					$rekasal = $this->input->post('reka');
					$banktujuan = $this->input->post('tbankb');
					$rektujuan = $this->input->post('rekb');
					break;
			}
			$member = array('kode'=>$kode,
				'nama'=>$nama,
				'jns_kel'=>$sex,
				'nama_ortu'=>$nama_ortu,
				'tempat_lahir'=>$tempat,
				'tgl_lahir'=>$tgllahir,
				'alamat'=>$alamat,
				'no_hp'=>$nope,
				'foto'=>$kode . ".jpg",
				'id_agama'=>$agama,
				'id_pendidikan'=>$pendidikan,
				'id_pekerjaan'=>$pekerjaan);
			$this->db->insert('tbl_member',$member);
			$ckquota = $this->db->get_where('tbl_subtipe',array('id'=>$tipe))->result();
			foreach ($ckquota as $ooo) {
				$quota = $ooo->pertemuan;
			}
			$detil = array('kode_member'=>$kode,
				'id_kursus'=>$tipe,
				'mulai'=>date('Y-m-d H:i:s'),
				'status'=>'1',
				'quota'=>$quota,
				'ket'=>'-');
			$this->db->insert('tbl_member_detil',$detil);
			$tran = "MREG-" . date("ymdhis");
			$regmember = array('kode_reg'=>$tran,
				'tgl_reg'=>date('Y-m-d'),
				'kode_member'=>$kode,
				'total'=>$subtotal,
				'discount'=>$diskon,
				'totalbersih'=>$total,
				'carabayar'=>$cbayar,
				'nama_bank'=>$namabank,
				'jenis_kartu'=>$jeniskartu,
				'nomor_kartu'=>$no_kartu,
				'bank_asal'=>$bankasal,
				'rek_asal'=>$rekasal,
				'bank_tujuan'=>$banktujuan,
				'rek_tujuan'=>$rektujuan,
				'post'=>'1',
				'operator'=>$this->session->userdata('kode'),
				'status'=>'1');
			$this->db->insert('tbl_registermember',$regmember);
			$regdetil = array('kode_reg'=>$tran,
				'kode_paket'=>$tipe,
				'bayar'=>$bayarna,
				'sisa'=>$sisa);
			$this->db->insert('tbl_regmemdetil',$regdetil);
			$transaksi = array('kode_trans'=>$tran,
				'tgl_bayar'=>date("Y-m-d H:i:s"),
				'kode_member'=>$kode,
				'total'=>$total,
				'bayar'=>$bayarna,
				'sisa'=>$sisa);
			$this->db->insert('tbl_transaksi',$transaksi);
			$this->kacang->log_aktivitas('Pendaftaran Member Baru : ' . $kode,''.$this->session->userdata('kode').'','bg-blue');
			redirect('member','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function hapus($kode=NULL){
		$ckdata = $this->db->get_where('tbl_mulai',array('kode_member'=>$kode))->result();
		if(count($ckdata)>0){
			$data['say'] = "NotOk";
		}else{
			$this->hapusfoto($kode);
			$this->hapus_member($kode);
			$this->hapus_member_detil($kode);
			$ckreg = $this->db->get_where('tbl_registermember',array('kode_member'=>$kode))->result();
			foreach ($ckreg as $row) {
				$this->hapus_regmem_detil($row->kode_reg);
			}
			$this->hapus_regmem($kode);
			$this->hapus_transaksi($kode);
			$data['say'] = "ok";
		}
        if('IS_AJAX'){
		    echo json_encode($data);
		}
	}
	public function hapus_member($kode=NULL){
		$this->db->where('kode',$kode);
		$this->db->delete('tbl_member');
	}
	public function hapus_member_detil($kode=NULL){
		$this->db->where('kode_member',$kode);
		$this->db->delete('tbl_member_detil');	
	}
	public function hapus_regmem($kode){
		$this->db->where('kode_member',$kode);
		$this->db->delete('tbl_registermember');		
	}
	public function hapus_regmem_detil($kode=NULL){
		$this->db->where('kode_reg',$kode);
		$this->db->delete('tbl_regmemdetil');		
	}
	public function hapus_transaksi($kode=NULL){
		$this->db->where('kode_trans',$kode);
		$this->db->delete('tbl_transaksi');		
	}
	public function hapusfoto($kode=Null){
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		foreach ($ckdata as $hehe) {
			$fotona = $hehe->foto;
		}
		if($fotona!="no.jpg"){
			@chmod(unlink('./foto/member/' . $fotona),777);
		}
	}
	public function cekdata($kode){
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		if(count($ckdata)>0){
			$data['say'] = "ok";
		}else{
			$data['say'] = "NotOk";
		}
		if('IS_AJAX'){
		    echo json_encode($data);
		}
	}
	public function edit($kode=NULL){
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		if(count($ckdata)>0){
			$this->session->set_userdata('idna',$kode);
			$isi['kelas'] = "master";
			$isi['namamenu'] = "Data Siswa";
			$isi['page'] = "member";
			$isi['link'] = 'member';
			$isi['actionhapus'] = 'hapus';
			$isi['action'] = "../proses_edit";
			$isi['actionedit'] = 'edit';
			$isi['halaman'] = "Edit Data Siswa";
			$isi['judul'] = "Halaman Edit Data Siswa";
			$isi['tombolbatal'] = "Batal";
			$isi['tombolsimpan'] = "Simpan";
			$isi['content'] = "form_edit";
			foreach ($ckdata as $key) {
				$isi['default']['nama'] = $key->nama;
				$isi['sex'] = $key->jns_kel;
				$isi['default']['nama_ortu'] = $key->nama_ortu;
				$isi['default']['tgllahir'] = date("d-m-Y",strtotime($key->tgl_lahir));
				$isi['default']['tempat'] = $key->tempat_lahir;
				$isi['default']['alamat'] = $key->alamat;
				$isi['default']['nope'] = $key->no_hp;
				$agm = $key->id_agama;
				$ckagama = $this->db->get_where('tbl_agama',array('id'=>$agm))->result();
				if(count($ckagama)>0){
					foreach ($ckagama as $row) {
						$isi['option_agama'][$agm] = $row->agama;
					}
				}else{
					$isi['option_agama'][''] = "Data Agama Tidak Tersedia";
				}
				$pdk = $key->id_pendidikan;
				$ckpendidikan = $this->db->get_where('tbl_pendidikan',array('id'=>$pdk))->result();
				if(count($ckpendidikan)>0){
					foreach ($ckpendidikan as $oo) {
						$isi['option_pendidikan'][$pdk] = $oo->nama;
					}
				}else{
					$isi['option_pendidikan'][''] = "Data Pendidikan Tidak Tersedia";
				}
				$krj = $key->id_pekerjaan;
				$ckpekerjaan = $this->db->get_where('tbl_pekerjaan',array('id'=>$krj))->result();
				if(count($ckpekerjaan)>0){
					foreach ($ckpekerjaan as $key1) {
						$isi['option_pekerjaan'][$krj] = $key1->nama;						
					}
				}else{
					$isi['option_pekerjaan'][''] = "Data Pekerjaan Belum Tersedia";
				}
			}
			$ckpendidikan = $this->db->get('tbl_pendidikan')->result();
	 		if(count($ckpendidikan)>0){
	 			foreach ($ckpendidikan as $key) {
	 				$isi['option_pendidikan'][$key->id] = $key->nama;
	 			}
	 		}else{
	 			$isi['option_pendidikan'][''] = "Data Pendidikan Belum Tersedia";
	 		}
			$agama = $this->db->get('tbl_agama')->result();
			if(count($agama)>0){
				foreach ($agama as $xxxx) {
					$isi['option_agama'][$xxxx->id] = $xxxx->agama;
				}
			}else{
				$isi['option_agama'][''] = "Data Agama Tidak Tersedia";
			}
			$ckpekerjaan = $this->db->get('tbl_pekerjaan')->result();
	 		if(count($ckpekerjaan)>0){
	 			foreach ($ckpekerjaan as $Xxx) {
	 				$isi['option_pekerjaan'][$Xxx->id] = $Xxx->nama;
	 			}
	 		}else{
	 			$isi['option_pekerjaan'][''] = "DAta Pekerjaan Belum Tersedia";
	 		}
			$this->load->view("dashboard/dashboard_view",$isi);		
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$nama = $this->input->post('nama');
		$nama_ortu = $this->input->post('nama_ortu');
		$tempat = $this->input->post('tempat');
		$tgl = date("Y-m-d",strtotime($this->input->post('tgllahir')));
		$sex = $this->input->post('sex');
		$alamat = $this->input->post('alamat');
		$agama = $this->input->post('agama');
		$pendidikan = $this->input->post('pendidikan');
		$pekerjaan = $this->input->post('pekerjaan');
		$nope = $this->input->post('nope');
		$update = array('nama'=>$nama,
			'jns_kel'=>$sex,
			'nama_ortu'=>$nama_ortu,
			'tempat_lahir'=>$tempat,
			'tgl_lahir'=>$tgl,
			'alamat'=>$alamat,
			'no_hp'=>$nope,
			'id_agama'=>$agama,
			'id_pendidikan'=>$pendidikan,
			'id_pekerjaan'=>$pekerjaan);
		$this->db->where('kode',$this->session->userdata('idna'));
		$this->db->update('tbl_member',$update);
		$this->session->unset_userdata('idna');
		redirect('member','refresh');
	}
	public function cetak_absen($kode){
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		if(count($ckdata)>0){
			$isi['kode'] = $kode;
			$this->load->helper('pdf_helper');
			$this->load->view('cetak_absen',$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function cetak_bayar($kode){
		$ckdata = $this->db->get_where('tbl_member',array('kode'=>$kode))->result();
		if(count($ckdata)>0){
			$isi['kode'] = $kode;
			$this->load->helper('pdf_helper');
			$this->load->view('cetak_bayar',$isi);
		}else{
			redirect('error','refresh');
		}
	}
}
