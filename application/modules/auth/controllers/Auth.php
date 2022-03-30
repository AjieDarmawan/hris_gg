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
        
       
            $user = $this->auth_model->login(
                $this->input->post('username'), 
                $this->input->post('password'));
               
 
            $pegawai = $this->Pegawai_model->select_by_id($user['id_kar']);


            if($user){
                $this->session->set_userdata(array('pegawai'=>$pegawai));

                redirect('pegawai');
            }else{
                redirect('auth');
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
