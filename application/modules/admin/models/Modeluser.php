<?php
class Modeluser extends CI_Model
{
    // var $table = 'kategori'; //nama tabel dari database
    var $column_order = array(null, 'userid', 'usernama', 'levelnama', 'useraktif', null); //field yang ada di table user
    var $column_search = array('userid', 'usernama', 'levelnama', 'useraktif'); //field yang diizin untuk pencarian 
    var $order = array('userid' => 'asc'); // default order 

    private function _get_datatables_query()
    {

        $this->db->select('id,userid,usernama,useraktif,levelnama')
            ->from('nnuser')
            ->join('nnlevel', 'levelid=userlevelid');

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
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
        $this->db->select('id,userid,usernama,useraktif,levelnama')
            ->from('nnuser')
            ->join('nnlevel', 'levelid=userlevelid');

        return $this->db->count_all_results();
    }
}