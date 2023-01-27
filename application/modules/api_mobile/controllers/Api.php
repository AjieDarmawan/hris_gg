<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{


    function __construct(){
        parent::__construct();
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
      // $this->load->model(array('auth/auth_model'));
        
    }

    public function abs_tampil_kar($kar_id,$abs_tgl_masuk)
{
    $sql = "SELECT * FROM abs_master WHERE kar_id='$kar_id' AND abs_tgl_masuk='$abs_tgl_masuk' ORDER BY abs_id";
    $query = $this->db->query($sql)->row_array();
    
    return $query;
}

function abs_settime_id($abs_stm_nm)
{
    $sql = "SELECT * FROM abs_settime WHERE abs_stm_nm='$abs_stm_nm' ORDER BY abs_stm_id";
    $query = $this->db->query($sql)->row_array();
    return $query;
}


function cek_shift_masuk($kar_id){

    //$kar_id = 617;
    $date=date('Y-m-d');
    $time = date('H:i:s');
    $waktu=$time;
                $abs_tgl_masuk=$date;
                $abs_tampil_kar=$this->abs_tampil_kar($kar_id,$abs_tgl_masuk);
                // $data=mysql_fetch_array($abs_tampil_kar);
                // $cek=mysql_num_rows($abs_tampil_kar);

                // echo "<pre>";
                // print_r($abs_tampil_kar);
                error_reporting(0);
                $cek = count($abs_tampil_kar);
                
                
                
                //udah pernah masuk
                if($cek == 0){
                   // echo "tes";

                    $waktu=$time;
                    $t=explode(":",$waktu);
                    if($t[0]=="00"){
                        $jam="24";
                    }else{
                        $jam=$t[0];
                    }
                    $menit=$t[1];

                    //NEW CHANGE
                    $waktu_jam_menit=substr($time, 0,5);

                    //Range Pagi
                    $abs_stm_nm="Jam Telat Pagi";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                    //$abs_settime_data=mysql_fetch_array($abs_settime_id);
                    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
                        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
                            $jam_telat_pagi=substr($kar_data['kar_default_shift1_in'], 0,5);
                        }else{
                            $jam_telat_pagi=substr($kar_data['ktr_default_shift1_in'], 0,5);
                        }
                    }else{
                        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
                            $jam_telat_pagi=substr($kar_data['kar_default_shift1_in'], 0,5);
                        }else{
                            $jam_telat_pagi=substr($abs_settime_data['abs_stm_jam'], 0,5);
                        }
                    }                       

                    //Range Siang
                    $abs_stm_nm="Jam Telat Siang";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                    //$abs_settime_data=mysql_fetch_array($abs_settime_id);
                    if(!empty($kar_data['ktr_default_shift2_in']) && !empty($kar_data['ktr_default_shift2_out'])){
                        if(!empty($kar_data['kar_default_shift2_in']) && !empty($kar_data['kar_default_shift2_out'])){
                            $jam_telat_siang=substr($kar_data['kar_default_shift2_in'], 0,5);
                        }else{
                            $jam_telat_siang=substr($kar_data['ktr_default_shift2_in'], 0,5);
                        }
                    }else{
                        if(!empty($kar_data['kar_default_shift2_in']) && !empty($kar_data['kar_default_shift2_out'])){
                            $jam_telat_siang=substr($kar_data['kar_default_shift2_in'], 0,5);
                        }else{
                            $jam_telat_siang=substr($abs_settime_data['abs_stm_jam'], 0,5);
                        }
                    }

                    //Range Sore
                    $abs_stm_nm="Jam Telat Sore";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                    //$abs_settime_data=mysql_fetch_array($abs_settime_id);
                    if(!empty($kar_data['ktr_default_shift3_in']) && !empty($kar_data['ktr_default_shift3_out'])){
                        if(!empty($kar_data['kar_default_shift3_in']) && !empty($kar_data['kar_default_shift3_out'])){
                            $jam_telat_sore=substr($kar_data['kar_default_shift3_in'], 0,5);
                        }else{
                            $jam_telat_sore=substr($kar_data['ktr_default_shift3_in'], 0,5);
                        }
                    }else{
                        if(!empty($kar_data['kar_default_shift3_in']) && !empty($kar_data['kar_default_shift3_out'])){
                            $jam_telat_sore=substr($kar_data['kar_default_shift3_in'], 0,5);
                        }else{
                            $jam_telat_sore=substr($abs_settime_data['abs_stm_jam'], 0,5);
                        }
                    }

                    //Range Malam
                    $abs_stm_nm="Jam Telat Malam";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                    //$abs_settime_data=mysql_fetch_array($abs_settime_id);
                    if(!empty($kar_data['ktr_default_shift4_in']) && !empty($kar_data['ktr_default_shift4_out'])){
                        if(!empty($kar_data['kar_default_shift4_in']) && !empty($kar_data['kar_default_shift4_out'])){
                            $jam_telat_malam=substr($kar_data['kar_default_shift4_in'], 0,5);
                        }else{
                            $jam_telat_malam=substr($kar_data['ktr_default_shift4_in'], 0,5);
                        }
                    }else{
                        if(!empty($kar_data['kar_default_shift4_in']) && !empty($kar_data['kar_default_shift4_out'])){
                            $jam_telat_malam=substr($kar_data['kar_default_shift4_in'], 0,5);
                        }else{
                            $jam_telat_malam=substr($abs_settime_data['abs_stm_jam'], 0,5);
                        }
                    }


                    if ($jam >= 00 and $jam < 10 ){ // > change >=
                        if ($menit >= 00 and $menit<60){ // > change >=
                        $ucapan="Shift Pagi";
                        $checked_pagi="checked";
                            if($waktu_jam_menit > $jam_telat_pagi){
                                $type="button";
                                $name="";
                            

                                //Tampil selisih terlambat
                                $start_date = new DateTime(''.$date.' '.$jam_telat_pagi.'');
                                $since_start = $start_date->diff(new DateTime(''.$date.' '.$time.''));
                                if($since_start->h > 0){
                                    $jam_telat=$since_start->h." Jam ".$since_start->i." Menit ".$since_start->s." Detik ";
                                }else{
                                    $jam_telat=$since_start->i." Menit ".$since_start->s." Detik ";
                                }
                                    

                            }
                            else{
                                $type="button";
                                $name="";
                            
                            }
                        }
                    }else if ($jam >= 10 and $jam < 13 ){
                        if ($menit >= 00 and $menit<60){ // > change >=
                        $ucapan="Shift Siang";
                        $checked_siang="checked";
                            if($waktu_jam_menit > $jam_telat_siang){
                                $type="button";
                                $name="";
                                
                                
                                //Tampil selisih terlambat
                                $start_date = new DateTime(''.$date.' '.$jam_telat_siang.'');
                                $since_start = $start_date->diff(new DateTime(''.$date.' '.$time.''));
                                    if($since_start->h > 0){
                                    $jam_telat=$since_start->h." Jam ".$since_start->i." Menit ".$since_start->s." Detik ";
                                }else{
                                    $jam_telat=$since_start->i." Menit ".$since_start->s." Detik ";
                                }

                            }else{
                                $type="button";
                                $name="";
                                
                            }
                        }
                    }else if ($jam >= 13 and $jam < 18 ){
                        if ($menit >= 00 and $menit<60){ // > change >=
                        $ucapan="Shift Sore";
                        $checked_sore="checked";
                            if($waktu_jam_menit > $jam_telat_sore){
                                $type="button";
                                $name="";
                                
                                
                                //Tampil selisih terlambat
                                $start_date = new DateTime(''.$date.' '.$jam_telat_sore.'');
                                $since_start = $start_date->diff(new DateTime(''.$date.' '.$time.''));
                                    if($since_start->h > 0){
                                    $jam_telat=$since_start->h." Jam ".$since_start->i." Menit ".$since_start->s." Detik ";
                                }else{
                                    $jam_telat=$since_start->i." Menit ".$since_start->s." Detik ";
                                }

                            }else{
                                $type="button";
                                $name="";
                                
                            }
                        }
                    }else if ($jam >= 18 and $jam <= 24 ){
                        if ($menit >= 00 and $menit<60){ // > change >=
                        $ucapan="Shift Malam";
                        
                    
                        }
                    }else {
                        $ucapan="Error";
                    }

                    return $ucapan;

                   // $this->cek_status_masuk($ucapan);
                }else{
                    //belum masuk
                    return "Belum Masuk";




                }

}


function cek_status_masuk($ucapan){
    $time = date('H:i:s');
    $waktu=$time;
    $t=explode(":",$waktu);
    if($t[0]=="00"){
        $jam="24";
    }else{
        $jam=$t[0];
    }
    $menit=$t[1];

    //NEW CHANGE
    $waktu_jam_menit=substr($time, 0,5);

    //Range Pagi
    $abs_stm_nm="Jam Telat Pagi";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                  //  $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_telat_pagi=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_telat_pagi=substr($kar_data['ktr_default_shift1_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_telat_pagi=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_telat_pagi=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    //Range Siang
    $abs_stm_nm="Jam Telat Siang";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                   // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift2_in']) && !empty($kar_data['ktr_default_shift2_out'])){
        if(!empty($kar_data['kar_default_shift2_in']) && !empty($kar_data['kar_default_shift2_out'])){
            $jam_telat_siang=substr($kar_data['kar_default_shift2_in'], 0,5);
        }else{
            $jam_telat_siang=substr($kar_data['ktr_default_shift2_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift2_in']) && !empty($kar_data['kar_default_shift2_out'])){
            $jam_telat_siang=substr($kar_data['kar_default_shift2_in'], 0,5);
        }else{
            $jam_telat_siang=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    //Range Sore
    $abs_stm_nm="Jam Telat Sore";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                    //$abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift3_in']) && !empty($kar_data['ktr_default_shift3_out'])){
        if(!empty($kar_data['kar_default_shift3_in']) && !empty($kar_data['kar_default_shift3_out'])){
            $jam_telat_sore=substr($kar_data['kar_default_shift3_in'], 0,5);
        }else{
            $jam_telat_sore=substr($kar_data['ktr_default_shift3_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift3_in']) && !empty($kar_data['kar_default_shift3_out'])){
            $jam_telat_sore=substr($kar_data['kar_default_shift3_in'], 0,5);
        }else{
            $jam_telat_sore=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    //Range Malam
    $abs_stm_nm="Jam Telat Malam";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                   // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift4_in']) && !empty($kar_data['ktr_default_shift4_out'])){
        if(!empty($kar_data['kar_default_shift4_in']) && !empty($kar_data['kar_default_shift4_out'])){
            $jam_telat_malam=substr($kar_data['kar_default_shift4_in'], 0,5);
        }else{
            $jam_telat_malam=substr($kar_data['ktr_default_shift4_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift4_in']) && !empty($kar_data['kar_default_shift4_out'])){
            $jam_telat_malam=substr($kar_data['kar_default_shift4_in'], 0,5);
        }else{
            $jam_telat_malam=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }
    
    //PENAMBAHAN//
    //Range Tepat Pagi
    $abs_stm_nm="Jam Tepat Pagi";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                   // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_pagi=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_pagi=substr($kar_data['ktr_default_shift1_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_pagi=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_pagi=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }
    
    //PENAMBAHAN//
    //Range Tepat Siang
    $abs_stm_nm="Jam Tepat Siang";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                   // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_siang=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_siang=substr($kar_data['ktr_default_shift1_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_siang=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_siang=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }
    
    //PENAMBAHAN//
    //Range Tepat Sore
    $abs_stm_nm="Jam Tepat Sore";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                   // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_sore=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_sore=substr($kar_data['ktr_default_shift1_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_sore=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_sore=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }
    
    //PENAMBAHAN//
    //Range Tepat Malam
    $abs_stm_nm="Jam Tepat Malam";
                    $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
                   // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_malam=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_malam=substr($kar_data['ktr_default_shift1_in'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_tepat_malam=substr($kar_data['kar_default_shift1_in'], 0,5);
        }else{
            $jam_tepat_malam=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

     $shift = $ucapan;

    // echo $shift;

   // $shift = "Shift Pagi";

    if ($shift == "Shift Pagi"){
        
        $abs_shift="Shift Pagi";
            if($waktu_jam_menit > $jam_telat_pagi){
                $abs_rwd_masuk="Telat";
                                            $abs_point=30;
       
                 }
            elseif($waktu_jam_menit < $jam_tepat_pagi){
                $abs_rwd_masuk="Rajin";
                                            $abs_point=80;
                
                                            
                                    }
            elseif($waktu_jam_menit = $jam_tepat_pagi){
                $abs_rwd_masuk="Tepat";
              
                                            
                                    }else{
                $abs_rwd_masuk="Error";
            }
        
    }else if ($shift == "Shift Siang"){
        
        $abs_shift="Shift Siang";
            if($waktu_jam_menit > $jam_telat_siang){
                $abs_rwd_masuk="Telat";
                                            $abs_point=30;
             
                                            
                                    }
            elseif($waktu_jam_menit < $jam_tepat_siang){
                $abs_rwd_masuk="Rajin";
                                            $abs_point=80;
               
                                            
                                    }
            elseif($waktu_jam_menit = $jam_tepat_siang){
                $abs_rwd_masuk="Tepat";
                                            $abs_point=50;
              
                                            
                                    }else{
                $abs_rwd_masuk="Error";
            }

            //echo $abs_rwd_masuk;
        
    }else if ($shift == "Shift Sore"){

        // echo "tes";
        // die;

       // echo $jam_telat_sore;
    
        $abs_shift="Shift Sore";
            if($waktu_jam_menit > $jam_telat_sore){
                $abs_rwd_masuk="Telat";
                                            $abs_point=30;
                
                                            
                                    }
            elseif($waktu_jam_menit < $jam_tepat_sore){
                $abs_rwd_masuk="Rajin";
                                            $abs_point=80;
               
                                    
                                    }
            elseif($waktu_jam_menit = $jam_tepat_sore){
                $abs_rwd_masuk="Tepat";
                                            $abs_point=50;
                
                                            
                                    }else{
                $abs_rwd_masuk="Error";
            }
        
    }else if ($shift == "Shift Malam"){
        
        $abs_shift="Shift Malam";
         $abs_rwd_masuk="Rajin";
        $abs_point=50;
                                        
                           
    }else {
        $abs_shift="Error";
    }

    // echo $abs_rwd_masuk;
    // echo "<br>";
    // echo $abs_point;

    $data_show = array(
        'abs_rwd_masuk'=>$abs_rwd_masuk,
        'abs_point'=>$abs_point,
    );

    //echo json_encode($data_show);
    // //print_r($data_show);
    return $data_show;

  // echo "";

}








function cek_status_pulang($kar_id){
    //$time = date('H:i:s');
        $time = '18:01:00';

    // $kar_id = 617;
    // $unt_id = 0;
    // $ktr_id = 0;
    $abs_tgl_masuk=date("Y-m-d");
    $abs_data=$this->abs_tampil_kar($kar_id,$abs_tgl_masuk);
    //$abs_data=mysql_fetch_array($abs_tampil_kar);
    
//     $ip_tampil_unt_ktr=$ip->ip_tampil_unt_ktr($unt_id,$ktr_id);
// $ip_data=mysql_fetch_array($ip_tampil_unt_ktr);

// //if($abs_data['abs_ip']==$ip_data['ip_nm']){
//     $abs_ip=$ip_jaringan;

            //NEW CHANGE
    $waktu_jam_menit=substr($time, 0,5);

    //Range Pagi
    $abs_stm_nm="Jam Cepat Pagi";
            $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
            //$abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift1_in']) && !empty($kar_data['ktr_default_shift1_out'])){
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_cepat_pagi=substr($kar_data['kar_default_shift1_out'], 0,5);
        }else{
            $jam_cepat_pagi=substr($kar_data['ktr_default_shift1_out'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift1_in']) && !empty($kar_data['kar_default_shift1_out'])){
            $jam_cepat_pagi=substr($kar_data['kar_default_shift1_out'], 0,5);
        }else{
            $jam_cepat_pagi=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    //Range Siang
    $abs_stm_nm="Jam Cepat Siang";
            $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
            //$abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift2_in']) && !empty($kar_data['ktr_default_shift2_out'])){
        if(!empty($kar_data['kar_default_shift2_in']) && !empty($kar_data['kar_default_shift2_out'])){
            $jam_cepat_siang=substr($kar_data['kar_default_shift2_out'], 0,5);
        }else{
            $jam_cepat_siang=substr($kar_data['ktr_default_shift2_out'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift2_in']) && !empty($kar_data['kar_default_shift2_out'])){
            $jam_cepat_siang=substr($kar_data['kar_default_shift2_out'], 0,5);
        }else{
            $jam_cepat_siang=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    //Range Sore
    $abs_stm_nm="Jam Cepat Sore";
            $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
           // $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift3_in']) && !empty($kar_data['ktr_default_shift3_out'])){
        if(!empty($kar_data['kar_default_shift3_in']) && !empty($kar_data['kar_default_shift3_out'])){
            $jam_cepat_sore=substr($kar_data['kar_default_shift3_out'], 0,5);
        }else{
            $jam_cepat_sore=substr($kar_data['ktr_default_shift3_out'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift3_in']) && !empty($kar_data['kar_default_shift3_out'])){
            $jam_cepat_sore=substr($kar_data['kar_default_shift3_out'], 0,5);
        }else{
            $jam_cepat_sore=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    //Range Malam
    $abs_stm_nm="Jam Cepat Malam";
            $abs_settime_data=$this->abs_settime_id($abs_stm_nm);
          //  $abs_settime_data=mysql_fetch_array($abs_settime_id);
    if(!empty($kar_data['ktr_default_shift4_in']) && !empty($kar_data['ktr_default_shift4_out'])){
        if(!empty($kar_data['kar_default_shift4_in']) && !empty($kar_data['kar_default_shift4_out'])){
            $jam_cepat_malam=substr($kar_data['kar_default_shift4_out'], 0,5);
        }else{
            $jam_cepat_malam=substr($kar_data['ktr_default_shift4_out'], 0,5);
        }
    }else{
        if(!empty($kar_data['kar_default_shift4_in']) && !empty($kar_data['kar_default_shift4_out'])){
            $jam_cepat_malam=substr($kar_data['kar_default_shift4_out'], 0,5);
        }else{
            $jam_cepat_malam=substr($abs_settime_data['abs_stm_jam'], 0,5);
        }
    }

    // echo "<pre>";
    // print_r($abs_data);
    // die;

    if($abs_data['abs_shift']=="Shift Pagi"){
            $jamloyal = substr($jam_cepat_pagi , 0,2).":29";
    $jamtepat = substr($jam_cepat_pagi , 0,2).":30";
        if($waktu_jam_menit < $jam_cepat_pagi){
            // echo "HAHAH";
            // die;
            $abs_rwd_pulang="Izin";
            $abs_point=($abs_data['abs_point']+30);
        
            $ntf_act="Absen Pulang";
                 
                    //End Notify

        }elseif($waktu_jam_menit > $jamloyal){
            $abs_rwd_pulang="Loyal";
            $abs_point=($abs_data['abs_point']+80);
        
            $ntf_act="Absen Pulang";
                  

        }elseif($waktu_jam_menit >= $jam_cepat_pagi && $waktu_jam_menit < $jamtepat){
            $abs_rwd_pulang="Tepat";
            $abs_point=($abs_data['abs_point']+50);
        
            $ntf_act="Absen Pulang";
                   
        }

    }elseif($abs_data['abs_shift']=="Shift Siang"){
            $jamloyal = substr($jam_cepat_siang , 0,2).":29";
    $jamtepat = substr($jam_cepat_siang , 0,2).":30";
        if($waktu_jam_menit < $jam_cepat_siang){
            $abs_rwd_pulang="Izin";
            $abs_point=($abs_data['abs_point']+30);
        
            $ntf_act="Absen Pulang";
                

        }elseif($waktu_jam_menit > $jamloyal){
            $abs_rwd_pulang="Loyal";
            $abs_point=($abs_data['abs_point']+80);
        
            $ntf_act="Absen Pulang";
                  

        }elseif($waktu_jam_menit >= $jam_cepat_siang && $waktu_jam_menit < $jamtepat){
            $abs_rwd_pulang="Tepat";
            $abs_point=($abs_data['abs_point']+50);
        
                    $ntf_act="Absen Pulang";
                   
        }
    }elseif($abs_data['abs_shift']=="Shift Sore"){
            $jamloyal = substr($jam_cepat_sore , 0,2).":29";
    $jamtepat = substr($jam_cepat_sore , 0,2).":30";
        if($waktu_jam_menit < $jam_cepat_sore){
            $abs_rwd_pulang="Izin";
            $abs_point=($abs_data['abs_point']+30);
        
            $ntf_act="Absen Pulang";
                 
        }elseif($waktu_jam_menit > $jamloyal){
            $abs_rwd_pulang="Loyal";
            $abs_point=($abs_data['abs_point']+80);
        
            $ntf_act="Absen Pulang";
                   

        }elseif($waktu_jam_menit >= $jam_cepat_sore && $waktu_jam_menit < $jamtepat){
            $abs_rwd_pulang="Tepat";
            $abs_point=($abs_data['abs_point']+50);
    
            $ntf_act="Absen Pulang";
                  
        }
    }elseif($abs_data['abs_shift']=="Shift Malam"){

            $abs_rwd_pulang="Loyal";
            $abs_point=($abs_data['abs_point']+50);
    
            $ntf_act="Absen Pulang";
                 

    }else{
       
    }

    // echo $abs_rwd_pulang;
    // echo "<br>";
    // echo $abs_point;

    $data_show = array(
        'abs_rwd_pulang'=>$abs_rwd_pulang,
        'abs_point'=>$abs_point,
    );
    //return $data_show;

    return $data_show;
}



function save_photo($img,$kar_nik)
{

    // echo "<pre>";
    // print_r($img);
    // die;

    $tmpfile = $img['tmp_name'];
    $type = $img['type'];
    $filename = basename($img['name']);
    $url = "https://cb.web.id/apikaryawan/getdata.php";
    $ch = curl_init($url);

    $postData = array(
        "type" => "upload_foto",
        //"username" => "SG06172021",

         "username" => str_replace(".","",$kar_nik),
        // 'img' => '@'.$tmpfile.';filename='.$filename,
        'img' => curl_file_create($tmpfile, $type, $filename)

    );




    // for sending data as json type
   $fields = json_encode($postData);


//    echo "<pre>";
//    print_r($fields);
//    die;


    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json', // if the content type is json
            'Content-Type: multipart/form-data'
            //  'bearer: '.$token // if you need token in header
        )
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));


    $result = curl_exec($ch);
    curl_close($ch);



    $output = json_decode($result);

    return $output;

  

   // echo "tes";
}

function absen()
{

    error_reporting(0);
    $bulan = date('mY');




    //$bulan = '072021';
    $id_kar = $this->input->post('id_kar');
    $alasan = $this->input->post('alasan');
    $ktr_id = $this->input->post('ktr_id');




    $karname = $this->db->query("select kar_nik,kar_id,kar_nm,ktr_id,kar_lat,kar_long from kar_master where kar_id='" . $id_kar . "'")->row();


    $data['jadwal2'] = $this->db->query("select jdw_data from jdw_master as j
    inner join kar_master as k on j.jdw_nik=k.kar_nik 
    where  j.jdw_blnthn = '" . $bulan . "' and j.jdw_nik='" . $karname->kar_nik . "'")->result();






    $jad = $data['jadwal2'][0]->jdw_data;

    $jadwal = explode("#", $jad);

    // echo "<pre>";
    // print_r($jadwal);
    // die;

    $tgl = date('d') - 1;

    $jenis_masuk = $jadwal[$tgl];

    $lat = $this->input->post('lat');
    $long = $this->input->post('long');


    //$kar  = $this->db->query("select * from kar_master where kar_id = '" . $id_kar . "'")->Row();
    $kantor  = $this->db->query("select ktr_id,ktr_nm,ktr_lat,ktr_long,ktr_radius from ktr_master where ktr_id = '" . $karname->ktr_id . "'")->Row();
    $lat_kantor = $kantor->ktr_lat;
    $long_kantor = $kantor->ktr_long;

    //  $jadwal  = $this->db->query("select * from jadwal where kar_id = '".$id_kar."' and date(tanggal) =  '".date('Y-m-d')."'")->Row();


    // echo "<pre>";
    // print_r($kar);
    // die;



    if ($jenis_masuk == 'WFO' || $jenis_masuk == 'P' || $jenis_masuk == 'PS') {

        $lat_tujuan = $kantor->ktr_lat;
        $long_tujuan = $kantor->ktr_long;

        $tujuan_kantor = $kantor->ktr_nm;
        $tujuan_kantor_id = $kantor->ktr_id;



    } else if ($jenis_masuk == 'WFH' || $jenis_masuk == 'WH' || $jenis_masuk=='L'|| $jenis_masuk=='LM' ) {

        // $lat_tujuan = $kar->kar_lat;
        // $long_tujuan = $kar->kar_long;

        // if($jenis_masuk=='L'|| $jenis_masuk=='LM'){
        //              $tujuan_kantor = "Di Rumah/Libur";
        //             $tujuan_kantor_id = '171';
        //     }else{
        //          $tujuan_kantor = "WFH";
        //      $tujuan_kantor_id = '171';
        //     }

         if($jenis_masuk=='L'|| $jenis_masuk=='LM'){
                    
                    //$tujuan_kantor_id = '171';

                     $lat_tujuan = $kantor->ktr_lat;
                     $long_tujuan = $kantor->ktr_long;

                   $tujuan_kantor = "Di Rumah/Libur";
                  $tujuan_kantor_id = $kantor->ktr_id;


            }else{

                $lat_tujuan = $karname->kar_lat;
                $long_tujuan = $karname->kar_long;

                 $tujuan_kantor = "WFH";
                $tujuan_kantor_id = '171';
            }






    }

    else if ($jenis_masuk == 'M') {

        $lat_tujuan = $karname->kar_lat;
        $long_tujuan = $karname->kar_long;

         $tujuan_kantor = "WFH";
         $tujuan_kantor_id = '171';
    }


     else {
          $lat_tujuan = $kantor->ktr_lat;
        $long_tujuan = $kantor->ktr_long;

         $tujuan_kantor = $kantor->ktr_nm;
        $tujuan_kantor_id = $kantor->ktr_id;



    }



    // echo "Lat". $lat_tujuan;
    // echo "<br>";
    // echo "Long".$long_tujuan;
    // die;

    // error_reporting(0);

    // echo $jenis_masuk;
    // die;

    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=" . str_replace(" ","",$lat_tujuan).",".str_replace(" ","",$long_tujuan). "&origins=" . $lat . "," . $long . "&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";

   // echo $url;


    $ch = curl_init($url);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json', // if the content type is json
            //  'bearer: '.$token // if you need token in header
        )
    );
    //  curl_setopt($ch, CURLOPT_HEADER, false);
    //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    curl_close($ch);

    //   return $result;

    $output = json_decode($result);


      //   echo "<pre>";
      // //  print_r($output->rows[0]->elements[0]->distance->value);
      //   echo json_encode($output);
      //   die;

    $jarak_skrang = $output->rows[0]->elements[0]->distance->value;

    //echo "<br>";



    //$jarak_orang = $kar->kar_radius;

    if($kar->kar_radius){
        $jarak_orang = $kar->kar_radius;
    }else{
        $jarak_orang = 0.5;
    }


    $jarak_orang2 =   (double)$jarak_orang * 1000;


    


    //40317  >=   500
    if ($jarak_skrang <= $jarak_orang2) {


        $check_absen = $this->db->query("select abs_id,abs_tgl_pulang,abs_tgl_masuk,abs_point,abs_pulang,abs_masuk from abs_master where kar_id = " . $id_kar . " and date(abs_tgl_masuk) = '" . date('Y-m-d') . "'")->row();
        
       

        if ($check_absen) {

           // $cek_shift_masuk_ucapan =  $this->cek_shift_masuk();

          



            // jika dia sif 3 cek pulang kalo ada tambah/insert
            if ($check_absen->abs_tgl_pulang != '0000-00-00') {

                $pho =  $this->save_photo($_FILES['img'],$karname->kar_nik);
                if($pho->msg=='success'){
                $data_absen_simpan = array(
                    'abs_masuk'         =>date('H:i:s'),
                    'abs_pulang'        =>'00:00:00',
                    'abs_ip'            =>'',
                    'abs_tgl_masuk'     =>date('Y-m-d'),
                    'abs_tgl_pulang'    =>'0000-00-00',
                    'abs_alasan_masuk'  =>$alasan,
                   // 'abs_alasan_pulang' =>'',
                    'abs_sts'           =>'M',
                    'abs_shift'         =>'',
                    'abs_rwd_masuk'     =>'',
                    'abs_rwd_pulang'    =>'',
                    'abs_point'         => '',
                    'kar_id'            =>$id_kar,
                );

                $this->db->insert('abs_master', $data_absen_simpan);


                $abs_id = $this->db->insert_id();

                 $data_titik_kordinat_simpan = array(
                    'kar_id'=>$id_kar,
                    'lat_kar'=>$lat,
                    'long_kar'=>$long,
                    'lat_unit'=>$lat_tujuan,
                    'long_unit'=>$long_tujuan,
                    'crdt'=>date('Y-m-d H:i:s'),
                    'jarak'=>$jarak_skrang,
                    'alasan_masuk'=>$alasan,
                     'ktr_id'=>$ktr_id,
                     'abs_id'=>$abs_id,
                    
                );
                 $this->db->insert('abs_kar_titik_kordinat', $data_titik_kordinat_simpan);

            }

                $data_array = array(
                    'status' => 200,
                    'message' => "Success",
                );
            } else {
               
                   $cek_status_pulang = $this->cek_status_pulang($id_kar);
                   $pho =  $this->save_photo($_FILES['img'],$karname->kar_nik);
                        if($pho->msg=='success'){
                            //ABSEN PULANG ;
                        // echo "sukses";

                        $point = $check_absen->abs_point + $cek_status_pulang['abs_point'];

                            $data_absen_simpan = array(
                                //'abs_masuk'         =>date('H:i:s'),
                                'abs_pulang'        =>date('H:i:s'),
                                'abs_ip'            =>'',
                                //'abs_tgl_masuk'     =>date('Y-m-d'),
                                'abs_tgl_pulang'    =>date('Y-m-d'),
                               // 'abs_alasan_masuk'  =>'',
                                'abs_alasan_pulang' =>$alasan,
                                'abs_sts'           =>'P',
                                'abs_shift'         =>'',
                                'abs_rwd_masuk'     =>'',
                                'abs_rwd_pulang'    =>$cek_status_pulang['abs_rwd_pulang'],
                                'abs_point'         => $point,
                                'kar_id'            =>$id_kar,
                            );

                            $this->db->update('abs_master', $data_absen_simpan,array('abs_id'=>$check_absen->abs_id));

                        }

                        $data_array = array(
                            'status' => 200,
                            'message' => "Success",
                        );



               
            }
        } else {

            $cek_shift_masuk_ucapan =  $this->cek_shift_masuk($id_kar);

            $cek_status_masuk = $this->cek_status_masuk($cek_shift_masuk_ucapan);
      
         
      
            //   echo "<pre>";
            //   print_r($cek_status_masuk);
            //   die;

             $pho =  $this->save_photo($_FILES['img'],$karname->kar_nik);
            if($pho->msg=='success'){
                //ABSEN MASUK ;
               // echo "sukses";

                $data_absen_simpan = array(
                    'abs_masuk'         =>date('H:i:s'),
                    'abs_pulang'        =>'00:00:00',
                    'abs_ip'            =>'',
                    'abs_tgl_masuk'     =>date('Y-m-d'),
                    'abs_tgl_pulang'    =>'0000-00-00',
                    'abs_alasan_masuk'  =>$alasan,
                   // 'abs_alasan_pulang' =>'',
                    'abs_sts'           =>'M',
                    'abs_shift'         =>$cek_shift_masuk_ucapan,
                    'abs_rwd_masuk'     =>$cek_status_masuk['abs_rwd_masuk'],
                    'abs_rwd_pulang'    =>'',
                    'abs_point'         => $cek_status_masuk['abs_point'],
                    'kar_id'            =>$id_kar,
                );

                $this->db->insert('abs_master', $data_absen_simpan);

                 $abs_id = $this->db->insert_id();

                 $data_titik_kordinat_simpan = array(
                    'kar_id'=>$id_kar,
                    'lat_kar'=>$lat,
                    'long_kar'=>$long,
                    'lat_unit'=>$lat_tujuan,
                    'long_unit'=>$long_tujuan,
                    'crdt'=>date('Y-m-d H:i:s'),
                    'jarak'=>$jarak_skrang,
                    'alasan_masuk'=>$alasan,
                     'ktr_id'=>$ktr_id,
                     'abs_id'=>$abs_id,
                    
                );
                 $this->db->insert('abs_kar_titik_kordinat', $data_titik_kordinat_simpan);



                if($jenis_masuk=='WFH' || $jenis_masuk=='WH' ){
                    $abs_dtl_type = 'WFH';
                    $hadir = 'H';
                }else{
                     $abs_dtl_type = 'WFO';
                     $hadir = 'H';
                }


                $data_abs_detail = array(
                    'abs_dtl_sts'   =>$hadir,
                    'abs_dtl_tgl'   =>date('Y-m-d'),
                    'abs_dtl_type'  =>$abs_dtl_type,
                    'kar_id'         =>$id_kar,
                    'ktr_id'        =>$ktr_id,
                );
                $this->db->insert('abs_detail', $data_abs_detail);


                $data_array = array(
                    'status' => 200,
                    'message' => "Success",
                );


            }else{
                $data_array = array(
                    'status' => 404,
                    'message' => "Absen Gagal Foto tidak kesimpan",
                );
            }
           
        }
    } else {

        if($alasan){
             $check_absen = $this->db->query("select abs_id,abs_tgl_pulang,abs_tgl_masuk,abs_point,abs_pulang,abs_masuk from abs_master where kar_id = " . $id_kar . " and date(abs_tgl_masuk) = '" . date('Y-m-d') . "'")->row();
        
       

        if ($check_absen) {

           // $cek_shift_masuk_ucapan =  $this->cek_shift_masuk();

          



            // jika dia sif 3 cek pulang kalo ada tambah/insert
            if ($check_absen->abs_tgl_pulang != '0000-00-00') {

                $pho =  $this->save_photo($_FILES['img'],$karname->kar_nik);
                if($pho->msg=='success'){
                $data_absen_simpan = array(
                    'abs_masuk'         =>date('H:i:s'),
                    'abs_pulang'        =>'00:00:00',
                    'abs_ip'            =>'',
                    'abs_tgl_masuk'     =>date('Y-m-d'),
                    'abs_tgl_pulang'    =>'0000-00-00',
                    'abs_alasan_masuk'  =>$alasan,
                   // 'abs_alasan_pulang' =>'',
                    'abs_sts'           =>'M',
                    'abs_shift'         =>'',
                    'abs_rwd_masuk'     =>'',
                    'abs_rwd_pulang'    =>'',
                    'abs_point'         => '',
                    'kar_id'            =>$id_kar,
                );

                $this->db->insert('abs_master', $data_absen_simpan);

                 $abs_id = $this->db->insert_id();

                 $data_titik_kordinat_simpan = array(
                    'kar_id'=>$id_kar,
                    'lat_kar'=>$lat,
                    'long_kar'=>$long,
                    'lat_unit'=>$lat_tujuan,
                    'long_unit'=>$long_tujuan,
                    'crdt'=>date('Y-m-d H:i:s'),
                    'jarak'=>$jarak_skrang,
                    'alasan_masuk'=>$alasan,
                     'ktr_id'=>$ktr_id,
                     'abs_id'=>$abs_id,
                    
                );
                 $this->db->insert('abs_kar_titik_kordinat', $data_titik_kordinat_simpan);

            }

                $data_array = array(
                    'status' => 200,
                    'message' => "Success",
                );
            } else {
               
                   $cek_status_pulang = $this->cek_status_pulang($id_kar);
                   $pho =  $this->save_photo($_FILES['img'],$karname->kar_nik);
                        if($pho->msg=='success'){
                            //ABSEN PULANG ;
                        // echo "sukses";

                        $point = $check_absen->abs_point + $cek_status_pulang['abs_point'];

                            $data_absen_simpan = array(
                                //'abs_masuk'         =>date('H:i:s'),
                                'abs_pulang'        =>date('H:i:s'),
                                'abs_ip'            =>'',
                                //'abs_tgl_masuk'     =>date('Y-m-d'),
                                'abs_tgl_pulang'    =>date('Y-m-d'),
                               // 'abs_alasan_masuk'  =>'',
                                'abs_alasan_pulang' =>$alasan,
                                'abs_sts'           =>'P',
                                'abs_shift'         =>'',
                                'abs_rwd_masuk'     =>'',
                                'abs_rwd_pulang'    =>$cek_status_pulang['abs_rwd_pulang'],
                                'abs_point'         => $point,
                                'kar_id'            =>$id_kar,
                            );

                            $this->db->update('abs_master', $data_absen_simpan,array('abs_id'=>$check_absen->abs_id));

                        }

                        $data_array = array(
                            'status' => 200,
                            'message' => "Success",
                        );



               
            }
        } else {

            $cek_shift_masuk_ucapan =  $this->cek_shift_masuk($id_kar);

            $cek_status_masuk = $this->cek_status_masuk($cek_shift_masuk_ucapan);
      
         
      
              // echo "<pre>";
              // print_r($cek_status_masuk);
              // die;

             $pho =  $this->save_photo($_FILES['img'],$karname->kar_nik);
            if($pho->msg=='success'){
                //ABSEN MASUK ;
               // echo "sukses";

                $data_absen_simpan = array(
                    'abs_masuk'         =>date('H:i:s'),
                    'abs_pulang'        =>'00:00:00',
                    'abs_ip'            =>'',
                    'abs_tgl_masuk'     =>date('Y-m-d'),
                    'abs_tgl_pulang'    =>'0000-00-00',
                    'abs_alasan_masuk'  =>$alasan,
                   // 'abs_alasan_pulang' =>'',
                    'abs_sts'           =>'M',
                    'abs_shift'         =>$cek_shift_masuk_ucapan,
                    'abs_rwd_masuk'     =>$cek_status_masuk['abs_rwd_masuk'],
                    'abs_rwd_pulang'    =>'',
                    'abs_point'         => $cek_status_masuk['abs_point'],
                    'kar_id'            =>$id_kar,
                );

                $this->db->insert('abs_master', $data_absen_simpan);
                $abs_id = $this->db->insert_id();

                 $data_titik_kordinat_simpan = array(
                    'kar_id'=>$id_kar,
                    'lat_kar'=>$lat,
                    'long_kar'=>$long,
                    'lat_unit'=>$lat_tujuan,
                    'long_unit'=>$long_tujuan,
                    'crdt'=>date('Y-m-d H:i:s'),
                    'jarak'=>$jarak_skrang,
                    'alasan_masuk'=>$alasan,
                     'ktr_id'=>$ktr_id,
                     'abs_id'=>$abs_id,
                    
                );
                 $this->db->insert('abs_kar_titik_kordinat', $data_titik_kordinat_simpan);

                if($jenis_masuk=='WFH' || $jenis_masuk=='WH' ){
                    $abs_dtl_type = 'WFH';
                    $hadir = 'H';
                }else{
                     $abs_dtl_type = 'WFO';
                     $hadir = 'H';
                }


                $data_abs_detail = array(
                    'abs_dtl_sts'   =>$hadir,
                    'abs_dtl_tgl'   =>date('Y-m-d'),
                    'abs_dtl_type'  =>$abs_dtl_type,
                    'kar_id'         =>$id_kar,
                    'ktr_id'        =>$ktr_id,
                );
                $this->db->insert('abs_detail', $data_abs_detail);


                $data_array = array(
                    'status' => 200,
                    'message' => "Success",
                );


            }else{
                $data_array = array(
                    'status' => 404,
                    'message' => "Absen Gagal Foto tidak kesimpan",
                );
            }
           
        }








    }else{
        $data_array = array(
            'status' => 400,
            'message' => "Lokasi Kejauhan",
        );
    }
        
    

    }

    echo json_encode($data_array);
}


    function check_absen(){

            $bulan = date('mY');

       $id_kar = $this->input->post('id_kar');

          $karname = $this->db->query("select kar_nik,kar_id,ktr_id,kar_lat,kar_long from kar_master where kar_id='".$id_kar."'")->row();

           $data['jadwal2'] = $this->db->query("select j.jdw_data from jdw_master as j
                  inner join kar_master as k on j.jdw_nik=k.kar_nik 
                  where  j.jdw_blnthn = '".$bulan."' and j.jdw_nik='".$karname->kar_nik."'")->result();


            $cek_shift_masuk_ucapan =  $this->cek_shift_masuk($id_kar);
            $cek_status_masuk = $this->cek_status_masuk($cek_shift_masuk_ucapan);
           
            
           
           
            
    
    
          


            $jad = $data['jadwal2'][0]->jdw_data;
    
            $jadwal = explode("#",$jad);

            $tgl = date('d')-1;

             $jenis_masuk = $jadwal[$tgl];
           //  echo "<pre>";
           //  print_r($karname);

           // die;




          // die;

        $lat = $this->input->post('lat');
        $long = $this->input->post('long');


        // $kar  = $this->db->query("select * from kar_master where kar_id = '".$id_kar."'")->Row();
        $kantor  = $this->db->query("select ktr_id,ktr_nm,ktr_lat,ktr_long,ktr_radius from ktr_master where ktr_id = '".$karname->ktr_id."'")->Row();


        //$jadwal  = $this->db->query("select * from jdw_master where jdw_nik = '".$kar->kar_nik."' and date(tanggal) =  '".date('Y-m-d')."'")->Row();


        $daily  = $this->db->query("select wfd_createdate from wfh_data where kar_id = '".$id_kar."' and date(wfd_createdate) =  '".date('Y-m-d')."' and wfd_lock = 'Y'")->Row();

     
        if($daily){
            $daily = "sudah_bikin_daily";
        }else{
            $daily = "belum_bikin_daily";
        }

        if($jenis_masuk=='WFO' || $jenis_masuk=='P' || $jenis_masuk=='PS'){

            $lat_tujuan = $kantor->ktr_lat;
            $long_tujuan = $kantor->ktr_long;

            $tujuan_kantor = $kantor->ktr_nm;
            $tujuan_kantor_id = $kantor->ktr_id;
           

        }else if($jenis_masuk=='WFH' || $jenis_masuk=='M' ||  $jenis_masuk=='L' || $jenis_masuk=='LM'){

            


            if($jenis_masuk=='L'|| $jenis_masuk=='LM'){
                    
                    //$tujuan_kantor_id = '171';

                     $lat_tujuan = $kantor->ktr_lat;
                     $long_tujuan = $kantor->ktr_long;

                   $tujuan_kantor = "Di Rumah/Libur";
                  $tujuan_kantor_id = $kantor->ktr_id;

                  // echo $tujuan_kantor_id;
                  // echo "<pre>";
                  // print_r($kantor->ktr_id);
                  // die;


            }else{

                $lat_tujuan = $karname->kar_lat;
                $long_tujuan = $karname->kar_long;

                 $tujuan_kantor = "WFH";
                $tujuan_kantor_id = '171';
            }

             



        }  else{
            $lat_tujuan = $kantor->ktr_lat;
            $long_tujuan = $kantor->ktr_long;

              $tujuan_kantor = $kantor->ktr_nm;
              $tujuan_kantor_id = $kantor->ktr_id;
        }
        

        
       



       // error_reporting(0);


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".str_replace(" ","",$lat_tujuan).",".str_replace(" ","",$long_tujuan)."&origins=".$lat.",".$long."&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";


            $ch = curl_init($url);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json', // if the content type is json
                    //  'bearer: '.$token // if you need token in header
                )
            );
            //  curl_setopt($ch, CURLOPT_HEADER, false);
            //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

            //   return $result;

            $output = json_decode($result);


        //     echo "<pre>";
        //    print_r($output);

        //    die;
          //  echo json_encode($output);

            $jarak_skrang = $output->rows[0]->elements[0]->distance->value;

           //echo "<br>";
            
            // echo "<pre>";
            // print_r();
            // die;



            // $jarak_orang = $kar->radius;


            // $jarak_orang * 1000;

             if($kar->kar_radius){
                $jarak_orang = $kar->kar_radius;
            }else{
                $jarak_orang = 0.5;
            }


    $jarak_orang2 =   (double)$jarak_orang * 1000;
              //40317  >=   500

              $check_absen = $this->db->query("select abs_id,abs_tgl_pulang,abs_tgl_masuk,abs_point,abs_pulang,abs_masuk from abs_master where kar_id = ".$id_kar." and date(abs_tgl_masuk) = '".date('Y-m-d')."'")->row();

              error_reporting(0);

               if($check_absen->abs_tgl_masuk){
               

                    if($check_absen->abs_pulang != '00:00:00'){
                        $status_button = "sudah_pulang";

                        $alasan = 0;

                        


                    }else{
                        
                       // echo "hai";

                         $cek_status_pulang =  $this->cek_status_pulang($id_kar);
                        $status_button = "sudah_masuk";

                        //echo "21";
                        // echo "<pre>";
                        // print_r($cek_status_pulang);

                    if(($cek_status_pulang['abs_rwd_pulang']=='Loyal') or ($cek_status_pulang['abs_rwd_pulang']=='Tepat')  ){
                         $alasan = 0;
                         $status_keluar = $cek_status_pulang['abs_rwd_pulang'];
                    }else{


                         $alasan = 1;
                         $status_keluar = $cek_status_pulang['abs_rwd_pulang'];
                    }




                    }


               
               }else{

                    $status_button = "belum_masuk";

                    if(($cek_status_masuk['abs_rwd_masuk']=='Rajin') or ($cek_status_masuk['abs_rwd_masuk']=='Tepat')  ){
                         $alasan = 0;
                         $status_keluar = $cek_status_masuk['abs_rwd_masuk'];
                    }else{
                         $alasan = 1;
                         $status_keluar = $cek_status_masuk['abs_rwd_masuk'];
                    }
               }





               if($check_absen->abs_masuk){
                  $abs_masuk = $check_absen->abs_masuk;
               }else{
                  $abs_masuk = "00:00"; 
               }




                 $data_json = array(
                   'jenis_masuk'=>$jenis_masuk,
                 // 'jenis_masuk'=>'WFO',
                  'tujuan_lat'=>$lat_tujuan,
                  'tujuan_long'=>$long_tujuan,
                  'posisi_lat'=>$lat,
                  'posisi_long'=>$long,
                  'jarak_skrang'=>"".$jarak_skrang."",
                  'status_button'=> $status_button,
                  'radius'=>$jarak_orang2,
                    'kantor' => $tujuan_kantor,
                    'ktr_id' => $tujuan_kantor_id,
                  'lokasi_skrang'=>$output->destination_addresses[0],
                  'lokasi_tujuan'=>$output->origin_addresses[0],
                  'daily'=>$daily,
                  'cek_status_masuk'=>$cek_status_masuk['abs_rwd_masuk'],
                  'cek_status_pulang'=>$cek_status_pulang['abs_rwd_pulang'],
                  'alasan'=>$alasan,
                  'status_keluar'=>$status_keluar,
                  'jam_masuk'=>$abs_masuk,
                  'api'=>"https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".str_replace(" ","",$lat_tujuan).",".str_replace(" ","",$long_tujuan)."&origins=".$lat.",".$long."&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow",
              );

              echo json_encode($data_json);
            

    }


    function jadwal(){

        error_reporting(0);

       $id_kar = $this->input->post('id_kar');
       


        $kar = $this->db->query("select * from kar_master where kar_id='".$id_kar."'")->row();

        // echo "<pre>";
        // print_r($kar->kar_nik);
        // die;

            $bulan = date('mY');
            //$bulan = '072021';

      
        
              
                  $data['jadwal2'] = $this->db->query("select * from jdw_master as j
                  inner join kar_master as k on j.jdw_nik=k.kar_nik 
                  where  j.jdw_blnthn = '".$bulan."' and j.jdw_nik='".$kar->kar_nik."'")->result();
           
           
            
    
    
            // echo "<pre>";
            // print_r($data['jadwal2'][0]->jdw_nama);
    
            // die;
            $jad = $data['jadwal2'][0]->jdw_data;
    
            $jadwal = explode("#",$jad);
          
        
            //  echo "<pre>";
            //  print_r($jadwal);
            //  die;
           

        foreach($jadwal as $key => $ja){
            $key3 = ((int)$key+1);
            $ckey = strlen($key3);

            if($ckey=='1'){
                 $key2='0'.($key3);
            }else{
                $key2=$key+1;
            }


            $data2[] = array(
                "id_jadwal"=> "",
                "id_karyawan"=>  "",
                "jenis_masuk"=> $ja,
                "tanggal"=>date('d-m-Y',strtotime(date('Y-m-'.$key2))),
                "id_ktr"=>  "",
                "ket"=> "",
                "nama_karyawan"=>  "",
            );
        }

        echo json_encode($data2);
    }

    function cek_posisi(){
        $cek = $this->db->query('select * from cek_posisi order by id_cek_posisi desc')->result();

        echo json_encode($cek);
    }


    function cek_alasan(){
        error_reporting(0);
        $kar_id = $this->input->post('kar_id');
        $tgl = date('Y-m-d');
        $cek = $this->db->query('select * from abs_master where kar_id = "'.$kar_id.'" and abs_tgl_masuk ="'.$tgl.'"')->row();


        // echo "<pre>";
        // print_r($cek);
        // die;


        if($cek->abs_alasan_masuk){
             $data_json['status'] = 200;
             $data_json['message'] = "suksess";
             $data_json['alasan'] = $cek->abs_alasan_masuk;
             $data_json['jam_masuk'] = $cek->abs_masuk;
            
        }else{
             $data_json['status'] = 400;
             $data_json['message'] = "gagal";
             $data_json['alasan'] = "gagal";
             $data_json['jam_masuk'] = "";
            
        }

        echo json_encode($data_json);
    }



     function cek_absen_hari_ini(){
        error_reporting(0);
      //  $kar_id = $this->input->post('kar_id');
        $tgl = date('Y-m-d');
        $cek = $this->db->query('select d.abs_rwd_masuk,d.abs_alasan_masuk,d.abs_masuk,d.abs_pulang,k.kar_nm,(select acc_img from acc_master where kar_id=k.kar_id) as img

 from abs_master as d join kar_master as k on k.kar_id = d.kar_id where  abs_tgl_masuk ="'.$tgl.'" order by abs_masuk desc ')->result();


        // echo "<pre>";
        // print_r($cek);
        // die;

        foreach($cek as $c){
                $data_json[] = array(
                    'nama'=>$c->kar_nm,
                    'jam_masuk'=>$c->abs_masuk,
                    'jam_keluar'=>$c->abs_pulang,
                    'alasan_masuk'=>$c->abs_alasan_masuk,
                    'img'=>'https://cb.web.id/module/profile/img/'.$c->img,
                    'status'=>$c->abs_rwd_masuk,

                );
        }


        // if($cek->abs_alasan_masuk){
        //      $data_json['status'] = 200;
        //      $data_json['message'] = "suksess";
        //      $data_json['alasan'] = $cek->abs_alasan_masuk;
        //      $data_json['jam_masuk'] = $cek->abs_masuk;
            
        // }else{
        //      $data_json['status'] = 400;
        //      $data_json['message'] = "gagal";
        //      $data_json['alasan'] = "gagal";
        //      $data_json['jam_masuk'] = "";
            
        // }

        echo json_encode($data_json);
    }



  


    


    

   

}
