<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Final_gaji extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
			redirect('auth');
		}
        $this->load->model(array('Final_gaji_M'));
		
    }


    function lastOfMonth($year, $month) {
        return date("Y-m-d", strtotime('-1 second', strtotime('+1 month',strtotime($month . '/01/' . $year. ' 00:00:00'))));
        }

    // redirect if needed, otherwise display the user list
    public function index()
    {   
        $year = date('Y');
        $month = date('m');
        $data['tgl_akhir_bulan'] = $this->lastOfMonth($year,$month);

        // echo "<pre>";
        // print_r($data['tgl_akhir_bulan'] );

        // echo date('m',strtotime($data['tgl_akhir_bulan']));
        // die;

      

        $data['data_kar'] = $this->Final_gaji_M->getAll();

        //$data["divisi"] = $this->Insentif_M->getAll();
        $data["title"] = "List Data Master Insentif";
        $this->template->load('template','final_gaji/final_gaji_v',$data);
     
    }

    function download_excel(){


        $year = date('Y');
        $month = date('m');
        $data['tgl_akhir_bulan'] = $this->lastOfMonth($year,$month);

        // echo "<pre>";
        // print_r($data['tgl_akhir_bulan'] );

        // echo date('m',strtotime($data['tgl_akhir_bulan']));
        // die;

      

        $data['data_kar'] = $this->Final_gaji_M->getAll();

        $this->load->view('final_gaji/download_excel',$data);

    }

    function insert_final(){


        $data_array = array(
            'kar_id'=>'',
            'nik'=>'',
            'nama'=>'',
            'bulan',
            'gaji_pokok'=>'',
            't.fungsional'=>'',
            't.struktural'=>'',
            'upah_gaji_tetep'=>'',
            't.umum'=>'',
            't.kinerja'=>'',
            'upah_gaji_tidak_tetap'=>'',
            't.beras'=>'',
            't.dinas'=>'',
            't.listrik'=>'',
            't.lain_lain'=>'',
            'insentif'=>'',
            'total_gaji'=>'',
            'total_gaji_inf'=>'',
            'bpjs_k_1'=>'',
            'jht_k_2'=>'',
            'jp_k_1'=>'',
            'bpjs_pk_4'=>'',
            'jht_pk'=>'',
            'jkk_pk_024'=>'',
            'jkm_pk'=>'',
            'jp_pk'=>'',
            'total_terima'=>''

        );

        $simpan = $this->db->insert('final_gaji',$data_array);
    }


   
    

    
   


    
    
}
