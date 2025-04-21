<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rekognisi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rekognisi_model');
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

        $data['mahasiswa'] = $this->db->get_where('mahasiswa', [
            'id_user' => $data['user']['id']
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

        $data['title'] = 'Tambah Data Rekognisi';
        $data['komponen_rekognisi'] = [
            'Pemakalah/Speaker Seminar',
            'Narasumber Seminar',
            'Peserta Seminar',
            'MSIB (Studi Independent)',
            'MSIB (Magang)',
            'PMM (Pertukaran Mahasiswa Merdeka)',
            'Membangun Desa / KKN-T',
            'HKI',
            'Publikasi Jurnal Sinta'
        ];

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Data Rekognisi';

            // Pastikan view form tambah tetap memuat header, sidebar, dan topbar
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('rekognisi/tambah', $data);
            $this->load->view('templates/footer');
        } else {
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

            $data = [
                'nim' => $this->input->post('nim'),
                'nama_rekognisi' => $this->input->post('nama_rekognisi'),
                'bidang_rekognisi' => $this->input->post('bidang_rekognisi'),
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
                'komponen_rekognisi' => $this->input->post('komponen_rekognisi'),
                'penyelenggara' => $this->input->post('penyelenggara'),
                'bukti' => $bukti,
                'id_mahasiswa' => $this->session->userdata('id_user')
            ];

            $this->Rekognisi_model->tambahRekognisi($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil ditambahkan!</div>');
            redirect('rekognisi/getrekognisibyidmahasiswa'); // Redirect ke index agar layout tetap muncul
        }
    }

    public function editRekognisi($id)
    {
        $data['title'] = 'Edit Rekognisi';

        // Ambil data user berdasarkan session email
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // Ambil data rekognisi berdasarkan ID
        $data['rekognisi'] = $this->db->get_where('rekognisi', ['id' => $id])->row_array();

        $data['komponen_rekognisi'] = [
            'Pemakalah/Speaker Seminar',
            'Narasumber Seminar',
            'Peserta Seminar',
            'MSIB (Studi Independent)',
            'MSIB (Magang)',
            'PMM (Pertukaran Mahasiswa Merdeka)',
            'Membangun Desa / KKN-T',
            'HKI',
            'Publikasi Jurnal Sinta'
        ];

        // Validasi form sebelum update
        $this->form_validation->set_rules('nama_rekognisi', 'Nama Rekognisi', 'required');
        $this->form_validation->set_rules('bidang_rekognisi', 'Bidang Rekognisi', 'required');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan halaman edit
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('rekognisi/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi sukses, update data ke database
            $updateData = [
                'nama_rekognisi' => $this->input->post('nama_rekognisi'),
                'bidang_rekognisi' => $this->input->post('bidang_rekognisi'),
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
                'komponen_rekognisi' => $this->input->post('komponen_rekognisi'),
                'penyelenggara' => $this->input->post('penyelenggara')
            ];

            $this->db->where('id', $id);
            $this->db->update('rekognisi', $updateData);

            // Redirect kembali ke halaman rekognisi
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data rekognisi berhasil diubah!</div>');
            redirect('rekognisi');
        }
    }

    public function hapusRekognisi($id)
    {
        $this->Rekognisi_model->hapusRekognisiById($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data rekognisi berhasil dihapus!</div>');
        redirect('rekognisi');
    }


    public function getrekognisibyidmahasiswa()
    {
        $data['title'] = 'Data Rekognisi';
        $id_mahasiswa = $this->session->userdata('id_user');

        // Ambil data user berdasarkan session email
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['mahasiswa'] = $this->db->get_where('mahasiswa', [
            'id_user' => $data['user']['id']
        ])->row_array();

        // Ambil data rekognisi dari model
        $data['rekognisi'] = $this->Rekognisi_model->getAllrekognisibyidmahasiswa($id_mahasiswa);

        //Pastikan semua view dipanggil berurutan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data); // 🔹 Perbaikan ada di sini
        $this->load->view('rekognisi/rekognisibyidmahasiswa', $data);
        $this->load->view('templates/footer');
    }
}
