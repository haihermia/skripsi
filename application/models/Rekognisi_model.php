<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekognisi_model extends CI_Model
{
    public function getAllRekognisi()
    {
        return $this->db->get('rekognisi')->result_array();
    }

    public function tambahRekognisi($data)
    {
        return $this->db->insert('rekognisi', $data);
    }

    public function updateRekognisi($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('rekognisi', $data);
    }


    public function hapusRekognisiById($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rekognisi');
    }

    public function getAllrekognisibyidmahasiswa($id)
    {
        return $this->db->get_where('rekognisi', ['id_mahasiswa' => $id])->result_array();
    }
}
