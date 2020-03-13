<?php
class Profil extends CI_Controller
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
        $iduser = $this->session->userdata('iduser');
        $this->db->join('nnlevel', 'levelid=userlevelid');
        $q = $this->db->get_where('nnuser', ['userid' => $iduser]);
        $r = $q->row_array();
        $data = [
            'iduser' => $iduser,
            'namauser' => $r['usernama'],
            'level' => $r['levelnama'],
            'foto' => $r['userfoto']
        ];
        $parser = [
            'judul' => '<i class="fa fa-fw fa-user"></i> Profil',
            'isi' =>  $this->load->view('profil/index', $data, true),
        ];
        $this->parser->parse('layout/main', $parser);
    }

    function update()
    {
        $iduser = $this->input->post('iduser', true);
        $namauser = $this->input->post('namauser', true);
        $fileName = $_FILES['uploadfoto']['name'];

        if ($fileName == NULL) {
            $dataupdate = [
                'usernama' => $namauser
            ];
            $this->db->where('userid', $iduser);
            $this->db->update('nnuser', $dataupdate);

            $pesan =  '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Berhasil</h4><hr>
                        Berhasil di Update
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('kasir/profil/index', 'refresh');
        } else {
            $config['upload_path'] = './assets/img/'; //buat folder dengan nama assets di root folder
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['max_size'] = 2024;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('uploadfoto')) {
                $pesan =  '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Berhasil</h4><hr>
                        ' . $this->upload->display_errors() . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('kasir/profil/index', 'refresh');
            } else {
                //ambildata
                $q = $this->db->get_where('nnuser', ['userid' => $iduser]);
                $r = $q->row_array();
                $pathfotolama = $r['userfoto'];
                @unlink($pathfotolama);

                $media = $this->upload->data();
                $pathfilebaru = './assets/img/' . $media['file_name'];

                $dataupdate = [
                    'usernama' => $namauser, 'userfoto' => $pathfilebaru
                ];
                $this->db->where('userid', $iduser);
                $this->db->update('nnuser', $dataupdate);

                $pesan =  '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Berhasil</h4><hr>
                        Berhasil di Update
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('kasir/profil/index', 'refresh');
            }
        }
    }
}