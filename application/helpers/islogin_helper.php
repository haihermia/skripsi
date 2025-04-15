<?php
function checkRoles($allowed_roles)
{
    $ci = &get_instance();

    if (!$ci->session->userdata('role_id')) {
        redirect('auth', 'refresh');
    }

    $user_role = $ci->session->userdata('role_id');

    if (!in_array($user_role, $allowed_roles)) {
        $ci->session->set_flashdata('error_403', 'Anda tidak memiliki akses ke halaman ini!');
        redirect('errors/access_denied', 'refresh');
    }
}
