<?php $uri = service('uri'); ?>
<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Validar Usuario
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>
<?= $this->section('page_content') ?>
<section class="container py-5 mt-4">
    <?php if (!session('user')) : ?>
        <h1 class=" text-center h1-responsive font-weight-bold mb-4">Ingresa a la Colmena</h1>

        <div class="row d-flex justify-content-center">
            <!-- login -->
            <div class="col-md-5 card <?= (!$uri->getSegment(1) == 'confirmar-cliente' ? 'mx-auto' : null) ?> bg-login px-0 ">
                <div class="mask rgba-blue-grey-strong mx-0 h-100 w-100">
                    <form class="text-center px-5 my-5" action="/<?= ($uri->getSegment(1) == 'confirmar-cliente' ? 'confirmar-cliente' : 'ingresar') ?>" method="post">
                        <p class="h4 mb-4 text-white">Inicia Sesión</p>
                        <input type="hidden" name="from" value="login">
                        <!-- Email -->
                        <div>
                            <label class="sr-only" for="user_email">Correo Electrónico</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-warning"><i class="fas fa-envelope text-white"></i></div>
                                </div>
                                <input type="email" class="form-control" id="user_email" name="user_email" required placeholder="Correo Electrónico" value="<?= set_value('user_email'); ?>">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="sr-only" for="user_password">Contraseña</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-warning"><i class="fa fa-lock text-white"></i></div>
                                </div>
                                <input type="password" class="form-control" id="user_password" name="user_password" required placeholder="Contraseña">
                            </div>
                        </div>

                        <div class="d-flex justify-content-around">
                            <!-- Remember me -->
                            <!-- <div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                                <label class="custom-control-label text-white" for="defaultLoginFormRemember">Recuérdame</label>
                            </div>
                        </div> -->
                            <div>
                                <!-- Forgot password -->
                                <a href="<?= base_url('recuperar-contrasena') ?>" class="amber-text">¿Olviste tu contraseña?</a>
                            </div>
                        </div>

                        <!-- Sign in button -->
                        <button class="mt-4 btn btn-md btn-block btn-outline-white waves-effect" type="submit">Ingresar</button>
                        <?php if (isset($validation_user)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $validation_user->listErrors() ?>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <!-- login -->

            <?php if ($uri->getSegment(1) == 'confirmar-cliente') : ?>
                <!--Login Guest-->
                <div class="col-md-5 card  ">
                    <form class="text-center pt-5 p-4" action="/confirmar-cliente" method="post">
                        <p class="h4 mb-4">Continua como invitado</p>
                        <input type="hidden" name="from" value="invited">
                        <!-- Rut -->
                        <input type="text" id="rut" name="invited_rut" class="form-control mb-4" maxlength="10" required placeholder="Rut" oninput="checkRut(this)" value="<?= set_value('invited_rut'); ?>">
                        <!-- Name -->
                        <input type="text" name="invited_name" class="form-control mb-4" maxlength="100" required placeholder="Nombre" value="<?= set_value('invited_name'); ?>">
                        <!-- E-mail -->
                        <input type="email" name="invited_email" class="form-control mb-4" maxlength="255" required placeholder="Correo Electrónico" value="<?= set_value('invited_email'); ?>">
                        <!-- Phone number -->
                        <input type="tel" name="invited_phone" class="form-control" minlength="9" maxlength="9" required placeholder="Numero telefonico" value="<?= set_value('invited_phone'); ?>">
                        <!-- Sign up button -->
                        <button class="mt-3 btn btn-block btn-amber btn-rounded waves-effect" type="submit">Continuar</button>
                        <hr>
                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <!--./Login Guest-->
            <?php endif; ?>

        </div>

    <?php else : ?>
        <div class="container py-0 my-auto hv-100">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <h2 class="h2-responsive font-ds-bold text-center">Lo sentimos, pero actualmente no tienes acceso a esta orden de compra</h2>
                    <h3 class="h3-responsive font-ds-bold mt-3 text-center">Si esto es incorrecto favor contactanos</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/assets/vendor/jquery.rut/jquery.rut.js"></script>

<script>
    $(document).ready(function() {
        $("input#rut").rut({
            formatOn: 'keyup',
            minimumLength: 8,
            validateOn: 'change keyup',
            useThousandsSeparator: false
        });
    });

    function checkRut(rut) {
        var valor = rut.value.replace('.', '');
        valor = valor.replace('-', '');

        if ($.validateRut(valor)) {
            rut.setCustomValidity("");
        } else {
            rut.setCustomValidity("RUT Invalido");
        }
        return false;
    }
</script>
<?= $this->endSection() ?>