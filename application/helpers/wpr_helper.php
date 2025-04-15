<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        // Perbaikan di sini
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();

        if ($queryMenu) { // Pastikan menu ditemukan sebelum mengakses id
            $menu_id = $queryMenu['id'];

            $userAccess = $ci->db->get_where('user_access_menu', [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ]);

            if ($userAccess->num_rows() < 1) {
                redirect('auth/blocked');
            }
        } else {
            // Handle jika menu tidak ditemukan (opsional)
            redirect('auth/blocked');
        }
    }
}
