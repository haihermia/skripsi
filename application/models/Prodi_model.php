<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prodi_model extends CI_Model
{

    public function get_all_prodi()
    {
        return $this->db->get_where('user', ['role_id' => 4])->result_array();
    }

    public function getProdiById($id)
    {
        $this->db->select('prodi.*, user.password, user.role_id');
        $this->db->from('prodi');
        $this->db->join('user', 'user.id = prodi.id_user');
        $this->db->where('prodi.id', $id);
        return $this->db->get()->row_array();
    }

    public function tambahprodi($data)
    {
        return $this->db->insert('user', $data);
    }

    public function editprodi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('prodi', $data);
    }

    public function updateProdi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

    public function hapusProdiById($id)
    {
        $this->db->delete('user', ['id' => $id]);
    }
}
