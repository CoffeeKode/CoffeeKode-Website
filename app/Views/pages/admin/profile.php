<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Mis Datos
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header  white-text default-color">
                    Datos Personales
                </div>

                <div id="profile_messages" class="col-8 mt-2 mx-auto text-center">
                    <?php if (isset($validation)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php elseif (session()->get('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->get('success') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <form id="form-profile" action="/mi-cuenta" method="post">

                        <div class="md-form mb-1">
                            <input value="<?= array_values(session('user'))[0]['user_fullname'] ?>" name="user_fullname" type="text" id="user_fullname" class="form-control">
                            <label for="user_fullname">Nombre</label>
                        </div>

                        <div class="md-form mb-3">
                            <input value="<?= array_values(session('user'))[0]['user_email'] ?>" name="user_email" type="text" id="user_email" class="form-control ">
                            <label for="user_email">Correo Electronico</label>
                        </div>

                        <select name="select_region" id="select_region" class="custom-select" onchange="load_commune()">
                            <option disabled>Selecciona tu region</option>
                            <?php foreach ($regions as $region) : ?>
                                <option <?= (session('user') ? ($region['region_id'] == array_values(session('user'))[0]['user_region'] ? 'selected' : null) : null) ?> value="<?= $region['region_id'] ?>"><?= $region['region_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <hr>
                        <select name="user_commune" id="select_commune" class="custom-select mb-1">
                            <option disabled <?= (!session('user') && !set_value('order_client_commune') ? 'selected' : null) ?>>Selecciona tu comuna</option>
                            <?php foreach ($communes as $commune) : ?>
                                <?php if ($commune['province_region'] == (session('user') ? array_values(session('user'))[0]['user_region'] : null)) : ?>
                                    <option <?= (session('user') ? ($commune['commune_id'] == array_values(session('user'))[0]['user_commune'] ? 'selected' : null) : null) ?> value="<?= $commune['commune_id'] ?>"><?= $commune['commune_name'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                        <div class="md-form mb-1">
                            <input value="<?= array_values(session('user'))[0]['user_address'] ?>" name="user_address" type="text" id="user_address" class="form-control">
                            <label for="user_address">Dirección</label>
                        </div>

                        <div class="md-form mb-4">
                            <input value="<?= array_values(session('user'))[0]['user_phone'] ?>" name="user_phone" type="text" id="user_phone" class="form-control">
                            <label for="user_phone">Teléfono</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <button data-toggle="modal" data-target="#modal_password" type="button" class="btn btn-danger waves-effect px-3">Cambiar Contraseña
                                    <i class="ml-2 fas fa-key"></i></button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button data-toggle="modal" data-target="#modal_save" type="button" class="btn btn-cyan waves-effect px-3">Guardar
                                    <i class="ml-2 far fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moda Confirm Save -->
<div class="modal fade" id="modal_save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h5" id="exampleModalLongTitle">Guardar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class=" text-center">
                    <i class="far fa-save fa-4x animated zoomIn text-info"></i>
                    <p class=" h5 mt-3 ">¿Desea Guardar los cambios?</p>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="$('#form-profile').submit()" class="btn btn-info btn-rounded waves-effect text-white">Guardar</a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moda Change Password -->
<div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h5" id="exampleModalLongTitle">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <div class="md-form mb-1">
                        <input value="<?= array_values(session('user'))[0]['user_email'] ?>" id="current_user_email" style="display: none;">
                        <input type="password" name="user_old_passwrod" id="old_password" class="form-control">
                        <label for="old_password">Contraseña Antigua</label>
                    </div>
                    <div class="md-form mb-1">
                        <input type="password" name="user_new_passwrod" id="new_password" class="form-control">
                        <label for="new_password">Contraseña Nueva</label>
                    </div>
                    <div class="md-form mb-1">
                        <input type="password" name="user_confirm_passwrod" id="confirm_password" class="form-control">
                        <label for="confirm_password">Repetir Contraseña</label>
                    </div>
                    <div id="error_password" style="display: none;" role="alert">
                        <div style="color: #ff3547;" id="errors_messages"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" id="btn_password" class="btn btn-danger btn-rounded waves-effect text-white">Cambiar</a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function load_commune() {
        var region_id = $('#select_region').val();

        $.getJSON('get_commune', function(result) {
            var mySelect = $('#select_commune').empty();
            mySelect.append("<option disabled='disabled' SELECTED>Selecciona tu comuna</option>");
            $.each(result, function(index, value) {
                if (!region_id) {
                    mySelect.append(new Option(value.commune_name, value.commune_id));
                } else if (value.province_region == region_id) {
                    mySelect.append(new Option(value.commune_name, value.commune_id));
                }
            });
        });
    }

    $("#btn_password").click(function(e) {
        e.preventDefault();
        $('#error_password').css('display', 'none');

        var user_email = $('#current_user_email').val();
        var user_password = $('#old_password').val();
        var user_new_password = $('#new_password').val();
        var user_confirm_password = $('#confirm_password').val();

        $.ajax({
            type: "POST",
            url: "change_password",
            data: {
                user_email,
                user_password,
                user_new_password,
                user_confirm_password,
            },
            success: function(o) {
                if (o.success) {
                    $('#modal_password').modal('hide');
                    $('#profile_messages').append("<div class='alert alert-success' role='alert'>Contraseña cambiada</div>");
                    $('#old_password').val('');
                    $('#new_password').val('');
                    $('#confirm_password').val('');
                } else {
                    $('#error_password').css('display', 'inline');
                    $.each(o.validation, function(index, value) {
                        $('#errors_messages').append('<b>' + value + '<b><br>');
                    });
                }
            },
            dataType: "json"
        });
    });
</script>
<?= $this->endSection() ?>