<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user'); ?>">
        <div class="sidebar-brand-icon">
            <i class="bi bi-award-fill"></i>
        </div>
        <div class="sidebar-brand-text">Prestasi Rekognisi</div>
    </a>

    <hr class="sidebar-divider">

    <!-- QUERY MENU -->
    <?php
    $role_id = $this->session->userdata('role_id');
    $queryMenu = "SELECT `user_menu`.`id`, `menu`
                  FROM `user_menu`
                  JOIN `user_access_menu` 
                  ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                  WHERE `user_access_menu`.`role_id` = $role_id
                ORDER BY FIELD(`user_menu`.`id`, 1, 5, 6, 12, 9, 3, 4, 10, 11, 13, 7, 8, 2)";

    $menu = $this->db->query($queryMenu)->result_array();
    ?>

    <!-- LOOPING MENU -->
    <?php foreach ($menu as $m): ?>
        <div class="sidebar-heading">
            <?= $m['menu']; ?>
        </div>

        <!-- SIAPKAN SUB-MENU SESUAI MENU -->
        <?php
        $menuId = $m['id'];
        $querySubMenu = "SELECT *
                         FROM `user_sub_menu` 
                         JOIN `user_menu`
                         ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                         WHERE `user_sub_menu`.`menu_id` = $menuId
                         AND `user_sub_menu`.`is_active` = 1";

        $SubMenu = $this->db->query($querySubMenu)->result_array();
        ?>

        <?php foreach ($SubMenu as $sm): ?>
            <?php if ($title == $sm['title']) : ?>
                <li class="nav-item active">
                <?php else: ?>
                <li class="nav-item">
                <?php endif; ?>

                <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['title'] ?> </span>
                </a>
                </li>
            <?php endforeach; ?>

            <hr class="sidebar-divider mt-4">
        <?php endforeach; ?>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

</ul>
<!-- End of Sidebar -->