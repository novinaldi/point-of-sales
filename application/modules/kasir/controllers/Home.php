<?php
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 2) {
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'judul' => 'Selamat Datang : ' . $this->session->userdata('iduser'),
            'isi' =>  $this->load->view('home/index', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }
}