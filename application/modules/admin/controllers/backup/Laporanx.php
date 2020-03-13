<?php
class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            return true;
            $this->load->library('form_validation');
        } else {
            redirect('login/keluar');
        }
    }

    function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Pilih Laporan Yang Dapat di Cetak',
            'isi' =>  $this->load->view('laporan/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function cetaklappembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $awal = $this->input->post('tglawal');
            $akhir = $this->input->post('tglakhir');

            $this->form_validation->set_rules('tglawal', 'Tgl.Awal', 'trim|required');
            $this->form_validation->set_rules('tglakhir', 'Tgl.Akhir', 'trim|required');


            if ($this->form_validation->run() == TRUE or FALSE) {
                $msg = ['sukses' => site_url('admin/laporan/cetaklappembelianx/' . $awal . '/' . $akhir)];
            } else {
                $msg = ['error' => 'Inputan tanggal tidak boleh kosong'];
            }
            echo json_encode($msg);
        }
    }

    function cetaklappembelianx()
    {
        $awal = $this->uri->segment('4');
        $akhir = $this->uri->segment('5');

        $datapembelian = $this->db->query("SELECT pembelian.*,supplier.`supnm` FROM pembelian JOIN supplier ON belisupid=supid WHERE belitgl BETWEEN '$awal' AND '$akhir'");

        $data = [
            'judul' => 'Laporan Pembelian',
            'data' => $datapembelian,
            'awal' => date('d-m-Y', strtotime($awal)),
            'akhir' => date('d-m-Y', strtotime($akhir)),
        ];
        $this->load->view('laporan/cetak/lappembelian', $data);
    }

    function cetaklappenjualankat()
    {
        if ($this->input->is_ajax_request() == true) {
            $awal = $this->input->post('tglawal');
            $akhir = $this->input->post('tglakhir');
            $kat = $this->input->post('kat');

            $this->form_validation->set_rules('tglawal', 'Tgl.Awal', 'trim|required');
            $this->form_validation->set_rules('tglakhir', 'Tgl.Akhir', 'trim|required');


            if ($this->form_validation->run() == TRUE or FALSE) {
                $msg = ['sukses' => site_url('admin/laporan/cetaklappenjualankatx/' . $awal . '/' . $akhir . '/' . $kat)];
            } else {
                $msg = ['error' => 'Inputan tanggal tidak boleh kosong'];
            }
            echo json_encode($msg);
        }
    }

    function cetaklappenjualankatx()
    {
        $awal = $this->uri->segment('4');
        $akhir = $this->uri->segment('5');
        $kat = $this->uri->segment('6');


        if ($kat == 's') {
            $datacetak = $this->db->query("SELECT jualtgl,jualnota,detkodeproduk,produknm,katnama,detqty,detharga,detsubtotal FROM detailpenjualan
            JOIN penjualan ON detjualnota=jualnota JOIN stok ON stok.`stokkode`=detkodeproduk JOIN produk ON produk.`produkid`=stokprodukid
            JOIN kategori ON kategori.`katid`=produk.`produkkatid` WHERE jualtgl BETWEEN DATE_FORMAT('$awal','%Y-%m-%d') AND 
            DATE_FORMAT('$akhir','%Y-%m-%d') ORDER BY katid");
        } else {
            $datacetak = $this->db->query("SELECT jualtgl,jualnota,detkodeproduk,produknm,katnama,detqty,detharga,detsubtotal FROM detailpenjualan
            JOIN penjualan ON detjualnota=jualnota JOIN stok ON stok.`stokkode`=detkodeproduk JOIN produk ON produk.`produkid`=stokprodukid
            JOIN kategori ON kategori.`katid`=produk.`produkkatid` WHERE jualtgl BETWEEN DATE_FORMAT('$awal','%Y-%m-%d') AND 
            DATE_FORMAT('$akhir','%Y-%m-%d') AND katid='$kat'");
        }


        $data = [
            'judul' => 'Laporan Penjualan Per-Kategori',
            'data' => $datacetak,
            'awal' => date('d-m-Y', strtotime($awal)),
            'akhir' => date('d-m-Y', strtotime($akhir)),
            'kat' => $kat
        ];
        $this->load->view('laporan/cetak/lappenjualankat', $data);
    }
}