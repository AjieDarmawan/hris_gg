<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kar_Bpjs extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
            redirect('auth');
        }
        $this->load->model(array('Kar_Bpjs_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {

         error_reporting(0);
        
        $data['data_kar'] = $this->db->query('select d.kar_dtl_tgl_joi,d.kar_dtl_sts_nkh,k.kar_nm, k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, 
            INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() order by k.ktr_id asc')->result();

        //$data["divisi"] = $this->Kar_Bpjs_M->getAll();
        $data["title"] = "List Data Master Kar_Bpjs";
        $this->template->load('template','kar_bpjs/kar_bpjs_v',$data);
     
    }

    function kar_insert(){
        // echo "<pre>";
        // print_r();

        error_reporting(0);

        $data_kar = $_POST['kar'];

        echo "<pre>";
        print_r($_POST);

        // // echo count($status);
         die;

        foreach($data_kar as $key =>$k){

            $kar = $this->db->query('select kar_nik,kar_nm from kar_master where kar_id="'.$key.'"')->row();

            if($_POST['bpjs_tk'][$key]){
                $bpjs_k = 1;
            }else{
                $bpjs_k = 0;
            }

            if($_POST['bpjs_pk'][$key]){
                $bpjs_pk = 1;
            }else{
                $bpjs_pk = 0;
            }


             if($_POST['jht_tk'][$key]){
                $jht_tk = 1;
            }else{
                $jht_tk = 0;
            }



             if($_POST['jht_pk'][$key]){
                $jht_pk = 1;
            }else{
                $jht_pk = 0;
            }


             if($_POST['jp_tk'][$key]){
                $jp_tk = 1;
            }else{
                $jp_tk = 0;
            }


            if($_POST['jp_pk'][$key]){
                $jp_pk = 1;
            }else{
                $jp_pk = 0;
            }



            if($_POST['jkk_pk'][$key]){
                $jkk_pk = 1;
            }else{
                $jkk_pk = 0;
            }

            if($_POST['jkm_pk'][$key]){
                $jkm_pk = 1;
            }else{
                $jkm_pk = 0;
            }

            if($_POST['status'][$key]){
                $status = 1;
            }else{
                $status = 0;
            }









            $data_simpan = array(
                'kar_id'=>$key,
                'bpjs_k'=>$bpjs_k,
                'bpjs_pk'=>$bpjs_pk,

                'jht_k'=>$jht_tk,
                'jht_pk'=>$jht_pk,

                'jp_k'=>$jp_tk,
                'jp_pk'=>$jp_pk,

                'jkk_pk'=>$jkk_pk,
                'jkm_pk'=>$jkm_pk,

                'status'=>$status,

                'kar_nm' =>$kar->kar_nm,
                'kar_nik' =>$kar->kar_nik,
            );

            $kar_bpjs = $this->db->query('select kar_nik,kar_nm from payroll.kar_bpjs where kar_id="'.$key.'"')->row();

            if($kar_bpjs){
                 $this->db->where('kar_id',$key); 
                 $this->db->update('payroll.kar_bpjs',$data_simpan);


            }else{
                 $this->db->insert('payroll.kar_bpjs',$data_simpan);

            }

           
        }

        redirect('gaji/Kar_Bpjs');




    }


    


    
    

    
   


    
    
}
