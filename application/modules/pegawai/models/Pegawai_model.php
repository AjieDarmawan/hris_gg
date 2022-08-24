<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_by_id($kar_id)
    {
        // $result = $this->db->get_where('kar_master',array('kar_id'=>$kar_id))->row_array();
        // return $result;

        $result = $this->db->select('*')
        ->from('acc_master mk')
        ->join('kar_master k','k.kar_id = mk.kar_id')
      


        ->where('mk.kar_id',$kar_id)
        ->get()
        ->row_array();

        return $result;

       // $result = $this->db->query('user')
    }

 
}
