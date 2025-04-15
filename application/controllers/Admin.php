<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        // is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Data Admin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['admin'] = $this->Admin_model->get_all_admin();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
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
        // var_dump($this->input->post('password1'), $this->input->post('password2'));
        // die();
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            // Simpan pesan error dalam session
            $this->session->set_flashdata('message', '<div class="alert alert-danger">' . validation_errors() . '</div>');
            redirect('admin');
            //    var_dump(validation_errors() );
            //    die();
            // $this->index();
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password1')),
                'role_id' => 1, // Role Admin
                'is_active' => 1,
                'image' => 'default.jpg'
            ];
            // var_dump($data);
            // die();
            $this->Admin_model->tambahadmin($data);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Admin berhasil ditambahkan!</div>');
            redirect('admin');
        }

        // Insert ke tabel user
        // $userData = [
        //     'name' => $this->input->post('name'),
        //     'email' => $this->input->post('email'),
        //     'password' => md5($this->input->post('password2')),
        //     'role_id' => 1, // Role Admin
        //     'is_active' => 1
        // ];

        // Insert ke tabel admin
        // $adminData = [
        //     'name' => $this->input->post('name'),
        //     'email' => $this->input->post('email'),
        //     'is_active' => 1
        // ];
        // var_dump($userData, $adminData);
        // die();
        // $this->Admin_model->tambahadmin($userData);

        // $this->session->set_flashdata('message', '<div class="alert alert-success">Admin berhasil ditambahkan!</div>');
        // redirect('admin');
        // if ($this->form_validation->run() == FALSE) {
        //     $data['title'] = 'Tambah Admin';
        //     $this->load->view('templates/header', $data);
        //     $this->load->view('templates/sidebar', $data);
        //     $this->load->view('templates/topbar', $data);
        //     $this->load->view('admin/tambah', $data);
        //     $this->load->view('templates/footer');
        // } else {
        //     // Insert ke tabel user
        //     $userData = [
        //         'name' => $this->input->post('nama'),
        //         'email' => $this->input->post('email'),
        //         'password' => md5($this->input->post('password1')),
        //         'role_id' => 1, // Role Admin
        //         'is_active' => 1
        //     ];

        //     // Insert ke tabel admin
        //     $adminData = [
        //         'name' => $this->input->post('nama'),
        //         'email' => $this->input->post('email'),
        //         'is_active' => 1
        //     ];
        //     $this->Admin_model->tambahadmin($userData, $adminData);

        //     $this->session->set_flashdata('message', '<div class="alert alert-success">Admin berhasil ditambahkan!</div>');
        //     redirect('admin');
        // }
    }


    public function editAdmin($id)
    {
        $data['title'] = 'Edit Admin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['admin'] = $this->db->get_where('user', ['id' => $id])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $updateData = [
                'name' => $this->input->post('nama'),
                'email' => $this->input->post('email')
            ];

            $this->db->where('id', $id);
            $this->db->update('user', $updateData);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Data admin berhasil diubah!</div>');
            redirect('admin');
        }
    }

    public function updateAdmin($id)
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
            $this->Admin_model->updateAdmin($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data mahasiswa berhasil diperbarui.</div>');
            redirect('admin');
        }
    }

    public function hapusAdmin($id)
    {
        $this->Admin_model->hapusAdminById($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Admin berhasil dihapus!</div>');
        redirect('admin');
    }
}
