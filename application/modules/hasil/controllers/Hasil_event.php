<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_event extends CI_Controller
{


    function __construct(){
		parent::__construct();
		$sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
       $this->load->model(array('Hasil_event_M',));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
       // $sess = $this->session->userdata();
        // echo "<pre>";
        // print_r($sess['pegawai']->username);
        // die;
        //$data["Event"] = $this->Hasil_event_M->getAll();
        $data["title"] = "List Hasil  Event";
        $this->template->load('template','hasil_event/hasil_event_v',$data);
     
    }

    public function ajax_list()
    {


       


        header('Content-Type: application/json');
        $list = $this->Hasil_event_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Event) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('hasil/hasil_event/list/'.base64_encode($data_Event->id_event))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
           

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Event->judul;
            // $row[] = $data_Event->email;

            
            $row[] = date('d-m-Y',strtotime($data_Event->tgl_mulai));
            $row[] = date('d-m-Y',strtotime($data_Event->tgl_selesai));
            $row[] = $data_Event->desc;
            $row[] = $data_Event->mode;
            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $edit;
            }else{
                $row[] = $edit;
            }
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Hasil_event_M->count_all(),
            "recordsFiltered" => $this->Hasil_event_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function sortAssociativeArrayByKey($array, $key, $direction){

        switch ($direction){
            case "ASC":
                usort($array, function ($first, $second) use ($key) {
                    return $first[$key] <=> $second[$key];
                });
                break;
            case "DESC":
                usort($array, function ($first, $second) use ($key) {
                    return $second[$key] <=> $first[$key];
                });
                break;
            default:
                break;
        }
    
        return $array;
    }


    function list($id_event2){

        //cari nama 

        $id_event = base64_decode($id_event2);

        error_reporting(0);
        $user = $this->db->query('select id_peserta,email,id_event,materi_id from jawaban where id_event = "'.$id_event.'" group by email')->result();

        //looping cari nama
        foreach($user as $u){
                     
                    //cari materi nya apa aja
                    $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where m.id_event = "'.$id_event.'"' )->result();

                    // echo "<pre>";
                    // print_r($event_materi);

                    //dillooping materinya cari skor
                   
                    foreach($event_materi as $e)
                    {
                        $jawaban[$u->email][] = $this->db->query('select * from jawaban where mode = 1 and materi_id = "'.$e->materi_id.'" and email = "'.$u->email.'" order by id_jawaban desc')->row();

                    }


                  
                     $skor = 0;
                      foreach($jawaban[$u->email] as $j){
                        $skor += $j->skor;
                      }

                 $sekolah[$u->email] = $this->db->query('select asal_sekolah from peserta where id_peserta="'.$u->id_peserta.'"')->row();     
                 $event = $this->db->query('select judul from event where id_event='.$u->id_event)->row();     


                 $waktu_awal        =strtotime($jawaban[$u->email][0]->tgl_mulai);
                 $waktu_akhir    =strtotime($jawaban[$u->email][0]->create_add); // bisa juga waktu sekarang now()
                 
                 //menghitung selisih dengan hasil detik
                 $diff    =$waktu_akhir - $waktu_awal;

                 $data_api[] = array(
                    'email'=>$u->email,
                    'event'=>$event->judul,
                    'skor'=>$skor,
                    'waktu'=>floor($diff/60),
                    //'asal_sekolah'=>$sekolah[$u->email],
                  // 'jawaban'=>$jawaban[$u->email],
                   'waktu_pengerjaan'=> TanggalIndo(date('Y-m-d',strtotime($jawaban[$u->email][0]->tgl_mulai))) .' '.date('H:i:s',strtotime($jawaban[$u->email][0]->tgl_mulai)),
                   
                );

                
       }


       foreach($data_api as $a){

           // if($a['skor']==$a['skor']){
               
           // }else{

           // }
           $data_api_api[] = array(
               'email'=>$a['email'],
               'nama'=>$sekolah[$a['email']]->nama,
               'event'=>$a['event'],
               'skor'=>$a['skor'],
               'waktu'=>$a['waktu'],
               'asal_sekolah'=>$sekolah[$a['email']]->asal_sekolah,
                'waktu_pengerjaan'=>$a['waktu_pengerjaan'],
           );
       }

       $sort_by_skor = $this->sortAssociativeArrayByKey($data_api_api,'skor','DESC');

        

       // echo json_encode($sort_by_skor);

       $cari_ev = $this->db->query('select judul from event where id_event='.$id_event)->row();

       
        $data["title"] = "Rangking Event ".$cari_ev->judul;
        $data["hasil"] = $sort_by_skor;
        $this->template->load('template','hasil_event/hasil_event_list',$data);

 
     }


  
   

}
