<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sembako_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'absen.kar_master';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array('kar_nm','kar_nik','kar_dtl_sts_nkh',null,null);

    var $column_search = array('kar_nm','kar_nik');
    // default order 
    var $order = array('kar_master.kar_id' => 'desc');


    public $kar_id;
    public $kar_nm;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   

         $this->db->select('kar_detail.*,kar_master.kar_nik,kar_master.kar_nm,');
        //$this->db->select('*');
		
        $this->db->join('kar_detail', 'kar_detail.kar_id = kar_master.kar_id', 'left');
        $this->db->from($this->table);
        
        $this->db->where('DATE_ADD(kar_detail.kar_dtl_tgl_joi, INTERVAL "3" MONTH) >=','CURDATE()');

       



        $this->db->where('kar_detail.kar_dtl_typ_krj !=','Resign');
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
           $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select('kar_detail.*,kar_master.kar_nik,kar_master.kar_nm,DATE_ADD(kar_detail.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as bulan_tiga');
        //$this->db->select('*');
		
        $this->db->join('kar_detail', 'kar_detail.kar_id = kar_master.kar_id', 'left');
        $this->db->from($this->table);

        $this->db->where('kar_detail.kar_dtl_typ_krj !=','Resign');
       
        return $this->db->count_all_results();
    }



    // private $_table = "div_master";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["kar_id" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->kar_id = uniqid();
        // $this->kar_nm = $divisi;
        $data = array(
            'kar_nm'=>$divisi,
        );
        return $this->db->insert('div_master', $data);
    }

    public function update($kar_id,$kar_nm)
    {
        // $post = $this->input->post();
        // $this->kar_id = $kar_id;
        // $this->kar_nm = $kar_nm;

        $data = array(
            'kar_nm'=>$kar_nm,
        );

       
        return $this->db->update('div_master', $data, array('kar_id' => $kar_id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("kar_id" => $id));
    }
}