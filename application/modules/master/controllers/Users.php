<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();

        // echo "<pre>";
        // print_r($sess);
        // die;
      


        if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Users_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        
        // $sess = $this->session->userdata(['pegawai']['username']);
        // echo "<pre>";
        // print_r($sess);
        // die;
        //$data["users"] = $this->Users_M->getAll();
        $data["title"] = "List Data Master users";
        $this->template->load('template','users/users_v',$data);
     
    }


    public function ajax_list()
    {

        
        header('Content-Type: application/json');
        $list = $this->Users_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_users) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/users/update/'.base64_encode($data_users->id_users))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_users->id_users' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";

            if($data_users->role==1){
                $role = "Admin";
            }elseif($data_users->role==2){
                $role = "Users";
            }

            if($data_users->status==1){
                $status = "Aktif";
            }elseif($data_users->status==2){
                $status = "Non Aktif";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_users->username;
            $row[] = $role;
            $row[] = $status;
           	$row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Users_M->count_all(),
            "recordsFiltered" => $this->Users_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["users"] = $this->Users_M->getAll();
          $data["title"] = "List Data Master users";
          $this->template->load('template','users/users_tambah',$data);
    }

    function simpan(){
        $users =  $this->input->post('username');
        $password =  $this->input->post('password');
        $role =  $this->input->post('role');

        $simpan = $this->Users_M->save($users,$password,$role);

        if($simpan){

            $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan User '.$users.' id '.$this->db->insert_id(),
              'datetime'=>date('Y-m-d H:i:s'),
            );
     
            $this->db->insert('log',$data_log);


           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/users/');
        
        }else{

        }
    }

    function update($id){
         
        $data['users'] = $this->Users_M->getById(base64_decode($id));
        $data["title"] = "List Data Master users";
        $this->template->load('template','users/users_edit',$data);
    }

    function update_simpan(){
        $id_users  = $this->input->post('id_users');
        $users =  $this->input->post('username');
        $password =  $this->input->post('password');
        $role =  $this->input->post('role');


        $simpan = $this->Users_M->update($id_users,$users,$password,$role);

        if($simpan){

            $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Mengedit User '.$users.' id '.$id_users,
              'datetime'=>date('Y-m-d H:i:s'),
            );
     
            $this->db->insert('log',$data_log);


           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/users/');
        
        }else{

        }

    }

    function hapus(){
        $id_users = $this->input->post('id');

		$this->db->where('id_users',$id_users);
		$sql = $this->db->delete('users');

        $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Menghapus User  id '.$id_users,
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


    
    
}
