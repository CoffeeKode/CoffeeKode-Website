<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Administrar Página
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<section class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header white-text default-color">
                    Administración de Pagina Web
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
                            <a class="nav-link <?= (session()->get('add_product') || session()->get('update_about') || session()->get('update_team') || session()->get('update_contact') ? null : 'active') ?>" id="tabProducts" data-toggle="pill" href="#pillsProducts" role="tab" aria-controls="pillsProducts" aria-selected="true">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('add_product') ? 'active' : null) ?>" id="tabaAddProducts" data-toggle="pill" href="#pillsAddProducts" role="tab" aria-controls="pillsAddProducts" aria-selected="true">Agregar Producto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('update_about') ? 'active' : null) ?>" id="tabAboutUs" data-toggle="pill" href="#pillsAboutUs" role="tab" aria-controls="pillsAboutUs" aria-selected="true">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?= (session()->get('update_team') ? 'active' : null) ?>" id="tabTeam" data-toggle="pill" href="#pillsTeam" role="tab" aria-controls="pillsTeam" aria-selected="false">Equipo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('update_contact') ? 'active' : null) ?>" id="tabContact" data-toggle="pill" href="#pillsContact" role="tab" aria-controls="pillsContact" aria-selected="false">Contacto</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="adminPageContent">
                        <div class="tab-pane fade <?= (session()->get('add_product') || session()->get('update_about') || session()->get('update_team') || session()->get('update_contact') ? null : 'show active') ?>" id="pillsProducts" role="tabpanel" aria-labelledby="tabProducts">
                            <div class="table-responsive p-3">
                                <table id="table_2" class="display table-hover">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Color de fondo</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($products as $product) : ?>
                                            <tr>
                                                <th scope="row">
                                                    <?= $product['product_title'] ?>
                                                </th>
                                                <td><?= $product['product_description'] ?></td>
                                                <td nowrap>
                                                    <div class="card front text-center p-2 text-white <?= $product['product_bg'] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                </td>
                                                <td><?= ($product['product_status'] == 0 ? 'Activo' : 'Inactivo') ?></td>
                                                <td>
                                                    <button onclick="modal_edit('<?= $product['product_id'] ?>','<?= $product['product_title'] ?>','<?= $product['product_description'] ?>','<?= $product['product_bg'] ?>','<?= $product['product_status'] ?>')" data-toggle="modal" data-target="#modal_edit" type="button" class="btn btn-primary py-2 px-3"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Color de fondo</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade <?= (session()->get('add_product') ? 'show active' : null) ?>" id="pillsAddProducts" role="tabpanel" aria-labelledby="tabAddProducts">
                            <form class="text-center p-2 px-4" action="/administrar-web" method="post">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <h4 class="h4 mb-2">Agregar Productos</h4>
                                    </div>

                                    <input style="display: none;" name="from_to" value="add_product">

                                    <div class="col-md-8">
                                        <input type="text" name="product_title" class="form-control mb-4" maxlength="50" required placeholder="Título de producto" value="<?= set_value('product_title') ?>">
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="text-left" for="exampleFormControlTextarea1">Descripción</label>
                                            <textarea name="product_description" class="form-control rounded-0" id="exampleFormControlTextarea1" rows="5" maxlength="1000" value="<?= set_value('product_description') ?>"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <label class="text-left" for="exampleFormControlTextarea1">Color de fondo</label>
                                        <div class="colorPicker">
                                            <input class="red" type="radio" name="product_bg" value="red" id="product-bg-red" />
                                            <label class="red" for="product-bg-red">Rojo</label>
                                            <input class="orange" type="radio" name="product_bg" value="orange" id="product-bg-orange" />
                                            <label class="orange" for="product-bg-orange">Naranjo</label>
                                            <input class="yellow" type="radio" name="product_bg" value="yellow" id="product-bg-yellow" />
                                            <label class="yellow" for="product-bg-yellow">Amarillo</label>
                                            <input class="green" type="radio" name="product_bg" value="green" id="product-bg-green" />
                                            <label class="green" for="product-bg-green">Verde</label>
                                            <input class="blue" type="radio" name="product_bg" value="blue" id="product-bg-blue" />
                                            <label class="blue" for="product-bg-blue">Azul</label>
                                            <input class="indigo" type="radio" name="product_bg" value="indigo" id="product-bg-indigo" />
                                            <label class="indigo" for="product-bg-indigo">Indigo</label>
                                            <input class="violet" type="radio" name="product_bg" value="violet" id="product-bg-violet" />
                                            <label class="violet" for="product-bg-violet">Violeta</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4 mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="product_status" id="check_status" <?= (session()->get('add_product') ? (set_value('product_status') ? 'checked' : null) : 'checked') ?>>
                                            <label class="custom-control-label" for="check_status">Activo (Los productos inactivos no son visibles en la página)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mx-auto mt-3 text-right">
                                        <button type="submit" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?= (session()->get('update_about') ? 'show active' : null) ?>" id="pillsAboutUs" role="tabpanel" aria-labelledby="tabAboutUs">
                            <form class="text-center p-2 px-4" action="administrar-web" enctype="multipart/form-data" method="post">
                                <input style="display: none;" name="from_to" value="add_about">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <h4 class="h4 mb-2">¿Quienes somos?</h4>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="page_about_us_img" id="page_about_us_img" lang="es">
                                            <label class="custom-file-label" for="page_about_us_img">Seleccionar Imagen</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de imagen debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="text-left" for="about_us">Descripción</label>
                                            <textarea class="form-control rounded-0" name="page_about_us" id="about_us" rows="5"><?= $pages['page_about_us'] ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <h4 class="h4 mb-2">Nuestra Miel</h4>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="page_our_product_img" id="page_our_product_img" lang="es">
                                            <label class="custom-file-label" for="page_our_product_img">Seleccionar Imagen</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de imagen debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="text-left" for="our_products">Descripción</label>
                                            <textarea class="form-control rounded-0" name="page_our_product" id="our_products" rows="5"><?= $pages['page_our_product'] ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-cyan waves-effect px-3">Guardar
                                            <i class=" ml-2 far fa-save "></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?= (session()->get('update_team') ? 'show active' : null) ?>" id="pillsTeam" role="tabpanel" aria-labelledby="tabTeam">
                            <form class="text-center p-2 px-4" action="administrar-web" enctype="multipart/form-data" method="post">
                                <input style="display: none;" name="from_to" value="add_team">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <h4 class="h4 mb-2">Primer Integrante</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="team_title_1" class="form-control mb-4" maxlength="50" value="<?= $team['team_title_1'] ?>" required placeholder="Nombre Primer integrante">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="team_img_1" id="team_img_1" lang="es">
                                            <label class="custom-file-label" for="team_img_1">Seleccionar Imagen 1</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de imagen debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-left" for="team_description_1">Descripción Primer
                                                Integrante</label>
                                            <textarea class="form-control rounded-0" maxlength="1000" name="team_description_1" id="team_description_1" rows="3"><?= $team['team_description_1'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <h4 class="h4 mb-2">Segundo Integrante</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="team_title_2" class="form-control mb-4" maxlength="50" value="<?= $team['team_title_2'] ?>" required placeholder="Nombre segundo integrante">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="team_img_2" id="team_img_2" lang="es">
                                            <label class="custom-file-label" for="team_img_2">Seleccionar Imagen 2</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de imagen debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-left" for="team_description_2">Descripción Segundo
                                                Integrante</label>
                                            <textarea class="form-control rounded-0" maxlength="1000" name="team_description_2" id="team_description_2" rows="3"><?= $team['team_description_2'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <h4 class="h4 mb-2">Tercer Integrante</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="team_title_3" class="form-control mb-4" maxlength="50" value="<?= $team['team_title_3'] ?>" required placeholder="Nombre tercer integrante">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="team_img_3" id="team_img_3" lang="es">
                                            <label class="custom-file-label" for="team_img_3">Seleccionar Imagen 3</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de imagen debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-left" for="team_description_3">Descripción tercer
                                                integrante</label>
                                            <textarea class="form-control rounded-0" maxlength="1000" name="team_description_3" id="team_description_3" rows="3"><?= $team['team_description_3'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-cyan waves-effect px-3">Guardar
                                        <i class=" ml-2 far fa-save "></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?= (session()->get('update_contact') ? 'show active' : null) ?>" id="pillsContact" role="tabpanel" aria-labelledby="tabContact">
                            <form class="text-center p-2 px-4" action="administrar-web" method="post">
                                <input style="display: none;" name="from_to" value="add_contact">
                                <div class="row">
                                    <div class="col-md-6 md-form input-with-pre-icon">
                                        <i class="fas fa-envelope-open-text input-prefix fa-lg"></i>
                                        <input type="text" name="contact_mail" id="contact_mail" class="form-control" value="<?= $contact['contact_mail'] ?>">
                                        <label class="pl-2" for="contact_mail">Correo Electrónico</label>
                                    </div>

                                    <div class="col-md-6 md-form input-with-pre-icon">
                                        <i class="fas fa-phone-square-alt input-prefix fa-lg"></i>
                                        <input type="text" name="contact_number" id="contact_number" class="form-control" value="<?= $contact['contact_number'] ?>">
                                        <label class="pl-2" for="contact_number">Numero telefónico</label>
                                    </div>

                                    <div class="col-md-12 md-form input-with-pre-icon mb-0 pb-0">
                                        <i class="fas fa-map-marked input-prefix fa-lg"></i>
                                        <input type="text" name="contact_address" id="contact_address" class="form-control" value="<?= $contact['contact_address'] ?>">
                                        <label class="pl-2" for="contact_address">Dirección</label>
                                    </div>

                                    <div class="col-md-6 md-form input-with-pre-icon">
                                        <i class="fab fa-instagram input-prefix fa-lg"></i>
                                        <input type="text" name="contact_instagram" id="contact_instagram" class="form-control" value="<?= $contact['contact_instagram'] ?>">
                                        <label class="pl-2" for="contact_instagram">Instagram</label>
                                    </div>

                                    <div class="col-md-6 md-form input-with-pre-icon">
                                        <i class="fab fa-facebook-square input-prefix fa-lg"></i>
                                        <input type="text" name="contact_facebook" id="contact_facebook" class="form-control" value="<?= $contact['contact_facebook'] ?>">
                                        <label class="pl-2" for="contact_facebook">Facebook</label>
                                    </div>

                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-cyan waves-effect px-3">Guardar
                                        <i class=" ml-2 far fa-save "></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <h4 class="h4 mb-2">Agregar Productos</h4>
                        </div>

                        <input style="display: none;" name="product_id" id="modal_id" value="add_product">

                        <div class="col-md-8">
                            <input type="text" name="product_title" id="modal_title" class="form-control mb-4" maxlength="50" required placeholder="Título de producto" value="<?= set_value('product_title') ?>">
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="text-left" for="modal_description">Descripción</label>
                                <textarea name="product_description" class="form-control rounded-0" id="modal_description" rows="5" maxlength="1000" value="<?= set_value('product_description') ?>"></textarea>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="text-left">Color de fondo</label>
                            <div class="colorPicker">
                                <input class="red" type="radio" name="product_bg_update" value="red" id="modal-bg-red" />
                                <label class="red" for="modal-bg-red">Rojo</label>
                                <input class="orange" type="radio" name="product_bg_update" value="orange" id="modal-bg-orange" />
                                <label class="orange" for="modal-bg-orange">Naranjo</label>
                                <input class="yellow" type="radio" name="product_bg_update" value="yellow" id="modal-bg-yellow" />
                                <label class="yellow" for="modal-bg-yellow">Amarillo</label>
                                <input class="green" type="radio" name="product_bg_update" value="green" id="modal-bg-green" />
                                <label class="green" for="modal-bg-green">Verde</label>
                                <input class="blue" type="radio" name="product_bg_update" value="blue" id="modal-bg-blue" />
                                <label class="blue" for="modal-bg-blue">Azul</label>
                                <input class="indigo" type="radio" name="product_bg_update" value="indigo" id="modal-bg-indigo" />
                                <label class="indigo" for="modal-bg-indigo">Indigo</label>
                                <input class="violet" type="radio" name="product_bg_update" value="violet" id="modal-bg-violet" />
                                <label class="violet" for="modal-bg-violet">Violeta</label>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mb-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="product_status" id="modal_status">
                                <label class="custom-control-label" for="modal_status">Activo (Los productos inactivos no son visibles en la página)</label>
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
                        <a href="#" onclick="update_products()" class="btn btn-primary btn-rounded waves-effect text-white">Actualizar</a>
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

    function modal_edit(id, title, description, bg, status) {
        $('#modal_id').val(id);
        $('#modal_title').val(title);
        $('#modal_description').val(description);
        $('input:radio[name=product_bg_update]').filter('[value=' + bg + ']').prop('checked', true);

        if (status == 0) {
            $('#modal_status').prop("checked", "checked");
        } else {
            $('#modal_status').prop("checked", "");
        }
    }

    function update_products() {
        var product_id = $('#modal_id').val();
        var from_to = 'add_product';
        var product_title = $('#modal_title').val();
        var product_description = $('#modal_description').val();
        var product_bg = $('input:radio[name=product_bg_update]:checked').val()
        var product_status = ($('#modal_status').prop("checked") ? 0 : 1);

        $('#messages').empty();
        $('#errors_messages').empty();

        $.ajax({
            type: "POST",
            url: "administrar-web",
            data: {
                from_to,
                product_id,
                product_title,
                product_description,
                product_bg,
                product_status
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
</script>
<?= $this->endSection() ?>