<?php
class Modelstokproduk extends CI_Model
{
    var $column_order = array(null, 'produkkode', 'produknm', 'stokjml');
    var $column_search = array('produkkode', 'produknm'); //field yang diizin untuk pencarian 
    var $order = array('produknm' => 'asc'); // default order 

    private function _get_datatables_query_produk()
    {

        $this->db->select('produkid,produkkode,produknm,stokjml')
            ->from('produk')
            ->join('stok', 'stok.`stokprodukid`=produkid')
            ->where('produktokoid', $this->session->userdata('idtoko'));

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_produk()
    {
        $this->_get_datatables_query_produk();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_produk()
    {
        $this->_get_datatables_query_produk();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_produk()
    {
        $this->db->select('produkid,produkkode,produknm,stokjml')
            ->from('produk')
            ->join('stok', 'stok.`stokprodukid`=produkid')
            ->where('produktokoid', $this->session->userdata('idtoko'));

        return $this->db->count_all_results();
    }
}