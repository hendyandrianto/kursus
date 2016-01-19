<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	public function __construct(){
  		parent::__construct();
  		$this->load->model('users_model');
  		$this->kacang->login();
		$menu = "master";
		$this->kacang->validasi_menu($menu);
		$submenu = "Data Karyawan";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "users";
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
	public function _content(){
		$isi['kelas'] = "master";
		$isi['namamenu'] = "Data Karyawan";
		$isi['page'] = "users";
		$isi['link'] = 'users';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Karyawan";
		$isi['judul'] = "Halaman Data Karyawan";
		$isi['content'] = "users_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function get_data(){
		$aColumns = array('id','foto','nama','username','id');
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
        $rResult = $this->users_model->data_users($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->users_model->data_total($sIndexColumn);
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
		$isi['namamenu'] = "Data Karyawan";
		$isi['page'] = "users";
		$isi['link'] = 'users';
		$isi['action'] = "proses_add";
		$isi['cek'] = "add";							
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal'] = 'Batal';
		$isi['halaman'] = "Data Karyawan";
		$isi['judul'] = "Halaman Add Data Karyawan";
		$isi['content'] = "form_users";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function proses_add(){
		$this->form_validation->set_rules('nama', 'Nama', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$username = $this->input->post('username');
			$ckdata = $this->db->get_where('tbl_username',array('username'=>$username))->result();
			if(count($ckdata)>0){
				?>
					<script type="text/javascript">
		 				alert("Username Sudah Ada Sebelumnya !");
		 				window.location.href = "<?php echo base_url();?>users/add";
	 				</script>
				<?php
			}else{
	 			$foto = str_replace(" ", "_", $_FILES['foto']['name']);
				$acak=rand(00000000000,99999999999);
				$bersih = $_FILES['foto']['name'];
				$nm = str_replace(" ","_","$bersih");
				$pisah = explode(".",$nm);
				$nama_murni = $pisah[0];
				$ubah = $acak.$nama_murni;
				$nama_fl = $acak.$nm;
 				$tmpName = $_FILES['foto']['tmp_name'];
	 			$nmfile = "file_".time();
				if($tmpName!=''){
				   	$config['file_name'] = $nmfile;
					$config['upload_path'] = 'foto/pegawai';
					$config['allowed_types'] = 'gif|jpg|png|bmp';
					$config['max_size'] = '1048';
					$config['max_width'] = '0';
			        $config['max_height'] = '0';
			        $config['overwrite'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('foto')){
						$gbr = $this->upload->data();
						$simpan = array('nama'=>$nama,
							'username'=>$username,
							'password'=>md5(12345),
							'foto'=>$gbr['file_name'],
							'level'=>'0');
					}else{
						?>
						<script type="text/javascript">
			                alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 500kb");
			                window.location.href = "<?php echo base_url();?>users/add";
						</script>
						<?php
					}
				}else{
					$foto = "no.jpg";
					$simpan = array('nama'=>$nama,
						'username'=>$username,
						'password'=>md5(12345),
						'foto'=>$foto,
						'level'=>'0');
				}
				$this->db->insert('tbl_username',$simpan);
			}
			redirect('users','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function hapus($kode=Null){
		$ckdata = $this->db->query("SELECT id,level FROM tbl_username WHERE id = '$kode'")->result();
		if(count($ckdata)>0){
			$this->hapusfoto($kode);
			$this->db->where('id',$kode);
			if($this->db->delete('tbl_username')){
				$data['say'] = "ok";
			}else{
				$data['say'] = "NotOk";
			}
		}else{
			$data['say'] = "NotOk";
		}
		if('IS_AJAX'){
		    echo json_encode($data);
		}  	
	}
	function hapusfoto($kode=Null){
		$ckdata = $this->db->get_where('tbl_username',array('id'=>$kode))->result();
		foreach ($ckdata as $hehe) {
			$fotona = $hehe->foto;
		}
		if($fotona!="no.jpg"){
			@chmod(unlink('./foto/pegawai/' . $fotona),777);
		}
	}
	public function cekdata($kode=Null){
		$ckdata = $this->db->get_where('tbl_username',array('id'=>$kode))->result();
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
		$ckdatauser = $this->db->get_where('tbl_username',array('id'=>$kode))->result();
		if(count($ckdatauser)>0){
			foreach ($ckdatauser as $key) {
				$isi['default']['nama'] = $key->nama;
				$isi['default']['username'] = $key->username;
				$isi['foto'] = $key->foto;
			}
			$isi['judulx'] = "Edit Data Data Karyawan";
			$isi['idmaster'] = $kode;
			$isi['kelas'] = "master";
			$isi['namamenu'] = "Data Karyawan";
			$isi['page'] = "kirim";
			$isi['link'] = 'kirim';
			$isi['cek'] = 'edit';
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['judul'] = "Halaman Edit Data Karyawan";
			$isi['content'] = "form_users";
			$isi['halaman'] = "Edit Data Karyawan";
			$this->session->set_userdata('idna',$kode);
			$this->session->set_userdata('uname',$key->username);
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('nama', 'Nama', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$username = $this->input->post('username');
			$lv = "0";
			if($username!==$this->session->userdata('uname')){
				$ckdata = $this->db->get_where('tbl_username',array('username'=>$username))->result();
				if(count($ckdata)>0){
					?>
						<script type="text/javascript">
			 				alert("Username Sudah Ada Sebelumnya !");
			 				window.location.href = "<?php echo base_url();?>users/edit/<?php echo $this->session->userdata('idna');?>";
		 				</script>
					<?php
				}else{
					$foto = str_replace(" ", "_", $_FILES['foto']['name']);
					$acak=rand(00000000000,99999999999);
					$bersih = $_FILES['foto']['name'];
					$nm = str_replace(" ","_","$bersih");
					$pisah = explode(".",$nm);
					$nama_murni = $pisah[0];
					$ubah = $acak.$nama_murni;
					$nama_fl = $acak.$nm;
					$tmpName = $_FILES['foto']['tmp_name'];
		 			$nmfile = "file_".time();
					if($tmpName!=''){
					   	$config['file_name'] = $nmfile;
						$config['upload_path'] = 'foto/pegawai';
						$config['allowed_types'] = 'gif|jpg|png|bmp';
						$config['max_size'] = '1048';
						$config['max_width'] = '0';
				        $config['max_height'] = '0';
				        $config['overwrite'] = TRUE;
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('foto')){
							$this->hapusfoto($this->session->userdata('idna'));
							$gbr = $this->upload->data();
							$simpan = array('nama'=>$nama,
								'username'=>$username,
								'foto'=>$gbr['file_name'],
								'level'=>$lv);
						}else{
							?>
							<script type="text/javascript">
				                alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 500kb");
				                window.location.href = "<?php echo base_url();?>users/add";
							</script>
							<?php
						}
					}else{
						$simpan = array('nama'=>$nama,
							'username'=>$username,
							'level'=>$lv);
					}
					$this->db->where('id',$this->session->userdata('idna'));
					$this->db->update('tbl_username',$simpan);
				}
			}else{
				$foto = str_replace(" ", "_", $_FILES['foto']['name']);
				$acak=rand(00000000000,99999999999);
				$bersih = $_FILES['foto']['name'];
				$nm = str_replace(" ","_","$bersih");
				$pisah = explode(".",$nm);
				$nama_murni = $pisah[0];
				$ubah = $acak.$nama_murni;
				$nama_fl = $acak.$nm;
				$tmpName = $_FILES['foto']['tmp_name'];
	 			$nmfile = "file_".time();
				if($tmpName!=''){
				   	$config['file_name'] = $nmfile;
					$config['upload_path'] = 'foto/pegawai';
					$config['allowed_types'] = 'gif|jpg|png|bmp';
					$config['max_size'] = '1048';
					$config['max_width'] = '0';
			        $config['max_height'] = '0';
			        $config['overwrite'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('foto')){
						$this->hapusfoto($this->session->userdata('idna'));
						$gbr = $this->upload->data();
						$simpan = array('nama'=>$nama,
							'username'=>$username,
							'foto'=>$gbr['file_name'],
							'level'=>$lv);
					}else{
						?>
						<script type="text/javascript">
			                alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 500kb");
			                window.location.href = "<?php echo base_url();?>users/add";
						</script>
						<?php
					}
				}else{
					$simpan = array('nama'=>$nama,
						'username'=>$username,
						'posisi'=>'3',
						'level'=>$lv);
				}
				$this->db->where('id',$this->session->userdata('idna'));
				$this->db->update('tbl_username',$simpan);
			}
			redirect('users','refresh');
		}else{
			redirect('error','refresh');
		}
	}
}
