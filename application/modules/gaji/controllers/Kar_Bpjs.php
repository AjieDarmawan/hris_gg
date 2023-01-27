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
        order by k.kar_id desc')->result();

        foreach($data['data_kar'] as $k){
            $data_simpan = array(
                'bpjs_k'=>0,
                'bpjs_pk'=>0,
                'jp_k'=>0,
                'jp_pk'=>0,
                
                'jkk_pk'=>0,
                'sembako'=>0,
                'jht_pk'=>0,
                'jht_k'=>0,
                'jkm_pk'=>0,
                'iuran_paguyuban'=>0,
                'kar_id'=>$k->kar_id,
                'kar_nik'=>$k->kar_nik,
                'kar_nm'=>$k->kar_nm
            );

            $cek = $this->db->query('select * from payroll.kar_bpjs where kar_id = "'.$k->kar_id.'"')->row();
            
            if($cek){
                // $this->db->where('payroll.kar_id',$k->kar_id);
                // $this->db->update('payroll.kar_bpjs',$data_simpan);
            }else{
                $this->db->insert('payroll.kar_bpjs',$data_simpan);
            }
            

        }

       



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


    function update(){
       
        // echo "<pre>";
        // echo "tes";
        // die;



         $sembako = $this->input->post('sembako');
         $kar_id_sembako = $this->input->post('kar_id_sembako');


         $iuran_paguyuban = $this->input->post('iuran_paguyuban');
         $kar_id_iuran = $this->input->post('kar_id_iuran');

         $jkm_pk = $this->input->post('jkm_pk');
         $kar_id_jkm_pk = $this->input->post('kar_id_jkm_pk');

         $jkk_pk = $this->input->post('jkk_pk');
         $kar_id_jkk_pk = $this->input->post('kar_id_jkk_pk');

         $jp_tk = $this->input->post('jp_tk');
         $kar_id_jp_tk = $this->input->post('kar_id_jp_tk');

         $jp_pk = $this->input->post('jp_pk');
         $kar_id_jp_pk = $this->input->post('kar_id_jp_pk');

         $jht_pk = $this->input->post('jht_pk');
         $kar_id_jht_pk = $this->input->post('kar_id_jht_pk');

         $jht_tk = $this->input->post('jht_tk');
         $kar_id_jht_tk = $this->input->post('kar_id_jht_tk');


         $bpjs_pk = $this->input->post('bpjs_pk');
         $kar_id_bpjs_pk = $this->input->post('kar_id_bpjs_pk');

         $bpjs_tk = $this->input->post('bpjs_tk');
         $kar_id_bpjs_tk = $this->input->post('kar_id_bpjs_tk');

         
        if($kar_id_sembako){

            $data_simpan = array(
                'sembako'=>$sembako,
            );


            $this->db->where('kar_id',$kar_id_sembako); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }


        if($kar_id_iuran){

            $data_simpan = array(
                'iuran_paguyuban'=>$iuran_paguyuban,
            );


            $this->db->where('kar_id',$kar_id_iuran); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }

        if($kar_id_jkm_pk){

            $data_simpan = array(
                'jkm_pk'=>$jkm_pk,
            );


            $this->db->where('kar_id',$kar_id_jkm_pk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }

        if($kar_id_jkk_pk){

            $data_simpan = array(
                'jkk_pk'=>$jkk_pk,
            );


            $this->db->where('kar_id',$kar_id_jkk_pk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }




        if($kar_id_jp_tk){

            $data_simpan = array(
                'jp_k'=>$jp_tk,
            );


            $this->db->where('kar_id',$kar_id_jp_tk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }

        if($kar_id_jp_pk){

            $data_simpan = array(
                'jp_pk'=>$jp_pk,
            );


            $this->db->where('kar_id',$kar_id_jp_pk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }

        if($kar_id_jht_pk){

            $data_simpan = array(
                'jht_pk'=>$jht_pk,
            );


            $this->db->where('kar_id',$kar_id_jht_pk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }

        if($kar_id_jht_tk){

            $data_simpan = array(
                'jht_k'=>$jht_tk,
            );


            $this->db->where('kar_id',$kar_id_jht_tk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }


        if($kar_id_bpjs_tk){

            $data_simpan = array(
                'bpjs_k'=>$bpjs_tk,
            );


            $this->db->where('kar_id',$kar_id_bpjs_tk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }


        if($kar_id_bpjs_pk){

            $data_simpan = array(
                'bpjs_pk'=>$bpjs_pk,
            );


            $this->db->where('kar_id',$kar_id_bpjs_pk); 
            $this->db->update('payroll.kar_bpjs',$data_simpan);
        }

        


        redirect('gaji/Kar_Bpjs');


    }


    


    
    

    
   


    
    
}
