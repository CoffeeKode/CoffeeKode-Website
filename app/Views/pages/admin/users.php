<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Administrar Usuarios
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header  white-text default-color">
                    Administración de Usuarios
                </div>

                <div id="messages" class="col-8 mt-2 mx-auto text-center">
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
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  <?= (!session()->get('add_admin') && !session()->get('update_admin') ? 'active' : null) ?>" id="tabOrdersCompleted" data-toggle="pill" href="#pillsOrdersCompleted" role="tab" aria-controls="pillsOrdersCompleted" aria-selected="true">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?= (session()->get('update_admin') ? 'active' : null) ?>" id="tabOrdersPending" data-toggle="pill" href="#pillsOrdersPending" role="tab" aria-controls="pillsOrdersPending" aria-selected="false">Administradores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('add_admin') ? 'active' : null) ?>" id="tabAddAdmin" data-toggle="pill" href="#pillsAddAdmin" role="tab" aria-controls="pillsAddAdmin" aria-selected="false">Agregar Administrador</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabContentPills">
                        <div class="tab-pane fade <?= (!session()->get('add_admin') && !session()->get('update_admin') ? 'show active' : null) ?>" id="pillsOrdersCompleted" role="tabpanel" aria-labelledby="tabOrdersCompleted">
                            <div class="table-responsive">


                                <table id="table_1" class="display table">
                                    <thead>
                                        <tr>
                                            <th>Rut</th>
                                            <th>Nombres</th>
                                            <th>Correo</th>
                                            <th>N° telefónico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) : ?>
                                            <?php if ($user['user_profile'] == 2) : ?>
                                                <tr>
                                                    <th scope="row"><?= $user['user_rut'] ?></th>
                                                    <td><?= $user['user_fullname'] ?></td>
                                                    <td><?= $user['user_email'] ?></td>
                                                    <td><?= $user['user_phone'] ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Rut</th>
                                            <th>Nombres</th>
                                            <th>Correo</th>
                                            <th>N° telefónico</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('update_admin') ? 'show active' : null) ?>" id="pillsOrdersPending" role="tabpanel" aria-labelledby="tabOrdersPending">
                            <div class="table-responsive text-nowrap">
                                <table id="table_2" class="display table-hover">
                                    <thead>
                                        <tr>
                                            <th>Rut</th>
                                            <th>Nombres</th>
                                            <th>Correo</th>
                                            <th>N° telefónico</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) : ?>
                                            <?php if ($user['user_profile'] != 2 && $user['user_id'] != 1) : ?>
                                                <tr>
                                                    <th scope="row"><?= $user['user_rut'] ?></th>
                                                    <td><?= $user['user_fullname'] ?></td>
                                                    <td><?= $user['user_email'] ?></td>
                                                    <td><?= $user['user_phone'] ?></td>
                                                    <td><?= ($user['user_profile'] == 1 ? 'Activo' : 'Inactivo') ?></td>
                                                    <td>
                                                        <button onclick="load_admin('<?= $user['user_id'] ?>', '<?= $user['user_rut'] ?>', '<?= $user['user_fullname'] ?>', '<?= $user['user_email'] ?>', '<?= $user['user_phone'] ?>', '<?= $user['user_address'] ?>', '<?= $user['user_commune'] ?>', '<?= $user['user_profile'] ?>')" data-toggle="modal" data-target="#modal_edit" type="button" class="btn btn-primary py-2 px-3"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Rut</th>
                                            <th>Nombres</th>
                                            <th>Correo</th>
                                            <th>N° telefónico</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('add_admin') ? 'show active' : null) ?>" id="pillsAddAdmin" role="tabpanel" aria-labelledby="tabAddAdmin">
                            <form id="form_admin" class="text-center p-2 px-4" action="/administrar-usuarios" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" id="rut" name="user_rut" class="form-control mb-4" required placeholder="Rut" value="<?= set_value('user_rut') ?>" oninput="checkRut(this)">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="user_fullname" class="form-control mb-4" maxlength="100" required placeholder="Nombres" value="<?= set_value('user_fullname') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="user_email" class="form-control mb-4" required maxlength="255" placeholder="Correo electronico" value="<?= set_value('user_email') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="tel" name="user_phone" class="form-control mb-4" required maxlength="9" placeholder="Numero telefonico" value="<?= set_value('user_phone') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <select name="select_region" id="select_region" class="custom-select mb-4" onchange="load_commune()">
                                            <option disabled <?= (!set_value('select_region') ? 'selected' : null) ?>>Selecciona tu region</option>
                                            <?php foreach ($regions as $region) : ?>
                                                <option <?= (set_value('select_region') ? (set_value('select_region') == $region['region_id'] ? 'selected' : null) : null) ?> value="<?= $region['region_id'] ?>"><?= $region['region_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <select name="user_commune" id="select_commune" class="custom-select mb-4">
                                            <option disabled <?= (!set_value('user_commune') ? 'selected' : null) ?>>Selecciona tu comuna</option>
                                            <?php foreach ($communes as $commune) : ?>
                                                <?php if ($commune['province_region'] == (set_value('select_region') ? set_value('select_region') : null)) : ?>
                                                    <option <?= (set_value('user_commune') ? (set_value('user_commune') == $commune['commune_id'] ? 'selected' : null) : null) ?> value="<?= $commune['commune_id'] ?>"><?= $commune['commune_name'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="address" name="user_address" class="form-control mb-4" required maxlength="255" placeholder="Domicilio" value="<?= set_value('user_address') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="user_password" class="form-control" required maxlength="255" placeholder="Contraseña" aria-describedby="password_help">
                                        <small id="password_help" class="form-text text-muted mb-4">
                                            Como minimo 8 caracteres
                                        </small>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="user_password_repeat" class="form-control" required maxlength="255" placeholder="Repetir Contraseña" aria-describedby="defaultRegisterFormPasswordHelpBlock">
                                    </div>

                                    <div class="col-md-6 mx-auto mb-2 mt-3 mt-md-0">
                                        <a data-toggle="modal" data-target="#modal_add" href="#" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moda Confirm Save -->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h5" id="exampleModalLongTitle">Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class=" text-center">
                    <i class="far fa-save fa-4x animated zoomIn text-info"></i>
                    <p class=" h5 mt-3 ">¿Desea agregar a un nuevo administrador?</p>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="$('#form_admin').submit()" class="btn btn-info btn-rounded waves-effect text-white">Guardar</a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Central Modal Edit User -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h5" id="exampleModalLongTitle">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input id="modal_id" style="display: none;">
                        <input id="modal_rut" type="text" class="form-control mb-4" disabled placeholder="Rut" oninput="checkRut(this)">
                    </div>

                    <div class="col-md-6">
                        <input id="modal_fullname" type="text" class="form-control mb-4" maxlength="100" required placeholder="Nombres">
                    </div>

                    <div class="col-md-6">
                        <input id="modal_email" type="email" class="form-control mb-4" required maxlength="255" placeholder="Correo electronico">
                    </div>

                    <div class="col-md-6">
                        <input id="modal_phone" type="tel" class="form-control mb-4" required maxlength="9" placeholder="Numero telefonico">
                    </div>

                    <div class="col-md-6">
                        <select id="modal_region" class="custom-select mb-4" onchange="load_commune()">
                            <option disabled ?>>Selecciona tu region</option>
                            <?php foreach ($regions as $region) : ?>
                                <option value="<?= $region['region_id'] ?>"><?= $region['region_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <select id="modal_commune" name="user_commune" class="custom-select mb-4">
                        </select>
                    </div>

                    <div class="col-md-12">
                        <input id="modal_address" type="address" class="form-control mb-4" required maxlength="255" placeholder="Domicilio">
                    </div>

                    <div class="col-md-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="user_profile" id="modal_profile">
                            <label class="custom-control-label" for="modal_profile">Activo</label>
                        </div>
                    </div>
                </div>
                <div class="text-center" id="error_update" style="display: none;" role="alert">
                    <div style="color: #ff3547;" id="errors_messages"></div>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="update_admin()" class="btn btn-primary btn-rounded waves-effect text-white">Actualizar</a>
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
<script src="/assets/vendor/jquery.rut/jquery.rut.js"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table_1').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            }
        });

        $('#table_2').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            }
        });

        $("input#rut").rut({
            formatOn: 'keyup',
            minimumLength: 8,
            validateOn: 'change keyup',
            useThousandsSeparator: false
        });
    });

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

    function load_admin(id, rut, fullname, email, phone, address, commune, profile) {
        $('#modal_id').val(id);
        $('#modal_rut').val(rut);
        $('#modal_fullname').val(fullname);
        $('#modal_email').val(email);
        $('#modal_phone').val(phone);
        $('#modal_address').val(address);

        if (profile == 1) {
            $('#modal_profile').prop("checked", "checked");
        }

        $.getJSON('get_commune', function(result) {
            var mySelect = $('#modal_commune').empty();
            mySelect.append("<option disabled >Selecciona tu comuna</option>");
            $.each(result, function(index, value) {
                mySelect.append(new Option(value.commune_name, value.commune_id));
                if (value.commune_id == commune) {
                    $("#modal_region").val(value.province_region);
                    mySelect.append("<option selected value='" + value.commune_id + "' >" + value.commune_name + "</option>");
                }
            });
        });
    }

    function update_admin() {
        var user_id = $('#modal_id').val();
        var user_rut = $('#modal_rut').val();
        var user_fullname = $('#modal_fullname').val();
        var user_email = $('#modal_email').val();
        var user_phone = $('#modal_phone').val();
        var user_address = $('#modal_address').val();
        var user_commune = $('#modal_commune').val();
        var user_profile = ($('#modal_profile').prop("checked") ? 1 : 3);

        $('#messages').empty();
        $('#errors_messages').empty();

        $.ajax({
            type: "POST",
            url: "update_admin",
            data: {
                user_id,
                user_rut,
                user_fullname,
                user_email,
                user_phone,
                user_address,
                user_commune,
                user_profile,
            },
            success: function(o) {
                if (o.success) {
                    location.reload();
                } else {
                    $('#error_update').css('display', 'inline');
                    $('#errors_messages').empty();
                    $.each(o.validation, function(index, value) {
                        $('#errors_messages').append('<b>' + value + '<b><br>');
                    });
                }
            },
            dataType: "json"
        });
    }

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