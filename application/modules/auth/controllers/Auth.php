<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('auth_model','pegawai/Pegawai_model'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $this->template->load('template','login');

        $this->load->view('login');
        //redirect('auth/logout', 'refresh');
    }

    // log the user in
     public function login()
    {   
        $username =  $this->input->post('username');
        $password = $this->input->post('password');
        if($username=='SG00212004' || $username=='SG05842020' || $username=='SG06172021'|| $username=='SG00372007' ||  $username=='SG04472018'){
            $user = $this->auth_model->login(
                $username, 
                 $password);
              
           
  
             $pegawai = $this->Pegawai_model->select_by_id($user['kar_id']);
 
             // echo "<pre>";
             // print_r($pegawai);
             //     die;
 
 
             if($user){
                 $this->session->set_userdata(array('pegawai'=>$pegawai));
 
                 redirect('pegawai');
             }else{
                   echo "<script> alert('Password Anda Salah');</script>";
                   echo "<script>window.location.href = 'index';</script>";
             }
        }else{
          // redirect('auth');
          // redirect('auth');

         
           echo "<script> alert('User ini Tidak Berhak Untuk Akses Halaman ini');</script>";
           echo "<script>window.location.href = 'index';</script>";
          
        }
       
           

            
    }

    // log the user out
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth', false);
    }

    function error(){
        $this->load->view('errors/html/error_404');
    }
    function tes(){

        $this->load->view('layouts/template');

    }

}
