<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ambil_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    /*==================================== ssp_data_kirim ============================================*/
    function data($aColumns, $sWhere, $sOrder, $sLimit){
        $query = $this->db->query("
           SELECT * FROM (
                SELECT a.*, CONCAT_WS('|', a.kode) AS add_data
                FROM view_ijazah a WHERE status_ambil = '1'
            ) A 
            $sWhere
            $sOrder
            $sLimit
        ");
        return $query;
        $query->free_result();
    }
    function data_total($sIndexColumn){
        $query = $this->db->query("
            SELECT $sIndexColumn
            FROM (
                SELECT a.*, CONCAT_WS('|', a.kode) AS add_data
                FROM view_ijazah a WHERE status_ambil = '1'
            ) A 
        ");
        return $query;
    }
    function data_belum($aColumns, $sWhere, $sOrder, $sLimit){
        $query = $this->db->query("
           SELECT * FROM (
                SELECT a.*, CONCAT_WS('|', a.kode) AS add_data
                FROM view_ijazah a WHERE status_ambil = '0'
            ) A 
            $sWhere
            $sOrder
            $sLimit
        ");
        return $query;
        $query->free_result();
    }
    function data_total_belum($sIndexColumn){
        $query = $this->db->query("
            SELECT $sIndexColumn
            FROM (
                SELECT a.*, CONCAT_WS('|', a.kode) AS add_data
                FROM view_ijazah a WHERE status_ambil = '0'
            ) A 
        ");
        return $query;
    }
}