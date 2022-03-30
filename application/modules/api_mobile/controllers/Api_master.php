<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_master extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
       $this->load->model(array('Api_M'));
		
    }
    

    // redirect if needed, otherwise display the user list
    public function master_aktivity()
    {
            $data  = $this->Api_M->get_master_wfh();
            echo json_encode($data);
    }


    function get_aktifitas()
    {

		$wfh_id = $this->input->post('wfh_id');

        //$wfh_id = 1;
		$sql = $this->db->query('select * from wfh_master where wfh_id='.$wfh_id)->row();
		$wfh_aksi = explode(',',$sql->wfh_aksi);

        echo json_encode($wfh_aksi);

		// foreach($wfh_aksi as $w){
		// 	echo "<option value=$w>$w</option>";
		// }

	}


	function get_aktifitas_satuan(){

		$wfh_id = $this->input->post('wfh_id');

    //$wfh_id = 1;
		$sql = $this->db->query('select * from wfh_master where wfh_id='.$wfh_id)->row();
		$wfh_satuan = explode(',',$sql->wfh_satuan);

        echo json_encode($wfh_satuan);
		// foreach($wfh_satuan as $w){
		// 	echo "<option value=$w>$w</option>";
		// }

	}

   

  
}
