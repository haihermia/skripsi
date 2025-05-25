<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rekognisi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Rekognisi_model');
		$this->load->model('Prestasi_model');
		$this->load->library('form_validation'); // 🔹 Load form validationt
		$this->load->helper('url'); // 🔹 Tambahkan jika perlu
		// is_logged_in();
	}
	public function index()
	{
		$data['title'] = 'Data Rekognisi';

		// Ambil data user berdasarkan session email
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil data rekognisi dari model
		$data['rekognisi'] = $this->Rekognisi_model->getAllRekognisi();

		//Pastikan semua view dipanggil berurutan
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data); // 🔹 Perbaikan ada di sini
		$this->load->view('rekognisi/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nim', 'NIM', 'required');
		$this->form_validation->set_rules('nama_rekognisi', 'Nama Rekognisi', 'required');

		// Ambil role user
		$role_id = $this->session->userdata('role_id');
		$redirect_target = ($role_id == 2) ? 'rekognisi/getrekognisibyidmahasiswa' : 'rekognisi/index';

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menambahkan data. Periksa isian Anda.</div>');
			redirect($redirect_target);
			return;
		}

		// Konfigurasi upload file
		$config['upload_path'] = './uploads/bukti/';
		$config['allowed_types'] = 'jpg|jpeg|png|webp';
		$config['max_size'] = 6000;
		$config['file_name'] = time();

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		$bukti = '';

		if (!empty($_FILES['bukti']['name'])) {
			if ($this->upload->do_upload('bukti')) {
				$bukti_data = $this->upload->data();
				$bukti = $bukti_data['file_name'];
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
				redirect($redirect_target);
				return;
			}
		}

		// $data = [
		// 	'nim' => $this->input->post('nim'),
		// 	'nama_rekognisi' => $this->input->post('nama_rekognisi'),
		// 	'bidang_rekognisi' => $this->input->post('bidang_rekognisi'),
		// 	'nama_kegiatan' => $this->input->post('nama_kegiatan'),
		// 	'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
		// 	'komponen_rekognisi' => $this->input->post('komponen_rekognisi'),
		// 	'penyelenggara' => $this->input->post('penyelenggara'),
		// 	'bukti' => $bukti,
		// 	'jenis' => 'rekognisi',
		// 	'id_mahasiswa' => $this->session->userdata('id_user')
		// ];
		$nim = $this->input->post('nim', true);

		$mahasiswa = $this->db->get_where('mahasiswa', ['nim' => $nim])->row_array();
		if (!$mahasiswa) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Mahasiswa dengan NIM tersebut tidak ditemukan!</div>');
			redirect($redirect_target);
			return;
		}
		$id_mahasiswa = $mahasiswa['id'];

		$data = [
			'nim' => $this->input->post('nim'),
			'nama_prestasi' => $this->input->post('nama_rekognisi'),
			'bidang_prestasi' => $this->input->post('bidang_rekognisi'),
			'nama_kegiatan' => $this->input->post('nama_kegiatan'),
			'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
			'komponen_prestasi' => $this->input->post('komponen_rekognisi'),
			'penyelenggara' => $this->input->post('penyelenggara'),
			'bukti' => $bukti,
			'jenis' => 'rekognisi',
			'tanggal' => date('Y-m-d'),
			'id_mahasiswa' => $id_mahasiswa
		];

		// $this->Rekognisi_model->tambahRekognisi($data);
		$this->db->insert('prestasi', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil ditambahkan!</div>');
		redirect($redirect_target);
	}


	public function editRekognisi($id)
	{
		$data['title'] = 'Edit Rekognisi';

		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// $data['rekognisi'] = $this->db->get_where('rekognisi', ['id' => $id])->row_array();
		$data['rekognisi'] = $this->db->get_where('prestasi', ['id' => $id])->row_array();

		$data['komponen_rekognisi'] = [/* ... array komponen seperti sebelumnya ... */];

		$this->form_validation->set_rules('nama_rekognisi', 'Nama Rekognisi', 'required');
		$this->form_validation->set_rules('bidang_rekognisi', 'Bidang Rekognisi', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('rekognisi/edit', $data);
			$this->load->view('templates/footer');
		} else {
			// 🔽 Konfigurasi upload file
			$config['upload_path'] = './uploads/bukti/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp';
			$config['max_size'] = '6000';
			$config['file_name'] = time();

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			$bukti = $data['rekognisi']['bukti']; // default tetap yang lama

			if (!empty($_FILES['bukti']['name'])) {
				if ($this->upload->do_upload('bukti')) {
					$upload_data = $this->upload->data();
					$bukti = $upload_data['file_name'];
				} else {
					echo "<pre>";
					print_r($this->upload->display_errors());
					echo "</pre>";
					exit;
				}
			}

			$updateData = [
				'nama_prestasi' => $this->input->post('nama_rekognisi'),
				'bidang_prestasi' => $this->input->post('bidang_rekognisi'),
				'nama_kegiatan' => $this->input->post('nama_kegiatan'),
				'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
				'komponen_prestasi' => $this->input->post('komponen_rekognisi'),
				'penyelenggara' => $this->input->post('penyelenggara'),
				'bukti' => $bukti
			];

			$this->db->where('id', $id);
			$this->db->update('prestasi', $updateData);

			$this->session->set_flashdata('message', '<div class="alert alert-success">Data rekognisi berhasil diubah!</div>');

			// 🔁 Redirect berdasarkan role
			$role_id = $this->session->userdata('role_id');
			$redirect_target = ($role_id == 2) ? 'rekognisi/getrekognisibyidmahasiswa' : 'rekognisi/index';
			redirect($redirect_target);
		}
	}



	public function hapusRekognisi($id)
	{
		$this->Rekognisi_model->hapusRekognisiById($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data rekognisi berhasil dihapus!</div>');

		// 🔁 Redirect berdasarkan role
		$role_id = $this->session->userdata('role_id');
		$redirect_target = ($role_id == 2) ? 'rekognisi/getrekognisibyidmahasiswa' : 'rekognisi/index';
		redirect($redirect_target);
	}



	public function getrekognisibyidmahasiswa()
	{
		$data['title'] = 'Data Rekognisi';
		// Ambil data user yang login
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil data mahasiswa berdasarkan id_user
		$data['mahasiswa'] = $this->db->get_where('mahasiswa', [
			'id_user' => $data['user']['id']
		])->row_array();

		// Ambil ID mahasiswa dari tabel mahasiswa
		$id_mahasiswa = $data['mahasiswa']['id'];

		// Ambil semua prestasi berdasarkan id_mahasiswa
		// $data['prestasi'] = $this->Prestasi_model->getAllPrestasibyidmahasiswa($id_mahasiswa);

		// $id_mahasiswa = $this->session->userdata('id_user');

		// // Ambil data user berdasarkan session email
		// $data['user'] = $this->db->get_where('user', [
		// 	'email' => $this->session->userdata('email')
		// ])->row_array();

		// $data['mahasiswa'] = $this->db->get_where('mahasiswa', [
		// 	'id_user' => $data['user']['id']
		// ])->row_array();

		// Ambil data rekognisi dari model
		// $data['rekognisi'] = $this->Rekognisi_model->getAllrekognisibyidmahasiswa($id_mahasiswa);
		$data['rekognisi'] = $this->Prestasi_model->getAllRekognisibyidmahasiswa($id_mahasiswa);

		//Pastikan semua view dipanggil berurutan
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data); // 🔹 Perbaikan ada di sini
		$this->load->view('rekognisi/rekognisibyidmahasiswa', $data);
		$this->load->view('templates/footer');
	}
}
