<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jurusan extends CI_Controller
{


    function __construct(){
        parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
            //redirect('auth');
        }else{
            redirect('auth');
        }
        $this->load->model(array('Jurusan_M','Jenis_M'));
        
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        

        //$data["Jurusan"] = $this->Jurusan_M->getAll();
        $data["title"] = "List Data Master Jurusan";
        $this->template->load('template','jurusan/Jurusan_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Jurusan_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Jurusan) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Jurusan/update/'.base64_encode($data_Jurusan->id_jurusan))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Jurusan->id_jurusan' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Jurusan->jurusan_nama;
            $row[] = $data_Jurusan->jenis_nama;
          
            $row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Jurusan_M->count_all(),
            "recordsFiltered" => $this->Jurusan_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          $data["jenis"] = $this->Jenis_M->getAll();


        //   echo "<pre>";
        //   print_r($data);
        //   die;

        
          $data["title"] = "List Data Master Jurusan";
          $this->template->load('template','jurusan/Jurusan_tambah',$data);
    }

    function simpan(){
        $Jurusan =  $this->input->post('jurusan');

        $id_jenis =  $this->input->post('id_jenis');

        

        $simpan = $this->Jurusan_M->save($Jurusan,$id_jenis);

        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Jurusan/');
        
        }else{

        }
    }

    function update($id){

        $data["jenis"] = $this->Jenis_M->getAll();
        $data['Jurusan'] = $this->Jurusan_M->getById(base64_decode($id));


        // echo "<pre>";
        // print_r($data['Jurusan']);
        // die;
        $data["title"] = "List Data Master Jurusan";
        $this->template->load('template','jurusan/Jurusan_edit',$data);
    }

    function update_simpan(){
        $id_jurusan  = $this->input->post('id_jurusan');
        $Jurusan_nama  = $this->input->post('jurusan');
        $id_jenis =  $this->input->post('id_jenis');





        $simpan = $this->Jurusan_M->update($id_jurusan,$Jurusan_nama,$id_jenis);

        if($simpan){
           $this->session->set_flashdata('status',"success");
            $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Jurusan/');
        
        }else{

        }

    }

    function hapus(){
        $id_jurusan = $this->input->post('id');

        $this->db->where('id_jurusan',$id_jurusan);
        $sql = $this->db->delete('jurusan');
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
