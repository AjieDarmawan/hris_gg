<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Final_gaji extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata()['pegawai']) {
            redirect('auth');
        }
        $this->load->model(array('Final_gaji_M'));
    }


    function lastOfMonth($year, $month)
    {
        return date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($month . '/01/' . $year . ' 00:00:00'))));
    }

    // redirect if needed, otherwise display the user list
    public function index()
    {
        $year = date('Y');
        $month = date('m');
        $data['tgl_akhir_bulan'] = $this->lastOfMonth($year, $month);

        // echo "<pre>";
        // print_r($data['tgl_akhir_bulan'] );

        // echo date('m',strtotime($data['tgl_akhir_bulan']));
        // die;



         $kar_data_kar = $this->Final_gaji_M->getAll();

        $bulan_where = date('m');
        $year_where = date('Y');

       $risen = $this->db->query("select * from kar_master as k inner join kar_detail as d on k.kar_id = d.kar_id
        where kar_dtl_typ_krj = 'Resign' and month(kar_dtl_tgl_res) = '".$bulan_where."' and year(kar_dtl_tgl_res) = '".$year_where."'
        ")->result();

        $data['data_kar'] = array_merge($kar_data_kar,$risen);

        //$data["divisi"] = $this->Insentif_M->getAll();
        $data["title"] = "List Data Master Insentif";
        $this->template->load('template', 'final_gaji/final_gaji_v', $data);
    }

    function download_excel()
    {


        $year = date('Y');
        $month = date('m');
        $data['tgl_akhir_bulan'] = $this->lastOfMonth($year, $month);

        // echo "<pre>";
        // print_r($data['tgl_akhir_bulan'] );

        // echo date('m',strtotime($data['tgl_akhir_bulan']));
        // die;



        $data['data_kar'] = $this->Final_gaji_M->getAll();

        $this->load->view('final_gaji/download_excel', $data);
    }

    function insert_final()
    {

        error_reporting(0);

        $year = date('Y');
        $month = date('m');
        $tgl_akhir_bulan = $this->lastOfMonth($year, $month);

        $bulan_dibayarkan = '2022-08';
        $waktu = '2022-08-31';

        $bulan_where = '08';
        $year_where = '2022';

        $bulan_where_tahun = '08-2022';
         $bulan_tahun = '082022';

         $data_kar = $this->db->query('select d.kar_dtl_tgl_joi,d.kar_dtl_sts_nkh,k.kar_nm, k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
         inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
           order by k.kar_id asc')->result();
 
         $bulan_dibayarkan = date('Y-m');
         $waktu = date('Y-m-d');
 
         $bulan_where = date('m');
         $year_where = date('Y');
         $no = 1;
         $tot_harga = 0;
         $tot_total_penerimaan = 0;
 
         $tot_bpjs_k = 0;
         $tot_jht_k  = 0;
         $tot_jp_k = 0;
         $tot_bpjs_pk = 0;;
         $tot_jkk_pk = 0;
         $tot_jht_pk = 0;
         $tot_jkm_pk = 0;
         $tot_jp_pk = 0;

          


        $no = 1;
        $tot_harga = 0;
        $tot_total_penerimaan = 0;
        $tot_pph_dibayar = 0;
        foreach ($data_kar as $m) {
            error_reporting(0);
            $data_kom = $this->db->query('select * from payroll.komponen_gaji where kar_id =  "' . $m->kar_id . '"')->row();
            $data_insentif = $this->db->query('select jumlah from payroll.insentif where kar_id =  "' . $m->kar_id . '" and date(bulan_dibayarkan) = "' . $bulan_dibayarkan . '" ')->row();

            $insentif = $data_insentif->jumlah;

            $data_listrik = $this->db->query('select total from payroll.listrik where kar_id =  "' . $m->kar_id . '" and month(crdt) = "' . $bulan_where . '" and year(crdt) = "' . $year_where . '" ')->row();
            $t_listik = $data_listrik->total;

            $data_dinas = $this->db->query('select sum(jumlah_hari) as jumlah from dinas_lk where kar_id =  "' . $m->kar_id . '" and month(tgl_selesai) = "' . $bulan_where . '" and year(tgl_selesai) = "' . $year_where . '" ')->row();
            $t_dinas = $data_dinas->jumlah * 40000;


          

            $data_sembako = $this->db->query('select harga from payroll.sembako where kar_id =  "' . $m->kar_id . '" and bulan="' . $bulan_where_tahun . '"')->row();

            if ($data_sembako) {
                $t_beras = $data_sembako->harga;
            } else {
                $t_beras = 0;
            }



            $t_lain = $t_listik + $t_beras;

            $array_gp = array(
                'cid' => (string)$data_kom->nik,
                'secret' => (string)$data_kom->kar_id,
                'data' => (string)$data_kom->gaji_pokok,
                'action' => 'decrypt',
            );

            $gaji_pokok_en = educrypt($array_gp);


            $array_t_fungsional = array(
                'cid' => (string)$data_kom->nik,
                'secret' => $data_kom->kar_id,
                'data' => (string)$data_kom->t_fungsional,
                'action' => 'decrypt',
            );

            $t_fungsional_en = educrypt($array_t_fungsional);


            $array_t_struktural = array(
                'cid' => (string)$data_kom->nik,
                'secret' => $data_kom->kar_id,
                'data' => (string)$data_kom->t_struktural,
                'action' => 'decrypt',
            );

            $t_struktural_en = educrypt($array_t_struktural);


            $array_t_umum = array(
                'cid' => (string)$data_kom->nik,
                'secret' => $data_kom->kar_id,
                'data' => (string)$data_kom->t_umum,
                'action' => 'decrypt',
            );

            $t_umum_en = educrypt($array_t_umum);

            $array_t_kinerja = array(
                'cid' => (string)$data_kom->nik,
                'secret' => $data_kom->kar_id,
                'data' => (string)$data_kom->t_kinerja,
                'action' => 'decrypt',
            );

            $t_kinerja_en = educrypt($array_t_kinerja);


         
            $gaji_tetap = intval($gaji_pokok_en+$t_fungsional_en+$t_struktural_en);
            $gaji_tidak_tetap = intval($t_umum_en+$t_kinerja_en);

            

            $total_gaji = $gaji_tetap + $gaji_tidak_tetap + $t_lain;
            $total_gaji_inst = $gaji_tetap + $gaji_tidak_tetap + $t_lain + $insentif;


            $r_bpjs = $this->db->query('select * from payroll.bpjs where kar_id =  "' . $m->kar_id . '" and bulan="' . $bulan_where_tahun . '"')->row();


            if ($r_bpjs) {

                $bpjs_k  = $r_bpjs->bpjs_k_1;
                $bpjs_pk = $r_bpjs->bpjs_pk_4;

                $jht_k  = $r_bpjs->jht_k_2;
                $jht_pk = $r_bpjs->jht_pk;

                $jp_k  = $r_bpjs->jp_k_1;
                $jp_pk  = $r_bpjs->jp_pk;
                $jkk_pk = $r_bpjs->jkk_pk_024;
                $jkm_pk = $r_bpjs->jkm_pk;

                $gaji_bpjs = $r_bpjs->gaji_bpjs;
            } else {
                $bpjs_k  = 0;
                $bpjs_pk = 0;

                $jht_k  = 0;
                $jht_pk = 0;

                $jp_k  = 0;
                $jp_pk  = 0;

                $jkk_pk = 0;
                $jkm_pk = 0;
            }








           


           $data_paguyuban_pinjam = $this->db->query('select dibayarkan from payroll.paguyuban_pinjam where kar_id =  "' . $m->kar_id . '"  and bulan = "'.$bulan_dibayarkan.'"')->row();
            $paguyuban_pinjam = $data_paguyuban_pinjam->dibayarkan;


            $cek_data_paguyban = $this->db->query("select kar_id_dipinjam from _paguyuban_master where pg_status = 'Disetujui' and pg_ke < 10 and pg_kar_id =  '" . $m->kar_id . "' order by pg_id desc")->row();


            if ($cek_data_paguyban->kar_id_dipinjam) {
                $paguyuban = 0;
            } else {
                $data_paguyuban = $this->db->query('select dibayarkan from payroll.paguyuban where kar_id =  "' . $m->kar_id . '"  and bulan = "'.$bulan_dibayarkan.'"')->row();
                $paguyuban = $data_paguyuban->dibayarkan + $paguyuban_pinjam;
            }





            $cek_masa_kerja = $this->db->query('select  kar_dtl_tgl_joi,kar_dtl_tgl_res from
            kar_detail where kar_id =  "'.$m->kar_id.'"')->row();
                       
            $iuran_paguyban_lebih_sebulan =  date('Y-m-d', strtotime('+1 month', strtotime($cek_masa_kerja->kar_dtl_tgl_joi)));


            if ($iuran_paguyban_lebih_sebulan >= $waktu) {
                $iuran_paguyuban = 0;
            } else {

                if($cek_masa_kerja->kar_dtl_tgl_res!='0000-00-00'){
                     $tgl_risen = date('d', strtotime($cek_masa_kerja->kar_dtl_tgl_res));

                     $waktu_sebulan = date('d', strtotime($tgl_akhir_bulan));

                     if($waktu_sebulan!=$tgl_risen){
                        $iuran_paguyuban = 0;
                     }else{
                        $iuran_paguyuban = 55000;
                     }

                }else{
                    $iuran_paguyuban = 55000;

                }

                
                
            }



           // $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban  + $t_beras;

           $kar_jabodetabek = $this->db->query("select jdw_zona from jdw_master as j
                            inner join kar_master as k on j.jdw_nik=k.kar_nik 
                            where  j.jdw_blnthn = '" . $bulan_tahun . "' and j.jdw_nik='".$m->kar_nik."' and jdw_zona = 'JABODETABEK'")->row();


           if($kar_jabodetabek){
                   $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban  + $t_beras;
             }else{
                   $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban  + 0;
              }



            $total_penerimaan =  $total_gaji - $potongan;




                $tgl_akhir_bulan2 =  date('m-Y', strtotime('-1 month', strtotime( $tgl_akhir_bulan)));
           // $tgl_akhir_bulan2 = date('m-Y', strtotime($tgl_akhir_bulan));
             

             $kar_dtl_tgl_joi2 = date('m-Y', strtotime($m->kar_dtl_tgl_joi));
             $kar_dtl_tgl_res2 = date('m-Y', strtotime($m->kar_dtl_tgl_res));

//                   	$kar_dtl_tgl_joi2 =  date('m-Y', strtotime('-1 month', strtotime( $m->kar_dtl_tgl_joi)));
            // $kar_dtl_tgl_res2 =  date('m-Y', strtotime('-1 month', strtotime( $m->kar_dtl_tgl_res) ));



           

            $cek_absen_masuk = $this->db->query('select count(kar_id) as total from abs_detail where kar_id = "' . $m->kar_id . '" and MONTH(abs_dtl_tgl) = "' . $bulan_where . '" and year(abs_dtl_tgl) = "' . $year_where . '" and abs_dtl_sts = "H"')->row();
            $cek_absen_libur = $this->db->query('select count(kar_id) as total from abs_detail where kar_id = "' . $m->kar_id . '" and MONTH(abs_dtl_tgl) = "' . $bulan_where . '" and year(abs_dtl_tgl) = "' . $year_where . '" and abs_dtl_sts = "L"')->row();



           


            //$karname = $this->db->query("select * from kar_master where kar_id='" . $m->kar_id . "'")->row();
            $data['jadwal2'] = $this->db->query("select * from jdw_master as j
        inner join kar_master as k on j.jdw_nik=k.kar_nik 
        where  j.jdw_blnthn = '" . $bulan_tahun . "' and j.jdw_nik='SG.0617.2021'")->result();

            // $tgl = date('d') - 1;
              $tgl = 30 - 1;
            $jad = $data['jadwal2'][0]->jdw_data;
            $jadwal = explode("#", $jad);


            foreach ($jadwal as $key => $j) {

                if ($key <= $tgl) {
                    $data_array[$key] = $j;
                }
            }



            $jumlah = array_count_values($data_array);

            $libur = $jumlah['L'] + $jumlah['LN'] + $jumlah['LM'];

            $absen_masuk = $cek_absen_masuk->total;
            // $libur = 5;
            $waktu_sebulan = date('d', strtotime($tgl_akhir_bulan));
            $hari_kerja = $waktu_sebulan - $libur;

           

            if ($tgl_akhir_bulan2 == $kar_dtl_tgl_joi2) {
                $colom = 'style="
            background: green;
        "';


                //jumlah absen masuk/bulan -libur*gaji


                $total_penerimaan = ($absen_masuk / $hari_kerja) * $total_gaji;
            } else {
                $colom = "";
            }

            if ($tgl_akhir_bulan2 == $kar_dtl_tgl_res2) {
                $colom = 'style="
            background: red;
        "';
                $total_penerimaan = (($absen_masuk / $hari_kerja) * $total_gaji) - $potongan;
            }




            $tot_total_penerimaan += $total_penerimaan;

            $data_pajak = $this->db->query('select pph_dibayar from payroll.pajak where kar_id =  "' . $m->kar_id . '"  and bulan = "' . $bulan_where_tahun.'"')->row();
            
            if($data_pajak){
                $pph_dibayar = $data_pajak->pph_dibayar;
            }else{
                $pph_dibayar = 0;
            }

            $tot_pph_dibayar += $pph_dibayar;


            $data_array = array(
                'kar_id' => $m->kar_id,
                'kar_nik' => $m->kar_nik,
                'kar_nm' => $m->kar_nm,
                'bulan' => date('m-Y'),
                'gaji_pokok' => $data_kom->gaji_pokok,
                't_fungsional' => $data_kom->t_fungsional,
                't_struktural' => $data_kom->t_struktural,
                'upah_gaji_tetap' => $gaji_tetap,
                't_umum' => $data_kom->t_umum,
                't_kinerja' => $data_kom->t_kinerja,
                'upah_gaji_tidak_tetap' => $gaji_tidak_tetap,
                't_beras' => $t_beras,
                't_dinas' => $t_dinas,
                't_listrik' => $t_listik,
                't_lain_lain' => $t_lain,
                'insentif' => $insentif,
                'total_gaji' => $total_gaji,
                'total_gaji_inf' => $total_gaji_inst,
                'bpjs_k_1' => $bpjs_k,
                'jht_k_2' => $jht_k,
                'jp_k_1' => $jp_k,
                'bpjs_pk_4' => $bpjs_pk,
                'jht_pk' => $jht_pk,
                'jkk_pk_024' => $jkk_pk,
                'jkm_pk' => $jkm_pk,
                'jp_pk' => $jp_pk,
                'iuran_paguyuban'=>$iuran_paguyuban,
                'paguyuban'=>$paguyuban,
                'potongan'=>$potongan,
                'total_terima' => $total_penerimaan,
                'crdt' => date('Y-m-d H:i:s'),
                'pph_dibayar'=>$pph_dibayar,

            );

            $simpan = $this->db->insert('payroll.final_gaji', $data_array);
        }

        if($simpan){
            redirect('gaji/final_gaji');
        }
    }


    function final_gaji_testing(){
        error_reporting(0);
        if(isset($_FILES["file"]["name"]))
        {


           
            // upload
          $file_tmp = $_FILES['file']['tmp_name'];
          $file_name = $_FILES['file']['name'];
          $file_size =$_FILES['file']['size'];
          $file_type=$_FILES['file']['type'];
          // move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads
          
          $object = PHPExcel_IOFactory::load($file_tmp);
  
          foreach($object->getWorksheetIterator() as $worksheet)
          {
  
              $highestRow = $worksheet->getHighestRow();
              $highestColumn = $worksheet->getHighestColumn();

              $getHighestDataColumn = $worksheet->getHighestDataColumn();
             

                $xls = PHPExcel_IOFactory::load($file_tmp);
                $xls->setActiveSheetIndex(0);
                $sheet = $xls->getActiveSheet();

                 $highestRow;

                
              for($row=0; $row<=$highestRow; $row++)
              {
  
                  $nim = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                  $nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                  $angkatan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                 // $angkatan2 = $xls->getActiveSheet()->getCellByColumnAndRow(1, $row)->getCalculatedValue();

                 $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);



              } 
  
          }
          
        //   echo "<pre>";
        //   print_r($rowData);
        //   die;
         

          foreach($rowData as $key => $k){


            if($k[0][1]!='nik' and $k[0][1]!='NIK' and $k[0][1]!=''){

               

                $nik = $k[0][1];
                $kar_nm = $k[0][2];
                $jumlah = $k[0][3];

                $insert_nik = $this->db->query("select * from kar_master where kar_nik='".$nik."'")->row();
              

                $data_simpan = array(
                    'kar_id'=> $insert_nik->kar_id,
                    'kar_nm'=> $kar_nm,
                    'kar_nik'=>$nik,
                    'nominal'=>$jumlah,
                    'bulan'=>'08-2022',
                 


                );

                $cek_update = $this->db->query("select * from payroll.final_gaji_testing where kar_nik='".$nik."'")->row();

                if($cek_update){
                    $this->db->update('payroll.final_gaji_testing',$data_simpan,array('kar_nik',$nik));
                }else{
                    $this->db->insert('payroll.final_gaji_testing',$data_simpan);
                }
               

            }

          }

              $message = array(
              'message'=>'<div class="alert alert-success">Import file Suksess</div>',
          );
           $this->session->set_flashdata($message);
          redirect('gaji/final_gaji');


      
            
       


      }
      else
      {

        echo "gagal";
        //    $message = array(
        //       'message'=>'<div class="alert alert-danger">Import file gagal, coba lagi</div>',
        //   );
          
        //   $this->session->set_flashdata($message);
        //   redirect('import');
      }
    }



    function selisih_final_gaji(){
        
        $data['data_kar'] = $this->db->query('select * 
        from payroll.final_gaji as f 
        left join payroll.final_gaji_testing as t on t.kar_id = f.kar_id'
        
        )->result();
        
        $this->load->view('gaji/final_gaji/selisih_final',$data);
    
    }
}
