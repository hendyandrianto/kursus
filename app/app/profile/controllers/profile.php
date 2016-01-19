<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {
	public function __construct(){
  		parent::__construct();
  		$this->kacang->login();
		$menu = "info";
		$this->kacang->validasi_menu($menu);
		$submenu = "Profile";
		$this->kacang->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "profile";
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
		$isi['kelas'] = "info";
		$isi['namamenu'] = "Profile";
		$isi['page'] = "profile";
		$ckdata = $this->db->get_where('tbl_username',array('id'=>$this->session->userdata('kode')))->result();
		foreach ($ckdata as $key) {
			$isi['default']['nama'] = $key->nama;
			$isi['foto'] = $key->foto;
			$isi['nama'] = $key->nama;
		}
		$isi['link'] = 'profile';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Profile";
		$isi['judul'] = "Halaman Profile";
		$isi['content'] = "profile_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function ganti(){
		$isi['kelas'] = "info";
		$isi['namamenu'] = "Profile";
		$isi['page'] = "profile";
		$ckdata = $this->db->get_where('tbl_username',array('id'=>$this->session->userdata('kode')))->result();
		foreach ($ckdata as $key) {
			$isi['default']['username'] = $key->username;
		}
		$this->session->set_userdata('uname',$key->username);
		$isi['link'] = 'profile';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit'] = 'edit';
		$isi['halaman'] = "Profile";
		$isi['judul'] = "Halaman Profile";
		$isi['content'] = "change_view";
		$this->load->view("dashboard/dashboard_view",$isi);		
	}
	public function edit_data(){
		$this->form_validation->set_rules('nama', 'Nama', 'htmlspecialchars|trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama');
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
					$this->hapusfoto();
					$gbr = $this->upload->data();
					$simpan = array('nama'=>$nama,
						'foto'=>$gbr['file_name']);
					$this->session->set_userdata('foto',$gbr['file_name']);
				}else{
					?>
					<script type="text/javascript">
		                alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 500kb");
		                window.location.href = "<?php echo base_url();?>profile";
					</script>
					<?php
				}
			}else{
				$simpan = array('nama'=>$nama);
			}
			$this->db->where('id',$this->session->userdata('kode'));
			$this->db->update('tbl_username',$simpan);
			$this->session->set_userdata('nama',$nama);
			redirect('profile','refresh');
		}else{
			redirect('error','refresh');
		}
	}
	public function hapusfoto(){
		$ckdatafoto = $this->db->get_where('tbl_username',array('id'=>$this->session->userdata('kode')))->result();
		if(count($ckdatafoto)>0){
			foreach ($ckdatafoto as $row) {
				$fotona = $row->foto;
			}
			if($fotona!="no.jpg"){
				@chmod(unlink('./foto/pegawai/' . $fotona),777);
			}
		}
	}
	public function edit_pass(){
		if($this->input->post('username')!=$this->session->userdata('uname')){
			$this->form_validation->set_rules('username', 'Username', 'htmlspecialchars|trim|required|min_length[5]|max_length[12]|is_unique[tbl_username.username]');
		}
		$this->form_validation->set_rules('password', 'Password', 'htmlspecialchars|trim|required|xss_clean|matches[password1]');
		$this->form_validation->set_rules('password1', 'Password', 'htmlspecialchars|trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE){
			$uname = $this->input->post('username');
			$pass = md5($this->input->post('password'));
			$edit = array('username'=>$uname,
				'password'=>$pass);
			$this->db->where('id',$this->session->userdata('kode'));
			if($this->db->update('tbl_username',$edit)){
				?>
				<script type="text/javascript">
					alert('Pergantian Password Berhasil \nSilahkan Login Kembali !');
					window.location.href = "<?php echo base_url();?>dashboard/logout";
				</script>
				<?php
			}else{
				redirect('error','refresh');	
			}
			redirect('profile','refresh');
		}else{
			redirect('error','refresh');
		}
	}
}
