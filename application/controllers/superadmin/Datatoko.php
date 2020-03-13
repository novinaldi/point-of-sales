<?php
class Datatoko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 3) {
            $this->load->library('form_validation');
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-store-alt"></i> Manajemen Data Toko',
            'isi' =>  $this->load->view('datatoko/index', '', TRUE),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('superadmin/Modeltoko', 'toko');
            $list = $this->toko->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolhapus = '<button type="button" class="btn btn-outline-danger btn-sm" onclick="hapus(' . $field->tokoid . ')"><i class="fa fw fa-trash-alt" title="Hapus Data"></i></button>';
                $tomboledit = '<button type="button" class="btn btn-outline-info btn-sm" onclick="edit(' . $field->tokoid . ')"><i class="fa fw fa-pencil-alt" title="Edit Data"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->tokonama;
                $row[] = $field->tokoalamat;
                $row[] = $field->tokotelp;
                $row[] = $field->tokopemilik;
                $row[]  = $tomboledit . ' ' . $tombolhapus;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->toko->count_all(),
                "recordsFiltered" => $this->toko->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function formtambahdata()
    {
        if ($this->input->is_ajax_request() === true) {
            $this->load->view('datatoko/formtambahdata');
        }
    }

    function formeditdata()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('id', true);

            //ambil data
            $query = $this->db->get_where('toko', ['tokoid' => $id]);
            if ($query->num_rows() > 0) {
                $r = $query->row_array();
                $data = [
                    'id' => $r['tokoid'],
                    'nama' => $r['tokonama'],
                    'telp' => $r['tokotelp'],
                    'pemilik' => $r['tokopemilik'],
                    'alamat' => $r['tokoalamat'],
                ];

                $this->load->view('datatoko/formeditdata', $data);
            }
        }
    }

    function simpandata()
    {
        if ($this->input->is_ajax_request() === true) {
            $namatoko = $this->input->post('namatoko', true);
            $alamat = $this->input->post('alamat', true);
            $namapemilik = $this->input->post('namapemilik', true);
            $telp = $this->input->post('telp', true);

            $this->form_validation->set_rules('namatoko', 'Nama Toko', 'trim|required', ['required' => '%s tidak boleh kosong']);
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required', ['required' => '%s tidak boleh kosong']);
            $this->form_validation->set_rules('telp', 'No.Telp/HP', 'trim|required', ['required' => '%s tidak boleh kosong']);


            if ($this->form_validation->run() == TRUE) {
                $insert_toko = [
                    'tokonama' => $namatoko,
                    'tokoalamat' => $alamat,
                    'tokotelp' => $telp,
                    'tokopemilik' => $namapemilik
                ];

                $this->db->insert('toko', $insert_toko);

                $pesan = [
                    'berhasil' => 'Data Berhasil tersimpan'
                ];
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
        }
    }
    function updatedata()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('idtoko', true);
            $namatoko = $this->input->post('namatoko', true);
            $alamat = $this->input->post('alamat', true);
            $namapemilik = $this->input->post('namapemilik', true);
            $telp = $this->input->post('telp', true);

            $this->form_validation->set_rules('namatoko', 'Nama Toko', 'trim|required', ['required' => '%s tidak boleh kosong']);
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required', ['required' => '%s tidak boleh kosong']);
            $this->form_validation->set_rules('telp', 'No.Telp/HP', 'trim|required', ['required' => '%s tidak boleh kosong']);


            if ($this->form_validation->run() == TRUE) {
                $update_toko = [
                    'tokonama' => $namatoko,
                    'tokoalamat' => $alamat,
                    'tokotelp' => $telp,
                    'tokopemilik' => $namapemilik
                ];
                $this->db->where('tokoid', $id);
                $this->db->update('toko', $update_toko);

                $pesan = [
                    'berhasil' => 'Data Berhasil di update'
                ];
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
        }
    }

    function hapusdata()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('id', true);

            $this->db->delete('toko', ['tokoid' => $id]);
            $pesan = [
                'sukses' => 'Berhasil di hapus'
            ];
            echo json_encode($pesan);
        }
    }
}