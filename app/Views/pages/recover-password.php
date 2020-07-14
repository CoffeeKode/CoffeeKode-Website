<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas polo
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>

<section class="bg-blue-grey py-5">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 mb-4 d-flex align-items-center">
                <div class="card py-5 px-3">
                    <form action="recuperar-contrasena" method="post" class="card-body">
                        <div class="text-center mb-3">
                            <img height="80px" src="/assets/img/icon.png">
                        </div>
                        <h4 class="card-title text-center">¿No recuerdas tu contraseña?</h4>
                        <p class="card-text text-center">¡No te preocupes! Nos sucede a todos.
                            Ingrese tu Email y te ayudaremos.
                        </p>
                        <div method="post" class="md-form">
                            <i class="fas fa-envelope prefix"></i>
                            <input type="text" id="inputIconEx1" name="recover_email" class="form-control" value="<?= set_value('recover_email') ?>">
                            <label for="inputIconEx1">Correo electrónico</label>
                        </div>
                        <div class="col-md-6 mx-auto">
                            <button type="submit" class="mt-2 btn btn-amber btn-rounded btn-block waves-effect">Enviar</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <?php if (session()->get('success_recover')) : ?>
                            <div class="alert alert-success mb-4" role="alert">
                                <?= session()->get('success_recover') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->get('notfound_recover')) : ?>
                            <div class="alert alert-warning mb-4" role="alert">
                                <?= session()->get('notfound_recover') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($validation)) : ?>
                            <div class="col-12">
                                <div class="alert alert-danger mb-4" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header amber darken-1">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center ">
                        <i class="far fa-paper-plane fa-4x mb-4 animated fadeInLeft text-dark"></i>
                        <p class="text-muted">Su correo electrónico fue enviado exitosamente,
                            porfavor siga las instrucciones indicadas para recuperar su contraseña</p>
                    </div>
                </div>
                <div data-dismiss="modal" class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-amber btn-rounded">Aceptar </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>