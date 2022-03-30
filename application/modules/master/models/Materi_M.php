<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Materi_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'materi';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'materi_nama');

    var $column_search = array('materi_nama');
    // default order 
    var $order = array('materi_id' => 'asc');


    public $materi_id;
    public $materi_nama;
    



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id)
    {   

        $id2= base64_decode($id);

        
      
        $this->db->select('materi.*,jenis.jenis_nama');
		$this->db->join('jenis', 'jenis.id_jenis = materi.id_jenis', 'inner');
        $this->db->where('materi.id_event',$id2);
        $this->db->order_by('materi.no_urut','ASC');
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

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    // private $_table = "materi";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["materi_id" => $id])->row();
    }

    public function save($Materi,$id_jurusan,$tgl_mulai,$tgl_selesai,$id_event,$waktu,$no_urut,$id_jenis)
    {
        // $post = $this->input->post();
        // $this->materi_id = uniqid();
        // $this->materi_nama = $divisi;
        $data = array(
            'materi_nama'=>$Materi,
            'id_jurusan'=>$id_jurusan,
            'tgl_mulai'=>$tgl_mulai,
            'tgl_selesai'=>$tgl_selesai,
            'id_event'=>$id_event,
            'waktu'=>$waktu,
            'no_urut'=>$no_urut,
            'id_jenis'=>$id_jenis,
        );
        return $this->db->insert('materi', $data);
    }

    public function update($materi_id,$materi_nama,$no_urut,$id_jenis)
    {
        // $post = $this->input->post();
        // $this->materi_id = $materi_id;
        // $this->materi_nama = $materi_nama;

        $data = array(
            'materi_nama'=>$materi_nama,
            'no_urut'=>$no_urut,
            'id_jenis'=>$id_jenis,
        );

       
        return $this->db->update('materi', $data, array('materi_id' => $materi_id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("materi_id" => $id));
    }
}