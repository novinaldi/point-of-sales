<?php
class Datauser extends CI_Controller
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
            'judul' => '<i class="fas fa-fw fa-users"></i> Manajemen Data User',
            'isi' =>  $this->load->view('datauser/index', '', TRUE),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function ambildata()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('superadmin/Modeluser', 'user');
            $list = $this->user->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                // $tombolhapus = '<button type="button" class="btn btn-outline-danger btn-sm" onclick="hapus(' . $field->tokoid . ')"><i class="fa fw fa-trash-alt" title="Hapus Data"></i></button>';
                // $tomboledit = '<button type="button" class="btn btn-outline-info btn-sm" onclick="edit(' . $field->tokoid . ')"><i class="fa fw fa-pencil-alt" title="Edit Data"></i></button>';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->userid;
                $row[] = $field->usernama;
                $row[] = $field->levelnama;
                $row[] = $field->tokonama;

                if ($field->useraktif == 1) {
                    $useraktif = '<span class="badge badge-success">Aktif</span>';
                } else {
                    $useraktif = '<span class="badge badge-danger">Tidak Aktif</span>';
                }

                $row[] = $useraktif;

                if ($field->userlevelid == 3) {
                    $tombol = "";
                } else {
                    $tombol = '<div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="edituser(' . $field->id . ')"><i class="fa fa-edit"></i> Edit</a>
                        <a class="dropdown-item" href="#" onclick="hapususer(' . $field->id . ')"><i class="fa fa-trash-alt"></i> Hapus</a>
                        <a class="dropdown-item" href="#" onclick="resetpass(' . $field->id . ')"><i class="fa fa-key"></i> Reset Password</a>
                      </div>
                    </div>
                  </div>';
                }
                $row[] = $tombol;

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

    function formtambahdata()
    {
        if ($this->input->is_ajax_request() === true) {
            $data = [
                'datatoko' => $this->db->get('toko')->result(),
                'datalevel' => $this->db->query("SELECT * FROM nnlevel WHERE levelid NOT IN (3)")->result()
            ];
            $this->load->view('datauser/formtambahdata', $data);
        }
    }

    function formedit()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('id', true);

            //ambildata user 
            $query_user = $this->db->get_where('nnuser', ['id' => $id]);
            $row_user = $query_user->row_array();

            // ambil data level
            // $query_level = $this->db->get_where('nnlevel', ['levelid' => $row_user['userlevelid']]);
            // $row_level = $query_level->row_array();

            // ambil data toko 
            // $query_toko = $this->db->get_where('toko', ['tokoid' => $row_user['usertokoid']]);
            // $row_toko = $query_toko->row_array();

            $data = [
                'id' => $id,
                'userid' => $row_user['userid'],
                'usernama' => $row_user['usernama'],
                'userlevelid' => $row_user['userlevelid'],
                'usertokoid' => $row_user['usertokoid'],
                'datalevel' => $this->db->get('nnlevel')->result(),
                'datatoko' => $this->db->get('toko')->result(),
            ];
            $this->load->view('datauser/formeditdata', $data);
        }
    }

    function simpandata()
    {
        if ($this->input->is_ajax_request() === true) {
            $iduser = $this->input->post('iduser', true);
            $namauser = $this->input->post('namauser', true);
            $toko = $this->input->post('toko', true);
            $level = $this->input->post('level', true);
            $pass = $this->input->post('passbaru', true);
            $ulangipass = $this->input->post('upassbaru', true);

            $this->form_validation->set_rules(
                'iduser',
                'ID User',
                'trim|required|is_unique[nnuser.userid]',
                [
                    'required' => 'Inputan %s tidak boleh kosong',
                    'is_unique' => '%s sudah ada didalam database, silahkan gunakan dengan Id User yang lain'
                ]
            );

            $this->form_validation->set_rules(
                'namauser',
                'Nama User',
                'trim|required',
                [
                    'required' => '%s tidak boleh kosong'
                ]
            );
            $this->form_validation->set_rules(
                'passbaru',
                'Password Baru',
                'trim|required',
                [
                    'required' => '%s tidak boleh kosong'
                ]
            );
            $this->form_validation->set_rules(
                'upassbaru',
                'Ulangi Password Baru',
                'trim|required|matches[passbaru]',
                [
                    'required' => '%s tidak boleh kosong',
                    'matches' => '%s harus sama dengan yang diatas'
                ]
            );
            $this->form_validation->set_rules(
                'toko',
                'Toko',
                'trim|required',
                [
                    'required' => '%s tidak boleh kosong'
                ]
            );
            $this->form_validation->set_rules(
                'level',
                'Level',
                'trim|required',
                [
                    'required' => '%s tidak boleh kosong'
                ]
            );


            if ($this->form_validation->run() == TRUE) {
                $insert_data = [
                    'userid' => $iduser,
                    'usernama' => $namauser,
                    'useraktif' => 1,
                    'userlevelid' => $level,
                    'usertokoid' => $toko,
                    'userpass' => password_hash($pass, PASSWORD_DEFAULT)
                ];

                $this->db->insert('nnuser', $insert_data);

                $p = ['berhasil' => 'Data user berhasil tersimpan'];
            } else {
                $p = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error...</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                ];
            }
            echo json_encode($p);
        }
    }

    function updatedata()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('id', true);
            $iduser = $this->input->post('iduser', true);
            $namauser = $this->input->post('namauser', true);
            $toko = $this->input->post('toko', true);
            $level = $this->input->post('level', true);


            $update_data = [
                'usernama' => $namauser,
                'userlevelid' => $level,
                'usertokoid' => $toko
            ];
            $this->db->where('id', $id);
            $this->db->update('nnuser', $update_data);

            $p = ['berhasil' => 'Data user berhasil di-Update'];
            echo json_encode($p);
        }
    }

    function hapusdata()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('id', true);
            $this->db->delete('nnuser', [
                'id' => $id
            ]);

            $p = ['sukses' => 'User berhasil di hapus'];
            echo json_encode($p);
        }
    }

    function resetpassword()
    {
        if ($this->input->is_ajax_request() === true) {
            $id = $this->input->post('id', true);

            $passrandom = rand(1, 9999);

            $ambildatauser = $this->db->get_where('nnuser', ['id' => $id]);
            $r = $ambildatauser->row_array();

            $update = [
                'userpass' => password_hash($passrandom, PASSWORD_DEFAULT)
            ];
            $this->db->where('id', $id);
            $this->db->update('nnuser', $update);

            $data = [
                'iduser' => $r['userid'],
                'namauser' => $r['usernama'],
                'passbaru' => $passrandom
            ];
            $this->load->view('datauser/modalresetpassword', $data);
        }
    }
}