<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Level_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'lvl_master';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'lvl_nm');

    var $column_search = array('lvl_nm');
    // default order 
    var $order = array('lvl_id' => 'asc');


    public $lvl_id;
    public $lvl_nm;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
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



    // private $_table = "lvl_master";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["lvl_id" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->lvl_id = uniqid();
        // $this->lvl_nm = $divisi;
        $data = array(
            'lvl_nm'=>$divisi,
        );
        return $this->db->insert('lvl_master', $data);
    }

    public function update($lvl_id,$lvl_nm)
    {
        // $post = $this->input->post();
        // $this->lvl_id = $lvl_id;
        // $this->lvl_nm = $lvl_nm;

        $data = array(
            'lvl_nm'=>$lvl_nm,
        );

       
        return $this->db->update('lvl_master', $data, array('lvl_id' => $lvl_id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("lvl_id" => $id));
    }

    // function get(){
    //     $sql = $this->db->query('select * from lvl_master');
    //     return $sql->result();
    // }
}