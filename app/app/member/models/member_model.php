<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    function data_member($aColumns, $sWhere, $sOrder, $sLimit){
        $query = $this->db->query("
           SELECT * FROM (
                SELECT a.*, CONCAT_WS('|', a.id) AS add_data
                FROM view_member a
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
                SELECT a.*, CONCAT_WS('|', a.id) AS add_data
                FROM view_member a
            ) A
        ");
        return $query;
    }
}