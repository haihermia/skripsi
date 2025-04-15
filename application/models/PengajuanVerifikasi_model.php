<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanVerifikasi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_pengajuan()
    {
        return $this->db->get('pengajuan_verifikasi')->result_array();
    }

    public function get_pengajuan_by_id($id)
    {
        return $this->db->get_where('pengajuan_verifikasi', ['id' => $id])->row_array();
    }

    public function insert_pengajuan($data)
    {
        return $this->db->insert('pengajuan_verifikasi', $data); // Pastikan nama tabel sesuai
    }

    public function update_pengajuan($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('pengajuan_verifikasi', $data);
    }

    public function hapus_pengajuan($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('pengajuan_verifikasi'); // Pastikan nama tabel sesuai
    }

    public function getAllPengajuanbyidmahasiswa($id)
    {
        return $this->db->get_where('pengajuan_verifikasi', ['id_mahasiswa' => $id])->result_array();
    }
}
