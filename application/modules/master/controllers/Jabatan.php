<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('Jabatan_M','Divisi_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        

        $data["title"] = "List Data Master Jabatan";
        $this->template->load('template','jabatan/jabatan_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Jabatan_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_jbt) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/jabatan/update/'.base64_encode($data_jbt->jbt_id))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_jbt->jbt_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_jbt->jbt_nm;
            $row[] = $data_jbt->div_nm;
            $row[] = "";

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Jabatan_M->count_all(),
            "recordsFiltered" => $this->Jabatan_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function tambah(){
         $data["divisi"] = $this->Divisi_M->getAll();
        $data["title"] = "List Data Master jabatan";
        $this->template->load('template','jabatan/jabatan_tambah',$data);
  }

  function simpan(){
      $jabatan =  $this->input->post('jabatan');
      $div_id =  $this->input->post('div_id');

      $simpan = $this->Jabatan_M->save($jabatan,$div_id);

      if($simpan){
         $this->session->set_flashdata('status',"success");
          $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
          
          redirect('master/jabatan/');
      
      }else{

      }
  }

  function update($id){
       

      $data['jabatan'] = $this->Jabatan_M->getById(base64_decode($id));
      $data["divisi"] = $this->Divisi_M->getAll();

      

      $data["title"] = "List Data Master jabatan";
      $this->template->load('template','jabatan/jabatan_edit',$data);
  }

  function update_simpan(){
      $jabatan_id  = $this->input->post('jabatan_id');
      $jabatan_nama  = $this->input->post('jabatan');
      $div_id  = $this->input->post('div_id');


      $simpan = $this->Jabatan_M->update($jabatan_id,$jabatan_nama,$div_id);

      if($simpan){
         $this->session->set_flashdata('status',"success");
          $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
          
          redirect('master/jabatan/');
      
      }else{

      }


  }

  function hapus(){
      $jbt_id = $this->input->post('id');

      $this->db->where('jbt_id',$jbt_id);
      $sql = $this->db->delete('jbt_master');
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
