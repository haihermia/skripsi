<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function get_all_admin()
    {
        return $this->db->get_where('user', ['role_id' => 1])->result_array();
    }

    public function getAdminById($id)
    {
        $this->db->select('admin.*, user.password, user.role_id');
        $this->db->from('admin');
        $this->db->join('user', 'user.id = admin.id_user');
        $this->db->where('admin.id', $id);
        return $this->db->get()->row_array();
    }

    public function tambahadmin($data)
    {
        return $this->db->insert('user', $data);
    }

    public function editadmin($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('admin', $data);
    }

    public function updateAdmin($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

    public function hapusAdminById($id)
    {
        $this->db->delete('user', ['id' => $id]);
    }
}
