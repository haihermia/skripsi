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
        $this->db->where('id_mahasiswa', $id);
        $this->db->where('jenis', 'prestasi');
        return $this->db->get('prestasi')->result_array();
    }

    public function getAllRekognisibyidmahasiswa($id)
    {
        $this->db->where('id_mahasiswa', $id);
        $this->db->where('jenis', 'rekognisi');
        return $this->db->get('prestasi')->result_array();
    }

    public function getAllPengajuanbyidmahasiswa($id)
    {
        $this->db->where('id_mahasiswa', $id);
        return $this->db->get('prestasi')->result_array();
    }
}
