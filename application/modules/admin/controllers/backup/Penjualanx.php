<?php
class Penjualan extends CI_Controller
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
    function buatnomor()
    {
        $tglhariini = date('Y-m-d');
        $query = $this->db->query("SELECT MAX(jualnota) AS nota FROM penjualan WHERE jualtgl = '$tglhariini'");
        $hasil = $query->row_array();
        $data  = $hasil['nota'];


        $lastNoUrut = substr($data, 16, 4);

        // nomor urut ditambah 1
        $nextNoUrut = $lastNoUrut + 1;

        // membuat format nomor transaksi berikutnya
        $nextNoTransaksi = 'ANT-' . date('dmy', strtotime($tglhariini)) . date('His') . sprintf('%04s', $nextNoUrut);
        return $nextNoTransaksi;
    }
    public function index()
    {
        $data = ['nota' => $this->buatnomor()];
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Transaksi Penjualan',
            'isi' =>  $this->load->view('penjualan/viewinput', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function cariproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('penjualan/modalcariproduk');
        }
    }
    function ambildataproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modelpenjualan', 'penjualan');
            $list = $this->penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolpilih = '<button type="button" onclick="return pilih(' . $field->stokkode . ')" class="btn btn-outline-primary"><i class="fa fa-fw fa-hand-point-up"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->stokkode;
                $row[] = $field->produknm;
                $row[] = number_format($field->produkharga, 0, ",", ".");
                $row[] = number_format($field->stokqty, 0, ",", ".");
                $row[] = $tombolpilih;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->penjualan->count_all(),
                "recordsFiltered" => $this->penjualan->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function tampildetaildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $nota = $this->input->post('nota', true);
            $iduser = $this->session->userdata('iduser');
            $query = $this->db->query("SELECT tempjual.*,produknm FROM tempjual JOIN stok ON stokkode=tempkode JOIN produk ON produkid=stokprodukid WHERE tempnota='$nota' AND tempuserinput='$iduser' ORDER BY id DESC")->result();

            $data = [
                'datadetail' => $query,
                'nota' => $nota
            ];
            $this->load->view('penjualan/viewdatadetail', $data);
        }
    }

    function simpantemp()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $kode = $this->input->post('kode', true);
            $nota = $this->input->post('nota', true);
            $qty = $this->input->post('qty', true);
            $cekkodeproduk = $this->db->get_where('stok', ['stokkode' => $kode]);

            if ($cekkodeproduk->num_rows() > 0) {
                $r = $cekkodeproduk->row_array();
                $stokqty = $r['stokqty'];
                if ($qty > $stokqty) {
                    $pesan = ['error' => 'Stok tidak cukup'];
                } else {
                    //ambil data di produk
                    $dataproduk = $this->db->get_where('produk', ['produkid' => $r['stokprodukid']]);
                    $rr = $dataproduk->row_array();
                    $harga = $rr['produkharga'];
                    //simpan ke Temp
                    $simpantemp = [
                        'tempnota' => $nota, 'temptgl' => date('Y-m-d H:i:s'),
                        'tempkode' => $kode, 'tempqty' => $qty,
                        'tempharga' => $harga, 'tempsubtotal' => $qty * $harga,
                        'tempuserinput' => $this->session->userdata('iduser')
                    ];
                    $this->db->insert('tempjual', $simpantemp);
                    $pesan = ['sukses' => 'Berhasil'];
                }
            } else {
                $pesan = ['error' => 'Kode Barcode tidak ditemukan'];
            }


            echo json_encode($pesan);
        }
    }

    function batalkan()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $nota = $this->input->post('nota');
            $iduser = $this->session->userdata('iduser');
            //hapus temp
            $this->db->delete('tempjual', ['tempnota' => $nota, 'tempuserinput' => $iduser]);
            $pesan = ['sukses' => 'Berhasil batal'];
            echo json_encode($pesan);
        }
    }

    function simpantransaksi()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $nota = $this->input->post('nota');
            $total = $this->input->post('total');
            $iduser = $this->session->userdata('iduser');
            //simpan transaksi 
            $datapenjualan = [
                'jualnota' => $nota,
                'jualtgl' => date('Y-m-d H:i:s'),
                'jualuserinput' => $iduser,
                'jualtotal' => $total
            ];
            $this->db->insert('penjualan', $datapenjualan);

            //simpan detail
            $this->db->query("INSERT INTO detailpenjualan(detjualnota,detkodeproduk,detqty,detharga,detsubtotal)
            (SELECT tempnota,tempkode,tempqty,tempharga,tempsubtotal FROM tempjual WHERE tempnota='$nota' AND tempuserinput = '$iduser')");

            //hapus temp
            $this->db->delete('tempjual', ['tempnota' => $nota, 'tempuserinput' => $iduser]);

            $data = [
                'nota' => $nota,
                'total' => $total
            ];

            echo $this->load->view('penjualan/modalpembayaran', $data);
        }
    }

    function updatepenjualan()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $nota = $this->input->post('nota');
            $jmlbayar = $this->input->post('jmlbayar');
            $sisa = $this->input->post('sisax');

            $update = [
                'jualbayar' => $jmlbayar, 'jualsisa' => $sisa
            ];
            $this->db->where('jualnota', $nota);
            $this->db->update('penjualan', $update);

            $pesan = ['sukses' => site_url('admin/penjualan/cetakfaktur/' . $nota)];
            echo json_encode($pesan);
        }
    }

    function cetakfaktur()
    {
        $nota = $this->uri->segment('4');

        $q = $this->db->get_where('penjualan', ['jualnota' => $nota]);
        $r = $q->row_array();
        $data = [
            'nota' => $nota,
            'tgl' => date('d-m-Y', strtotime($r['jualtgl'])),
            'jualtotal' => number_format($r['jualtotal'], 0, ",", "."),
            'jualbayar' => number_format($r['jualbayar'], 0, ",", "."),
            'jualsisa' => number_format($r['jualsisa'], 0, ",", ".")
        ];

        $this->load->view('penjualan/cetakfaktur', $data);
    }

    function hapusitem()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id');

            $this->db->delete('tempjual', ['id' => $id]);
            echo 'sukses';
        }
    }

    function data()
    {
        $this->load->library('pagination');
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripenjualan', $cari);

            redirect('admin/penjualan/data');
        } else {
            $cari = $this->session->userdata('caripenjualan');
        }

        //Query data
        $q = "SELECT * FROM penjualan ORDER BY jualnota DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('admin/penjualan/data/');
        $config['total_rows'] = $total_data;
        $config['per_page'] = '10';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['uri_segment'] = 4;

        //Custom Pagination
        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        //custom pagination

        $this->pagination->initialize($config);
        //End

        $uri = $this->uri->segment(4);
        $per_page = $config['per_page'];

        if ($uri == null) {
            $start = 0;
        } else {
            $start = $uri;
        }
        //Query data perpage


        $qx = "SELECT * FROM penjualan ORDER BY jualnota DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );

        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Data penjualan',
            'isi' =>  $this->load->view('penjualan/viewdatapenjualan', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function hapuspenjualan()
    {
        $nota = $this->input->post('nota', true);

        $this->db->delete('detailpenjualan', ['detjualnota' => $nota]);

        $this->db->delete('penjualan', ['jualnota' => $nota]);
        $pesan = ['sukses' => 'Semua data berhasil dihapus'];
        echo json_encode($pesan);
    }
}