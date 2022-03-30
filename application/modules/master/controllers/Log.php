<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Log_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        
        // $sess = $this->session->userdata(['pegawai']['username']);
        // echo "<pre>";
        // print_r($sess);
        // die;
        //$data["log"] = $this->Log_M->getAll();
        $data["title"] = "List Data Master log";
        $this->template->load('template','log/log_v',$data);
     
    }


    public function ajax_list()
    {

        
        header('Content-Type: application/json');
        $list = $this->Log_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_log) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/log/update/'.base64_encode($data_log->id_log))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_log->id_log' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_log->aktifitas;
            $row[] = $data_log->datetime;
           
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Log_M->count_all(),
            "recordsFiltered" => $this->Log_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["log"] = $this->Log_M->getAll();
          $data["title"] = "List Data Master log";
          $this->template->load('template','log/log_tambah',$data);
    }

    function simpan(){
        $log =  $this->input->post('log');

        $simpan = $this->Log_M->save($log);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/log/');
        
        }else{

        }
    }

    function update($id){
         
        $data['log'] = $this->Log_M->getById(base64_decode($id));
        $data["title"] = "List Data Master log";
        $this->template->load('template','log/log_edit',$data);
    }

    function update_simpan(){
        $id_log  = $this->input->post('id_log');
        $log_nama  = $this->input->post('log');


        $simpan = $this->Log_M->update($id_log,$log_nama);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/log/');
        
        }else{

        }

    }

    function hapus(){
        $id_log = $this->input->post('id');

		$this->db->where('id_log',$id_log);
		$sql = $this->db->delete('log');
		if($sql){
			$datas= array(
				'status' =>true,
			);
		}else{
			$datas= array(
				'status' =>false,
			);
		}

		echo json_encode($datas);
    }


    
    
}
