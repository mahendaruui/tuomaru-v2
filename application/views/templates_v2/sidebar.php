<?php
$role_id = $this->session->userdata('role_id');
$queryMenu = "SELECT `user_menu`.`id`, `menu`
                FROM `user_menu` JOIN `user_access_menu`
                  ON `user_menu`.`id` = `user_access_menu`.`menu_id`
               WHERE `user_access_menu`.`role_id` = $role_id
            ORDER BY `user_access_menu`.`menu_id` ASC";
$menu = $this->db->query($queryMenu)->result_array();
?>

<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar__inner">
        <a class="admin-brand" href="<?= base_url('admin'); ?>">
            <span class="admin-brand__mark"><i class="fas fa-university"></i></span>
            <span>
                <strong>TUOMARU</strong>
                <small>UUI Admin Console</small>
            </span>
        </a>

        <div class="admin-sidebar__menu">
            <?php foreach ($menu as $m) : ?>
                <section class="admin-nav-group">
                    <p class="admin-nav-group__label"><?= $m['menu']; ?></p>
                    <?php
                    $menuId = $m['id'];
                    $querySubMenu = "SELECT *
                                       FROM `user_sub_menu` JOIN `user_menu`
                                         ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                      WHERE `user_sub_menu`.`menu_id` = $menuId
                                        AND `user_sub_menu`.`is_active` = 1";
                    $subMenu = $this->db->query($querySubMenu)->result_array();
                    ?>
                    <ul class="admin-nav-list">
                        <?php foreach ($subMenu as $sm) : ?>
                            <li>
                                <a class="admin-nav-link <?= ($title == $sm['title']) ? 'is-active' : ''; ?>" href="<?= base_url($sm['url']); ?>">
                                    <i class="<?= $sm['icon']; ?>"></i>
                                    <span><?= $sm['title']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endforeach; ?>
        </div>

        <div class="admin-sidebar__footer">
            <a class="admin-nav-link admin-nav-link--ghost" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</aside>

<div class="admin-backdrop" id="adminBackdrop"></div>

<main class="admin-main">