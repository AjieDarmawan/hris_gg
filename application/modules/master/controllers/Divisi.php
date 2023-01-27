<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Divisi extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('Divisi_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        

        //$data["divisi"] = $this->Divisi_M->getAll();
        $data["title"] = "List Data Master Divisi";
        $this->template->load('template','divisi/divisi_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Divisi_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_divisi) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/divisi/update/'.base64_encode($data_divisi->div_id))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_divisi->div_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_divisi->div_nm;
           	    $row[] = "";

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Divisi_M->count_all(),
            "recordsFiltered" => $this->Divisi_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["divisi"] = $this->Divisi_M->getAll();
          $data["title"] = "List Data Master Divisi";
          $this->template->load('template','divisi/divisi_tambah',$data);
    }

    function simpan(){
        $divisi =  $this->input->post('divisi');

        $simpan = $this->Divisi_M->save($divisi);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/divisi/');
        
        }else{

        }
    }

    function update($id){
         

        $data['divisi'] = $this->Divisi_M->getById(base64_decode($id));

       

        $data["title"] = "List Data Master Divisi";
        $this->template->load('template','divisi/divisi_edit',$data);
    }

    function update_simpan(){
        $divisi_id  = $this->input->post('divisi_id');
        $divisi_nama  = $this->input->post('divisi');


        $simpan = $this->Divisi_M->update($divisi_id,$divisi_nama);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/divisi/');
        
        }else{

        }


    }

    function hapus(){
        $div_id = $this->input->post('id');

		$this->db->where('div_id',$div_id);
		$sql = $this->db->delete('div_master');
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
