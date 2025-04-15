<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prodi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prodi_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        // is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Data Prodi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['prodi'] = $this->Prodi_model->get_all_prodi();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('prodi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]', [
            'required' => 'Email wajib diisi!',
            'valid_email' => 'Format email tidak valid!',
            'is_unique' => 'Email ini sudah digunakan, silakan gunakan email lain!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            // Simpan pesan error dalam session
            $this->session->set_flashdata('message', '<div class="alert alert-danger">' . validation_errors() . '</div>');
            redirect('prodi');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password1')),
                'role_id' => 4, // Role Prodi
                'is_active' => 1,
                'image' => 'default.jpg'
            ];
            // var_dump($data);
            // die();
            $this->Prodi_model->tambahprodi($data);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Prodi berhasil ditambahkan!</div>');
            redirect('prodi');
        }
    }


    public function editProdi($id)
    {
        $data['title'] = 'Edit Prodi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['prodi'] = $this->db->get_where('user', ['id' => $id])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('prodi/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $updateData = [
                'name' => $this->input->post('nama'),
                'email' => $this->input->post('email')
            ];

            $this->db->where('id', $id);
            $this->db->update('user', $updateData);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Prodi berhasil diubah!</div>');
            redirect('prodi');
        }
    }

    public function updateProdi($id)
    {
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            $data = [
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
            ];
            // var_dump($data);
            // die();
            $this->Prodi_model->updateProdi($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Prodi berhasil diperbarui.</div>');
            redirect('prodi');
        }
    }

    public function hapusProdi($id)
    {
        $this->Prodi_model->hapusProdiById($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Prodi berhasil dihapus!</div>');
        redirect('prodi');
    }
}
