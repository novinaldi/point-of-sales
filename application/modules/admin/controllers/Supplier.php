<?php
class Supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            $this->load->model('Modelsupplier', 'supplier');
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-users"></i> Manajemen Data Supplier',
            'isi' =>  $this->load->view('supplier/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->supplier->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolhapus = '<button type="button" class="btn btn-outline-danger" onclick="hapus(' . $field->supid . ')"><i class="fa fw fa-trash-alt"></i></button>';
                $tomboledit = '<button type="button" class="btn btn-outline-info" onclick="edit(' . $field->supid . ')"><i class="fa fw fa-pencil-alt"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->supnm;
                $row[] = $field->supalamat;
                $row[] = $field->suptelp;
                if ($field->supid != 1) {
                    $row[] = $tombolhapus . '&nbsp;' . $tomboledit;
                } else {
                    $row[] = '';
                }
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
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formtambahdata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->view('supplier/formtambah');
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function simpandata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->library('form_validation');

            $nama = $this->input->post('namasupplier', true);
            $alamat = $this->input->post('alamat', true);
            $telp = $this->input->post('telp', true);

            $this->form_validation->set_rules('namasupplier', 'Nama supplier', 'trim|required', array(
                'required' => 'Setidaknya %s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == TRUE) {
                //lakukan simpan data
                $datasimpan = array(
                    'supnm' => $nama,
                    'supalamat' => $alamat,
                    'suptelp' => $telp
                );

                $this->db->insert('supplier', $datasimpan);
                $pesan = array(
                    'berhasil' => 'Data supplier berhasil tersimpan'
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
            $idsupplier = $this->input->post('idsupplier', true);

            //hapus data
            $hapus = $this->db->delete('supplier', array('supid' => $idsupplier));
            if ($hapus) {
                $pesan = array('sukses' => 'Data supplier berhasil dihapus');
            }
            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formedit()
    {
        $idsupplier = $this->input->post('idsupplier', true);

        //query ambil data supplier
        $ambildata = $this->db->get_where('supplier', array('supid' => $idsupplier));
        $row = $ambildata->row_array();

        $data = array(
            'id' => $idsupplier,
            'nama' => $row['supnm'],
            'alamat' => $row['supalamat'],
            'telp' => $row['suptelp'],
        );
        $this->load->view('supplier/formedit', $data);
    }

    function updatedata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->library('form_validation');

            $id = $this->input->post('id', true);
            $nama = $this->input->post('namasupplier', true);
            $alamat = $this->input->post('alamat', true);
            $telp = $this->input->post('telp', true);

            $this->form_validation->set_rules('namasupplier', 'Nama supplier', 'trim|required', array(
                'required' => 'Setidaknya %s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == TRUE) {
                //lakukan simpan data
                $datasimpan = array(
                    'supnm' => $nama,
                    'supalamat' => $alamat,
                    'suptelp' => $telp
                );
                $this->db->where('supid', $id);
                $this->db->update('supplier', $datasimpan);
                $pesan = array(
                    'berhasil' => 'Data supplier berhasil terupdate'
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