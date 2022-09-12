<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Level extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('Level_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        

        //$data["Level"] = $this->Level_M->getAll();
        $data["title"] = "List Data Master Level";
        $this->template->load('template','level/level_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Level_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Level) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/level/update/'.base64_encode($data_Level->lvl_id))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Level->lvl_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Level->lvl_nm;
            $row[] = "";

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Level_M->count_all(),
            "recordsFiltered" => $this->Level_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Level"] = $this->Level_M->getAll();
          $data["title"] = "List Data Master Level";
          $this->template->load('template','level/level_tambah',$data);
    }

    function simpan(){
        $Level =  $this->input->post('Level');

        $simpan = $this->Level_M->save($Level);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/level/');
        
        }else{

        }
    }

    function update($id){
         

        $data['Level'] = $this->Level_M->getById(base64_decode($id));

       

        $data["title"] = "List Data Master Level";
        $this->template->load('template','level/level_edit',$data);
    }

    function update_simpan(){
        $Level_id  = $this->input->post('Level_id');
        $Level_nama  = $this->input->post('Level');


        $simpan = $this->Level_M->update($Level_id,$Level_nama);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/level/');
        
        }else{

        }


    }

    function hapus(){
        $lvl_id = $this->input->post('id');

		$this->db->where('lvl_id',$lvl_id);
		$sql = $this->db->delete('lvl_master');
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
