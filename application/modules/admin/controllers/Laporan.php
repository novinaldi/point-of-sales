<?php
class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true) {
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-print"></i> Pilih Laporan',
            'isi' =>  $this->load->view('laporan/index', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    public function pembelian()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-print"></i> Laporan Pembelian',
            'isi' =>  $this->load->view('laporan/viewlappembelian', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function laporanpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $awal = $this->input->post('tglawal');
            $akhir = $this->input->post('tglakhir');

            $this->form_validation->set_rules('tglawal', 'Tgl.Awal', 'trim|required');
            $this->form_validation->set_rules('tglakhir', 'Tgl.Akhir', 'trim|required');


            if ($this->form_validation->run() == TRUE or FALSE) {
                $msg = ['sukses' => site_url('admin/laporan/cetaklaporanpembelian/' . $awal . '/' . $akhir)];
            } else {
                $msg = ['error' => 'Inputan tanggal tidak boleh kosong'];
            }
            echo json_encode($msg);
        }
    }

    function cetaklaporanpembelian()
    {
        $awal = $this->uri->segment(4);
        $akhir = $this->uri->segment(5);

        $sql = "SELECT pembelian.*,supnm FROM pembelian JOIN supplier ON belisupid=supid WHERE belitgl BETWEEN ? AND ? order by belitgl desc";
        $q = $this->db->query($sql, [$awal, $akhir])->result();

        $data = [
            'awal' => date('d-m-Y', strtotime($awal)),
            'akhir' => date('d-m-Y', strtotime($akhir)),
            'judul' => 'Laporan Pembelian Per-Periode',
            'data' => $q
        ];
        $this->load->view('laporan/cetak/lappembelian', $data);
    }

    function penjualan()
    {
        $data = [
            'datakategori' => $this->db->get('kategori')
        ];
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-shopping-cart"></i> Laporan Penjualan',
            'isi' =>  $this->load->view('laporan/viewlappenjualan', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function laporanpenjualan()
    {
        if ($this->input->is_ajax_request() == true) {
            $awal = $this->input->post('tglawal');
            $akhir = $this->input->post('tglakhir');
            $kat = $this->input->post('kat');

            $this->form_validation->set_rules('tglawal', 'Tgl.Awal', 'trim|required');
            $this->form_validation->set_rules('tglakhir', 'Tgl.Akhir', 'trim|required');


            if ($this->form_validation->run() == TRUE or FALSE) {
                if ($kat == '') {
                    $msg = ['sukses' => site_url('admin/laporan/cetaklaporanpenjualan/' . $awal . '/' . $akhir)];
                } else {
                    $msg = ['sukses' => site_url('admin/laporan/cetaklaporanpenjualan/' . $awal . '/' . $akhir . '/' . $kat)];
                }
            } else {
                $msg = ['error' => 'Inputan tanggal tidak boleh kosong'];
            }
            echo json_encode($msg);
        }
    }

    function cetaklaporanpenjualan()
    {
        $awal = $this->uri->segment(4);
        $akhir = $this->uri->segment(5);
        $kat = $this->uri->segment(6);

        if ($kat == '') {
            $this->db->order_by('katnama', 'asc');
            $datakategori = $this->db->get('kategori');
            $data = [
                'awal' => date('d-m-Y', strtotime($awal)),
                'akhir' => date('d-m-Y', strtotime($akhir)),
                'judul' => 'Laporan Penjualan Semua Kategori Produk',
                'datakategori' => $datakategori
            ];
            $this->load->view('laporan/cetak/lappenjualansemua', $data);
        } else {
            $datakategori = $this->db->get_where('kategori', ['katid' => $kat]);
            $rr = $datakategori->row_array();
            $namakat = $rr['katnama'];

            $sqldetail = "SELECT detjualtgl,detjualprodukkode,produknm,detjualqty,detjualharga,detjualsubtotal FROM detailpenjualan JOIN produk
                                ON produkkode=detjualprodukkode JOIN kategori ON katid=produk.`produkkatid` WHERE katid= ? AND DATE_FORMAT(detjualtgl,'%Y-%m-%d') BETWEEN ? AND ?";

            $qdetail = $this->db->query($sqldetail, [$kat, $awal, $akhir])->result();
            $data = [
                'awal' => date('d-m-Y', strtotime($awal)),
                'akhir' => date('d-m-Y', strtotime($akhir)),
                'judul' => 'Laporan Penjualan Kategori ' . $namakat,
                'data' => $qdetail,
                'namakat' => $namakat
            ];
            $this->load->view('laporan/cetak/lappenjualanperkategori', $data);
        }
    }

    function pendapatan()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-money-check-alt"></i> Laporan Pendapatan',
            'isi' =>  $this->load->view('laporan/viewlappendapatan', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function laporanpendapatan()
    {
        if ($this->input->is_ajax_request() == true) {
            $tahun = $this->input->post('tahun', true);

            $this->form_validation->set_rules('tahun', 'Inputan Tahun', 'trim|required', array('required' => '%s tidak boleh kosong'));


            if ($this->form_validation->run() == TRUE) {
                $msg = ['sukses' => site_url('admin/laporan/cetaklaporanpendapatan/' . $tahun)];
            } else {
                $msg = [
                    'error' => validation_errors()
                ];
            }
            echo json_encode($msg);
        }
    }

    function cetaklaporanpendapatan()
    {
        $tahun = $this->uri->segment('4');

        $sqlpembelian = "SELECT IFNULL(SUM(IF(MONTH(belitgl)=1,belitotal,0)),0) AS jan,
        IFNULL(SUM(IF(MONTH(belitgl)=2,belitotal,0)),0) AS feb,
        IFNULL(SUM(IF(MONTH(belitgl)=3,belitotal,0)),0) AS mar,
        IFNULL(SUM(IF(MONTH(belitgl)=4,belitotal,0)),0) AS apr,
        IFNULL(SUM(IF(MONTH(belitgl)=5,belitotal,0)),0) AS mei,
        IFNULL(SUM(IF(MONTH(belitgl)=6,belitotal,0)),0) AS jun,
        IFNULL(SUM(IF(MONTH(belitgl)=7,belitotal,0)),0) AS jul,
        IFNULL(SUM(IF(MONTH(belitgl)=8,belitotal,0)),0) AS agt,
        IFNULL(SUM(IF(MONTH(belitgl)=9,belitotal,0)),0) AS sep,
        IFNULL(SUM(IF(MONTH(belitgl)=10,belitotal,0)),0) AS okt,
        IFNULL(SUM(IF(MONTH(belitgl)=11,belitotal,0)),0) AS nov,
        IFNULL(SUM(IF(MONTH(belitgl)=12,belitotal,0)),0) AS des
        FROM pembelian WHERE YEAR(belitgl) = ?";

        $sqlpenjualan = "SELECT IFNULL(SUM(IF(MONTH(jualtgl)=1,jualtotal,0)),0) AS jan,
        IFNULL(SUM(IF(MONTH(jualtgl)=2,jualtotal,0)),0) AS feb,
        IFNULL(SUM(IF(MONTH(jualtgl)=3,jualtotal,0)),0) AS mar,
        IFNULL(SUM(IF(MONTH(jualtgl)=4,jualtotal,0)),0) AS apr,
        IFNULL(SUM(IF(MONTH(jualtgl)=5,jualtotal,0)),0) AS mei,
        IFNULL(SUM(IF(MONTH(jualtgl)=6,jualtotal,0)),0) AS jun,
        IFNULL(SUM(IF(MONTH(jualtgl)=7,jualtotal,0)),0) AS jul,
        IFNULL(SUM(IF(MONTH(jualtgl)=8,jualtotal,0)),0) AS agt,
        IFNULL(SUM(IF(MONTH(jualtgl)=9,jualtotal,0)),0) AS sep,
        IFNULL(SUM(IF(MONTH(jualtgl)=10,jualtotal,0)),0) AS okt,
        IFNULL(SUM(IF(MONTH(jualtgl)=11,jualtotal,0)),0) AS nov,
        IFNULL(SUM(IF(MONTH(jualtgl)=12,jualtotal,0)),0) AS des
        FROM penjualan WHERE YEAR(jualtgl) = ?";

        $qpembelian = $this->db->query($sqlpembelian, [$tahun]);
        $qpenjualan = $this->db->query($sqlpenjualan, [$tahun]);

        $data = [
            'x' => $qpembelian,
            'y' => $qpenjualan,
            'judul' => 'Laporan Pendapatan Tahun :' . $tahun,
            'tahun' => $tahun
        ];

        $this->load->view('laporan/cetak/lappendapatanpertahun', $data);
    }
}