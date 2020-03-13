<?php
class Utility extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 3) {
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-cogs"></i> Utility',
            'isi' =>  $this->load->view('utility/index', '', TRUE),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function kosongkandata()
    {

        // $this->db->empty_table('detailpembelian');
        // $this->db->empty_table('pembelian');
        // $this->db->empty_table('detailpenjualan');
        // $this->db->empty_table('penjualan');
        // $this->db->empty_table('stokmasuk');
        // $this->db->empty_table('stok');
        // $this->db->empty_table('produk');
        // $this->db->empty_table('satuan');
        // $this->db->empty_table('kategori');
        // $this->db->empty_table('supplier');

        $this->db->trans_start();
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->truncate('tempjual');
        $this->db->truncate('detailpembelian');
        $this->db->truncate('pembelian');
        $this->db->truncate('detailpenjualan');
        $this->db->truncate('penjualan');
        $this->db->truncate('supplier');
        $this->db->truncate('stokmasuk');
        $this->db->truncate('stok');
        $this->db->truncate('produk');
        $this->db->truncate('satuan');
        $this->db->truncate('kategori');
        $this->db->truncate('nnlevel');
        $this->db->truncate('nnuser');
        $this->db->truncate('toko');
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");

        $insert_satuan = ['satnama' => '-'];
        $insert_kategori = ['katnama' => '-'];
        $insert_supplier = ['supnm' => '-'];

        $insert_user = [
            'userid' => 'superadmin',
            'usernama' => 'Super Admin',
            'userpass' => password_hash('superadmin', PASSWORD_DEFAULT),
            'useraktif' => 1, 'userlevelid' => 3
        ];

        $this->db->insert('satuan', $insert_satuan);
        $this->db->insert('kategori', $insert_kategori);
        $this->db->insert('supplier', $insert_supplier);
        $this->db->query("INSERT INTO nnlevel VALUES(1,'Administrator'),(2,'Kasir'),(3,'Super Admin')");
        $this->db->insert('nnuser', $insert_user);


        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Berhasil</h4><hr>
            Semua data berhasil di kosongkan...
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

            $this->session->set_flashdata('msg', $pesan);
            redirect('superadmin/utility/index');
        }
    }
}