<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Kategori_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        
        // $sess = $this->session->userdata(['pegawai']['username']);
        // echo "<pre>";
        // print_r($sess);
        // die;
        //$data["Kategori"] = $this->Kategori_M->getAll();
        $data["title"] = "List Data Master Kategori";
        $this->template->load('template','kategori/kategori_v',$data);
     
    }


    public function ajax_list()
    {

        
        header('Content-Type: application/json');
        $list = $this->Kategori_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Kategori) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Kategori/update/'.base64_encode($data_Kategori->id_kategori))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Kategori->id_kategori' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Kategori->kategori_nama;
           	$row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Kategori_M->count_all(),
            "recordsFiltered" => $this->Kategori_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Kategori"] = $this->Kategori_M->getAll();
          $data["title"] = "List Data Master Kategori";
          $this->template->load('template','kategori/kategori_tambah',$data);
    }

    function simpan(){
        $Kategori =  $this->input->post('kategori');

        $simpan = $this->Kategori_M->save($Kategori);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Kategori/');
        
        }else{

        }
    }

    function update($id){
         
        $data['kategori'] = $this->Kategori_M->getById(base64_decode($id));
        $data["title"] = "List Data Master Kategori";
        $this->template->load('template','kategori/kategori_edit',$data);
    }

    function update_simpan(){
        $id_kategori  = $this->input->post('id_kategori');
        $Kategori_nama  = $this->input->post('kategori');


        $simpan = $this->Kategori_M->update($id_kategori,$Kategori_nama);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Kategori/');
        
        }else{

        }

    }

    function hapus(){
        $id_kategori = $this->input->post('id');

		$this->db->where('id_kategori',$id_kategori);
		$sql = $this->db->delete('kategori');
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
