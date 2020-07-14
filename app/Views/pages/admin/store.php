<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Administrar Tiendas
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>

<section class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header  white-text default-color">
                    Administrar Tiendas
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
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= (!session()->get('add_store') ? 'active' : null) ?>" id="tabOrdersCompleted" data-toggle="pill" href="#pillsOrdersCompleted" role="tab" aria-controls="pillsOrdersCompleted" aria-selected="true">Tiendas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('add_store') ? 'active' : null) ?>" id="tabOrdersPending" data-toggle="pill" href="#pillsOrdersPending" role="tab" aria-controls="pillsOrdersPending" aria-selected="false">Agregar Tiendas</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabContentPills">
                        <div class="tab-pane fade <?= (!session()->get('add_store') ? 'show active' : null) ?>" id="pillsOrdersCompleted" role="tabpanel" aria-labelledby="tabOrdersCompleted">
                            <div class="table-responsive text-nowrap">
                                <table id="table_2" class="display table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Región</th>
                                            <th>Comuna</th>
                                            <th>Dirección</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($store as $store) : ?>
                                            <?php if ($store['store_id'] != 1) : ?>
                                                <tr>
                                                    <th scope="row">
                                                        <?= $store['store_name'] ?>
                                                    </th>
                                                    <td><?= $store['store_phone'] ?></td>
                                                    <td><?= $store['region_name'] ?></td>
                                                    <td><?= $store['commune_name'] ?></td>
                                                    <td><?= $store['store_address'] ?></td>
                                                    <td><?= ($store['store_status'] == 0 ? 'Activa' : 'Inactiva') ?></td>
                                                    <td>
                                                        <button onclick="modal_edit('<?= $store['store_id'] ?>', '<?= $store['store_name'] ?>', '<?= $store['store_phone'] ?>', '<?= $store['store_address'] ?>', '<?= $store['store_commune'] ?>', '<?= $store['region_id'] ?>', '<?= $store['store_status'] ?>')" data-toggle="modal" data-target="#modal_edit" type="button" class="btn btn-primary py-2 px-3"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Región</th>
                                            <th>Comuna</th>
                                            <th>Dirección</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('add_store') ? 'show active' : null) ?>" id="pillsOrdersPending" role="tabpanel" aria-labelledby="tabOrdersPending">
                            <form class="text-center p-2 px-4" id="form-store" action="/administrar-tiendas" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="store_name" class="form-control mb-4" maxlength="50" required placeholder="Nombre" value="<?= set_value('store_name') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="tel" name="store_phone" class="form-control mb-4" required maxlength="9" placeholder="Numero telefonico" value="<?= set_value('store_phone') ?>">
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
                                        <select name="store_commune" id="select_commune" class="custom-select mb-4">
                                            <option disabled <?= (!set_value('user_commune') ? 'selected' : null) ?>>Selecciona tu comuna</option>
                                            <?php foreach ($communs as $commune) : ?>
                                                <?php if ($commune['province_region'] == (set_value('select_region') ? set_value('select_region') : null)) : ?>
                                                    <option <?= (set_value('store_commune') ? (set_value('store_commune') == $commune['commune_id'] ? 'selected' : null) : null) ?> value="<?= $commune['commune_id'] ?>"><?= $commune['commune_name'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="address" name="store_address" class="form-control mb-4" required maxlength="100" placeholder="Domicilio" value="<?= set_value('store_address') ?>">
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="store_status" id="check_status" <?= (session()->get('add_store') ? (set_value('store_status') ? 'checked' : null) : 'checked') ?>>
                                            <label class="custom-control-label" for="check_status">Activo (Las tiendas inactivas no son visibles en la página)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mx-auto mb-2">
                                        <button type="submit" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Central Modal Save -->
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
                        <a href="#" onclick="$('#form-store').submit()" class="btn btn-info btn-rounded waves-effect text-white">Guardar

                        </a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Central Modal Edit Product -->
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
                <form id="form_update" class="text-center p-2 px-4">
                    <div class="row">
                        <div class="col-md-6">
                            <input name="store_id" id="modal_id">
                            <input type="text" name="store_name" id="modal_name" class="form-control mb-4" maxlength="50" required placeholder="Nombre">
                        </div>

                        <div class="col-md-6">
                            <input type="tel" name="store_phone" id="modal_phone" class="form-control mb-4" required maxlength="9" placeholder="Numero telefonico">
                        </div>

                        <div class="col-md-6">
                            <select id="modal_region" class="custom-select mb-4" onchange="load_commune('#modal_commune')">
                                <option disabled>Selecciona tu region</option>
                                <?php foreach ($regions as $region) : ?>
                                    <option value="<?= $region['region_id'] ?>"><?= $region['region_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <select name="store_commune" id="modal_commune" class="custom-select mb-4">

                            </select>
                        </div>

                        <div class="col-md-12">
                            <input type="address" name="store_address" id="modal_address" class="form-control mb-4" required maxlength="100" placeholder="Domicilio" value="<?= set_value('store_address') ?>">
                        </div>

                        <div class="col-md-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="store_status" id="modal_status">
                                <label class="custom-control-label" for="modal_status">Activo (Las tiendas inactivas no son visibles en la página)</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" id="error_update" style="display: none;" role="alert">
                        <div style="color: #ff3547;" id="errors_messages"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="update_store()" class="btn btn-primary btn-rounded waves-effect text-white">Actualizar</a>
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
    });

    function modal_edit(id, name, phone, address, commune, region, status) {
        $('#modal_id').val(id);
        $('#modal_name').val(name);
        $('#modal_phone').val(phone);
        $('#modal_address').val(address);
        $('#modal_region').val(region);

        if (status == 0) {
            $('#modal_status').prop("checked", "checked");
        } else {
            $('#modal_status').prop("checked", "");
        }

        $.getJSON('get_commune', function(result) {
            var mySelect = $('#modal_commune').empty();
            mySelect.append("<option disabled >Selecciona tu comuna</option>");
            $.each(result, function(index, value) {
                mySelect.append(new Option(value.commune_name, value.commune_id));
                if (value.commune_id == commune) {
                    mySelect.append("<option selected value='" + value.commune_id + "' >" + value.commune_name + "</option>");
                }
            });
        });
    }

    function load_commune(select = '#select_commune') {
        var region_id = $('#select_region').val();

        $.getJSON('get_commune', function(result) {
            var mySelect = $(select).empty();
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

    function update_store() {
        var data = new FormData($('#form_update')[0]);

        $('#messages').empty();
        $('#errors_messages').empty();

        $.ajax({
            url: 'administrar-tiendas',
            type: 'post',
            dataType: 'json',
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            timeout: false,
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
            error: function() {
                alert("Error interno");
            }
        });
    }
</script>
<?= $this->endSection() ?>