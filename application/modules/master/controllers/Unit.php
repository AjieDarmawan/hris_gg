<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('Unit_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        

        //$data["Unit"] = $this->Unit_M->getAll();
        $data["title"] = "List Data Master Unit";
        $this->template->load('template','unit/unit_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Unit_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Unit) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/unit/update/'.base64_encode($data_Unit->unt_id))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Unit->unt_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Unit->unt_nm;
            $row[] = "";

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Unit_M->count_all(),
            "recordsFiltered" => $this->Unit_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Unit"] = $this->Unit_M->getAll();
          $data["title"] = "List Data Master Unit";
          $this->template->load('template','unit/unit_tambah',$data);
    }

    function simpan(){
        $Unit =  $this->input->post('Unit');

        $simpan = $this->Unit_M->save($Unit);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Unit/');
        
        }else{

        }
    }

    function update($id){
         

        $data['Unit'] = $this->Unit_M->getById(base64_decode($id));

       

        $data["title"] = "List Data Master Unit";
        $this->template->load('template','unit/unit_edit',$data);
    }

    function update_simpan(){
        $Unit_id  = $this->input->post('Unit_id');
        $Unit_nama  = $this->input->post('Unit');


        $simpan = $this->Unit_M->update($Unit_id,$Unit_nama);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Unit/');
        
        }else{

        }


    }

    function hapus(){
        $unt_id = $this->input->post('id');

		$this->db->where('unt_id',$unt_id);
		$sql = $this->db->delete('unt_master');
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
