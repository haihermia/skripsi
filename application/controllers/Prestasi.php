<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prestasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prestasi_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Data Prestasi';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', [
            'id_user' => $data['user']['id']
        ])->row_array();

        $data['prestasi'] = $this->Prestasi_model->getAllPrestasi();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('prestasi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        // Ambil role user
        $role_id = $this->session->userdata('role_id');
        $redirect_target = ($role_id == 2) ? 'prestasi/getprestasibyidmahasiswa' : 'prestasi/index';

        // Ambil data dari form
        $nim = $this->input->post('nim', true);
        $nama_prestasi = $this->input->post('nama_prestasi', true);
        $bidang_prestasi = $this->input->post('bidang_prestasi', true);
        $nama_kegiatan = $this->input->post('nama_kegiatan', true);
        $tanggal_kegiatan = $this->input->post('tanggal_kegiatan', true);
        $komponen_prestasi = $this->input->post('komponen_prestasi', true);
        $penyelenggara = $this->input->post('penyelenggara', true);

        // Cari id_mahasiswa berdasarkan NIM
        $mahasiswa = $this->db->get_where('mahasiswa', ['nim' => $nim])->row_array();
        if (!$mahasiswa) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Mahasiswa dengan NIM tersebut tidak ditemukan!</div>');
            redirect($redirect_target);
            return;
        }
        $id_mahasiswa = $mahasiswa['id'];

        // Upload bukti
        $config['upload_path'] = './uploads/bukti/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
        $config['max_size'] = 6000;
        $config['file_name'] = time();

        $this->upload->initialize($config);
        $bukti = '';

        if (!empty($_FILES['bukti']['name'])) {
            if ($this->upload->do_upload('bukti')) {
                $upload_data = $this->upload->data();
                $bukti = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
                redirect($redirect_target);
                return;
            }
        }

        // Simpan ke database
        $data = [
            'nim' => $nim,
            'nama_prestasi' => $nama_prestasi,
            'bidang_prestasi' => $bidang_prestasi,
            'nama_kegiatan' => $nama_kegiatan,
            'tanggal_kegiatan' => $tanggal_kegiatan,
            'komponen_prestasi' => $komponen_prestasi,
            'penyelenggara' => $penyelenggara,
            'bukti' => $bukti,
            'id_mahasiswa' => $id_mahasiswa
        ];

        $this->db->insert('prestasi', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data prestasi berhasil ditambahkan!</div>');
        redirect($redirect_target);
    }



    public function editPrestasi($id)
    {
        $data['title'] = 'Edit Prestasi';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['prestasi'] = $this->db->get_where('prestasi', ['id' => $id])->row_array();
        $data['komponen_prestasi'] = ['Juara Umum', 'Juara 1 (Nasional)', 'Juara 2 (Nasional)', 'Juara 3 (Nasional)', 'Juara Harapan 1 (Nasional)', 'Juara Harapan 2 (Nasional)', 'Juara Harapan 3 (Nasional)'];

        $this->form_validation->set_rules('nama_prestasi', 'Nama Prestasi', 'required');
        $this->form_validation->set_rules('bidang_prestasi', 'Bidang Prestasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('prestasi/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // Konfigurasi upload gambar
            $config['upload_path'] = './uploads/bukti/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
            $config['max_size'] = 6000;
            $config['file_name'] = time();

            $this->upload->initialize($config);
            $bukti_lama = $data['prestasi']['bukti'];
            $bukti_baru = $bukti_lama;

            if (!empty($_FILES['bukti']['name'])) {
                if ($this->upload->do_upload('bukti')) {
                    $upload_data = $this->upload->data();
                    $bukti_baru = $upload_data['file_name'];
                    // Hapus file lama jika ada
                    if ($bukti_lama && file_exists('./uploads/bukti/' . $bukti_lama)) {
                        unlink('./uploads/bukti/' . $bukti_lama);
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
                    redirect('prestasi/editPrestasi/' . $id);
                }
            }

            $updateData = [
                'nama_prestasi' => $this->input->post('nama_prestasi'),
                'bidang_prestasi' => $this->input->post('bidang_prestasi'),
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
                'komponen_prestasi' => $this->input->post('komponen_prestasi'),
                'penyelenggara' => $this->input->post('penyelenggara'),
                'bukti' => $bukti_baru
            ];

            $this->db->where('id', $id);
            $this->db->update('prestasi', $updateData);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Data prestasi berhasil diubah!</div>');

            // Redirect sesuai role
            if ($data['user']['role_id'] == 2) {
                redirect('prestasi/getprestasibyidmahasiswa');
            } else {
                redirect('prestasi');
            }
        }
    }

    public function hapusPrestasi($id)
    {
        $this->Prestasi_model->hapusPrestasiById($id);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data prestasi berhasil dihapus!</div>');

        // Cek role dan arahkan sesuai
        $role_id = $this->session->userdata('role_id');
        $redirect_target = ($role_id == 2) ? 'prestasi/getprestasibyidmahasiswa' : 'prestasi/index';

        redirect($redirect_target);
    }


    public function bukti($id)
    {
        $data = $this->Prestasi_model->get_prestasi_by_id($id);
        if ($data && !empty($data['bukti'])) {
            redirect(base_url('uploads/bukti/' . $data['bukti']));
        } else {
            show_404();
        }
    }

    public function getprestasibyidmahasiswa()
    {
        $data['title'] = 'Data Prestasi';

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
        $data['prestasi'] = $this->Prestasi_model->getAllPrestasibyidmahasiswa($id_mahasiswa);

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('prestasi/prestasibyidmahasiswa', $data);
        $this->load->view('templates/footer');
    }
}
