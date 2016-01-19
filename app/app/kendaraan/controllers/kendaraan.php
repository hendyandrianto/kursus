<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kendaraan extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->load->model('kendaraan_model');
  		$this->kacang->login();
		$menu = "ref_data";
		$this->kacang->validasi_menu($menu);
		$submenu = "Data Fasilitas";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "kendaraan";
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
		$isi['namamenu'] = "Data Fasilitas";
		$isi['page'] = "kendaraan";
		$isi['link'] = 'kendaraan';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Fasilitas";
		$isi['judul'] = "Halaman Data Fasilitas";
		$isi['content'] = "kendaraan_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function get_data(){
		$aColumns = array('id','foto','plat','nama','id');
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
        $rResult = $this->kendaraan_model->data($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->kendaraan_model->data_total($sIndexColumn);
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
		$isi['namamenu'] = "Data Fasilitas";
		$isi['page'] = "kendaraan";
		$isi['link'] = 'kendaraan';
		$isi['action'] = "proses_add";
		$isi['cek'] = "add";							
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal'] = 'Batal';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Fasilitas";
		$isi['judul'] = "Halaman Add Data Fasilitas";
		$isi['content'] = "form_add";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function proses_add(){
		$this->form_validation->set_rules('nama', 'Nama Kendaraan', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('plat', 'Plat Kendaraan', 'htmlspecialchars|trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$plat = $this->input->post('plat');
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
				$config['upload_path'] = 'foto/mobil';
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
					'plat'=>$plat,
					'foto'=>$gbr['file_name']);
				}else{
					?>
					<script type="text/javascript">
		                alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 500kb");
		                window.location.href = "<?php echo base_url();?>kendaraan/add";
					</script>
					<?php
				}
			}else{
				$foto = "no.jpg";
				$simpan = array('nama'=>$nama,
					'plat'=>$plat,
					'foto'=>$foto);
			}
			$this->db->insert('tbl_mobil',$simpan);
			redirect('kendaraan','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function hapus($kode=Null){
		$ckdata = $this->db->get_where('tbl_mobil',array('id'=>$kode))->result();
		if(count($ckdata)>0){
			$this->hapusfoto($kode);
			$this->db->where('id',$kode);
			if($this->db->delete('tbl_mobil')){
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
		$ckdata = $this->db->get_where('tbl_mobil',array('id'=>$kode))->result();
		if(count($ckdata)>0){
			$data['say'] = "ok";
		}else{
			$data['say'] = "NotOk";
		}
		if('IS_AJAX'){
		    echo json_encode($data);
		}  	
	}
	function hapusfoto($kode=Null){
		$ckdata = $this->db->get_where('tbl_member',array('id'=>$kode))->result();
		foreach ($ckdata as $hehe) {
			$fotona = $hehe->foto;
		}
		if($fotona!="no.jpg"){
			@chmod(unlink('./foto/mobil/' . $fotona),777);
		}
	}
	public function edit($kode=Null){
		$ckdata = $this->db->get_where('tbl_mobil',array('id'=>$kode))->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $key) {
				$isi['default']['plat'] = $key->plat;
				$isi['foto'] = $key->foto;
				$isi['default']['nama'] = $key->nama;
			}
			$this->session->set_userdata('idna',$kode);
			$isi['kelas'] = "ref_data";
			$isi['namamenu'] = "Data Fasilitas";
			$isi['page'] = "kendaraan";
			$isi['link'] = 'kendaraan';
			$isi['cek'] = 'edit';
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['judul'] = "Halaman Edit Data Fasilitas";
			$isi['content'] = "form_add";
			$isi['halaman'] = "Edit Data Fasilitas";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('nama', 'Nama Kendaraan', 'htmlspecialchars|trim|required|xss_clean');
		$this->form_validation->set_rules('plat', 'Plat Kendaraan', 'htmlspecialchars|trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$plat = $this->input->post('plat');
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
				$config['upload_path'] = 'foto/mobil';
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
					'plat'=>$plat,
					'foto'=>$gbr['file_name']);
				}else{
					?>
					<script type="text/javascript">
		                alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 500kb");
		                window.location.href = "<?php echo base_url();?>kendaraan/add";
					</script>
					<?php
				}
			}else{
				$simpan = array('nama'=>$nama,
					'plat'=>$plat);
			}
			$this->db->where('id',$this->session->userdata('idna'));
			$this->db->update('tbl_mobil',$simpan);
			$this->session->unset_userdata('idna');
			redirect('kendaraan','refresh');
		}else{
			redirect('error','refresh');
		}
	}
}
