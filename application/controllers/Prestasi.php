<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Prestasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prestasi_model');
        $this->load->library('form_validation'); // 🔹 Load form validationt
        $this->load->helper('url'); // 🔹 Tambahkan jika perlu
        // is_logged_in();
    }
    public function index()
    {
        $data['title'] = 'Data Prestasi';

        // Ambil data user berdasarkan session email
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // Ambil data prestasi dari model
        $data['prestasi'] = $this->Prestasi_model->getAllPrestasi();

        //Pastikan semua view dipanggil berurutan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('prestasi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nim', 'NIM', 'required');
        $this->form_validation->set_rules('nama_prestasi', 'Nama Prestasi', 'required');

        //konfigurasi upload gambar
        $config['upload_path'] = './uploads/bukti/';
        $config['allowed_types'] = 'jpg|jpeg|png|wepb|JPG|PNG|JPEG|WEPB';
        $config['max_size'] = '6000';
        $config['file_name'] = time();

        $this->load->library('upload', $config);

        $bukti = NULL;

        if ($this->upload->do_upload('bukti')) {
            $bukti_data = $this->upload->data();
            $bukti = $bukti_data['file_name'];
        } else {
            echo $this->upload->display_errors();
            $bukti = '';
        }

        if (!$this->upload->do_upload('bukti')) {
            echo "<pre>";
            print_r($this->upload->display_errors());
            echo "</pre>";
            exit; // Hentikan eksekusi untuk melihat error
        }

        $data['title'] = 'Tambah Data Prestasi';
        $data['komponen_prestasi'] = [
            'Juara Umum',
            'Juara 1 (Nasional)',
            'Juara 2 (Nasional)',
            'Juara 3 (Nasional)',
            'Juara Harapan 1 (Nasional)',
            'Juara Harapan 2 (Nasional)',
            'Juara Harapan 3 (Nasional)'
        ];

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Data Prestasi';

            // Pastikan view form tambah tetap memuat header, sidebar, dan topbar
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('prestasi/tambah', $data);
            $this->load->view('templates/footer');
        } else {


            $data = [
                'nim' => $this->input->post('nim'),
                'nama_prestasi' => $this->input->post('nama_prestasi'),
                'bidang_prestasi' => $this->input->post('bidang_prestasi'),
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
                'komponen_prestasi' => $this->input->post('komponen_prestasi'),
                'penyelenggara' => $this->input->post('penyelenggara'),
                'bukti' => $bukti,
                'id_mahasiswa' => $this->session->userdata('id_user')
            ];

            $this->Prestasi_model->tambahPrestasi($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil ditambahkan!</div>');
            redirect('prestasi/getprestasibyidmahasiswa'); // Redirect ke index agar layout tetap muncul
        }
    }

    public function editPrestasi($id)
    {
        $data['title'] = 'Edit Prestasi';

        // Ambil data user berdasarkan session email
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // Ambil data prestasi berdasarkan ID
        $data['prestasi'] = $this->db->get_where('prestasi', ['id' => $id])->row_array();

        $data['komponen_prestasi'] = [
            'Juara Umum',
            'Juara 1 (Nasional)',
            'Juara 2 (Nasional)',
            'Juara 3 (Nasional)',
            'Juara Harapan 1 (Nasional)',
            'Juara Harapan 2 (Nasional)',
            'Juara Harapan 3 (Nasional)'
        ];

        // Validasi form sebelum update
        $this->form_validation->set_rules('nama_prestasi', 'Nama Prestasi', 'required');
        $this->form_validation->set_rules('bidang_prestasi', 'Bidang Prestasi', 'required');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan halaman edit
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('prestasi/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi sukses, update data ke database
            $updateData = [
                'nama_prestasi' => $this->input->post('nama_prestasi'),
                'bidang_prestasi' => $this->input->post('bidang_prestasi'),
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
                'komponen_prestasi' => $this->input->post('komponen_prestasi'),
                'penyelenggara' => $this->input->post('penyelenggara')
            ];

            $this->db->where('id', $id);
            $this->db->update('prestasi', $updateData);

            // Redirect kembali ke halaman prestasi
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data prestasi berhasil diubah!</div>');
            redirect('prestasi');
        }
    }

    public function hapusPrestasi($id)
    {
        $this->Prestasi_model->hapusPrestasiById($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data prestasi berhasil dihapus!</div>');
        redirect('prestasi');
    }


    public function bukti($id)
    {
        $this->load->model('Prestasi_model');
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
        $id_mahasiswa = $this->session->userdata('id_user');


        // Ambil data user berdasarkan session email
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['mahasiswa'] = $this->db->get_where('mahasiswa', [
            'id_user' => $data['user']['id']
        ])->row_array();
        // var_dump($data['mahasiswa']);
        // die();

        // Ambil data prestasi dari model
        $data['prestasi'] = $this->Prestasi_model->getAllPrestasibyidmahasiswa($id_mahasiswa);

        //Pastikan semua view dipanggil berurutan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data); // 🔹 Perbaikan ada di sini
        $this->load->view('prestasi/prestasibyidmahasiswa', $data);
        $this->load->view('templates/footer');
    }
}
