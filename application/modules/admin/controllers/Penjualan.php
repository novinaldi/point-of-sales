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
        $iduser = $this->session->userdata('iduser');
        $tglhariini = date('Y-m-d');
        $query = $this->db->query("SELECT MAX(jualnota) AS nota FROM penjualan WHERE DATE_FORMAT(jualtgl,'%Y-%m-%d') = '$tglhariini'");
        $hasil = $query->row_array();
        $data  = $hasil['nota'];


        $lastNoUrut = substr($data, 10, 4);

        // nomor urut ditambah 1
        $nextNoUrut = $lastNoUrut + 1;

        // membuat format nomor transaksi berikutnya
        $nextNoTransaksi = 'ANT-' . date('dmy', strtotime($tglhariini)) . sprintf('%04s', $nextNoUrut);
        return $nextNoTransaksi;
    }

    public function input()
    {
        $data = [
            'nota' => $this->buatnomor()
        ];
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-cart-plus"></i> Transaksi Penjualan',
            'isi' =>  $this->load->view('penjualan/input', $data, true),
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
            $this->load->model('penjualan/Modelcariproduk', 'produk');
            $list = $this->produk->get_datatables();
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
                "recordsTotal" => $this->produk->count_all(),
                "recordsFiltered" => $this->produk->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function ambildatadetailproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $kode = $this->input->post('kode', true);

            //ambil data produk
            $sqlproduk = "SELECT produkid,produkkode,produknm,produkharga,stokjml,satuan.* FROM produk JOIN satuan ON satid=produksatid JOIN stok ON stokprodukid=produkid WHERE produkkode=?";
            $query = $this->db->query($sqlproduk, [$kode]);

            if ($query->num_rows() > 0) {
                $r = $query->row_array();
                $data = [
                    'namaproduk' => $r['produknm'],
                    'satnama' => $r['satnama'],
                    'satid' => $r['satid'],
                    'satqty' => $r['satqty'],
                    'hargajualx' => number_format($r['produkharga'], 0,),
                    'hargajual' => $r['produkharga'],
                    'stokproduk' => $r['stokjml']
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

    function carisatuan()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('penjualan/modalcarisatuan');
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

    function tampildetailpenjualanbarang()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $iduser = $this->session->userdata('iduser');
            $sql = "SELECT id,tempkode,produknm,satnama,tempharga,tempqty,tempsubtotal FROM tempjual JOIN produk ON tempjual.`tempkode`=produkkode
            JOIN satuan ON tempsatid=satid WHERE tempnota=? and tempuserinput = ? order by id desc";
            $q = $this->db->query($sql, [$nota, $iduser]);

            $data = [
                'datadetail' => $q
            ];
            $this->load->view('penjualan/datadetail', $data);
        }
    }

    function simpantempjual()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);
            $kode = $this->input->post('kode', true);
            $harga = $this->input->post('harga', true);
            $jml = $this->input->post('jml', true);
            $satid = $this->input->post('satid', true);
            $satqty = $this->input->post('satqty', true);

            $subtotal = $harga * $jml;

            //ambil data produk
            $this->db->join('kategori', 'katid=produkkatid');
            $qproduk = $this->db->get_where('produk', ['produkkode' => $kode]);
            $rproduk = $qproduk->row_array();
            $katket = $rproduk['katket'];
            $produkid = $rproduk['produkid'];

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

            $kalistok = $satqty * $jml;

            if ($katket == 'P') {
                $datasimpan = [
                    'tempnota' => $nota,
                    'temptgl' => date('Y-m-d H:i:s'),
                    'tempkode' => $kode,
                    'tempsatid' => $satid,
                    'tempsatqty' => $satqty,
                    'tempqty' => $jml,
                    'tempharga' => $harga,
                    'tempsubtotal' => $subtotal,
                    'tempuserinput' => $this->session->userdata('iduser')
                ];
                $this->db->insert('tempjual', $datasimpan);

                $msg = [
                    'sukses' => 'Berhasil di tambahkan'
                ];
                echo json_encode($msg);
            } else {
                if ($kalistok > $stokjml) {
                    $msg = [
                        'error' => 'Stok tidak mencukupi'
                    ];
                } else {
                    $datasimpan = [
                        'tempnota' => $nota,
                        'temptgl' => date('Y-m-d H:i:s'),
                        'tempkode' => $kode,
                        'tempsatid' => $satid,
                        'tempsatqty' => $satqty,
                        'tempqty' => $jml,
                        'tempharga' => $harga,
                        'tempsubtotal' => $subtotal,
                        'tempuserinput' => $this->session->userdata('iduser')
                    ];
                    $this->db->insert('tempjual', $datasimpan);

                    $msg = [
                        'sukses' => 'Berhasil di tambahkan'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    function hapusitem()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);
            $hapusitem = $this->db->delete('tempjual', ['id' => $id]);
            if ($hapusitem) {
                $msg = ['sukses' => 'Berhasil dihapus'];
            }
            echo json_encode($msg);
        }
    }

    // function formpembayaran()
    // {
    //     if ($this->input->is_ajax_request() == true) {
    //         $nota = $this->input->post('nota', true);
    //         $total = $this->input->post('total', true);

    //         $data = [
    //             'nota' => $nota, 'total' => $total
    //         ];
    //         $this->load->view('penjualan/formpembayaran', $data);
    //     }
    // }

    function simpanpenjualan()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota');
            $total = $this->input->post('total');
            $iduser = $this->session->userdata('iduser');
            $data = [
                'nota' => $nota,
                'total' => $total
            ];

            echo $this->load->view('penjualan/formpembayaran', $data);
            //cek dulu nota di tabel tempjual
            // $qcektempjual = $this->db->get_where('tempjual', ['tempnota' => $nota]);

            // if ($qcektempjual->num_rows() > 0) {
            //     //simpan transaksi 
            //     $datapenjualan = [
            //         'jualnota' => $nota,
            //         'jualtgl' => date('Y-m-d H:i:s'),
            //         'jualuserinput' => $iduser,
            //         'jualtotal' => $total
            //     ];
            //     $this->db->insert('penjualan', $datapenjualan);

            //     //simpan detail
            //     $this->db->query("INSERT INTO detailpenjualan(detjualnota,detjualtgl,detjualprodukkode,detjualsatid,detjualsatqty,detjualqty,detjualharga,detjualsubtotal,detjualuserinput) (SELECT '$nota',temptgl,tempkode,tempsatid,tempsatqty,tempqty,tempharga,tempsubtotal,tempuserinput FROM tempjual WHERE tempnota='$nota' AND tempuserinput = '$iduser')");

            //     //hapus temp
            //     $this->db->delete('tempjual', ['tempnota' => $nota, 'tempuserinput' => $iduser]);

            //     $data = [
            //         'nota' => $nota,
            //         'total' => $total
            //     ];

            //     echo $this->load->view('penjualan/formpembayaran', $data);
            // } else {
            //     echo 'error';
            // }
        }
    }

    function updatepenjualan()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $iduser = $this->session->userdata('iduser');
            $nota = $this->input->post('nota');
            $jmlbayar = $this->input->post('jmlbayar');
            $sisa = $this->input->post('sisa');
            $total = $this->input->post('totalxx');
            $jmlbayar = $this->input->post('jmlbayar');
            $sisa = $this->input->post('sisa');
            $diskon = $this->input->post('diskon');


            // $update = [
            //     'jualbayar' => $jmlbayar, 'jualsisa' => $sisa
            // ];
            // $this->db->where('jualnota', $nota);
            // $this->db->update('penjualan', $update);

            //Insert ke Penjualan
            $datapenjualan = [
                'jualnota' => $nota,
                'jualtgl' => date('Y-m-d H:i:s'),
                'jualuserinput' => $iduser,
                'jualtotal' => $total,
                'jualdiskon' => $diskon,
                'jualbayar' => $jmlbayar,
                'jualsisa' => $sisa
            ];
            $this->db->insert('penjualan', $datapenjualan);

            //simpan detail penjualan
            $this->db->query("INSERT INTO detailpenjualan(detjualnota,detjualtgl,detjualprodukkode,detjualsatid,detjualsatqty,detjualqty,detjualharga,detjualsubtotal,detjualuserinput) (SELECT '$nota',temptgl,tempkode,tempsatid,tempsatqty,tempqty,tempharga,tempsubtotal,tempuserinput FROM tempjual WHERE tempnota='$nota' AND tempuserinput = '$iduser')");

            //hapus temp
            $this->db->delete('tempjual', ['tempnota' => $nota, 'tempuserinput' => $iduser]);

            $pesan = ['sukses' => site_url('admin/penjualan/cetakfaktur/' . $nota)];
            echo json_encode($pesan);
        }
    }

    function cetakfaktur()
    {
        $nota = $this->uri->segment('4');

        $q = $this->db->get_where('penjualan', ['jualnota' => $nota]);
        $r = $q->row_array();

        //ambil data detail
        $qdetail = $this->db->query("SELECT produknm,detjualqty AS qty,satnama,detjualharga AS harga,detjualsubtotal AS subtotal FROM detailpenjualan JOIN produk ON produkkode=detjualprodukkode JOIN satuan ON detjualsatid=satid WHERE detjualnota ='$nota'");

        $data = [
            'nota' => $nota,
            'tgl' => date('d-m-Y H:i:s', strtotime($r['jualtgl'])),
            'jualdiskon' => number_format($r['jualdiskon'], 0, ",", "."),
            'jualbayar' => number_format($r['jualbayar'], 0, ",", "."),
            'jualsisa' => number_format($r['jualsisa'], 0, ",", "."),
            'datadetail' => $qdetail->result()
        ];

        $this->load->view('penjualan/cetakfaktur', $data);
    }

    function data()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-cart-plus"></i> Data Transaksi Penjualan',
            'isi' =>  $this->load->view('penjualan/viewdata', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambilseluruhdatapenjualan()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->model('penjualan/Modeldatapenjualan', 'penjualan');
            $list = $this->penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {

                //ambil data detail 
                $sqldetail = "SELECT detjualqty FROM detailpenjualan WHERE detjualnota = ?";
                $qdetail = $this->db->query($sqldetail, [$field->jualnota])->result();
                $item = 0;
                $totproduk = 0;
                foreach ($qdetail as $r) {
                    $item++;
                    $totproduk = $totproduk + $r->detjualqty;
                }

                $tombolhapus = "<button type=\"button\" class=\"btn btn-sm btn-circle btn-outline-danger\" onclick=\"hapus('" . $field->jualnota . "')\"><i class=\"fa fa-fw fa-trash-alt\"></i></button>";
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->jualnota;
                $row[] = date('d-m-Y H:i:s', strtotime($field->jualtgl));
                $row[] = number_format($item, 0, ",", ".");
                $row[] = number_format($totproduk, 0, ",", ".");
                $row[] = number_format($field->jualtotal, 0, ",", ".");
                $row[] = $field->jualuserinput;
                $row[] = $tombolhapus;
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

    function hapustransaksipenjualan()
    {
        if ($this->input->is_ajax_request() == true) {
            $nota = $this->input->post('nota', true);

            //hapus detail
            $this->db->trans_start();
            $this->db->delete('detailpenjualan', ['detjualnota' => $nota]);
            $this->db->delete('penjualan', ['jualnota' => $nota]);
            $this->db->trans_complete();

            if ($this->db->trans_status() == true) {
                $msg = [
                    'sukses' => 'Transaksi Penjualan, No.Faktur : ' . $nota . ' Berhasil di hapus'
                ];
                echo json_encode($msg);
            }
        }
    }

    function bataltransaksi()
    {
        if ($this->input->is_ajax_request() == true) {
            $iduser = $this->session->userdata('iduser');

            //hapus tempjual
            $this->db->delete('tempjual', ['tempuserinput' => $iduser]);

            $msg = [
                'sukses' => 'Transaksi Berhasil dibatalkan'
            ];
            echo json_encode($msg);
        }
    }
}