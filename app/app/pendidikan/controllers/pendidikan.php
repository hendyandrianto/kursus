<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pendidikan extends CI_Controller {
	public function __construct(){
  		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
  		$this->load->model('pendidikan_model');
  		$this->kacang->login();
		$menu = "ref_data";
		$this->kacang->validasi_menu($menu);
		$submenu = "Data Pendidikan";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "pendidikan";
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
		$isi['namamenu'] = "Data Pendidikan";
		$isi['page'] = "pendidikan";
		$isi['link'] = 'pendidikan';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Pendidikan";
		$isi['judul'] = "Halaman Data Data Pendidikan";
		$isi['content'] = "pendidikan_view";
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
        $rResult = $this->pendidikan_model->data($aColumns, $sWhere, $sOrder, $sLimit);
        $iFilteredTotal = 10;
        $rResultTotal = $this->pendidikan_model->data_total($sIndexColumn);
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
		$isi['namamenu'] = "Data Pendidikan";
		$isi['page'] = "pendidikan";
		$isi['link'] = 'pendidikan';
		$isi['action'] = "proses_add";
		$isi['cek'] = "add";							
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal'] = 'Batal';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Data Pendidikan";
		$isi['judul'] = "Halaman Add Data Pendidikan";
		$isi['content'] = "form_add";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function proses_add(){
		$this->form_validation->set_rules('nama', 'Jenis Pendidikan', 'htmlspecialchars|trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$simpan = array('nama'=>$nama);
			$this->db->insert('tbl_pendidikan',$simpan);
			redirect('pendidikan','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function hapus($kode=Null){
		$ckdata = $this->db->get_where('tbl_member',array('id_pendidikan'=>$kode))->result();
		if(count($ckdata)>0){
			$data['say'] = "NotOk";
		}else{
			$this->db->where('id',$kode);
			if($this->db->delete('tbl_pendidikan')){
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
		$ckdata = $this->db->get_where('tbl_pendidikan',array('id'=>$kode))->result();
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
		$ckdata = $this->db->get_where('tbl_pendidikan',array('id'=>$kode))->result();
		if(count($ckdata)>0){
			foreach ($ckdata as $key) {
				$isi['default']['nama'] = $key->nama;
			}
			$this->session->set_userdata('idna',$kode);
			$isi['kelas'] = "ref_data";
			$isi['namamenu'] = "Data Pendidikan";
			$isi['page'] = "pendidikan";
			$isi['link'] = 'pendidikan';
			$isi['cek'] = 'edit';
			$isi['tombolsimpan'] = "Edit";
			$isi['tombolbatal'] = "Batal";
			$isi['action'] = "../proses_edit";
			$isi['judul'] = "Halaman Edit Data Pendidikan";
			$isi['content'] = "form_add";
			$isi['halaman'] = "Edit Data Pendidikan";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('error','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('nama', 'Data Pendidikan', 'htmlspecialchars|trim|required|min_length[1]|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
			$data = array('nama'=>$nama);
			$this->db->where('id',$this->session->userdata('idna'));
			$this->db->update('tbl_pendidikan',$data);
			$this->session->unset_userdata('idna');
			redirect('pendidikan','refresh');
		}else{
			redirect('error','refresh');
		}
	}
}
