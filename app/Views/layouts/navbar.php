<?php $uri = service('uri'); ?>

<nav id="navbar" class="navbar <?= ($sidebar?'z-depth-0' : null) ?> navbar-expand-lg navbar-dark amber darken-1 scrolling-navbar px-5">
    <?php if ($sidebar) : ?>
        <button id="menu-toggle" class="btn btn-amber px-3 py-2 ml-1"><i class="fas fa-chevron-right"></i></button>
    <?php else : ?>
        <a class="navbar-brand font-ds-bold" href="<?= base_url() ?>">
            <img src="/assets/img/icon.png" height="30" class="d-inline-block align-top" alt="mdb logo"> Colmenas Polo
        </a>
    <?php endif; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
                <a data-scroll class="nav-link" href="<?= base_url() ?>">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a data-scroll class="nav-link" href="<?= base_url('#products'); ?>">Productos</a>
            </li>
            <li class="nav-item">
                <a data-scroll class="nav-link" href="<?= base_url('#services'); ?>">Servicios</a>
            </li>
            <li class="nav-item">
                <a data-scroll class="nav-link" href="<?= base_url('#about-us'); ?>">Sobre nosotros</a>
            </li>
            <li class="nav-item">
                <a data-scroll class="nav-link" href="<?= base_url('#team'); ?>">Equipo</a>
            </li>
            <li class="nav-item">
                <a data-scroll class="nav-link" href="<?= base_url('#contact'); ?>">Contacto</a>
            </li>

            <div class="nav-item dropdown">
                <?php if (session()->get('user')) : ?>
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= ucwords(mb_strtolower(array_values(session('user'))[0]['user_fullname'])); ?></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= base_url(array_values(session('user'))[0]['user_profile'] == 1 ? 'mi-cuenta' : 'mi-perfil') ?>">Mi Cuenta</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_logout">Cerrar Sesión</a>
                    </div>
                <?php else : ?>
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Iniciar Sesión</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <form class="px-4 py-3" action="/ingresar" method="post">
                            <input type="text" name="login_from" value="navbar" style="display: none;">
                            <div class="form-group">
                                <label for="user_email">Correo electrónico</label>
                                <input type="email" class="form-control" name="user_email" id="user_email" placeholder="correo@ejemplo.cl">
                            </div>
                            <div class="form-group">
                                <label for="user_password">Contraseña</label>
                                <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Contraseña">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="dropdownCheck">
                                <label class="form-check-label" for="dropdownCheck">
                                    Recuerdame
                                </label>
                            </div>
                            <button type="submit" class="btn btn-amber btn-rounded waves-effect">Iniciar Sesión</button>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="px-4 dropdown-item" href="<?= base_url('registro-usuario') ?>">¿Nuevo por aquí? Registrate</a>
                        <!-- Proximamente-->
                        <a class="px-4 dropdown-item" href="/recuperar-contrasena">¿Olvidate tu contraseña?</a>
                    </div>
                <?php endif; ?>
            </div>
        </ul>

        <ul class="ml-lg-3 navbar-nav nav-flex-icons">
            <li class="nav-item">
                <a href="<?= base_url('comprar') ?>" class="text-white"><i class="fas fa-shopping-bag fa-lg"></i>
                    <strong id="carrito_value">
                        <?php
                        if (session('cart')) {
                            $items = array_values(session('cart'));
                            $total = 0;
                            foreach ($items as $item) {
                                $total += $item['item_quantity'];
                            }
                            echo $total;
                        }
                        ?>
                    </strong>
                </a>
            </li>
        </ul>
    </div>
</nav>