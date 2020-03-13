<?php
class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            $this->load->model('Modelproduk', 'produk');
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-archive"></i> Manajemen Data Produk',
            'isi' =>  $this->load->view('produk/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }
    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->produk->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolhapus = '<button type="button" class="btn btn-outline-danger" onclick="hapus(' . $field->produkid . ')"><i class="fa fw fa-trash-alt"></i></button>';
                $tomboledit = '<button type="button" class="btn btn-outline-info" onclick="edit(' . $field->produkid . ')"><i class="fa fw fa-pencil-alt"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->produkkode;
                $row[] = $field->produknm;
                $row[] = $field->katnama;
                $row[] = number_format($field->produkharga, 0, ",", ".");
                $row[] = $tomboledit . '&nbsp;' . $tombolhapus;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->produk->count_all(),
                "recordsFiltered" => $this->produk->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }
    function formtambahdata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $data = [
                'kategori' => $this->db->get('kategori'),
                'satuan' => $this->db->get('satuan')
            ];
            $this->load->view('produk/formtambah', $data);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function simpandata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $kode = $this->input->post('kode', true);
            $nama = $this->input->post('namaproduk', true);
            $kategori = $this->input->post('kat', true);
            $satuan = $this->input->post('sat', true);
            $harga = $this->input->post('hargax', true);


            $this->form_validation->set_rules('kode', 'Kode Produk/Barcode', 'trim|required|is_unique[produk.produkkode]', [
                'required' => '%s tidak boleh kosong',
                'is_unique' => '%s sudah ada, silahkan coba dengan kode yang lain'
            ]);
            $this->form_validation->set_rules('namaproduk', 'Nama Produk', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);

            $this->form_validation->set_rules('hargax', 'Inputan Harga', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);



            if ($this->form_validation->run() == TRUE) {
                $datasimpan = [
                    'produkkode' => $kode,
                    'produknm' => $nama,
                    'produkkatid' => $kategori, 'produksatid' => $satuan,
                    'produkharga' => $harga,
                    'tglinput' => date('Y-m-d H:i:s'),
                    'userinput' => $this->session->userdata('iduser'),
                    'produktokoid' => $this->session->userdata('idtoko')
                ];

                $simpan = $this->db->insert('produk', $datasimpan);
                if ($simpan) {
                    $pesan = ['berhasil' => 'Data Produk berhasil disimpan'];
                }
            } else {
                $pesan = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error...</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                ];
            }

            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function hapusdata()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);

            $this->db->delete('stok', ['stokprodukid' => $id]);
            $this->db->delete('produk', ['produkid' => $id]);
            $x = [
                'sukses' => 'Data produk berhasil terhapus'
            ];
            echo json_encode($x);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formedit()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);

            $ambildata = $this->db->get_where('produk', ['produkid' => $id]);

            $r = $ambildata->row_array();

            $data = [
                'id' => $id,
                'nama' => $r['produknm'],
                'idkat' => $r['produkkatid'],
                'idsat' => $r['produksatid'],
                'harga' => $r['produkharga'],
                'kategori' => $this->db->get('kategori'),
                'satuan' => $this->db->get('satuan')
            ];

            $this->load->view('produk/formedit', $data);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function updatedata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);
            $nama = $this->input->post('namaproduk', true);
            $kategori = $this->input->post('kat', true);
            $satuan = $this->input->post('sat', true);
            $harga = $this->input->post('hargax', true);

            $this->form_validation->set_rules('namaproduk', 'Nama Produk', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);

            $this->form_validation->set_rules('hargax', 'Inputan Harga', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);



            if ($this->form_validation->run() == TRUE) {
                $datasimpan = [
                    'produknm' => $nama,
                    'produkkatid' => $kategori, 'produksatid' => $satuan,
                    'produkharga' => $harga,
                    'tgledit' => date('Y-m-d H:i:s'),
                    'useredit' => $this->session->userdata('iduser'),
                    'produktokoid' => $this->session->userdata('idtoko')
                ];
                $this->db->where('produkid', $id);
                $simpan = $this->db->update('produk', $datasimpan);
                if ($simpan) {
                    $pesan = ['berhasil' => 'Data Produk berhasil di-update'];
                }
            } else {
                $pesan = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error...</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                ];
            }

            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }
}