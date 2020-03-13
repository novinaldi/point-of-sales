<?php
class Satuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            $this->load->model('Modelsatuan', 'satuan');
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-tasks"></i> Manajemen Data Satuan',
            'isi' =>  $this->load->view('satuan/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->satuan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $tombolhapus = '<button type="button" class="btn btn-outline-danger" onclick="hapus(' . $field->satid . ')"><i class="fa fw fa-trash-alt"></i></button>';
                $tomboledit = '<button type="button" class="btn btn-outline-info" onclick="edit(' . $field->satid . ')"><i class="fa fw fa-pencil-alt"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->satnama;
                if ($field->satqty == 1) {
                    $row[] = '<span class="badge badge-success">' . $field->satqty . '</span>';
                } else {
                    $row[] = '<span class="badge badge-primary">' . $field->satqty . '</span>';
                }
                if ($field->satid != 1) {
                    $row[] = $tombolhapus . '&nbsp;' . $tomboledit;
                } else {
                    $row[] = '';
                }
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
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formtambahdata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->view('satuan/formtambah');
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function simpandata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->library('form_validation');

            $nama = $this->input->post('namasatuan', true);
            $jml = $this->input->post('jml', true);

            $this->form_validation->set_rules('namasatuan', 'Nama satuan', 'trim|required', array(
                'required' => '%s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == TRUE) {
                //lakukan simpan data
                $datasimpan = array('satnama' => $nama, 'satqty' => $jml);

                $this->db->insert('satuan', $datasimpan);
                $pesan = array(
                    'berhasil' => 'Data satuan berhasil tersimpan'
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
            $idsatuan = $this->input->post('idsatuan', true);

            //hapus data
            $hapus = $this->db->delete('satuan', array('satid' => $idsatuan));
            if ($hapus) {
                $pesan = array('sukses' => 'Data satuan berhasil dihapus');
            }
            echo json_encode($pesan);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function formedit()
    {
        $idsatuan = $this->input->post('idsatuan', true);

        //query ambil data satuan
        $ambildata = $this->db->get_where('satuan', array('satid' => $idsatuan));
        $row = $ambildata->row_array();

        $data = array(
            'idsatuan' => $idsatuan,
            'namasatuan' => $row['satnama'],
            'jml' => $row['satqty']
        );
        $this->load->view('satuan/formedit', $data);
    }

    function updatedata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->library('form_validation');

            $idsatuan  = $this->input->post('idsatuan', true);
            $nama = $this->input->post('namasatuan', true);
            $jml = $this->input->post('jml', true);

            $this->form_validation->set_rules('namasatuan', 'Nama satuan', 'trim|required', array(
                'required' => '%s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == TRUE) {
                //lakukan simpan data
                $datasimpan = array('satnama' => $nama, 'satqty' => $jml);

                $this->db->where('satid', $idsatuan);
                $this->db->update('satuan', $datasimpan);
                $pesan = array(
                    'berhasil' => 'Data satuan berhasil diupdate'
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