<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Event extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Event_M','Materi_M','Jenis_M','Kategori_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $sess = $this->session->userdata();
        // echo "<pre>";
        // print_r($sess['pegawai']->username);
        // die;
        //$data["Event"] = $this->Event_M->getAll();
        $data["title"] = "List Data Master Event";
        $this->template->load('template','event/event_v',$data);
     
    }


    public function ajax_list()
    {


       


        header('Content-Type: application/json');
        $list = $this->Event_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Event) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Event/update/'.base64_encode($data_Event->id_event))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            $materi = "<a data-toggle='tooltip' title='materi'  href=".base_url('master/materi/index/'.base64_encode($data_Event->id_event))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Event->id_event' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Event->judul;
            $row[] = $data_Event->kategori_nama;

            
            $row[] = date('d-m-Y',strtotime($data_Event->tgl_mulai));
            $row[] = date('d-m-Y',strtotime($data_Event->tgl_selesai));
            $row[] = $data_Event->desc;
            $row[] = $data_Event->mode;
            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $edit." ".$delete." ".$materi;
            }else{
                $row[] = $edit."  ".$materi;
            }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Event_M->count_all(),
            "recordsFiltered" => $this->Event_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Event"] = $this->Event_M->getAll();


          $data["kategori"] = $this->Kategori_M->getAll();


        //   echo "<pre>";
        //   print_r($data['kategori']);
        //   die;
          $data["title"] = "List Data Master Event";
          $this->template->load('template','event/event_tambah',$data);
    }

    function simpan(){
        $judul =  $this->input->post('judul');
        $tgl_mulai =  $this->input->post('tgl_mulai');
        $tgl_selesai =  $this->input->post('tgl_selesai');
        $desc =  $this->input->post('desc');
        $mode =  $this->input->post('status');
        $id_kategori = $this->input->post('id_kategori');



        $data_event = array(
            'judul'=>$judul,
            'tgl_mulai'=>$tgl_mulai,
            'tgl_selesai'=>$tgl_selesai,
            'desc'=>$desc,
            'mode'=>$mode,
            'id_kategori'=>$id_kategori,

        );

       $simpan = $this->db->insert('event',$data_event);

       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan Event '.$judul.' id '.$this->db->insert_id(),
         'datetime'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('log',$data_log);



      

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Event/');
        
        }else{

        }
    }

    function update($id){

        $data["kategori"] = $this->Kategori_M->getAll();
        $data['event'] = $this->Event_M->getById(base64_decode($id));
        $data["title"] = "List Data Master Event";
        $this->template->load('template','event/event_edit',$data);
    }

    function update_simpan(){
        $id_event  = $this->input->post('id_event');
        $Event_nama  = $this->input->post('Event');


        $judul =  $this->input->post('judul');
        $tgl_mulai =  $this->input->post('tgl_mulai');
        $tgl_selesai =  $this->input->post('tgl_selesai');
        $desc =  $this->input->post('desc');
        $id_kategori = $this->input->post('id_kategori');



        $data_event = array(
            'judul'=>$judul,
            'tgl_mulai'=>$tgl_mulai,
            'tgl_selesai'=>$tgl_selesai,
            'desc'=>$desc,
            'id_kategori'=>$id_kategori,
        );



        $this->db->where('id_event',$id_event);
        $simpan = $this->db->update('event',$data_event);


        $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Mengedit Event '.$judul.' id '.$id_event,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);



       


        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Event/');
        
        }else{

        }

    }

    function hapus(){
        $id_event = $this->input->post('id');

	

        $materi = $this->db->query('select * from materi where id_event='.$id_event)->result();
        $peserta = $this->db->query('select * from peserta where id_event='.$id_event)->result();

        foreach($materi as $m){
            $this->db->where('materi_id',$m->materi_id);
          $this->db->delete('soalonline');
        }

       

       $this->db->where('id_event',$id_event);
       $this->db->delete('materi');

       if($peserta){
        $this->db->where('id_event',$id_event);
       $this->db->delete('peserta');
      }

       $this->db->where('id_event',$id_event);
       $sql =  $this->db->delete('event');



       $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' menghapus Event id '.$id_event,
         'datetime'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('log',$data_log);



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


    function materi(){

    }




    
    
}
