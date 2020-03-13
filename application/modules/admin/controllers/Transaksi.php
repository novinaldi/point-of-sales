<?php
class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Pilih Transaksional',
            'isi' =>  $this->load->view('transaksi/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }
}