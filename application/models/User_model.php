<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_all_user()
    {
        return $this->db->get('user')->result_array();
    }

    // public function tambahuser($dataUser, $dataMahasiswa)
    // {
    //     $this->db->trans_start(); // Memulai transaksi

    //     // Insert ke tabel user
    //     $this->db->insert('user', $dataUser);
    //     $user_id = $this->db->insert_id(); // Ambil ID user yang baru ditambahkan

    //     // Tambahkan ID user ke data mahasiswa
    //     $dataMahasiswa['id_user'] = $user_id;
    //     $this->db->insert('mahasiswa', $dataMahasiswa); // Insert ke tabel mahasiswa

    //     $this->db->trans_complete(); // Selesaikan transaksi

    //     return true; // Return true jika sukses, false jika gagal
    // }




    // public function get_all_user_mahasiswa()
    // {
    //     $this->db->select('user.*,mahasiswa.*, mahasiswa.id as mahasiswa_id'); // Pilih semua kolom dari user & id mahasiswa
    //     $this->db->from('user');
    //     $this->db->join('mahasiswa', 'mahasiswa.id_user = user.id', 'left'); // Left join agar tetap menampilkan user tanpa mahasiswa
    //     $this->db->where('user.role_id', 2);

    //     return $this->db->get()->result_array();
    // }

    public function get_all_user_admin()
    {
        $this->db->select('user.*,admin.*, admin.id as admin_id'); // Pilih semua kolom dari user & id mahasiswa
        $this->db->from('user');
        $this->db->join('admin', 'admin.id_user = user.id', 'left'); // Left join agar tetap menampilkan user tanpa mahasiswa
        $this->db->where('user.role_id', 1);

        return $this->db->get()->result_array();
    }

    public function get_all_user_fakultas()
    {
        $this->db->select('user.*,fakultas.*, fakultas.id as fakultas_id'); // Pilih semua kolom dari user & id mahasiswa
        $this->db->from('user');
        $this->db->join('fakultas', 'fakultas.id_user = user.id', 'left'); // Left join agar tetap menampilkan user tanpa mahasiswa
        $this->db->where('user.role_id', 3);

        return $this->db->get()->result_array();
    }

    public function get_all_user_prodi()
    {
        $this->db->select('user.*,prodi.*, prodi.id as prodi_id'); // Pilih semua kolom dari user & id mahasiswa
        $this->db->from('user');
        $this->db->join('prodi', 'prodi.id_user = user.id', 'left'); // Left join agar tetap menampilkan user tanpa mahasiswa
        $this->db->where('user.role_id', 4);

        return $this->db->get()->result_array();
    }

    public function get_mahasiswa_by_id($id)
    {
        return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
    }

    public function insert_mahasiswa($data)
    {
        return $this->db->insert('mahasiswa', $data);
    }

    public function insert_admin($data)
    {
        return $this->db->insert('user', $data);
    }

    public function insert_fakultas($data)
    {
        return $this->db->insert('user', $data);
    }

    public function insert_prodi($data)
    {
        return $this->db->insert('user', $data);
    }


    public function update_mahasiswa($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mahasiswa', $data);
    }

    public function updateAdmin($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('admin', $data);
    }

    public function updateFakultas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('fakultas', $data);
    }

    public function updateProdi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('prodi', $data);
    }

    public function hapus_mahasiswa($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('mahasiswa');
    }
}
