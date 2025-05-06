<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        // $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // $email = $this->input->post('email');
        // $password = $this->input->post('password');
        $passwordmd5 = md5($this->input->post('password'));

        
        if ($user) {
            if ($user['is_active'] == 1) {
                // Verifikasi password
                if ($passwordmd5 == $user['password']) {
                    $data = [
                        'id_user' => $user['id'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        '1' => $user['role_id'] == '1' ? 1 : 0,
                        '2' => $user['role_id'] == '2' ? 1 : 0,
                        '3' => $user['role_id'] == '3' ? 1 : 0,
                        '4' => $user['role_id'] == '4' ? 1 : 0,
                        'superadmin' => $user['role_id'] == '5' ? 1 : 0,
                    ];
                    $this->session->set_userdata($data);

                    // Redirect berdasarkan role_id
                    switch ($user['role_id']) {
                        case 1:
                            redirect('dashboard');
                            break;
                        case 2:
                            redirect('user');
                            break;
                        case 3:
                            redirect('fakultas');
                            break;
                        case 4:
                            redirect('prodi');
                            break;
                        case 5:
                            redirect('superadmin');
                            break;
                        default:
                            redirect('auth');
                            break;
                    }
                } else {
                    // Password salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Maaf, password yang Anda masukkan salah!
                    </div>');
                    redirect('auth');
                }
            } else {
                // Akun belum aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    This email has not been activated!
                </div>');
                redirect('auth');
            }
        } else {
            // Email tidak terdaftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Maaf, email yang Anda masukkan tidak terdaftar!
            </div>');
            redirect('auth');
        }


        // if ($user) {
        //     if ($user['is_active'] == 1) {
        //         $data = [
        //             'id_user' => $user['id'],
        //             'email' => $user['email'],
        //             'role_id' => $user['role_id'],
        //             '1' => $user['role_id'] == '1' ? 1 : 0,
        //             '2' => $user['role_id'] == '2' ? 1 : 0,
        //             '3' => $user['role_id'] == '3' ? 1 : 0,
        //             '4' => $user['role_id'] == '4' ? 1 : 0,
        //             'superadmin' => $user['role_id'] == '5' ? 1 : 0,
        //         ];
        //         $this->session->set_userdata($data);

        //         if ($user['role_id'] == 1) {
        //             redirect('dashboard');
        //         } elseif ($user['role_id'] == 2) {
        //             redirect('user');
        //         } elseif ($user['role_id'] == 3) {
        //             redirect('fakultas');
        //         } elseif ($user['role_id'] == 4) {
        //             redirect('prodi');
        //         } elseif ($user['role_id'] == 5) {
        //             // echo $user['role_id'] == '5' ? 1 : 0;
        //             redirect('superadmin');
        //         } else {
        //             redirect('auth');
        //         }
        //     } else {
        //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        //     This email has not been activated!
        //     </div>');
        //         redirect('auth');
        //     }
        // } else {
        //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        // Maaf username/password yang Anda masukkan salah!
        // </div>');
        //     redirect('auth');
        // }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,

                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your account has been created. Please login.
            </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('user_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been logged out!
        </div>');
        redirect('auth');
    }

    // public function blocked()
    // {
    //     $this->load->view('auth/blocked');
    // }
}
