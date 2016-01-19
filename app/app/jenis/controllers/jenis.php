<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jenis extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->load->model('jenis_model');
  		$this->kacang->login();
		$menu = "ref_data";
		$this->kacang->validasi_menu($menu);
		$submenu = "Jenis Kursus";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "jenis";
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
		$isi['namamenu'] = "Jenis Kursus";
		$isi['page'] = "jenis";
		$isi['link'] = 'jenis';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Jenis Kursus";
		$isi['judul'] = "Halaman Data Jenis Kursus";
		$isi['content'] = "jenis_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function get_data(){
		$aColumns = array('id','nama','id');
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
        $rResult = $this->jenis_model->data($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->jenis_model->data_total($sIndexColumn);
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
		$isi['namamenu'] = "Jenis Kursus";
		$isi['page'] = "jenis";
		$isi['link'] = 'jenis';
		$isi['action'] = "proses_add";
		$isi['cek'] = "add";							
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal'] = 'Batal';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Jenis Kursus";
		$isi['judul'] = "Halaman Add Data Jenis Kursus";
		$isi['content'] = "form_add";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function proses_add(){
		$this->form_validation->set_rules('nama', 'Jenis Kursus', 'htmlspecialchars|trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$simpan = array('nama'=>$nama);
			$this->db->insert('tbl_tipe',$simpan);
			redirect('jenis','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function edit_detil($kode=NULL,$idpupuk=NULL){
		if($this->session->userdata('level')=='0'){
			$ckdata = $this->db->get_where('view_jenisan_produsen_detil',array('IdDet'=>$kode))->result();
		}else{
			$id = $this->session->userdata('id_pro');
			$ckdata = $this->db->get_where('view_jenisan_produsen_detil',array('IdDet'=>$kode,'IdProdusen'=>$id))->result();
		}
		if(count($ckdata)>0){
			$isi['kelas'] = "ref_data";
			$isi['namamenu'] = "Jenis Kursus";
			$isi['page'] = "jenis";
			$isi['link'] = 'jenis';
			$isi['cek'] = 'edit';
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['judul'] = "Halaman Edit Data Jenis Kursus";
			$isi['content'] = "form_edit_detil";
			$isi['halaman'] = "Edit Data Jenis Kursus";
			foreach ($ckdata as $key) {
				$isi['option_pupuk'][$idpupuk] = $key->NmPupuk;
				$isi['default']['jml'] = $key->Jml;
				$isi['default']['ket'] = $key->ver_ket_detil;
			}
			$isi['iddet'] = $kode;
			$isi['idpupuk'] = $idpupuk;
			$isi['judulx'] = "Edit Data Jenis Kursus No. Faktur : " . $key->faktur . " Distributor : " . $key->NmDistributor;
			$pupuk = $this->db->get('t_m_pupuk')->result();
			if(count($pupuk)>0){
				foreach ($pupuk as $key) {
					$isi['option_pupuk'][$key->NmPupuk] = $key->NmPupuk;
				}
			}else{
				$isi['option_pupuk'][''] = "Data Jns. Pupuk Belum Tersedia";
			}
			$this->load->view("dashboard/dashboard_view",$isi);
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
		$ckdata = $this->db->get_where('tbl_tipe',array('id'=>$kode))->result();
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
		$ckdata = $this->db->get_where('tbl_tipe',array('id'=>$kode))->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $key) {
				$isi['default']['nama'] = $key->nama;
			}
			$this->session->set_userdata('idna',$kode);
			$isi['kelas'] = "ref_data";
			$isi['namamenu'] = "Jenis Kursus";
			$isi['page'] = "jenis";
			$isi['link'] = 'jenis';
			$isi['cek'] = 'edit';
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['judul'] = "Halaman Edit Data Jenis Kursus";
			$isi['content'] = "form_add";
			$isi['halaman'] = "Edit Data Jenis Kursus";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('nama', 'Jenis Kursus', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$data = array('nama'=>$nama);
			$this->db->where('id',$this->session->userdata('idna'));
			$this->db->update('tbl_tipe',$data);
			$this->session->unset_userdata('idna');
			redirect('jenis','refresh');
		}else{
			redirect('error','refresh');
		}
	}
}
