<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('auth_model','karyawan_model'));
        // $this->load->model(array('auth_model'));
    }

    // redirect if needed, otherwise display the user list
    public function index()
    {
       
        redirect('auth/logout', 'refresh');
    }

    // log the user in
    public function login()
    {


        $this->template->load('template','auth/login');
        die;
        if($this->session->userdata('devs')){
            // logged in
            redirect('home');
            
        }elseif($this->session->userdata('it')){
            // do login
            // $user = $this->auth_model->login($this->input->post('username'), $this->input->post('password'));
            $user = (array) $this->session->userdata('session')['biodata_detail'];
            $user['id'] = $this->session->userdata('session')['user']->id;
            // if($user){
                // set session user
                $this->session->set_userdata(array('devs'=>$user));
                // set session karyawan
                $karyawan = $this->karyawan_model->select_by_id($this->session->userdata('m_karyawan_id'));
                $this->session->set_userdata(array('karyawan'=>$karyawan));
                // // set session subdit
                $subdit = $this->karyawan_model->get_organisasi_by_id_karyawan($this->session->userdata('m_karyawan_id'),3);
                $this->session->set_userdata(array('subdit'=>$subdit));
                // // set session jabatan
                $jabatan = $this->karyawan_model->get_jabatan_by_karyawan_id($this->session->userdata('m_karyawan_id'));
                $this->session->set_userdata(array('jabatan'=>$jabatan));
            // }
            redirect('auth/login', 'refresh');
        }else{
            redirect(baseapplicationhcm, false);
        }
    }

    // log the user out
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(baseapplicationhcm, false);
    }

}
