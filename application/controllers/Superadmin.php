<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in(); // Pastikan fungsi ini sudah ada di helper
        $this->load->library('form_validation'); // Load form validation
        $this->load->library('upload'); // Pastikan upload library sudah dimuat
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('superadmin/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->session->userdata('email');

            // Cek jika ada gambar yang akan diupload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    // Ambil nama gambar lama
                    $old_image = $data['user']['image'];
                    $file_path = FCPATH . 'assets/img/profile/' . $old_image;

                    // Hapus gambar lama jika bukan default dan file ada
                    if ($old_image != 'default.jpg' && file_exists($file_path)) {
                        clearstatcache(); // Bersihkan cache sebelum menghapus
                        if (!unlink($file_path)) {
                            log_message('error', 'Gagal menghapus gambar lama: ' . $file_path);
                        }
                    }

                    // Simpan nama file baru ke database
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
                        . $this->upload->display_errors() .
                        '</div>');
                    redirect('user/edit');
                    return;
                }
            }

            // Update nama pengguna
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your profile has been updated!
        </div>');
            redirect('user');
        }
    }



    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $this->input->post('new_password1');

            // Hash password baru sebelum disimpan
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $this->db->set('password', $password_hash);
            $this->db->where('email', $this->session->userdata('email'));
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Password changed successfully!
        </div>');
            redirect('user/changepassword');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/changepassword', $data);
        $this->load->view('templates/footer');
    }
}
