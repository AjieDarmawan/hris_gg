<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daily_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_master_wfh(){
        $sql = $this->db->query('select * from wfh_master ORDER by wfh_aktifitas asc');
        return $sql->result();
    }


    public function get_harian($nomor){
        $sql = $this->db->query("select w.*,m.wfh_aktifitas from wfh_data  as w 
        inner join wfh_master as m on w.wfd_aktifitas = m.wfh_id  where w.wfd_nomor = '".$nomor."' and date(w.wfd_tanggal) = '".date('Y-m-d')."' ");
        return $sql->result();
    }

    public function get_harian_groupby($nomor){
        $sql = $this->db->query("select w.*,m.wfh_aktifitas from wfh_data  as w 
        inner join wfh_master as m on w.wfd_aktifitas = m.wfh_id where date(w.wfd_tanggal) = '".date('Y-m-d')."' group by w.wfd_nomor = '".$nomor."'");
        return $sql->result();
    }


 
}
