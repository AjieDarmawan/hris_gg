<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_latihan_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'materi';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'materi_nama');

    var $column_search = array('judul');
    // default order 
    var $order = array('materi_id' => 'asc');


    public $materi_id;
    public $judul;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {  
        //$this->db->where('status','latihan');


        $this->db->select('materi.*,jawaban.email,jawaban.skor,jawaban.create_add,jawaban.tgl_mulai as tgl_mengerjakan');
		$this->db->join('jawaban', 'jawaban.materi_id = materi.materi_id', 'inner');
        $this->db->where('jawaban.mode','2');
       // $this->db->group_by('event.judul');
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



    // private $_table = "event";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["materi_id" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->materi_id = uniqid();
        // $this->judul = $divisi;
        $data = array(
            'judul'=>$divisi,
        );
        return $this->db->insert('event', $data);
    }

    public function update($materi_id,$judul)
    {
        // $post = $this->input->post();
        // $this->materi_id = $materi_id;
        // $this->judul = $judul;

        $data = array(
            'judul'=>$judul,
        );

       
        return $this->db->update('event', $data, array('materi_id' => $materi_id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("materi_id" => $id));
    }
}