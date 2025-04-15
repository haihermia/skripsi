<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prestasi_model extends CI_Model
{
    public function getAllPrestasi()
    {
        return $this->db->get('prestasi')->result_array();
    }

    public function tambahPrestasi($data)
    {
        return $this->db->insert('prestasi', $data);
    }

    public function updatePrestasi($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('prestasi', $data);
    }


    public function hapusPrestasiById($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('prestasi');
    }

    public function getAllPrestasibyidmahasiswa($id)
    {
        return $this->db->get_where('prestasi', ['id_mahasiswa' => $id])->result_array();
    }
}
