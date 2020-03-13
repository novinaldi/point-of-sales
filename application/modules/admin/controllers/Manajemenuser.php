<?php
class Manajemenuser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 1) {
            $this->load->model('Modeluser', 'user');
            return true;
        } else {
            redirect('login/keluar');
        }
    }

    function index()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-cogs"></i> Manajemen User',
            'isi' =>  $this->load->view('manajemenuser/view', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->user->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                if ($field->userid == $this->session->userdata('iduser')) {
                    $tombol = '';
                    $tombolpassword = '';
                } else {
                    $tombol = '<button type="button" class="btn btn-outline-danger" onclick="hapus(' . $field->id . ')"><i class="fa fa-fw fa-trash-alt"></i></button>';
                    $tombolpassword = "<button type=\"button\" class=\"btn btn-outline-info\" title=\"Reset Password\" onclick=\"resetpass('" . $field->id . "')\">
                        <i class=\"fa fa-fw fa-key\"></i>
                    </button>";
                }
                if ($field->useraktif == '1') {
                    $stt = '<span class="badge badge-success">Aktif</span>';
                } else {
                    $stt = '<span class="badge badge-danger">Tidak Aktif</span>';
                }
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->userid;
                $row[] = $field->usernama;
                $row[] = $stt;
                $row[] = $field->levelnama;
                $row[] = $tombol . '&nbsp;' . $tombolpassword;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->user->count_all(),
                "recordsFiltered" => $this->user->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function hapus()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id', true);

            $this->db->delete('nnuser', ['id' => $id]);
            $pesan = [
                'sukses' => 'User berhasil dihapus'
            ];
            echo json_encode($pesan);
        }
    }

    function formtambah()
    {
        $parser = [
            'menu' => $this->load->view('layout/menu', '', true),
            'judul' => '<i class="fas fa-fw fa-cogs"></i> Tambah User',
            'isi' =>  $this->load->view('manajemenuser/formtambah', '', true)
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function simpandata()
    {
        $iduser = $this->input->post('iduser', true);
        $namauser = $this->input->post('namauser', true);
        $level = $this->input->post('level', true);

        $this->form_validation->set_rules('iduser', 'ID user', 'trim|required|is_unique[nnuser.userid]', [
            'required' => '%s tidak boleh kosong',
            'is_unique' => '%s yang diinput sudah ada didalam database, coba yang lain'
        ]);
        $this->form_validation->set_rules('namauser', 'Nama User', 'trim|required', [
            'required' => '%s tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == TRUE) {
            if ($_FILES['upload']['name'] == NULL) {
                $simpandata = [
                    'userid' => $iduser,
                    'usernama' => $namauser,
                    'useraktif' => 1,
                    'userlevelid' => $level
                ];

                $this->db->insert('nnuser', $simpandata);

                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Berhasil</h4><hr>
                    Id User : <strong>' . $iduser . '</strong> berhasil ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('admin/manajemenuser/formtambah', 'refresh');
            } else {
                $fileName = $_FILES['upload']['name'];
                $config['upload_path'] = './assets/img/'; //buat folder dengan nama assets di root folder
                $config['file_name'] = $fileName;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['max_size'] = 2024;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('upload')) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Error...</h4><hr>
                        ' . $this->upload->display_errors() . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $media = $this->upload->data();
                    $pathfile = './assets/img/' . $media['file_name'];

                    $simpandata = [
                        'userid' => $iduser,
                        'usernama' => $namauser,
                        'useraktif' => 1,
                        'userfoto' => $pathfile,
                        'userlevelid' => $level
                    ];

                    $this->db->insert('nnuser', $simpandata);

                    $pesan = [
                        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Berhasil</h4><hr>
                        Id User : <strong>' . $iduser . '</strong> berhasil ditambahkan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                    ];
                    $this->session->set_flashdata($pesan);
                    redirect('admin/manajemenuser/formtambah', 'refresh');
                }
            }
        } else {
            $pesan = [
                'pesan' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error...</h4><hr>
                ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('admin/manajemenuser/formtambah', 'refresh');
        }
    }

    function resetpassword()
    {
        if ($this->input->is_ajax_request()) {
            $user = $this->input->post('id', true);

            $ambildatauser = $this->db->get_where('nnuser', ['id' => $user]);
            $r = $ambildatauser->row_array();
            $iduser = $r['userid'];

            $passrandom = rand(1, 999999);

            $hashpassword = password_hash($passrandom, PASSWORD_BCRYPT);

            $updatepass = [
                'userpass' => $hashpassword
            ];
            $this->db->where('id', $user);
            $this->db->update('nnuser', $updatepass);

            $data = [
                'iduser' => $iduser, 'pass' => $passrandom
            ];
            $pesan = [
                // 'user' => $user,
                // 'sukses' => 'Berhasil'
                'modalreset' => $this->load->view('manajemenuser/modalresetpassword', $data, true)
            ];
            echo json_encode($pesan);
        }
    }
}