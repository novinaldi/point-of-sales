<?php
class Stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            $this->load->model('Modelproduk', 'produk');
            $this->load->model('Modelstok', 'stok');
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function input()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Stok Produk',
            'isi' =>  $this->load->view('stok/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function cariproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->view('stok/cariproduk');
        } else {
            redirect('login/keluar');
        }
    }

    function ambildataproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->produk->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombol = '<button type="button" class="btn btn-primary" onclick="pilih(' . $field->produkid . ')"><i class="fa fa-fw fa-hand-point-up"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->produknm;
                $row[] = $field->katnama;
                $row[] = $field->satnama;
                $row[] = number_format($field->produkharga, 0, ",", ".");
                $row[] = $tombol;
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

    function pilihdataproduk()
    {

        if ($this->input->is_ajax_request() == TRUE) {
            $idproduk = $this->input->post('idproduk', true);

            $q = $this->db->get_where('produk', ['produkid' => $idproduk]);
            $r = $q->row_array();

            $data = [
                'idproduk' => $idproduk,
                'namaproduk' => $r['produknm']
            ];
            echo json_encode($data);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    // function cekkode()
    // {
    //     if ($this->input->is_ajax_request() == TRUE) {
    //         $kode = $this->input->post('kode', true);
    //         $qty = $this->input->post('qty', true);
    //         $idproduk = $this->input->post('idproduk', true);
    //         // cek kode pada tabel stok 
    //         $cekkode = $this->db->get_where('stok', ['stokkode' => $kode]);
    //         if ($cekkode->num_rows() > 0) {
    //             $row = $cekkode->row_array();

    //             $updatestok = [
    //                 'stokqty' => $qty + $row['stokqty']
    //             ];
    //             $this->db->where('stokkode', $kode);
    //             $this->db->update('stok', $updatestok);
    //             $pesan = [
    //                 'sukses' => 'Berhasil di Update Stok'
    //             ];
    //         } else {
    //             if ($idproduk == '') {
    //                 $pesan = [
    //                     'error' => 'ID Produk silahkan dipilih terlebih dahulu'
    //                 ];
    //             } else {
    //                 $simpanstok = [
    //                     'stokkode' => $kode,
    //                     'stokprodukid' => $idproduk,
    //                     'stokqty' => $qty
    //                 ];
    //                 $this->db->insert('stok', $simpanstok);
    //                 $pesan = [
    //                     'sukses' => 'Barcode produk baru berhasil ditambahkan'
    //                 ];
    //             }
    //         }
    //         echo json_encode($pesan);
    //     } else {
    //         exit('data tidak bisa dieksekusi');
    //     }
    // }

    function ambildatastok()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->stok->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->stokkode;
                $row[] = $field->produknm;
                $row[] = $field->stokqty;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->stok->count_all(),
                "recordsFiltered" => $this->stok->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function simpankodeproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $kode = $this->input->post('kode', true);
            $qty = $this->input->post('qty', true);
            $idproduk = $this->input->post('idproduk', true);

            if (strlen($kode) == 0 || $kode == '') {
                $pesan = [
                    'error' => 'Kode Barcode tidak boleh kosong'
                ];
            } else {
                $cekkode = $this->db->get_where('stok', ['stokkode' => $kode]);
                if ($cekkode->num_rows() > 0) {
                    $row = $cekkode->row_array();

                    //Insert ke table stok masuk
                    $inserttabelstokmasuk = [
                        'tglmasuk' => date('Y-m-d H:i:s'),
                        'kodebarcode' => $kode, 'jmlmasuk' => $qty,
                        'userinput' => $this->session->userdata('iduser')
                    ];
                    $this->db->insert('stokmasuk', $inserttabelstokmasuk);

                    //lakukan update stok saja
                    $updatestok = [
                        'stokqty' => $qty + $row['stokqty']
                    ];
                    $this->db->where('stokkode', $kode);
                    $this->db->update('stok', $updatestok);

                    $pesan = [
                        'sukses' => 'Stok Berhasil di Update'
                    ];
                } else {
                    if (strlen($idproduk) == 0 || $idproduk == '') {
                        $pesan = [
                            'error' => 'Kode Barcode yang di-input tidak ditemukan, silahkan pilih Produk'
                        ];
                    } else {
                        //Insert ke table stok masuk
                        $inserttabelstokmasuk = [
                            'tglmasuk' => date('Y-m-d H:i:s'),
                            'kodebarcode' => $kode, 'jmlmasuk' => $qty,
                            'userinput' => $this->session->userdata('iduser')
                        ];
                        $this->db->insert('stokmasuk', $inserttabelstokmasuk);

                        //insert kode barcode baru untuk produk pada tabel stok
                        $simpanstokproduk = [
                            'stokkode' => $kode,
                            'stokprodukid' => $idproduk,
                            'stokqty' => $qty
                        ];
                        $this->db->insert('stok', $simpanstokproduk);
                        $pesan = [
                            'sukses' => 'Kode Barcode dan Stok berhasil di tambahkan'
                        ];
                    }
                }
            }


            echo json_encode($pesan);
        } else {
            exit('data tidak dapat dieksekusi');
        }
    }

    function datastokmasuk()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => 'Data Stok Yang Masuk',
            'isi' =>  $this->load->view('stok/datastokmasuk', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildatastokmasuk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modelstokmasuk', 'stokmasuk');
            $list = $this->stokmasuk->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolhapus = '<button onclick="hapus(' . $field->id . ')" type="button" class="btn btn-outline-danger"><i class="fa fa-fw fa-trash-alt"></i></button>';
                $tomblupdate = '<button onclick="edit(' . $field->id . ')" type="button" class="btn btn-outline-info"><i class="fa fa-fw fa-tag"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = date('d-m-Y H:i:s', strtotime($field->tglmasuk));
                $row[] = $field->kodebarcode;
                $row[] = $field->produknm;
                $row[] = $field->jmlmasuk;
                $row[] = $field->userinput;
                $row[] = $tomblupdate . '&nbsp;' . $tombolhapus;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->stokmasuk->count_all(),
                "recordsFiltered" => $this->stokmasuk->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function hapusdatastokmasuk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);

            //ambil data pada stok masuk
            $ambildatastokmasuk = $this->db->get_where('stokmasuk', ['id' => $id]);
            $r = $ambildatastokmasuk->row_array();
            $jmlmasuk = $r['jmlmasuk'];
            $kodebarcode = $r['kodebarcode'];

            //ambil data pada stok produk 
            $ambildatastokproduk = $this->db->get_where('stok', ['stokkode' => $kodebarcode]);
            $rr = $ambildatastokproduk->row_array();
            $stokqty = $rr['stokqty'];

            //hapus data stok masuk
            $this->db->delete('stokmasuk', ['id' => $id]);


            //update qty pada stok produk
            $dataupdate = [
                'stokqty' => $stokqty - $jmlmasuk
            ];
            $this->db->where('stokkode', $kodebarcode);
            $this->db->update('stok', $dataupdate);

            $pesan = [
                'sukses' => 'Data Stok masuk berhasil dihapus'
            ];
            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formeditstokmasuk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);
            //ambil data pada stok masuk
            $ambildatastokmasuk = $this->db->get_where('stokmasuk', ['id' => $id]);
            $r = $ambildatastokmasuk->row_array();
            $jmlmasuk = $r['jmlmasuk'];
            $kodebarcode = $r['kodebarcode'];

            $data = [
                'id' => $id,
                'jmlmasuk' => $jmlmasuk
            ];
            $this->load->view('stok/modalformeditstokmasuk', $data);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function updatedatastokmasuk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);
            $jmlmasukbaru = $this->input->post('jmlmasuk', true);

            //ambil data pada stok masuk
            $ambildatastokmasuk = $this->db->get_where('stokmasuk', ['id' => $id]);
            $r = $ambildatastokmasuk->row_array();
            $jmlmasuk = $r['jmlmasuk'];
            $kodebarcode = $r['kodebarcode'];

            //ambil data pada stok produk 
            $ambildatastokproduk = $this->db->get_where('stok', ['stokkode' => $kodebarcode]);
            $rr = $ambildatastokproduk->row_array();
            $stokqty = $rr['stokqty'];

            $dataupdatestokmasuk = [
                'jmlmasuk' => $jmlmasukbaru
            ];
            $this->db->where('id', $id);
            $this->db->update('stokmasuk', $dataupdatestokmasuk);

            $pesan = ['sukses' => 'Stok masuk berhasil diupdate'];
            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }
}