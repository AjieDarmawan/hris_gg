<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sembako extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata()['pegawai']) {
            redirect('auth');
        }
        $this->load->model(array('Sembako_M'));
    }




    // redirect if needed, otherwise display the user list
    public function index()
    {


        //$data["divisi"] = $this->Sembako_M->getAll();
        $data["title"] = "List Data Master Sembako";
        $this->template->load('template', 'sembako/sembako_v', $data);
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Sembako_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_sembako) {
            $hari_ini = date('Y-m-d');
            $tgl_join =   date('Y-m-d', strtotime('+3 month', strtotime($data_sembako->kar_dtl_tgl_joi)));


            if (($data_sembako->kar_nik != 'SG.0060.2010' and $data_sembako->kar_nik != 'SG.0035.2007'
                and $data_sembako->kar_nik != 'SG.0410.2017' and $data_sembako->kar_nik != 'SG.0205.2014'
                and $data_sembako->kar_nik != 'SG.0247.2015' and $data_sembako->kar_nik != 'SG.0186.2014'
                and $data_sembako->kar_nik != 'SG.0273.2015' and $data_sembako->kar_nik != 'SG.0226.2015'
                and $data_sembako->kar_nik != 'SG.0608.2021' and $data_sembako->kar_nik != 'SG.0664.2022'
                and $data_sembako->kar_nik != 'SG.0665.2022' and $data_sembako->kar_nik != 'SG.0666.2022'
                and $data_sembako->kar_nik != 'SG.0667.2022' and $data_sembako->kar_nik != 'SG.0668.2022'

                and $data_sembako->kar_nik != 'SG.0663.2022' and $data_sembako->kar_nik != 'SG.0688.2022'
                and $data_sembako->kar_nik != 'SG.0689.2022')) {

                if ($data_sembako->kar_nik == 'SG.0675.2022') {
                       $harga = 220000;
                } else {

                    if ($data_sembako->kar_dtl_sts_nkh == 'TK') {
                        $harga = 110000;
                    } elseif ($data_sembako->kar_dtl_sts_nkh == 'K') {
                        $harga = 220000;
                    } else {
                        $harga = 0;
                    }
                }
            } else {
                $harga = 0;
            }

            if ($hari_ini >= $tgl_join) {





                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $data_sembako->kar_nik;
                $row[] = $data_sembako->kar_nm;
                $row[] = date('d-M-Y', strtotime($data_sembako->kar_dtl_tgl_joi));
                $row[] = $data_sembako->kar_dtl_sts_nkh;
                $row[] = number_format($harga);




                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Sembako_M->count_all(),
            "recordsFiltered" => $this->Sembako_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function menikah()
    {

        $menikah = $this->db->query('select k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where kar_dtl_sts_nkh="K" and kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and kar_nik not in ("SG.0060.2010","SG.0035.2007","SG.0410.2017","SG.0205.2014","SG.0247.2015",
        "SG.0186.2014","SG.0273.2015","SG.0226.2015","SG.0608.2021","SG.0664.2022","SG.0665.2022","SG.0666.2022","SG.0667.2022","SG.0668.2022","SG.0663.2022","SG.0688.2022","SG.0689.2022") order by k.ktr_id asc')->result();
        $data['menikah'] = $menikah;
        $data["title"] = "List Data Menikah";
        $this->template->load('template', 'sembako/menikah', $data);
    }

    function belum_menikah()
    {

        $menikah = $this->db->query('select k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where kar_dtl_sts_nkh="TK" and kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and kar_nik not in ("SG.0667.2022","SG.0668.2022","SG.0663.2022","SG.0688.2022","SG.0689.2022") order by k.ktr_id asc')->result();
        $data['menikah'] = $menikah;
        $data["title"] = "List Data Menikah";
        $this->template->load('template', 'sembako/belum_menikah', $data);
    }

    function sembako_insert()
    {

        $data_kar = $this->db->query('select d.kar_dtl_tgl_joi,d.kar_dtl_sts_nkh,k.kar_nm, k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  "2022-09-31"  order by k.ktr_id asc')->result();


        foreach ($data_kar as $k) {

            $hari_ini = date('Y-m-d');
            $tgl_join =   date('Y-m-d', strtotime('+3 month', strtotime($k->kar_dtl_tgl_joi)));





            if (($k->kar_nik != 'SG.0060.2010' and $k->kar_nik != 'SG.0035.2007'
                and $k->kar_nik != 'SG.0410.2017' and $k->kar_nik != 'SG.0205.2014'
                and $k->kar_nik != 'SG.0247.2015' and $k->kar_nik != 'SG.0186.2014'
                and $k->kar_nik != 'SG.0273.2015' and $k->kar_nik != 'SG.0226.2015'
                and $k->kar_nik != 'SG.0608.2021' and $k->kar_nik != 'SG.0664.2022'
                and $k->kar_nik != 'SG.0665.2022' and $k->kar_nik != 'SG.0666.2022'
                and $k->kar_nik != 'SG.0667.2022' and $k->kar_nik != 'SG.0668.2022'

                and $k->kar_nik != 'SG.0663.2022' and $k->kar_nik != 'SG.0688.2022'
                and $k->kar_nik != 'SG.0689.2022' and $k->kar_nik != 'SG.0011.2003'

                and $k->kar_nik != 'SG.0634.2021'
 

            )) {

                if ($k->kar_nik == 'SG.0675.2022') {
                    $harga = 220000;
             } else {

                if ($k->kar_dtl_sts_nkh == 'TK') {
                    $harga = 110000;
                } elseif ($k->kar_dtl_sts_nkh == 'K') {
                    $harga = 220000;
                } else {
                    $harga = 0;
                }
             }


               
            } else {
                $harga = 0;
            }



            $data_array = array(
                'kar_id' => $k->kar_id,
                'kar_nik' => $k->kar_nik,
                'kar_nm' => $k->kar_nm,
                // 'bulan' => date('m-Y'),
                'bulan' => '09-2022',
                'harga' => $harga,
                'crdt' => date('Y-m-d H:i:s'),
                'status_menikah' => $k->kar_dtl_sts_nkh,


            );
            $simpan = $this->db->insert('payroll.sembako', $data_array);
        }

        // echo "<pre>";
        // print_r($data_array);

        if ($simpan) {
            redirect('gaji/sembako');
        }

        //
    }

    function belum_dapet()
    {
        $belum_dapet = $this->db->query('select d.kar_dtl_tgl_joi,k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) >  CURDATE() order by k.ktr_id asc')->result();
        $data['belum_dapet'] = $belum_dapet;
        $data["title"] = "List Data Menikah";
        $this->template->load('template', 'sembako/belum_dapet', $data);
    }

    function ga_dapet()
    {
        $bulan_where = date('m-Y');
        $belum_dapet = $this->db->query('select s.*,k.kar_dtl_tgl_joi from payroll.sembako as s 
        join kar_detail as k on k.kar_id = s.kar_id where s.bulan = "' . $bulan_where . '" and s.harga="0"')->result();
        $data['tidak_dapat'] = $belum_dapet;
        $data["title"] = "List Data Menikah";
        $this->template->load('template', 'sembako/tidak_dapat', $data);
    }
}
