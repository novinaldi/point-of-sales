<?php
class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            $this->load->model('Modelkategori', 'kategori');
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-tasks"></i> Manajemen Data Kategori',
            'isi' =>  $this->load->view('kategori/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->kategori->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolhapus = '<button type="button" class="btn btn-outline-danger" onclick="hapus(' . $field->katid . ')"><i class="fa fw fa-trash-alt"></i></button>';
                $tomboledit = '<button type="button" class="btn btn-outline-info" onclick="edit(' . $field->katid . ')"><i class="fa fw fa-pencil-alt"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->katnama;
                // if ($field->katket == 'P') {
                //     $row[] = 'Plastik';
                // } else if ($field->katket == 'T') {
                //     $row[] = 'Telur';
                // } else {
                //     $row[] = '-';
                // }
                if ($field->katid != 1) {
                    $row[] = $tombolhapus . '&nbsp;' . $tomboledit;
                } else {
                    $row[] = '';
                }
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->kategori->count_all(),
                "recordsFiltered" => $this->kategori->count_filtered(),
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
            $this->load->view('kategori/formtambah');
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function simpandata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->library('form_validation');

            $nama = $this->input->post('namakategori', true);
            $ket = $this->input->post('ket', true);

            $this->form_validation->set_rules('namakategori', 'Nama Kategori', 'trim|required', array(
                'required' => '%s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == TRUE) {
                //lakukan simpan data
                $datasimpan = array('katnama' => $nama, 'katket' => $ket);

                $this->db->insert('kategori', $datasimpan);
                $pesan = array(
                    'berhasil' => 'Data Kategori berhasil tersimpan'
                );
            } else {
                $pesan = array(
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error...</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                );
            }

            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function hapusdata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $idkategori = $this->input->post('idkategori', true);

            //hapus data
            $hapus = $this->db->delete('kategori', array('katid' => $idkategori));
            if ($hapus) {
                $pesan = array('sukses' => 'Data kategori berhasil dihapus');
            }
            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formedit()
    {
        $idkategori = $this->input->post('idkategori', true);

        //query ambil data kategori
        $ambildata = $this->db->get_where('kategori', array('katid' => $idkategori));
        $row = $ambildata->row_array();

        $data = array(
            'idkategori' => $idkategori,
            'namakategori' => $row['katnama'],
            'ket' => $row['katket']
        );
        $this->load->view('kategori/formedit', $data);
    }

    function updatedata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->library('form_validation');

            $idkategori  = $this->input->post('idkategori', true);
            $nama = $this->input->post('namakategori', true);
            $ket = $this->input->post('ket', true);

            $this->form_validation->set_rules('namakategori', 'Nama Kategori', 'trim|required', array(
                'required' => '%s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == TRUE) {
                //lakukan simpan data
                $datasimpan = array('katnama' => $nama, 'katket' => $ket);

                $this->db->where('katid', $idkategori);
                $this->db->update('kategori', $datasimpan);
                $pesan = array(
                    'berhasil' => 'Data Kategori berhasil diupdate'
                );
            } else {
                $pesan = array(
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error...</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                );
            }

            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }
}