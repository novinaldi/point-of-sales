<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('login/view');
	}

	function validasiuser()
	{
		if ($this->input->is_ajax_request() == TRUE) {
			$iduser = $this->input->post('uid', true);
			$pass = $this->input->post('pass', true);

			$this->form_validation->set_rules('uid', 'ID User', 'trim|required', array(
				'required' => '%s tidak boleh kosong'
			));
			$this->form_validation->set_rules('pass', 'Password ', 'trim|required', array(
				'required' => '%s tidak boleh kosong'
			));

			if ($this->form_validation->run() == TRUE) {
				//cek user
				$cekuser = $this->db->get_where('nnuser', ['userid' => $iduser]);
				if ($cekuser->num_rows() > 0) {
					$r = $cekuser->row_array();
					$passuser = $r['userpass'];

					$ceklevel = $this->db->get_where('nnlevel', ['levelid' => $r['userlevelid']]);
					$l = $ceklevel->row_array();

					if (password_verify($pass, $passuser)) {
						$session = [
							'masuk' => TRUE,
							'iduser' => $iduser,
							'namauser' => $r['usernama'],
							'foto' => $r['userfoto'],
							'idlevel' => $r['userlevelid'],
							'namalevel' => $l['levelnama'],
							'idtoko' => $r['usertokoid']
						];
						$this->session->set_userdata($session);

						$pesan = [
							'idlevel' => $this->session->userdata('idlevel'),
							'sukses' => 'Login anda berhasil'
						];
					} else {
						$pesan = [
							'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Maaf !</strong> Password anda tidak valid.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>'
						];
					}
				} else {
					$pesan = [
						'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Maaf !</strong> User yang anda input tidak ditemukan.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>'
					];
				}
			} else {
				$pesan = [
					'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					' . validation_errors() . '
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>'
				];
			}
			echo json_encode($pesan);
		} else {
			redirect('login/index', 'refresh');
		}
	}

	function keluar()
	{
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}

	function test()
	{
		// $this->load->view('login/test');
		echo password_hash('admin', PASSWORD_DEFAULT);
	}
}