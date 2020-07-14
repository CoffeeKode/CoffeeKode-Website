<?php $uri = service('uri'); ?>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark" id="sidebar-wrapper">
        <!-- heading sidebar-->
        <div class="sidebar-heading amber darken-1 text-center border-right border-warning" style="height: 150px;">
            <img src="assets/img/icon.png" height="100" alt="mdb logo">
            <h3 class="font-ds-bold">Colmenas Polo</h3>
        </div>
        <!-- ./heading sidebar-->

        <!-- Item list sidebar-->
        <div id="tab-list" class="list-group list-group-flush bg-dark">
            <?php if (array_values(session('user'))[0]['user_profile'] == 1) : ?>
                <a href="<?= base_url('mi-cuenta') ?>" class="nav-link <?= ($uri->getSegment(1) == 'mi-cuenta' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-user"></i> Mis datos</a>

                <a href="<?= base_url('administrar-pedidos') ?>" class="nav-link <?= ($uri->getSegment(1) == 'administrar-pedidos' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-dolly"></i></i> Administrar Pedidos</a>

                <a href="<?= base_url('administrar-usuarios') ?>" class="nav-link <?= ($uri->getSegment(1) == 'administrar-usuarios' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-users"></i></i> Administrar Usuarios</a>

                <a href="<?= base_url('administrar-productos') ?>" class="nav-link <?= ($uri->getSegment(1) == 'administrar-productos' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-box-open"></i></i> Administrar Productos</a>

                <a href="<?= base_url('administrar-tiendas') ?>" class="nav-link <?= ($uri->getSegment(1) == 'administrar-tiendas' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-store"></i></i> Administrar Tiendas</a>

                <a href="<?= base_url('administrar-galeria') ?>" class="nav-link <?= ($uri->getSegment(1) == 'administrar-galeria' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-file-alt"></i></i> Administrar Galería</a>

                <a href="<?= base_url('administrar-web') ?>" class="nav-link <?= ($uri->getSegment(1) == 'administrar-web' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-file-alt"></i></i> Administrar Web</a>
            <?php else : ?>
                <a href="<?= base_url('mi-perfil') ?>" class="nav-link <?= ($uri->getSegment(1) == 'mi-perfil' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-user"></i></i> Mis datos</a>

                <a href="<?= base_url('mis-pedidos') ?>" class="nav-link <?= ($uri->getSegment(1) == 'mis-pedidos' ? 'active' : null) ?> list-group-item list-group-item-action bg-dark text-white">
                    <i class="mx-2 fas fa-shopping-bag"></i></i> Mis pedidos</a>
            <?php endif; ?>

            <a data-toggle="modal" data-target="#modal_logout" class="nav-link list-group-item list-group-item-action bg-dark text-white">
                <i class="mx-2 fas fa-sign-out-alt"></i>Cerrar sesión</a>
        </div>
        <!-- ./Item list sidebar-->
    </div>
    <!-- ./Sidebar -->

    <!-- Page Content -->
    <div id="page-content-wrapper" class="bg-blue-grey">
        <div id="navbar" class="tab-content container-fluid px-0">