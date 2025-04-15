<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fakultas_model extends CI_Model
{

    public function get_all_fakultas()
    {
        return $this->db->get_where('user', ['role_id' => 3])->result_array();
    }

    public function getFakultasById($id)
    {
        $this->db->select('fakultas.*, user.password, user.role_id');
        $this->db->from('fakultas');
        $this->db->join('user', 'user.id = fakultas.id_user');
        $this->db->where('fakultas.id', $id);
        return $this->db->get()->row_array();
    }

    public function tambahfakultas($data)
    {
        return $this->db->insert('user', $data);
    }

    public function editfakultas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('fakultas', $data);
    }

    public function updateFakultas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

    public function hapusFakultasById($id)
    {
        $this->db->delete('user', ['id' => $id]);
    }
}
