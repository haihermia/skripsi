<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation'); // Memuat library validasi
        $this->load->model('Mahasiswa_model');  // Memuat model Mahasiswa
    }

    public function index()
    {
        $data['title'] = 'Data Mahasiswa';
        $data['mahasiswa'] = $this->Mahasiswa_model->get_all_mahasiswa();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('templates/footer');
    }

    public function user_mahasiswa()
    {
        $data['title'] = 'Daftar User Mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['mahasiswa'] = $this->Mahasiswa_model->get_all_user_mahasiswa();
        // var_dump($data['user']);
        // die();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mahasiswa/user_mahasiswa', $data);
        $this->load->view('templates/footer');
    }


    public function tambah()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]', [
            'required' => 'Email wajib diisi!',
            'valid_email' => 'Format email tidak valid!',
            'is_unique' => 'Email ini sudah digunakan, silakan gunakan email lain!'
        ]);

        $this->form_validation->set_rules('nim', 'NIM', 'required|is_unique[mahasiswa.nim]', [
            'required' => 'NIM wajib diisi!',
            'is_unique' => 'NIM ini sudah digunakan, silakan gunakan NIM lain!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            // Simpan pesan error dalam session
            $this->session->set_flashdata('message', '<div class="alert alert-danger">' . validation_errors() . '</div>');
            redirect('mahasiswa/user_mahasiswa');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => md5($this->input->post('password1')),
                'role_id' => 2,
                'is_active' => 1,
                'image' => 'default.jpg',
                'date_created' => time()
            ];

            $datamahasiswa = [

                'nim' => htmlspecialchars($this->input->post('nim', true)),
                'nama_mahasiswa' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'program_studi' => htmlspecialchars($this->input->post('program_studi', true)),
                'fakultas' => htmlspecialchars($this->input->post('fakultas', true)),
            ];

            $this->Mahasiswa_model->tambahuser($data, $datamahasiswa);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Mahasiswa berhasil ditambahkan.</div>');
            redirect('mahasiswa/user_mahasiswa');
        }
    }

    public function edit($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Edit Mahasiswa";
        $data['mahasiswa'] = $this->Mahasiswa_model->get_mahasiswa_by_id($id);

        if (!$data['mahasiswa']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mahasiswa/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        // var_dump($id);
        // die();
        $data = $this->Mahasiswa_model->get_mahasiswa_by_id($id);
        $id_user = $data['id_user'];
        // var_dump($id_user);
        // die();

        $this->form_validation->set_rules('nama_mahasiswa', 'Nama Mahasiswa', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('program_studi', 'Program Studi', 'required|trim');
        $this->form_validation->set_rules('fakultas', 'Fakultas', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            $dataMahasiswa = [
                'nama_mahasiswa' => $this->input->post('nama_mahasiswa', true),
                'email' => $this->input->post('email', true),
                'program_studi' => $this->input->post('program_studi', true),
                'fakultas' => $this->input->post('fakultas', true)
            ];

            $dataUser = [
                'name' => $this->input->post('nama_mahasiswa', true),
                'email' => $this->input->post('email', true),

            ];
            // var_dump($dataMahasiswa, $dataUser);
            // die();

            $this->Mahasiswa_model->edit_mahasiswa($id, $id_user, $dataUser, $dataMahasiswa);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data mahasiswa berhasil diperbarui.</div>');
            redirect('mahasiswa/user_mahasiswa');
        }
    }

    public function hapus($id)
    {
        $data = $this->Mahasiswa_model->get_mahasiswa_by_id($id);
        $id_user = $data['id_user'];
        // var_dump($id , $id_user);
        // die();

        if ($this->Mahasiswa_model->hapus_mahasiswa($id, $id_user)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data mahasiswa berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus data.</div>');
        }
        redirect('mahasiswa/user_mahasiswa');
    }
}
