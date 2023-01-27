<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Potongan_lainnya extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
            redirect('auth');
        }
        $this->load->model(array('Potongan_lainnya_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        $data['kar_data'] = $this->db->query("select  k.kar_id,k.kar_nm,k.kar_nik from kar_master as k inner join kar_detail as d on k.kar_id = d.kar_id 
        where d.kar_dtl_typ_krj != 'Resign' order by k.kar_nm asc")->result();

        $data["data_kar"] = $this->Potongan_lainnya_M->getAll();
        $data["title"] = "List Data Master Potongan_lainnya";
        $this->template->load('template','potongan_lain_lain/potongan_lain_lain_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Potongan_lainnya_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_insentif) {


         
			error_reporting(0);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_insentif->kar_nik;
            $row[] = $data_insentif->kar_nm;
            $row[] = date('M-Y',strtotime($data_insentif->bulan));
           
            $row[] = number_format($data_insentif->nominal);
            $row[] = number_format($data_insentif->nominal);
           
          
           
          
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Potongan_lainnya_M->count_all(),
            "recordsFiltered" => $this->Potongan_lainnya_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function simpan(){
        $bulan = $this->input->post('bulan');
        $keterangan = $this->input->post('keterangan');
        $kar_id = $this->input->post('kar_id');
        $nominal = $this->input->post('nominal');

        $data_simpan = array(
            'bulan'=>$bulan,
            'keterangan'=>$keterangan,
            'kar_id'=>$kar_id,
            'nominal'=>$nominal,
            'crdt'=>date('Y-m-d'),
        );

        $this->db->insert('payroll.potongan_lain_lain',$data_simpan);

        redirect('gaji/potongan_lainnya');
    }


    

    

    
   


    
    
}
