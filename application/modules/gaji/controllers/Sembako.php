<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sembako extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
			redirect('auth');
		}
        $this->load->model(array('Sembako_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
      

        //$data["divisi"] = $this->Sembako_M->getAll();
        $data["title"] = "List Data Master Sembako";
        $this->template->load('template','sembako/sembako_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Sembako_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_sembako) {
            $hari_ini = date('Y-m-d');
           $tgl_join =   date('Y-m-d', strtotime('+3 month', strtotime($data_sembako->kar_dtl_tgl_joi))); 


            if($hari_ini>=$tgl_join){


           if($data_sembako->kar_dtl_sts_nkh=='N'){
            $harga = 220000;
           }else{
            $harga = 110000;
           }
			

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_sembako->kar_nik;
            $row[] = $data_sembako->kar_nm;
            $row[] = date('d-M-Y',strtotime($data_sembako->kar_dtl_tgl_joi));
            $row[] = $data_sembako->kar_dtl_sts_nkh;
            $row[] = number_format($harga);
          
            
          

            $data[] = $row;
        }

    }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Sembako_M->count_all(),
            "recordsFiltered" => $this->Sembako_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function menikah(){
       
        $menikah = $this->db->query('select k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where kar_dtl_sts_nkh="K" and kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and kar_nik not in ("SG.0060.2010","SG.0035.2007","SG.0410.2017","SG.0205.2014","SG.0247.2015","SG.0186.2014","SG.0273.2015") order by k.ktr_id asc')->result();
        $data['menikah'] = $menikah;
        $data["title"] = "List Data Menikah";
        $this->template->load('template','sembako/menikah',$data);
    }

    function belum_menikah(){
       
        $menikah = $this->db->query('select k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where kar_dtl_sts_nkh="TK" and kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() order by k.ktr_id asc')->result();
        $data['menikah'] = $menikah;
        $data["title"] = "List Data Menikah";
        $this->template->load('template','sembako/belum_menikah',$data);
    }

    
   


    
    
}
