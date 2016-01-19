<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		$this->load->model('dashboard/dashboard_model');
		date_default_timezone_set('Asia/Jakarta');
 	}
	public function index(){
		$this->kacang->login();
		$this->_content();
	}
	public function log_activity(){
		$hmm = $this->db->query("SELECT * FROM tbl_activity")->result_array();
		if('IS_AJAX'){
			echo json_encode($hmm);
		}
	}
	public function mulai_kursus(){
		$kode = $this->input->post('kode');
		$instruktur = $this->input->post('instruktur');
		$fasilitas = $this->input->post('fasilitas');
		$ckdata = $this->db->query("SELECT * FROM tbl_member_detil INNER JOIN tbl_subtipe ON tbl_member_detil.id_kursus = tbl_subtipe.id WHERE tbl_member_detil.kode_member = '$kode'")->result();
		foreach ($ckdata as $row) {
			$idna = $row->id;
			$tip = $row->id_tipe;
		}
		$ckdata = $this->db->query("SELECT view_kursus.expired,view_member.nama FROM view_member INNER JOIN view_kursus ON view_member.id_kursus = view_kursus.idna WHERE view_member.kode = '$kode' LIMIT 0,1")->result();
		foreach ($ckdata as $row) {
			$batas = $row->expired;
			$nama = $row->nama;
		}
		$data = array('kode_member'=>$kode,
			'tgl_mulai'=>date("Y-m-d H:i:s"),
			'instruktur'=>$instruktur,
			'fasilitas'=>$fasilitas,
			'kursus'=>$idna,
			'status'=>'1',
			'id_tipe'=>$tip);
		$hari = date("Y-m-d");
		$newdate = date('Y-m-d', strtotime('+'.$batas.' days', strtotime($hari)));
		$ckdata = $this->db->get_where('tbl_batas',array('kode_member'=>$kode))->result();
		if(count($ckdata)>0){
			$simpanex = array('tgl_expired'=>$newdate,
				'status'=>'1');
			$this->db->where('kode_member',$kode);
			$this->db->update('tbl_batas',$simpanex);
		}else{
			$simpanex = array('kode_member'=>$kode,
				'tgl_expired'=>$newdate,
				'status'=>'1');
			$this->db->insert('tbl_batas',$simpanex);
		}
		$this->kacang->batas('Batas Expired Member : ' . $nama ,''.$this->session->userdata('kode').'',$newdate,'bg-red');	
		if($this->db->insert("tbl_mulai",$data)){
			$data['response'] = 'true';
		}else{
			$data['response'] = 'false';
		}
		if('IS_AJAX'){
		    echo json_encode($data);
		}  	
	}
	public function cek_expired(){
		$date = date("Y-m-d");
        $data = $this->db->query("SELECT * FROM tbl_batas WHERE tgl_expired='$date' AND status = '1'")->result();
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-users fa-fw"></i> '.count($data).' Siswa Expired Hari Ini <b class="caret"></b>
        </a>
        <ul class="dropdown-menu" role="menu">';
        $i=0;
        if(count($data)>0){
	        $cekpesan=$this->db->query("SELECT tbl_batas.kode_member,tbl_member.nama FROM tbl_batas INNER JOIN tbl_member ON tbl_batas.kode_member = tbl_member.kode WHERE tbl_batas.tgl_expired='$date' ORDER BY tbl_batas.tgl_expired DESC")->result_array();
	        if (count($cekpesan)>0){
		        foreach ($cekpesan as $row3) {
		        	$i++;
	            	echo "<li><a title=\"Click Untuk Membuat Siswa Expired\" href='". base_url() ."dashboard/set_expired/".$row3['kode_member']."'>
	                                    <span class='subject'>
										<span class='from'> ".$i." . </span>
	                                    <span class='from'>".$row3['kode_member']."</span>
	                                    <span class='time'></span>
	                                    </span>
	                                    <span class='message'>
	                                        ".substr($row3['nama'],0,100)."
	                                    </span>
		            </a></li>";
		        }
		        echo '<div hidden="hidden">
	                <audio controls="controls" autoplay="autoplay">
	                    <source src="assets/alarm.mp3" type="audio/mpeg" />
	                    <embed src="sound.mp3" />
	                </audio>
	            </div>';
	        }else{
		        echo '<li style="text-align:center"><a href="javascript:void()"> Tidak Ada Siswa Expired Hari Ini</a></li>';
	        }
        }else{
	        echo '<li style="text-align:center"><a href="javascript:void()"> Tidak Ada Siswa Expired Hari Ini</a></li>';
        }
        echo '</ul>';
	}
	public function cek_tagihan(){
		$date = date("Y-m-d");
        $data = $this->db->query("SELECT * FROM view_alert WHERE tgl_mulai >= '$date' AND tgl_selesai <= '$date' AND status_tagihan = '1'")->result_array();
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-money fa-fw"></i> '.count($data).' Tagihan Hari Ini <b class="caret"></b>
        </a>
        <ul class="dropdown-menu" role="menu">';
        $i=0;
        if (count($data)>0){
	        foreach ($data as $row3) {
	        	$i++;
            	echo "<li><a title=\"Click Jika Sudah Melakukan Penagihan\" href='". base_url() ."dashboard/set_sudahditagih/".$row3['kode']."'>
                                    <span class='subject'>
									<span class='from'> ".$i." . </span>
                                    <span class='from'>".$row3['kode']."</span>
                                    <span class='time'></span>
                                    </span>
                                    <span class='message'>
                                        ".substr($row3['ket'],0,300)."
                                    </span>
	            </a></li>";
	        }
	        echo '<div hidden="hidden">
                <audio controls="controls" autoplay="autoplay">
                    <source src="assets/alarm.mp3" type="audio/mpeg" />
                    <embed src="sound.mp3" />
                </audio>
            </div>';
        }else{
	        echo '<li style="text-align:center"><a href="javascript:void()"> Tidak Ada Tagihan Hari Ini</a></li>';
        }
        echo '</ul>';
	}
	public function set_expired($kode){
		$tgl = date('Y-m-d');
		$ckdata = $this->db->get_where('tbl_batas',array('kode_member'=>$kode,'tgl_expired'=>$tgl))->result();
		if(count($ckdata)>0){
			$data = array('status'=>'0',
				'ket'=>"Mengundurkan Diri");
			$this->db->where('kode_member',$kode);
			$this->db->update('tbl_member_detil',$data);
			$setex = array('status'=>'0');
			$this->db->where('kode_member',$kode);
			$this->db->update('tbl_batas',$setex);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('error','refresh');
		}
	}
	public function set_sudahditagih($kode){
		$tgl = date('Y-m-d');
		$ckdata = $this->db->get_where('view_alert',array('kode'=>$kode,'tanggal'=>$tgl))->result();
		if(count($ckdata)>0){
			$data = array('status_tagihan'=>'0');
			$this->db->where('kode',$kode);
			$this->db->update('tbl_alert',$data);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('error','refresh');
		}
	}
	public function selesai($id,$kode){
		$ckstok = $this->db->get_where('tbl_member_detil',array('kode_member'=>$kode))->result();
		foreach ($ckstok as $key) {
			$quota = $key->quota;
		}
		$datastok = array('quota'=>$quota-1);
		$this->db->where('kode_member',$kode);
		$this->db->update('tbl_member_detil',$datastok);
		$data = array('status'=>'0',
			'tgl_selesai'=>date("Y-m-d H:i:s"));
		$this->db->where('id',$id);
		$this->db->update('tbl_mulai',$data);
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function _content(){
		$isi['namamenu'] = "";
		$isi['page'] = "dashboard";
		$isi['kelas'] = "dashboard";
		$isi['link'] = 'dashboard';
		$isi['halaman'] = "Dashboard";
		$isi['judul'] = "Halaman Dashboard";
		$isi['option_uker'][''] = "Pilih Unit Kerja";
		$isi['option_iker'][''] = "Pilih Instansi Kerja";
		$isi['content'] = "welcome";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function play(){
		$isi['namamenu'] = "";
		$isi['page'] = "dashboard";
		$isi['kelas'] = "dashboard";
		$isi['link'] = 'dashboard';
		$isi['halaman'] = "Dashboard";
		$isi['tombolsimpan'] = "Mulai Kursus";
		$isi['tombolbatal'] = "Batal";
		$isi['option_instruktur'][''] = "Pilih Instruktur";
		$ckaryawan = $this->db->get('tbl_username')->result();
		if(count($ckaryawan)>0){
			foreach ($ckaryawan as $key) {
				$isi['option_instruktur'][$key->id] = $key->nama;
			}
		}else{
				$isi['option_instruktur'][''] = "Data Instruktur Belum Tersedia";
		}
		$isi['option_fasilitas'][''] = "Pilih Fasilitas";
		$cfasiltias = $this->db->get('tbl_mobil')->result();
		if(count($cfasiltias)>0){
			foreach ($cfasiltias as $key1) {
				$isi['option_fasilitas'][$key1->id] = $key1->nama;
			}
		}else{
			$isi['option_fasilitas'][''] = "Data Fasilitas Belum Tersedia";
		}
		$isi['judul'] = "Form Mulai Kursus";
		$isi['content'] = "form_add";
		$this->load->view("dashboard/dashboard_view",$isi);	
	}
	function get_member(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false';
		$tgl = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM view_member_kursus WHERE nama LIKE '$keyword%' LIMIT 0,1")->result();
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
					'sisa'=>$row->quota,
					'statusna'=>$row->status);
            }
		}
		if('IS_AJAX'){
            echo json_encode($data);
        }     
	}
	public function log_out(){
		$this->session->sess_destroy();
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('login','refresh');
	}
}
