<?php
class Home extends CI_Controller
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
            'judul' => '<i class="fas fa-fw fa-tachometer-alt"></i> Home',
            'isi' =>  $this->load->view('home/index', '', TRUE),
        ];
        $this->parser->parse('layout/main', $parser);
    }
}