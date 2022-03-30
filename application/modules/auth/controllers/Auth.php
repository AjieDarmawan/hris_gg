<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('auth_model',));
		
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
               
 
            $session = $this->auth_model->select_by_id($user['id_users']);


            // echo "<pre>";
            // print_r($pegawai);


            if($session){
                $this->session->set_userdata(array('pegawai'=>$session));

                redirect('master/event');
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

    



    function rmrandomkey($length=4,$mode=''){
        switch($mode){
            case "N":
                $permitted_chars = '23456789';
            break;
            case "A":
                $permitted_chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
            break;
            default:
                $permitted_chars = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        }
        return substr(str_shuffle($permitted_chars), 0, $length);
    }

     function contentreplace($content = '', $prop = array(), $mformat = false) {

   if(count($prop) > 0) {
     foreach($prop as $k1 => $v1){
       $tagToReplace = "*|".strtoupper($k1)."|*";
       $content = str_replace($tagToReplace, $v1, $content);
     }
   }
   $content = preg_replace('/\\|(.)\|\*+/', '', $content);

   if($mformat) {
     return $content;
   }

   /* KALO WEB */
   // $content = str_replace("n", "<br />", $content);
   // $content = str_replace("_b", "<b>", $content);
   // $content = str_replace("b_", "</b>", $content);

   return $content;
 }

    function register(){

       

        $email = 'ajie.darmawan106@gmail.com';


        // $useranid = date('YmdHis') . $this->rmrandomkey(2, 'N');
        // $usercode = 'EN-' . date('Ym') . '-' . date('Hi') . '-' . date('s');
        // $keycode = sha1(md5("edu" . $useranid . "nitas"));


        // $nowa       = $this->input->post('nowa');
        // $notlp      = $this->input->post('notlp');
        // $username   = $this->input->post('username');
        // $email      = $this->input->post('email');
        // $pass       = $this->input->post('password');
        // $leveledu   = $this->input->post('leveledu');

        // //echo sha1(md5($pass));

        // //$pass="paswdT6Sa";
        // $uppercase = preg_match('@[A-Z]@', $pass);
        // $lowercase = preg_match('@[a-z]@', $pass);
        // $number    = preg_match('@[0-9]@', $pass);

        // // if(!$uppercase || !$lowercase || !$number || strlen($pass)<=6){
        // //  $data['status'] = 404;
        // //  $data['message'] = "password harus lebih dari 6 karakter, mengandung huruf BESAR, huruf kecil dan angka";

        // // }else{

            

        //      $users = $this->db->query('select * from edu_apps.app_userdata where email="'.$email.'"')->row();
           

        //     if($users){

        //         $data['status'] = 400;
        //         $data['message'] = "email sudah digunakan";

        //         echo json_encode($data);
        //     }else{

        //         $kodeacak = mt_rand(100000, 999999);
        //         $kodeacak_password = "A".mt_rand(100000, 999999);
        //         $values = array(
        //             'id'=> $useranid = date('YmdHis') . $this->rmrandomkey(2, 'N'),
        //             'username'=>$username,
        //             'password'=>sha1(md5($kodeacak_password)),
        //             'email'=>$email,
        //             'codereff'=>$kodeacak,
        //             'keycode'=>$keycode,

        //         );
        //      //  DB::table('app_userdata')->insert($values);

        //        $this->db->insert('edu_apps.app_userdata',$values);


        //        $edu = array(
        //         'namalengkap'=>$username,
        //         'email'=>$email,
        //         'nowa'=>$nowa,
        //         'notlp'=>$notlp,
        //         'keycode'=>$keycode,

        //        );
        //         //DB::table('edu_userinfo')->insert($edu);
        //          $this->db->insert('edu_apps.edu_userinfo',$edu);



        //          $values_pendidikan = array(
        //         'nama'=>$username,
        //         'leveledu'=>$leveledu,
        //         'keycode'=>$keycode,
        //         );
        //         // DB::table('edu_userpendidikan')->insert($values_pendidikan);

        //           $this->db->insert('edu_apps.edu_userpendidikan',$values_pendidikan);






         // $users_success =  DB::table('edu_apps.app_userdata')->where('email',$email)->first();

        //  $users_success = $this->db->query('select * from edu_apps.app_userdata where email="'.$email.'"')->row();
        //   $edu_userinfo = $this->db->query('select * from edu_apps.edu_userinfo where email="'.$email.'"')->row();
        //           // $edu_userinfo =  DB::table('edu_apps.edu_userinfo')->where('email',$email)->first();



        //   $mesasge = $this->db->query('select * from edu_apps.enitas_template where cid="tryout_nonlogin"')->result_array();

         


               $txtdata = array(
                 'KODEREFF'=> $users_success->codereff,
                 'NAMA'=>$edu_userinfo->namalengkap,
                 'PASSWORD'=>$kodeacak_password,
                 "NAMAREKOMENDER"=>$edu_userinfo->namalengkap);



                $a = $this->contentreplace($mesasge[0]['konten'], $txtdata, false, true);
                $org = trim(preg_replace('/\s\s+/', ' ', html_entity_decode($a, ENT_COMPAT, 'UTF-8')));


                $kontent = htmlspecialchars_decode(html_entity_decode($org));
                $kontent = html_entity_decode($kontent);
                $kontent = trim(preg_replace('/\s\s+/', '<br />', $kontent));




             $data_email_kirim = [
                'name' => $edu_userinfo->namalengkap,
                'code' => $users_success->codereff,
                //'content'=> $ilangin_semua_tagnya,
                'content'=> $kontent,
                'module' => "Edu Kampus",
            ];

            // echo "<pre>";
            // print_r($kontent);

            // die;


            $body = $this->load->view('email/sendmail.php',$data_email_kirim,TRUE);


        //$this->edu_sendmail('ajie.darmawan106@gmail.com','ajie,','Tryout',$body,'[""]','enitas');
          $this->edu_sendmail($email,$username,'AKUN TRYOUT EDUNITAS',$body,'[""]','enitas');    


                 $data['status'] = 200;
                $data['message'] = "suksess";

                echo json_encode($data);
    //   }
    }


    function edu_sendmail($to_email,$to_name,$subject,$html_message,$attach=array(),$sender='setuju'){


            // echo "<pre>";
            // print_r($html_message);
            //die;




        //     if(count($attach)>0){
        //         echo "tes";
        //     }
        // die;
    
    $list_sender = array(
        'enitas' => array(
            'email' => 'contact@edunitas.com',
            'sendername' => 'Edunitas'
        ),
        'lokeredu' => array(
            'email' => 'edukarir@edunitas.com',
            'sendername' => 'Edunitas'
        ),
        'setuju' => array(
            'email' => 'humas@gillandgroup.co.id',
            'sendername' => 'humas@gillandgroup.co.id'
        )
    );



    $header = array(
        'Content-Type: application/x-www-form-urlencoded',
        'Connection: keep-alive'
    );

    $fields = array(
            'sender' => $list_sender[$sender]['email'],
            'sendername' => $list_sender[$sender]['sendername'],
            'reciver' => $to_email,
            'recivername' => $to_name,
            'subject' => $subject, 
            'body' => $html_message         
    );
    
    // if(count($attach)>0){
    //     $fields['attach']=json_encode($attach);
    // }

    $fields_string = '';
    foreach($fields as $key1=>$value1) { $fields_string .= $key1.'='.$value1.'&'; }
    rtrim($fields_string, '&');


    ////////////////////////////////////////////////////////////////////////////
            
    $MAILAPI_url = "https://mail-api.p2k.co.id/sendmail.php";

    $MAILAPI_curl = curl_init();
    curl_setopt_array($MAILAPI_curl, array(
            CURLOPT_URL => $MAILAPI_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            //CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => $header,
    ));

    $MAILAPI_response = curl_exec($MAILAPI_curl);
    $MAILAPI_err = curl_error($MAILAPI_curl);
    curl_close($MAILAPI_curl);
    $MAILAPI_datares = json_decode($MAILAPI_response, true);
    
    //print_r($MAILAPI_response);
    
    //----------------

}


function tes_email(){

  
    $data_email_kirim = [
        'name' => 'tes',
        'code' => 'ccel',
        //'content'=> $ilangin_semua_tagnya,
        'content'=> '',
        'module' => "Edu Kampus",
    ];

    // echo "<pre>";
    // print_r($kontent);

    // die;


     //$this->load->view('email/sendmail',$data_email_kirim,TRUE);

     $this->load->view('email/sendmail',$data_email_kirim);
}


}
