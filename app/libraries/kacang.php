<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kacang{
   protected $CI;
   function __construct(){
      $this->CI =& get_instance();
   }
   function keurlogin(){
      if($this->CI->session->userdata('login') == FALSE){
         return FALSE;
      }
      return TRUE;
   }
   function login(){
      if($this->keurlogin() == FALSE){
         redirect('login','refresh');
      }
   }
   function do_logout(){
		$this->CI->session->sess_destroy();
	}
   function validasi_menu($menu){
      $cekmenu = $this->CI->db->get_where('tbl_menu',array('kelas'=>$menu,'status'=>'1'))->result();
      if(count($cekmenu)>0){
         return TRUE;
      }else{
         redirect('error','refresh');
      }
   }
   function validasi_submenu($submenu){
      $cekmenu = $this->CI->db->get_where('tbl_submenu',array('nama_smenu'=>$submenu,'sstatus'=>'1'))->result();
      if(count($cekmenu)>0){
         return TRUE;
      }else{
         redirect('error','refresh');
      }
   }
   public function cekmenu($namamenu){
      $smenu = $this->CI->db->get_where('tbl_submenu',array('slink'=>$namamenu,'sstatus'=>'1'))->result();
      foreach ($smenu as $key ) {
         $menuid = trim($key->smenu_id);
      }
      $hak = explode("|",$this->CI->session->userdata('priv'));
      $out = "";
      for($i=0;$i<count($hak);$i++){
         if($hak[$i]===$menuid){
            $out .= "TRUE|";
         }else{
            $out .= "FALSE|";
         }
      } 
      if(strpos($out,'TRUE') === FALSE) {
         return FALSE;
      }
      return TRUE;
   }
   public function hak_aksessubmenu($namamenu){
      if($this->cekmenu($namamenu) == FALSE){
         redirect('error','refresh');
      }
   }
   public function cekmenux($namamenu){
      $smenu = $this->CI->db->get_where('tbl_submenux',array('slinkx'=>$namamenu,'sstatusx'=>'1'))->result();
      foreach ($smenu as $key ) {
         $menuid = trim($key->smenu_id);
      }
      $hak = explode("|",$this->CI->session->userdata('privx'));
      $out = "";
      for($i=0;$i<count($hak);$i++){
         if($hak[$i]===$menuid){
               $out .= "true|";
         }else{
            $out .= "false|";
         }
      } 
      if(strpos($out,'true') === false) {
         redirect('error','refresh');
      }
   }
   function now(){
      date_default_timezone_set('Asia/Jakarta');
      return date('Y-m-d H:i:s');
   }
   function log_aktivitas($text,$oleh,$class){
      $this->CI->load->database();
      return $this->CI->db->insert('tbl_activity', array('title'=>$text,
         'start'=>$this->now(),
         'end'=>date('Y-m-d H:i:s'),
         'dibuat_oleh'=>$oleh,
         'className'=>$class));
   }
   function batas($text,$oleh,$tgl,$class){
      $this->CI->load->database();
      return $this->CI->db->insert('tbl_activity', array('title'=>$text,
         'start'=>$tgl,
         'end'=>$tgl,
         'dibuat_oleh'=>$oleh,
         'className'=>$class));
   }
}