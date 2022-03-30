<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'Log';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'aktifitas');

    var $column_search = array('aktifitas');
    // default order 
    var $order = array('id_Log' => 'asc');


    public $id_Log;
    public $aktifitas;
    




    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $this->db->order_by('id_log','desc');
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    // private $_table = "jenis";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_Log" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->id_Log = uniqid();
        // $this->aktifitas = $divisi;
        $data = array(
            'aktifitas'=>$divisi,
        );
        return $this->db->insert('Log', $data);
    }

    public function update($id_Log,$aktifitas)
    {
        // $post = $this->input->post();
        // $this->id_Log = $id_Log;
        // $this->aktifitas = $aktifitas;

        $data = array(
            'aktifitas'=>$aktifitas,
        );

       
        return $this->db->update('Log', $data, array('id_Log' => $id_Log));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_Log" => $id));
    }
}