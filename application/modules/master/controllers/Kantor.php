<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kantor extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('Kantor_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       
        //$data["Kantor"] = $this->Kantor_M->getAll();
        $data["title"] = "List Data Master Kantor";
        $this->template->load('template','kantor/kantor_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Kantor_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Kantor) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Kantor/update/'.base64_encode($data_Kantor->ktr_id))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Kantor->ktr_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Kantor->ktr_kd;
            $row[] = $data_Kantor->ktr_nm;
            $row[] = $data_Kantor->ktr_koordinator;
            $row[] = $data_Kantor->ktr_lat;
            $row[] = $data_Kantor->ktr_long;
            $row[] = $data_Kantor->ktr_radius;
           
           	$row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Kantor_M->count_all(),
            "recordsFiltered" => $this->Kantor_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Kantor"] = $this->Kantor_M->getAll();
          $data["title"] = "List Data Master Kantor";
          $this->template->load('template','kantor/kantor_tambah',$data);
    }

    function simpan(){
        $kantor_nama =  $this->input->post('kantor_nama');

        $kode_kantor =  $this->input->post('kode_kantor');

        $koordinator =  $this->input->post('koordinator');

       

        $lat =  $this->input->post('lat');
        $long =  $this->input->post('long');


        $data = array(
            'kantor_nama' =>$kantor_nama,
            'kantor_kd' =>$kode_kantor,
            'koordinator'=>$koordinator,
            'lat' =>$lat,
            'long' =>$long,
            'ktr_aktif' => 'Y',
        );

        // echo "<pre>";
        // print_r($data);
        // die;

        $simpan = $this->db->insert('m_kantor', $data);

       // $simpan = $this->Kantor_M->save($data);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Kantor/');
        
        }else{

        }
    }

    function update($id){
         

        $data['Kantor'] = $this->Kantor_M->getById(base64_decode($id));

       

        $data["title"] = "List Data Master Kantor";
        $this->template->load('template','kantor/kantor_edit',$data);
    }

    function update_simpan(){

        $ktr_id =  $this->input->post('ktr_id');


        $kantor_nama =  $this->input->post('kantor_nama');

        $kode_kantor =  $this->input->post('kode_kantor');

        $koordinator =  $this->input->post('koordinator');
        $lat =  $this->input->post('lat');
        $long =  $this->input->post('long');


        $data = array(
            'kantor_nama' =>$kantor_nama,
            'kantor_kd' =>$kode_kantor,
            'koordinator'=>$koordinator,
            'lat' =>$lat,
            'long' =>$long,
            'ktr_aktif' => 'Y',
        );


        $simpan = $this->Kantor_M->update($ktr_id,$data);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Kantor/');
        
        }else{

        }


    }

    function hapus(){
        $ktr_id = $this->input->post('id');

		$this->db->where('ktr_id',$ktr_id);
		$sql = $this->db->delete('m_kantor');
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
