<?php
class Stok extends CI_Controller
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
            'judul' => '<i class="fa fa-fw fa-store"></i> Input Stok Masuk',
            'isi' =>  $this->load->view('stokmasuk/input', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function cariproduk()
    {
        if ($this->input->is_ajax_request() == true) {
            $this->load->view('stokmasuk/modalcariproduk');
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

    function detailproduk()
    {
        if ($this->input->is_ajax_request()) {
            $kode = $this->input->post('kode', true);

            $sqlproduk = "SELECT produkid,produkkode,produknm,produkharga,satnama FROM produk JOIN satuan ON satid=produksatid WHERE produkkode=? and produktokoid=?";
            $query = $this->db->query($sqlproduk, [$kode, $this->session->userdata('idtoko')]);

            if ($query->num_rows() > 0) {
                $r = $query->row_array();

                $data = [
                    'idproduk' => $r['produkid'],
                    'namaproduk' => $r['produknm'],
                    'hargax' => number_format($r['produkharga'], 0),
                    'harga' => $r['produkharga'],
                    'satuan' => $r['satnama']
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

    function simpandata()
    {

        if ($this->input->is_ajax_request()) {
            $kode = $this->input->post('kode', true);
            $jml = $this->input->post('jml', true);

            //ambildata produk berdasarkan kode produk
            $q = $this->db->get_where('produk', ['produkkode' => $kode]);
            $r = $q->row_array();
            //simpan ke tabel stokmasuk
            $simpanstokmasuk = [
                'tglmasuk' => date('Y-m-d H-i-s'),
                'userinput' => $this->session->userdata('iduser'),
                'stokprodukid' => $r['produkid'],
                'jml' => $jml
            ];
            $this->db->insert('stokmasuk', $simpanstokmasuk);

            //update stok ke tabel stok
            //ambil data stok 
            $qq = $this->db->get_where('stok', ['stokprodukid' => $r['produkid']]);
            $rr = $qq->row_array();
            $updatestok = [
                'stokjml' => $rr['stokjml'] + $jml
            ];
            $this->db->where('stokprodukid', $r['produkid']);
            $this->db->update('stok', $updatestok);

            $m = [
                'sukses' => 'Berhasil di tambahkan'
            ];
            echo json_encode($m);
        }
    }

    function ambildatastokproduk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modelstokproduk', 'stokproduk');
            $list = $this->stokproduk->get_datatables_produk();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->produkkode;
                $row[] = $field->produknm;
                $row[] = $field->stokjml;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->stokproduk->count_all_produk(),
                "recordsFiltered" => $this->stokproduk->count_filtered_produk(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function data()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fa fa-fw fa-store"></i> Log Data Stok Masuk',
            'isi' =>  $this->load->view('stokmasuk/data', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildatastokmasuk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modeldatastokmasuk', 'stokmasuk');
            $list = $this->stokmasuk->get_datatables_produk();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $no++;
                $tombolhapus = "<button type=\"button\" onclick=\"hapus('" . $field->id . "')\" class=\"btn btn-outline-danger btn-sm btn-circle\"><i class=\"fa fa-fw fa-trash-alt\"></i></button>";
                $tomboledit = "<button type=\"button\" onclick=\"edit('" . $field->id . "')\" class=\"btn btn-outline-info btn-sm btn-circle\"><i class=\"fa fa-fw fa-edit\"></i></button>";
                $row = array();
                $row[] = $no;
                $row[] = date('d-m-Y H:i:s', strtotime($field->tglmasuk));
                $row[] = $field->produkkode;
                $row[] = $field->produknm;
                $row[] = $field->jml;
                $row[] = $field->userinput;
                $row[] = $tombolhapus . '&nbsp;' . $tomboledit;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->stokmasuk->count_all_produk(),
                "recordsFiltered" => $this->stokmasuk->count_filtered_produk(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function hapuslogstokmasuk()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);
            $sqlstokmasuk = "SELECT id,stokprodukid,produkkode,produknm,jml FROM stokmasuk JOIN produk ON produk.`produkid`=stokmasuk.`stokprodukid` WHERE id=?";
            $ambildata = $this->db->query($sqlstokmasuk, [$id]);
            $r = $ambildata->row_array();
            $namaproduk = $r['produknm'];
            $jml = $r['jml'];
            $stokprodukid = $r['stokprodukid'];

            $datastok = $this->db->get_where('stok', ['stokprodukid' => $stokprodukid]);
            $rr = $datastok->row_array();
            $stokjml = $rr['stokjml'];

            //hapus stok masuk
            $hapus = $this->db->delete('stokmasuk', ['id' => $id]);

            //update stok produk
            $updatestokproduk = [
                'stokjml' => $stokjml - $jml
            ];
            $this->db->where('stokprodukid', $stokprodukid);
            $this->db->update('stok', $updatestokproduk);

            if ($hapus) {
                $msg = [
                    'sukses' => 'Produk <strong>' . $namaproduk . '</strong> berhasil di hapus lognya'
                ];
            }
            echo json_encode($msg);
        }
    }

    function editstokmasuk()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);
            // echo $id;
            $sqlstokmasuk = "SELECT id,stokprodukid,produkkode,produknm,jml FROM stokmasuk JOIN produk ON produk.`produkid`=stokmasuk.`stokprodukid` WHERE id=?";
            $ambildata = $this->db->query($sqlstokmasuk, [$id]);
            $r = $ambildata->row_array();
            $namaproduk = $r['produknm'];
            $jml = $r['jml'];
            $stokprodukid = $r['stokprodukid'];

            $data = [
                'kode' => $r['produkkode'],
                'nama' => $r['produknm'],
                'jml' => $jml,
                'id' => $id
            ];
            // var_dump($data);
            $this->load->view('stokmasuk/modaleditstokmasuk', $data);
        }
    }

    function updatestokmasuk()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);
            $jml = $this->input->post('jml', true);

            $sqlstokmasuk = "SELECT id,stokprodukid,produkkode,produknm,jml FROM stokmasuk JOIN produk ON produk.`produkid`=stokmasuk.`stokprodukid` WHERE id=?";
            $ambildata = $this->db->query($sqlstokmasuk, [$id]);
            $r = $ambildata->row_array();
            $namaproduk = $r['produknm'];
            $jmllama = $r['jml'];
            $stokprodukid = $r['stokprodukid'];

            $datastok = $this->db->get_where('stok', ['stokprodukid' => $stokprodukid]);
            $rr = $datastok->row_array();
            $stokjml = $rr['stokjml'];

            //update tabel stok masuk 
            $updatestokmasuk = [
                'jml' => $jml
            ];
            $this->db->where('id', $id);
            $this->db->update('stokmasuk', $updatestokmasuk);

            //update table stok
            $updatestok = [
                'stokjml' => ($stokjml - $jmllama) + $jml
            ];
            $this->db->where('stokprodukid', $stokprodukid);
            $this->db->update('stok', $updatestok);

            $msg = ['sukses' => 'Data dengan nama produk <strong>' . $namaproduk . '</strong> berhasil di-Update stoknya'];
            echo json_encode($msg);
        }
    }
}