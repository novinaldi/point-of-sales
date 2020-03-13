<?php
class Pembelian extends CI_Controller
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
        $data = [
            'datasupplier' => $this->db->get('supplier')
        ];
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Transaksi Pembelian',
            'isi' =>  $this->load->view('pembelian/viewinput', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function simpanfakturpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $tgl = $this->input->post('tgl', true);
            $idsup = $this->input->post('sup', true);


            $this->form_validation->set_rules('nota', 'Inputan No.Faktur', 'trim|required|is_unique[pembelian.belinota]', [
                'required' => '%s tidak boleh kosong',
                'is_unique' => 'No.Faktur sudah pernah diinput atau sudah ada di-dalam database, silahkan input <strong>No.Faktur</strong> yang lain'
            ]);
            $this->form_validation->set_rules('tgl', 'Inputan Tgl.Faktur', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);


            if ($this->form_validation->run() == TRUE) {
                //simpan ke tabel pembelian
                $simpanpembelian = [
                    'belinota' => $nota, 'belitgl' => $tgl,
                    'belisupid' => $idsup, 'beliuserinput' => $this->session->userdata('iduser')
                ];
                $this->db->insert('pembelian', $simpanpembelian);

                $pesan = ['suksespembelian' => 'Silahkan Tambahkan Detail Produk'];
            } else {
                $pesan = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading" style="font-weight: bold;">Error!</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('Data tidak dapat di eksekusi');
        }
    }

    function bataltransaksi()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);

            $this->db->delete('detailpembelian', ['detailbelinota' => $nota]);

            $this->db->delete('pembelian', ['belinota' => $nota]);
            $pesan = ['sukses' => 'Transaksi berhasil dibatalkan'];
            echo json_encode($pesan);
        }
    }

    function hapuspembelian()
    {
        $nota = $this->input->post('nota', true);

        $this->db->delete('detailpembelian', ['detailbelinota' => $nota]);

        $this->db->delete('pembelian', ['belinota' => $nota]);
        $pesan = ['sukses' => 'Semua data berhasil dihapus'];
        echo json_encode($pesan);
    }

    function tampildetailpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $q = $this->db->query("SELECT detailid AS id,detailbelikode AS kode,detailbeliqty AS qty,produknm AS produk,detailbeliharga AS harga,
            detailbelisubtotal AS subtotal FROM detailpembelian JOIN stok ON stok.`stokkode`=detailbelikode JOIN produk ON stok.`stokprodukid`=produkid WHERE detailbelinota='$nota'");
            $data = [
                'tampildatadetail' => $q,
                'nota' => $nota,
            ];
            $this->load->view('pembelian/tampildatadetail', $data);
        }
    }

    function formdetailpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $data = [
                'nota' => $nota
            ];
            $this->load->view('pembelian/inputdetail', $data);
        } else {
            exit('Data tidak dapat di eksekusi');
        }
    }

    function simpandetailpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $kode = $this->input->post('kode', true);
            $qty = $this->input->post('qty', true);
            $harga = $this->input->post('harga', true);

            $this->form_validation->set_rules('kode', 'Kode', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('qty', 'Qty', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('harga', 'harga', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);


            if ($this->form_validation->run() == TRUE) {
                $datasimpan = [
                    'detailbelinota' => $nota,
                    'detailbelikode' => $kode, 'detailbeliqty' => $qty,
                    'detailbeliharga' => $harga, 'detailbelisubtotal' => $qty * $harga
                ];
                $this->db->insert('detailpembelian', $datasimpan);
                $pesan = ['sukses' => '<div class="alert alert-success">Silahkan tambahkan jika produk masih ada...</div>'];
            } else {
                $pesan = ['error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'];
            }

            echo json_encode($pesan);
        }
    }

    function cariproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('pembelian/modalcariproduk');
        }
    }
    function cariprodukx()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('pembelian/editmodalcariproduk');
        }
    }

    function ambildataproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modelpembelian', 'pembelian');
            $list = $this->pembelian->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolpilih = '<button type="button" onclick="return pilih(' . $field->stokkode . ')" class="btn btn-outline-primary"><i class="fa fa-fw fa-hand-point-up" style="color:red;"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->stokkode;
                $row[] = $field->produknm;
                $row[] = number_format($field->produkharga, 0, ",", ".");
                $row[] = $tombolpilih;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->pembelian->count_all(),
                "recordsFiltered" => $this->pembelian->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function hapusitemproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);

            $hapus = $this->db->delete('detailpembelian', ['detailid' => $id]);
            if ($hapus) {

                $pesan = ['sukses' => 'Data terhapus'];
            }
            echo json_encode($pesan);
        }
    }

    function data()
    {
        $this->load->library('pagination');
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripembelian', $cari);

            redirect('admin/pembelian/data');
        } else {
            $cari = $this->session->userdata('caripembelian');
        }

        //Query data
        $q = "SELECT belinota,belitgl,supnm,beliuserinput FROM pembelian JOIN supplier ON supplier.`supid`=belisupid WHERE belinota LIKE '%$cari%' OR belitgl LIKE '$cari%' ORDER BY belitgl DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('admin/pembelian/data/');
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


        $qx = "SELECT belinota,belitgl,supnm,beliuserinput FROM pembelian JOIN supplier ON supplier.`supid`=belisupid WHERE belinota LIKE '%$cari%' OR belitgl LIKE '$cari%' ORDER BY belitgl DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );

        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Data Pembelian',
            'isi' =>  $this->load->view('pembelian/viewdatapembelian', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function edit()
    {
        $nota = $this->uri->segment('4');
        $cek = $this->db->get_where('pembelian', ['sha1(belinota)' => $nota]);
        $r = $cek->row_array();
        $data = [
            'nota' => $r['belinota'],
            'tgl' => $r['belitgl'],
            'supid' => $r['belisupid'],
            'datasupplier' => $this->db->get('supplier')
        ];
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Update Detail Pembelian',
            'isi' =>  $this->load->view('pembelian/editdetail', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }
}