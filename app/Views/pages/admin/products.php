<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Administrar Productos
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/assets/css/ekko-lightbox.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header  white-text default-color">
                    Administrar Productos
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
                            <a class="nav-link <?= (!session()->get('add_product') ? 'active' : null) ?>" id="tabOrdersCompleted" data-toggle="pill" href="#pillsOrdersCompleted" role="tab" aria-controls="pillsOrdersCompleted" aria-selected="true">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('add_product') ? 'active' : null) ?>" id="tabOrdersPending" data-toggle="pill" href="#pillsOrdersPending" role="tab" aria-controls="pillsOrdersPending" aria-selected="false">Agregar Productos</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabContentPills">
                        <div class="tab-pane fade <?= (!session()->get('add_product') ? 'show active' : null) ?>" id="pillsOrdersCompleted" role="tabpanel" aria-labelledby="tabOrdersCompleted">
                            <div class="table-responsive">
                                <table id="table_2" class="display table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Formato</th>
                                            <th>Precio</th>
                                            <th>Precio Desc.</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($formats as $format) : ?>
                                            <tr>
                                                <th scope="row">
                                                    <a href="/assets/img/products/<?= $format['format_img'] ?>" data-toggle="lightbox">
                                                        <img src="/assets/img/products/<?= $format['format_img'] ?>" class="img-fluid" width="80px">
                                                    </a>
                                                </th>
                                                <td><?= $format['format_title'] ?></td>
                                                <td><?= $format['format_weight'] ?></td>
                                                <td>$<?= number_format($format['format_old_price'], 0, '', '.') ?></td>
                                                <td>$<?= number_format($format['format_price'], 0, '', '.') ?></td>
                                                <td><?= $format['format_stock'] ?></td>
                                                <td><?= ($format['format_status'] == 0 ? 'Activo' : 'Inactivo') ?></td>
                                                <td>
                                                    <button onclick="modal_edit('<?= $format['format_id'] ?>', '<?= $format['format_title'] ?>', '<?= $format['format_description'] ?>', '<?= $format['format_weight'] ?>', '<?= $format['format_img'] ?>', '<?= $format['format_gif'] ?>', '<?= $format['format_price'] ?>', '<?= $format['format_old_price'] ?>', '<?= $format['format_stock'] ?>', '<?= $format['format_default'] ?>', '<?= $format['format_product'] ?>', '<?= $format['format_status'] ?>')" data-toggle="modal" data-target="#modal_edit" type="button" class="btn btn-primary py-2 px-3"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Formato</th>
                                            <th>Precio</th>
                                            <th>Precio Desc.</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('add_product') ? 'show active' : null) ?>" id="pillsOrdersPending" role="tabpanel" aria-labelledby="tabOrdersPending">
                            <form id="form-product" class="text-center p-2 px-4" action="/administrar-productos" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <select name="format_product" id="format_product" class="custom-select">
                                            <option disabled selected>Selecciona Familia de Producto</option>
                                            <?php foreach ($products as $product) : ?>
                                                <option value="<?= $product['product_id'] ?>"><?= $product['product_title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="format_title" class="form-control mb-4" maxlength="255" required placeholder="Nombre">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="number" name="format_stock" class="form-control mb-4" required maxlength="255" placeholder="Stock">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" name="format_weight" class="form-control mb-4" required maxlength="255" placeholder="Formato">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="number" name="format_old_price" class="form-control mb-4" required min="1" placeholder="Precio">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="number" name="format_price" class="form-control mb-4" required min="1" placeholder="Precio Desc">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="format_img" class="custom-file-input" id="format_img" lang="es">
                                            <label class="custom-file-label" for="format_img">Seleccionar Imagen</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de imagen debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="format_gif" class="custom-file-input" id="format_gif" lang="es">
                                            <label class="custom-file-label" for="format_gif">Seleccionar Gif</label>
                                            <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                                Resolucion de gif debe ser 550x400
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label require class="text-left" for="format_description">Descripción</label>
                                            <textarea class="form-control rounded-0" maxlength="255" name="format_description" id="format_description" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="format_status" id="check_status" checked>
                                            <label class="custom-control-label" for="check_status">Activo (Los productos inactivos no son visibles en la página)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mx-auto mb-2">
                                        <!-- <button type="submit" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</button> -->
                                        <a data-toggle="modal" data-target="#modal_save" href="#" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</a>
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
                    <p class=" h5 mt-3 ">¿Desea Guardar el nuevo producto?</p>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="$('#form-product').submit()" class="btn btn-info btn-rounded waves-effect text-white">Guardar</a>
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
                            <select name="format_product" id="modal_product" class="custom-select">
                                <option disabled selected>Selecciona Familia de Producto</option>
                                <?php foreach ($products as $product) : ?>
                                    <option value="<?= $product['product_id'] ?>"><?= $product['product_title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input name="format_id" id="modal_id" style="display: none;">
                            <input type="text" name="format_title" id="modal_title" class="form-control mb-4" maxlength="255" required placeholder="Nombre">
                        </div>

                        <div class="col-md-3">
                            <input type="number" name="format_stock" id="modal_stock" class="form-control mb-4" required maxlength="255" placeholder="Stock">
                        </div>

                        <div class="col-md-3">
                            <input type="text" name="format_weight" id="modal_weight" class="form-control mb-4" required maxlength="255" placeholder="Formato">
                        </div>

                        <div class="col-md-3">
                            <input type="number" name="format_old_price" id="modal_old_price" class="form-control mb-4" required min="1" placeholder="Precio">
                        </div>

                        <div class="col-md-3">
                            <input type="number" name="format_price" id="modal_price" class="form-control mb-4" required min="1" placeholder="Precio Desc">
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="custom-file">
                                <input type="file" name="format_img" class="custom-file-input" lang="es">
                                <label class="custom-file-label" for="format_img">Seleccionar Imagen</label>
                                <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                    Resolucion de imagen debe ser 550x400
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="custom-file">
                                <input type="file" name="format_gif" class="custom-file-input" lang="es">
                                <label class="custom-file-label" for="format_gif">Seleccionar Gif</label>
                                <small id="fotmat_img_help" class="form-text text-muted mb-4">
                                    Resolucion de gif debe ser 550x400
                                </small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label require class="text-left" for="format_description">Descripción</label>
                                <textarea class="form-control rounded-0" maxlength="255" name="format_description" id="modal_description" id="format_description" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="format_status" id="modal_status">
                                <label class="custom-control-label" for="modal_status">Activo (Los productos inactivos no son visibles en la página)</label>
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
                        <a href="#" onclick="update_product()" class="btn btn-primary btn-rounded waves-effect text-white">Actualizar</a>
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
<script type="text/javascript" src="/assets/js/ekko-lightbox.min.js"></script>
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

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });


    function modal_edit(id, title, description, weight, img, gif, price, old_price, stock, def, product, status) {

        $('#modal_id').val(id);
        $('#modal_title').val(title);
        $('#modal_description').val(description);
        $('#modal_weight').val(weight);
        $('#modal_price').val(price);
        $('#modal_old_price').val(old_price);
        $('#modal_stock').val(stock);
        $('#modal_product').val(product);

        if (status == 0) {
            $('#modal_status').prop("checked", "checked");
        } else {
            $('#modal_status').prop("checked", "");
        }
    }

    function update_product() {
        var data = new FormData($('#form_update')[0]);

        $('#messages').empty();
        $('#errors_messages').empty();

        $.ajax({
            url: 'administrar-productos',
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