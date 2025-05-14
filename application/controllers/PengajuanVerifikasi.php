<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanVerifikasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('PengajuanVerifikasi_model');
    }

    public function index()
    {
        $data['title'] = 'Pengajuan Verifikasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pengajuan'] = $this->PengajuanVerifikasi_model->get_all_pengajuan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan_verifikasi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Pengajuan Verifikasi';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan_verifikasi/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function ajukan()
    {
        $id_mahasiswa = $this->session->userdata('id_user');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index();
            echo validation_errors();
        } else {
            $config['upload_path'] = './uploads/bukti/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
            $config['max_size'] = '6000';
            $config['file_name'] = time();

            $this->load->library('upload', $config);

            $bukti = NULL;

            if ($this->upload->do_upload('dokumen')) {
                $bukti_data = $this->upload->data();
                $bukti = $bukti_data['file_name'];
            } else {
                echo $this->upload->display_errors();
                $bukti = '';
            }

            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'jenis_pengajuan' => ($this->input->post('jenis_pengajuan', true)),
                'dokumen' => $bukti,
                'tanggal_pengajuan' => ($this->input->post('tanggal_pengajuan', true)),
                'status' => 'pending',
                'catatan' => null,  // Catatan awal kosong
                'tanggal_verifikasi' => null, // Belum diverifikasi
                'id_mahasiswa' => $id_mahasiswa
            ];

            $this->PengajuanVerifikasi_model->insert_pengajuan($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Pengajuan berhasil dikirim.</div>');
            redirect('pengajuanverifikasi/pengajuanku');
        }
    }

    public function edit($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Edit Pengajuan Verifikasi";
        $data['pengajuan'] = $this->PengajuanVerifikasi_model->get_pengajuan_by_id($id);

        if (empty($data['pengajuan'])) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan_verifikasi/edit', $data);
        $this->load->view('templates/footer');
    }

    public function editfrommahasiswa($id)
    {
        $data['title'] = "Edit Pengajuan Verifikasi";
        $data['pengajuan'] = $this->PengajuanVerifikasi_model->get_pengajuan_by_id($id);

        if (empty($data['pengajuan'])) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan_verifikasi/editfrommahasiswa', $data);
        $this->load->view('templates/footer');
    }

    public function updatefrommahasiswa($id)
    {
        $pengajuan = $this->PengajuanVerifikasi_model->get_pengajuan_by_id($id);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {

            $config['upload_path'] = './uploads/bukti/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
            $config['max_size'] = '6000';
            $config['file_name'] = time();

            $this->load->library('upload', $config);

            $bukti = $pengajuan['dokumen']; // Simpan file lama sebagai default

            if ($this->upload->do_upload('dokumen')) {
                $bukti_data = $this->upload->data();
                $bukti = $bukti_data['file_name'];

                // Hapus file lama jika ada
                if (!empty($pengajuan['dokumen']) && file_exists('./uploads/bukti/' . $pengajuan['dokumen'])) {
                    unlink('./uploads/bukti/' . $pengajuan['dokumen']);
                }
            }

            $data = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'jenis_pengajuan' => $this->input->post('jenis_pengajuan'),
                'tanggal_pengajuan' => $this->input->post('tanggal_pengajuan'),
                'dokumen' => $bukti
            ];


            $this->PengajuanVerifikasi_model->update_pengajuan($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil diperbarui.</div>');
            redirect('pengajuanverifikasi/pengajuanku');
        }
    }


    public function update($id)
    {
        $data = [
            'status' => $this->input->post('status'),
            'catatan' => $this->input->post('catatan'),
            'tanggal_verifikasi' => $this->input->post('tanggal_verifikasi'),
        ];
        // var_dump($data);
        // die();


        $this->PengajuanVerifikasi_model->update_pengajuan($id, $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil diperbarui.</div>');
        redirect('pengajuanverifikasi');
    }

    public function hapus($id)
    {
        if (!$id) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">ID tidak ditemukan!</div>');
            redirect('pengajuanverifikasi');
        }

        if ($this->PengajuanVerifikasi_model->hapus_pengajuan($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus data!</div>');
        }

        redirect('pengajuanverifikasi/pengajuanku');
    }

    public function pengajuanku()
    {
        $data['title'] = 'Pengajuan Verifikasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_mahasiswa = $this->session->userdata('id_user');
        $data['pengajuan'] = $this->PengajuanVerifikasi_model->getAllPengajuanbyidmahasiswa($id_mahasiswa);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan_verifikasi/pengajuanbyidmahasiswa', $data);
        $this->load->view('templates/footer');
    }
}
