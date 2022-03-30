<?php

defined('BASEPATH') or exit('No direct script access allowed');

class jenis_tes extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Jenis_M','Kategori_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        
        // $sess = $this->session->userdata(['pegawai']['username']);
        // echo "<pre>";
        // print_r($sess);
        // die;
        //$data["jenis_tes"] = $this->Jenis_M->getAll();
        $data["title"] = "List Data Master Jenis";
        $this->template->load('template','jenis_tes/jenis_tes_v',$data);
     
    }


    public function ajax_list()
    {

        
        header('Content-Type: application/json');
        $list = $this->Jenis_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_jenis_tes) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/jenis_tes/update/'.base64_encode($data_jenis_tes->id_jenis))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_jenis_tes->id_jenis' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_jenis_tes->jenis_nama;
            $row[] = $data_jenis_tes->kategori_nama;

            
           	$row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Jenis_M->count_all(),
            "recordsFiltered" => $this->Jenis_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          $data["kategori"] = $this->Kategori_M->getAll();
          $data["title"] = "List Data Master jenis_tes";
          $this->template->load('template','jenis_tes/jenis_tes_tambah',$data);
    }

    function simpan(){
        $jenis_tes =  $this->input->post('jenis_tes');

        $id_kategori =  $this->input->post('id_kategori');

        $simpan = $this->Jenis_M->save($jenis_tes,$id_kategori);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/jenis_tes/');
        
        }else{

        }
    }

    function update($id){
         
        $data["kategori"] = $this->Kategori_M->getAll();
        $data['jenis_tes'] = $this->Jenis_M->getById(base64_decode($id));
        $data["title"] = "List Data Master jenis_tes";
        $this->template->load('template','jenis_tes/jenis_tes_edit',$data);
    }

    function update_simpan(){
        $id_jenis  = $this->input->post('id_jenis');
        $jenis_tes_nama  = $this->input->post('jenis_tes');
        $id_kategori =  $this->input->post('id_kategori');


        $simpan = $this->Jenis_M->update($id_jenis,$jenis_tes_nama,$id_kategori);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/jenis_tes/');
        
        }else{

        }

    }

    function hapus(){
        $id_jenis = $this->input->post('id');

		$this->db->where('id_jenis',$id_jenis);
		$sql = $this->db->delete('jenis');
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
