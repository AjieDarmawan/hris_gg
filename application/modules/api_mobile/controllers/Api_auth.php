<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_auth extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
       $this->load->model(array('auth/auth_model'));
		
    }

    function kar_tampil_id($kar_id)
	{
		$sql = "SELECT kar_master.kar_nik,
        kar_master.kar_nik,
        kar_master.kar_nm,
        kar_master.kar_tgl_lahir,
        kar_master.kar_long,
        kar_master.kar_lat,
        kar_master.kar_radius,
        acc_master.acc_img, 
        jbt_master.jbt_nm,lvl_master.lvl_nm,div_master.div_nm,unt_nm,ktr_master.ktr_nm,
        kar_detail.kar_dtl_alt,
        kar_detail.kar_dtl_tlp,
        kar_detail.kar_dtl_eml,
        kar_detail.kar_dtl_no_ktp,
        kar_detail.kar_dtl_tmp_lhr,
        kar_detail.kar_dtl_pnd,
        kar_detail.kar_dtl_tgl_joi
        FROM 
        kar_master,
        jbt_master,
        lvl_master,
        div_master,
        unt_master,
        ktr_master,
        acc_master,
        kar_detail
         WHERE 
        kar_master.jbt_id=jbt_master.jbt_id AND 
        kar_master.lvl_id=lvl_master.lvl_id AND
        kar_master.div_id=div_master.div_id AND
        kar_master.unt_id=unt_master.unt_id AND
        kar_master.ktr_id=ktr_master.ktr_id AND
        acc_master.kar_id=kar_master.kar_id AND
        kar_detail.kar_id=kar_master.kar_id AND
        kar_master.kar_id='$kar_id'
        ORDER BY kar_master.kar_id";
		$query = $this->db->query($sql)->row();
        return $query;
	}


    

    // redirect if needed, otherwise display the user list
    public function login()
    {
        $user = $this->auth_model->login(
            $this->input->post('username'), 
            $this->input->post('password'));

            if($user){
                $data = array(
                    'status'=>200,
                    'message'=>'success',
                    'data'=>$user,
                );
            }else{

                $data = array(
                    'status'=>404,
                    'message'=>'gagal',
                    'data'=>array(),
                );

            }

            echo json_encode($data);


           
    }

    function users_detail(){
        $kar_id = $this->input->post('kar_id');

       $kar = $this->kar_tampil_id($kar_id);

       echo json_encode($kar);
    }

   

  
}
