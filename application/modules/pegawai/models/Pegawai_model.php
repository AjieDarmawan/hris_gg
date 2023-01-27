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


    function jumlah_karyawan_aktif(){
        $query = $this->db->query("select count(k.kar_id) as total from kar_master as k inner join kar_detail as d 
        on k.kar_id = d.kar_id where d.kar_dtl_typ_krj != 'Resign'")->row();

        return $query;
    }

    function karyawan_masuk_tahun(){

        $tgl_mulai = date('Y').'-'.'01-01';
        $tgl_selesai = date('Y').'-'.'12-31';

        
        $query = $this->db->query("SELECT m.MONTH, IFNULL(n.TOTAL,0) TOTAL FROM 
        (SELECT 'January' AS MONTH
        UNION 
        SELECT 'February' AS MONTH
        UNION 
        SELECT 'March' AS MONTH
        UNION 
        SELECT 'April' AS MONTH
        UNION 
        SELECT 'May' AS MONTH
        UNION 
        SELECT 'June' AS MONTH
        UNION 
        SELECT 'July' AS MONTH
        UNION 
        SELECT 'August' AS MONTH
        UNION 
        SELECT 'September' AS MONTH
        UNION 
        SELECT 'October' AS MONTH
        UNION 
        SELECT 'November' AS MONTH
        UNION 
        SELECT 'December' AS MONTH
        ) m LEFT JOIN
        (SELECT MONTHNAME(kar_dtl_tgl_joi) AS MONTH, 
        COUNT(MONTHNAME(kar_dtl_tgl_joi)) AS TOTAL 
        FROM kar_detail 
        WHERE kar_dtl_tgl_joi BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' 
        GROUP BY MONTHNAME(kar_dtl_tgl_joi),MONTH(kar_dtl_tgl_joi)
        ORDER BY MONTH(kar_dtl_tgl_joi)) n ON m.MONTH=n.MONTH")->result();

        return $query;
    }


    function karyawan_keluar_tahun(){

        $tgl_mulai = date('Y').'-'.'01-01';
        $tgl_selesai = date('Y').'-'.'12-31';

        
        $query = $this->db->query("SELECT m.MONTH, IFNULL(n.TOTAL,0) TOTAL FROM 
        (SELECT 'January' AS MONTH
        UNION 
        SELECT 'February' AS MONTH
        UNION 
        SELECT 'March' AS MONTH
        UNION 
        SELECT 'April' AS MONTH
        UNION 
        SELECT 'May' AS MONTH
        UNION 
        SELECT 'June' AS MONTH
        UNION 
        SELECT 'July' AS MONTH
        UNION 
        SELECT 'August' AS MONTH
        UNION 
        SELECT 'September' AS MONTH
        UNION 
        SELECT 'October' AS MONTH
        UNION 
        SELECT 'November' AS MONTH
        UNION 
        SELECT 'December' AS MONTH
        ) m LEFT JOIN
        (SELECT MONTHNAME(kar_dtl_tgl_res) AS MONTH, 
        COUNT(MONTHNAME(kar_dtl_tgl_res)) AS TOTAL 
        FROM kar_detail 
        WHERE kar_dtl_tgl_res BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."' 
        GROUP BY MONTHNAME(kar_dtl_tgl_res),MONTH(kar_dtl_tgl_res)
        ORDER BY MONTH(kar_dtl_tgl_res)) n ON m.MONTH=n.MONTH")->result();

        return $query;
    }

    function fasilitas_dapat(){
        $query = $this->db->query("select  
        (select count(bpjs_k) from payroll.kar_bpjs where bpjs_k=1) as bpjs_k,
        (select count(bpjs_pk) from payroll.kar_bpjs where bpjs_pk=1) as bpjs_pk,
        (select count(jht_pk) from payroll.kar_bpjs where jht_pk=1) as jht_pk,
        (select count(jht_k) from payroll.kar_bpjs where jht_k=1) as jht_k,
        (select count(jp_pk) from payroll.kar_bpjs where jp_pk=1) as jp_pk,
        (select count(jp_k) from payroll.kar_bpjs where jp_k=1) as jp_k,
        (select count(jkm_pk) from payroll.kar_bpjs where jkm_pk=1) as jkm_pk,
        (select count(jkk_pk) from payroll.kar_bpjs where jkk_pk=1) as jkk_pk,
        
        (select count(sembako) from payroll.kar_bpjs where sembako=1) as sembako_beras,
        (select count(sembako) from payroll.kar_bpjs where sembako=0) as sembako_tidak_ada,
        (select count(sembako) from payroll.kar_bpjs where sembako=2) as sembako_uang
        
        from payroll.kar_bpjs limit 1")->row();

        return $query;
    }

    function fasilitas_tidak_dapat(){
        $query = $this->db->query("select  
        (select count(bpjs_k) from payroll.kar_bpjs where bpjs_k=0) as bpjs_k,
        (select count(bpjs_pk) from payroll.kar_bpjs where bpjs_pk=0) as bpjs_pk,
        (select count(jht_pk) from payroll.kar_bpjs where jht_pk=0) as jht_pk,
        (select count(jht_k) from payroll.kar_bpjs where jht_k=0) as jht_k,
        (select count(jp_pk) from payroll.kar_bpjs where jp_pk=0) as jp_pk,
        (select count(jp_k) from payroll.kar_bpjs where jp_k=0) as jp_k,
        (select count(jkm_pk) from payroll.kar_bpjs where jkm_pk=0) as jkm_pk,
        (select count(jkk_pk) from payroll.kar_bpjs where jkk_pk=0) as jkk_pk,
        
        (select count(sembako) from payroll.kar_bpjs where sembako=1) as sembako_beras,
        (select count(sembako) from payroll.kar_bpjs where sembako=0) as sembako_tidak_ada,
        (select count(sembako) from payroll.kar_bpjs where sembako=2) as sembako_uang
        
        from payroll.kar_bpjs limit 1")->row();

        return $query;
    }

    function status_kar(){
        $query = $this->db->query("select  
        (select count(kar_dtl_id) from kar_detail where pajak_status='Kawin') as Kawin,
        (select count(kar_dtl_id) from kar_detail where pajak_status='Janda') as Janda,
        (select count(kar_dtl_id) from kar_detail where pajak_status='Duda') as Duda,
        (select count(kar_dtl_id) from kar_detail where pajak_status='Belum Kawin') as belum_kawin,
        (select count(kar_dtl_id) from kar_detail where pajak_status is null) as tidak_diketahui
      
        
       
        
        from kar_detail limit 1")->row();

        return $query;
    }



 
}
