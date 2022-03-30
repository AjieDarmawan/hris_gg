<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'jurusan';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'jurusan_nama');

    var $column_search = array('jurusan_nama');
    // default order 
    var $order = array('id_jurusan' => 'asc');


    public $id_jurusan;
    public $jurusan_nama;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('jurusan.*,jenis.jenis_nama');
		$this->db->join('jenis', 'jenis.id_jenis = jurusan.id_jenis', 'inner');
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



    // private $_table = "jurusan";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_jurusan" => $id])->row();
    }

    public function getByIdJenis($id)
    {
        return $this->db->get_where($this->table, ["id_jenis" => $id])->result();
    }

    public function save($jurusan_nama,$id_jenis)
    {
        // $post = $this->input->post();
        // $this->id_jurusan = uniqid();
        // $this->jurusan_nama = $jurusan_nama,$id_jenis;
        $data = array(
            'jurusan_nama'=>$jurusan_nama,
            'id_jenis'=>$id_jenis,
        );

       
        return $this->db->insert('jurusan', $data);
    }

    public function update($id_jurusan,$jurusan_nama,$id_jenis)
    {
        // $post = $this->input->post();
        // $this->id_jurusan = $id_jurusan;
        // $this->jurusan_nama = $jurusan_nama;

        $data = array(
            'jurusan_nama'=>$jurusan_nama,
            'id_jenis'=>$id_jenis
        );

       
        return $this->db->update('jurusan', $data, array('id_jurusan' => $id_jurusan));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_jurusan" => $id));
    }
}