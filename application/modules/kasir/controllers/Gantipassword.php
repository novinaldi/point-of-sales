<?php
class Gantipassword extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true && $this->session->userdata('idlevel') == 2) {
            return true;
        } else {
            redirect('login/keluar');
        }
    }
    public function index()
    {
        $parser = [
            'judul' => '<i class="fa fa-fw fa-key"></i> Ganti Password',
            'isi' =>  $this->load->view('gantipass/index', '', true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function updatepass()
    {
        if ($this->input->is_ajax_request() == true) {
            $lama = $this->input->post('passlama');
            $baru = $this->input->post('passbaru');
            $ulangi = $this->input->post('ulangi');

            $this->form_validation->set_rules('passlama', 'Password Lama', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('passbaru', 'Password Baru', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('ulangi', 'Ulangi Password Baru', 'trim|required|matches[passbaru]', [
                'required' => '%s tidak boleh kosong',
                'matches' => 'Inputan %s harus sama dengan diatas'
            ]);


            if ($this->form_validation->run() == TRUE) {
                //cek password lama
                $iduser = $this->session->userdata('iduser');
                $cekpasslama = $this->db->get_where('nnuser', ['userid' => $iduser]);

                $r = $cekpasslama->row_array();
                $hashpasslama = $r['userpass'];

                if (password_verify($lama, $hashpasslama)) {
                    $hashpassbaru = password_hash($baru, PASSWORD_BCRYPT);

                    $updatepass = [
                        'userpass' => $hashpassbaru
                    ];
                    $this->db->where('userid', $iduser);
                    $this->db->update('nnuser', $updatepass);

                    $msg = ['sukses' => 'Password anda berhasil diganti'];
                } else {
                    $msg = [
                        'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Error...</h4><hr>
                        Password Lama anda salah, silahkan coba kembali
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                    ];
                }
            } else {
                $msg = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Error...</h4><hr>
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
                ];
            }
            echo json_encode($msg);
        }
    }
}