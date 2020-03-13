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
    public function input()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-truck-moving"></i> Transaksi Pembelian',
            'isi' =>  $this->load->view('pembelian/input', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function carisupplier()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('pembelian/modalcarisupplier');
        }
    }

    function ambildatasupplier()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->model('pembelian/Modelsupplier', 'supplier');
            $list = $this->supplier->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolpilih = "<button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"pilih('" . $field->supid . "')\"><i class=\"fa fa-fw fa-hand-pointer\"></i></button>";
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->supnm;
                $row[] = $field->supalamat;
                $row[] = $field->suptelp;
                $row[] = $tombolpilih;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->supplier->count_all(),
                "recordsFiltered" => $this->supplier->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function ambildetailsupplier()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);

            //ambil data supplier
            $q = $this->db->get_where('supplier', ['supid' => $id]);

            $r = $q->row_array();

            $data = [
                'namasup' => $r['supnm']
            ];

            $msg = [
                'sukses' => $data
            ];
            echo json_encode($msg);
        }
    }

    function cariproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('pembelian/modalcariproduk');
        }
    }
    function ambildataproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modelstokmasukx', 'stok');
            $list = $this->stok->get_datatables_produk();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolpilih = "<button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"pilih('" . $field->produkkode . "')\"><i class=\"fa fa-fw fa-hand-pointer\"></i></button>";
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->produkkode;
                $row[] = $field->produknm;
                $row[] = number_format($field->produkharga, 0, ",", ".");
                $row[] = $field->satnama;
                $row[] = $tombolpilih;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->stok->count_all_produk(),
                "recordsFiltered" => $this->stok->count_filtered_produk(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function carisatuan()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('pembelian/modalcarisatuan');
        }
    }

    function ambildatasatuan()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->model('Modelsatuan', 'satuan');
            $list = $this->satuan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->satnama;
                if ($field->satqty == 1) {
                    $row[] = '<span class="badge badge-success">' . $field->satqty . '</span>';
                } else {
                    $row[] = '<span class="badge badge-primary">' . $field->satqty . '</span>';
                }
                $row[] = "<button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"pilih('" . $field->satid . "','" . $field->satnama . "','" . $field->satqty . "')\"><i class=\"fa fa-fw fa-hand-point-up\"></i></button>";
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->satuan->count_all(),
                "recordsFiltered" => $this->satuan->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function simpanfakturpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $tgl = $this->input->post('tgl', true);
            $supid = $this->input->post('supid', true);
            $iduser = $this->session->userdata('iduser');

            $datasimpan = [
                'belinota' => $nota,
                'belitgl' => $tgl,
                'belisupid' => $supid,
                'beliuserinput' => $iduser
            ];
            $simpan = $this->db->insert('pembelian', $datasimpan);

            if ($simpan) {
                $msg = [
                    'sukses' => 'Berhasil tersimpan, silahkan lanjutkan mengisi detail produk'
                ];
                echo json_encode($msg);
            }
        }
    }

    function batalkantransaksi()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);

            //hapus table detail dulu
            $this->db->delete('detailpembelian', ['detailbelinota' => $nota]);
            $this->db->delete('pembelian', ['belinota' => $nota]);

            $pesan = [
                'sukses' => 'Transaksi Berhasil dibatalkan'
            ];
            echo json_encode($pesan);
        }
    }

    function ambildatadetailproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $kode = $this->input->post('kode', true);

            //ambil data produk
            $sqlproduk = "SELECT produkid,produkkode,produknm,produkharga,satuan.* FROM produk JOIN satuan ON satid=produksatid WHERE produkkode=?";
            $query = $this->db->query($sqlproduk, [$kode]);

            if ($query->num_rows() > 0) {
                $r = $query->row_array();
                $data = [
                    'namaproduk' => $r['produknm'],
                    'satnama' => $r['satnama'],
                    'satid' => $r['satid'],
                    'satqty' => $r['satqty'],
                    'hargajualx' => number_format($r['produkharga'], 0,),
                    'hargajual' => $r['produkharga']
                ];
                $msg = [
                    'sukses' => $data
                ];
            } else {
                $msg = [
                    'error' => 'Produk tidak ditemukan'
                ];
            }
            echo json_encode($msg);
        }
    }

    function simpandetailpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $kode = $this->input->post('kode', true);
            $satid = $this->input->post('satid', true);
            $jml = $this->input->post('jml', true);
            $hargabeli = $this->input->post('hargabeli', true);

            $subtotal = $hargabeli * $jml;

            //ambil data satuan
            $qsatuan = $this->db->get_where('satuan', ['satid' => $satid]);
            $rsatuan = $qsatuan->row_array();
            $satqty = $rsatuan['satqty'];

            //ambil data produk
            $this->db->join('kategori', 'katid=produkkatid');
            $qproduk = $this->db->get_where('produk', ['produkkode' => $kode]);
            $rproduk = $qproduk->row_array();
            $katket = $rproduk['katket'];
            $produkid = $rproduk['produkid'];

            //ambil data stok
            $qstok = $this->db->get_where('stok', ['stokprodukid' => $produkid]);
            $rstok = $qstok->row_array();
            $stokjml = $rstok['stokjml'];

            //update jmlstok
            if ($katket != 'P') {
                $stokbaru = $stokjml + ($jml * $satqty);
                $updatestok = [
                    'stokjml' => $stokbaru
                ];
                $this->db->where('stokprodukid', $produkid);
                $this->db->update('stok', $updatestok);
            }

            //simpan ke tabel detail pembelian
            $simpandetailpembelian = [
                'detailbelinota' => $nota,
                'detailbelikode' => $kode,
                'detsatid' => $satid,
                'detsatqty' => $satqty,
                'detailbeliqty' => $jml,
                'detailbeliharga' => $hargabeli,
                'detailbelisubtotal' => $subtotal
            ];
            $this->db->insert('detailpembelian', $simpandetailpembelian);



            $msg = [
                'sukses' => 'Produk berhasil tersimpan'
            ];
            echo json_encode($msg);
        }
    }

    function tampildatadetailpembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);

            //ambil data detail
            $sql = "SELECT detailid,detailbelikode,produknm,satnama,detailbeliqty,detailbeliharga,detailbelisubtotal FROM detailpembelian JOIN produk ON 
            produkkode=detailbelikode JOIN satuan ON satid=detsatid WHERE detailbelinota = ? ORDER BY detailid DESC";
            $q = $this->db->query($sql, [$nota]);

            $data = [
                'datadetail' => $q
            ];
            $this->load->view('pembelian/datadetail', $data);
        }
    }

    function ambildetailberdasarkanfaktur()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $q = $this->db->query("SELECT pembelian.*,supnm FROM pembelian JOIN supplier ON supid=belisupid WHERE belinota='$nota'");

            if ($q->num_rows() > 0) {
                $r = $q->row_array();

                $data = [
                    'tgl' => $r['belitgl'],
                    'supid' => $r['belisupid'],
                    'supnama' => $r['supnm']
                ];
                $msg = [
                    'sukses' => $data
                ];
            } else {
                $msg = [
                    'error' => ''
                ];
            }
            echo json_encode($msg);
        }
    }

    function hapusitem()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);

            //hapus item detail pembelian 
            $hapus = $this->db->delete('detailpembelian', ['detailid' => $id]);
            if ($hapus) {
                $msg = ['sukses' => 'Berhasil terhapus'];
            }
            echo json_encode($msg);
        }
    }

    function data()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-truck-moving"></i> Data Transaksi Pembelian',
            'isi' =>  $this->load->view('pembelian/viewdata', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambilseluruhdatapembelian()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->model('pembelian/Modeldatapembelian', 'pembelian');
            $list = $this->pembelian->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {

                //Menampilkan jumlah item pembelian dan total
                $q = $this->db->get_where('detailpembelian', ['detailbelinota' => $field->belinota])->result();
                $item = 0;
                $total = 0;
                foreach ($q as $rr) {
                    $item++;
                    $total = $total + $rr->detailbelisubtotal;
                }

                $tombolhapus = "<button type=\"button\" class=\"btn btn-sm btn-circle btn-outline-danger\" onclick=\"hapus('" . $field->belinota . "')\"><i class=\"fa fa-fw fa-trash-alt\"></i></button>";
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->belinota;
                $row[] = date('d-m-Y', strtotime($field->belitgl));
                $row[] = $field->supnm;
                $row[] = $item;
                $row[] = "Rp. " . number_format($total, 0);
                $row[] = $tombolhapus;
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
}