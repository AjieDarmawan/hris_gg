<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Komponen_gaji extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata()['pegawai']) {
            redirect('auth');
        }
        $this->load->model(array('Komponen_gaji_model'));
    }

    function educrypt($crypt = array())
    {
        $output = false;
        $encrypt_method = "AES-256-CFB8";


        if (is_array($crypt)) {



            if ((isset($crypt['cid']) && $crypt['cid'] <> '') && (isset($crypt['secret']) && $crypt['secret'] <> '')) {


                $secret_f = $crypt['cid'];
                $secret_s = $crypt['secret'];

                if (isset($crypt['data']) && is_string($crypt['data'])) {




                    $string = $crypt['data'];
                    if (is_string($secret_f) && is_string($secret_s)) {


                        $key = hash('sha256', $secret_f);
                        $iv = substr(hash('sha256', $secret_s), 0, 16);

                        if (isset($crypt['action']) && $crypt['action'] <> '') {


                            if ($crypt['action'] == 'encrypt') {
                                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                                $output = str_replace("=", $secret_f, base64_encode($output));
                            } else if ($crypt['action'] == 'decrypt') {
                                $output = openssl_decrypt(base64_decode(str_replace($secret_f, "=", $string)), $encrypt_method, $key, 0, $iv);
                            }
                        }
                    }
                }
            }
        }

        return $output;
    }




    // redirect if needed, otherwise display the user list
    public function index()
    {







        //$data["divisi"] = $this->Komponen_gaji_model->getAll();
        $data["title"] = "List Data Master komponen gaji";
        $this->template->load('template', 'komponen_gaji/komponen_gaji_v', $data);
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Komponen_gaji_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_komponen_gaji) {

            $array_gp = array(
                'cid' => (string)$data_komponen_gaji->kar_nik,
                'secret' => $data_komponen_gaji->kar_id,
                'data' => (string)$data_komponen_gaji->gaji_pokok,
                'action' => 'decrypt',
            );

            $gaji_pokok_en = $this->educrypt($array_gp);


            $array_t_fungsional = array(
                'cid' => (string)$data_komponen_gaji->kar_nik,
                'secret' => $data_komponen_gaji->kar_id,
                'data' => (string)$data_komponen_gaji->t_fungsional,
                'action' => 'decrypt',
            );

            $t_fungsional_en = $this->educrypt($array_t_fungsional);


            $array_t_struktural = array(
                'cid' => (string)$data_komponen_gaji->kar_nik,
                'secret' => $data_komponen_gaji->kar_id,
                'data' => (string)$data_komponen_gaji->t_struktural,
                'action' => 'decrypt',
            );

            $t_struktural_en = $this->educrypt($array_t_struktural);


            $array_t_umum = array(
                'cid' => (string)$data_komponen_gaji->kar_nik,
                'secret' => $data_komponen_gaji->kar_id,
                'data' => (string)$data_komponen_gaji->t_umum,
                'action' => 'decrypt',
            );

            $t_umum_en = $this->educrypt($array_t_umum);

            $array_t_kinerja = array(
                'cid' => (string)$data_komponen_gaji->kar_nik,
                'secret' => $data_komponen_gaji->kar_id,
                'data' => (string)$data_komponen_gaji->t_kinerja,
                'action' => 'decrypt',
            );

            $t_kinerja_en = $this->educrypt($array_t_kinerja);





            if ($gaji_pokok_en == '') {
                $gaji_pokok2 = 0;
            } else {
                $gaji_pokok2 = $gaji_pokok_en;
            }

            if ($t_fungsional_en == '') {
                $t_fungsional2 = 0;
            } else {
                $t_fungsional2 = $t_fungsional_en;
            }

            if ($t_struktural_en == '') {
                $t_struktural2 = 0;
            } else {
                $t_struktural2 = $t_struktural_en;
            }

            if ($t_umum_en == '') {
                $t_umum2 = 0;
            } else {
                $t_umum2 = $t_umum_en;
            }

            if ($t_kinerja_en == '') {
                $t_kinerja2 = 0;
            } else {
                $t_kinerja2 = $t_kinerja_en;
            }


            $edit = "<button type='button' onclick='myFunction($data_komponen_gaji->kar_id,$gaji_pokok2,$t_fungsional2,$t_struktural2,$t_umum2,$t_kinerja2)' class='btn btn-success btn-sm' id='passingId' 
            data-toggle='modal' data-target='.edit'>Edit</button>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_komponen_gaji->kar_nik;
            $row[] = $data_komponen_gaji->kar_nm;
            $row[] = number_format($gaji_pokok2);
            $row[] = number_format($t_fungsional2);
            $row[] = number_format($t_struktural2);
            $row[] = number_format($gaji_pokok2 + $t_fungsional2 + $t_struktural2);
            $row[] = number_format($t_umum2);
            $row[] = number_format($t_kinerja2);
            $row[] = number_format($t_umum2 + $t_kinerja2);

            $row[] = $edit;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Komponen_gaji_model->count_all(),
            "recordsFiltered" => $this->Komponen_gaji_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function upload_excel()
    {

        error_reporting(0);

        if (isset($_FILES["file"]["name"])) {



            // upload
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            // move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads

            $object = PHPExcel_IOFactory::load($file_tmp);

            foreach ($object->getWorksheetIterator() as $worksheet) {

                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                $getHighestDataColumn = $worksheet->getHighestDataColumn();


                $xls = PHPExcel_IOFactory::load($file_tmp);
                $xls->setActiveSheetIndex(0);
                $sheet = $xls->getActiveSheet();

                $highestRow;


                for ($row = 0; $row <= $highestRow; $row++) {

                    $nim = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $angkatan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    // $angkatan2 = $xls->getActiveSheet()->getCellByColumnAndRow(1, $row)->getCalculatedValue();

                    $rowData[] = $sheet->rangeToArray(
                        'A' . $row . ':' . $highestColumn . $row,
                        NULL,
                        TRUE,
                        FALSE
                    );
                }
            }



            foreach ($rowData as $key => $k) {



                if ($k[0][0] != 'nik' and $k[0][0] != '') {


                    $nik = $k[0][0];
                    $g_pokok = $k[0][1];
                    $t_struktural = $k[0][2];
                    $t_fungsional = $k[0][3];
                    $t_umum = $k[0][5];
                    $t_kinerja = $k[0][6];

                    $insert_nik = $this->db->query("select * from kar_master where kar_nik='" . $nik . "'")->row();

                    $array_gp = array(
                        'cid' => (string)$nik,
                        'secret' => $insert_nik->kar_id,
                        'data' => (string)$g_pokok,
                        'action' => 'encrypt',
                    );
                    $gaji_pokok_en = $this->educrypt($array_gp);


                    $array_t_struktural = array(
                        'cid' => (string)$insert_nik->kar_nik,
                        'secret' => $insert_nik->kar_id,
                        'data' => (string)$t_struktural,
                        'action' => 'encrypt',
                    );
                    $t_struktural_en = $this->educrypt($array_t_struktural);

                    $array_t_fungsional = array(
                        'cid' => (string)$insert_nik->kar_nik,
                        'secret' => $insert_nik->kar_id,
                        'data' => (string)$t_fungsional,
                        'action' => 'encrypt',
                    );
                    $t_fungsional_en = $this->educrypt($array_t_fungsional);




                    $array_t_umum = array(
                        'cid' => (string)$insert_nik->kar_nik,
                        'secret' => $insert_nik->kar_id,
                        'data' => (string)$t_umum,
                        'action' => 'encrypt',
                    );
                    $t_umum_en = $this->educrypt($array_t_umum);


                    $array_t_kinerja = array(
                        'cid' => (string)$insert_nik->kar_nik,
                        'secret' => $insert_nik->kar_id,
                        'data' => (string)$t_kinerja,
                        'action' => 'encrypt',
                    );
                    $t_kinerja_en = $this->educrypt($array_t_kinerja);




                    $data_simpan = array(
                        'kar_id'        => $insert_nik->kar_id,
                        'gaji_pokok' => $gaji_pokok_en,
                        't_struktural' => $t_struktural_en,
                        't_fungsional' => $t_fungsional_en,
                        't_umum' => $t_umum_en,
                        't_kinerja' => $t_kinerja_en,
                        'nik'           => $nik,


                    );



                    $cek_update = $this->db->query("select * from payroll.komponen_gaji where nik='" . $nik . "'")->row();

                    if ($cek_update) {


                        $this->db->where('nik', $nik);
                        $this->db->update('payroll.komponen_gaji', $data_simpan);
                    } else {
                        $this->db->insert('payroll.komponen_gaji', $data_simpan);
                    }
                }
            }

            $message = array(
                'message' => '<div class="alert alert-success">Import file Suksess</div>',
            );
            $this->session->set_flashdata($message);
            redirect('gaji/komponen_gaji');
        } else {

            echo "gagal";
            //    $message = array(
            //       'message'=>'<div class="alert alert-danger">Import file gagal, coba lagi</div>',
            //   );

            //   $this->session->set_flashdata($message);
            //   redirect('import');
        }
    }

    function update()
    {

        $kar_id =  $this->input->post('kar_id');

        $g_pokok = $this->input->post('gaji_pokok');
        $t_struktural = $this->input->post('t_struktural');
        $t_fungsional = $this->input->post('t_fungsional');
        $t_umum = $this->input->post('t_umum');
        $t_kinerja = $this->input->post('t_kinerja');


        $insert_nik = $this->db->query("select * from kar_master where kar_id='" . $kar_id . "'")->row();


        $array_gp = array(
            'cid' => (string)$insert_nik->kar_nik,
            'secret' => $insert_nik->kar_id,
            'data' => (string)$g_pokok,
            'action' => 'encrypt',
        );
        $gaji_pokok_en = $this->educrypt($array_gp);


        $array_t_struktural = array(
            'cid' => (string)$insert_nik->kar_nik,
            'secret' => $insert_nik->kar_id,
            'data' => (string)$t_struktural,
            'action' => 'encrypt',
        );
        $t_struktural_en = $this->educrypt($array_t_struktural);

        $array_t_fungsional = array(
            'cid' => (string)$insert_nik->kar_nik,
            'secret' => $insert_nik->kar_id,
            'data' => (string)$t_fungsional,
            'action' => 'encrypt',
        );
        $t_fungsional_en = $this->educrypt($array_t_fungsional);




        $array_t_umum = array(
            'cid' => (string)$insert_nik->kar_nik,
            'secret' => $insert_nik->kar_id,
            'data' => (string)$t_umum,
            'action' => 'encrypt',
        );
        $t_umum_en = $this->educrypt($array_t_umum);


        $array_t_kinerja = array(
            'cid' => (string)$insert_nik->kar_nik,
            'secret' => $insert_nik->kar_id,
            'data' => (string)$t_kinerja,
            'action' => 'encrypt',
        );
        $t_kinerja_en = $this->educrypt($array_t_kinerja);


        $cek_update = $this->db->query("select * from payroll.komponen_gaji where kar_id='" . $kar_id . "'")->row();

        if ($cek_update) {

            // echo "<pre>";
            // print_r($cek_update);
            // die;



            $data_simpan = array(
                //  'kar_id'=> $insert_nik->kar_id,
                'gaji_pokok' => $gaji_pokok_en,
                't_struktural' => $t_struktural_en,
                't_fungsional' => $t_fungsional_en,
                't_umum' => $t_umum_en,
                't_kinerja' => $t_kinerja_en,
                //  'nik'=>$insert_nik->kar_nik,
            );

            // echo "<pre>";
            // print_r($data_simpan);
            // die;

            $this->db->where('kar_id', $kar_id);
            $this->db->update('payroll.komponen_gaji', $data_simpan);
        } else {






            $data_simpan = array(
                'kar_id' => $kar_id,
                'gaji_pokok' => $gaji_pokok_en,
                't_struktural' => $t_struktural_en,
                't_fungsional' => $t_fungsional_en,
                't_umum' => $t_umum_en,
                't_kinerja' => $t_kinerja_en,
                'nik' => $insert_nik->kar_nik,

            );
            $this->db->insert('payroll.komponen_gaji', $data_simpan);
        }

        $message = array(
            'message' => '<div class="alert alert-success">Import file Suksess</div>',
        );
        $this->session->set_flashdata($message);
        redirect('gaji/komponen_gaji');
    }
}
