<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
    public function get_all_mahasiswa()
    {
        return $this->db->get('mahasiswa')->result_array();
    }

    public function get_mahasiswa_by_id($id)
    {
        return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
    }

    public function get_all_user_mahasiswa()
    {
        $this->db->select('user.*,mahasiswa.*, mahasiswa.id as mahasiswa_id'); // Pilih semua kolom dari user & id mahasiswa
        $this->db->from('user');
        $this->db->join('mahasiswa', 'mahasiswa.id_user = user.id', 'left'); // Left join agar tetap menampilkan user tanpa mahasiswa
        $this->db->where('user.role_id', 2);

        return $this->db->get()->result_array();
    }

    public function tambahuser($dataUser, $dataMahasiswa)
    {
        $this->db->trans_start(); // Memulai transaksi

        // Insert ke tabel user
        $this->db->insert('user', $dataUser);
        $user_id = $this->db->insert_id(); // Ambil ID user yang baru ditambahkan

        // Tambahkan ID user ke data mahasiswa
        $dataMahasiswa['id_user'] = $user_id;
        $this->db->insert('mahasiswa', $dataMahasiswa); // Insert ke tabel mahasiswa

        $this->db->trans_complete(); // Selesaikan transaksi

        return true; // Return true jika sukses, false jika gagal
    }

    public function insert_mahasiswa($data)
    {
        return $this->db->insert('mahasiswa', $data);
    }

    public function update_mahasiswa($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mahasiswa', $data);
    }

    public function edit_mahasiswa($id, $id_user, $dataUser, $dataMahasiswa)
    {
        $this->db->trans_start(); // Memulai transaksi

        // Update data di tabel user berdasarkan ID user
        $this->db->where('id', $id_user);
        $this->db->update('user', $dataUser);

        // Update data di tabel mahasiswa berdasarkan ID user
        $this->db->where('id', $id);
        $this->db->update('mahasiswa', $dataMahasiswa);

        $this->db->trans_complete(); // Selesaikan transaksi

        return $this->db->trans_status(); // Return true jika sukses, false jika gagal
    }


    public function hapus_mahasiswa($id, $id_user)
    {
        $this->db->trans_start();
        // Hapus dari tabel user setelah mahasiswa dihapus
        $this->db->where('id', $id_user);
        $this->db->delete('user');
        
        // Hapus dari tabel mahasiswa dulu
        $this->db->where('id', $id);
        $this->db->delete('mahasiswa');
    
        $this->db->trans_complete(); // Selesaikan transaksi
    
        return $this->db->trans_status();
    }
}    
