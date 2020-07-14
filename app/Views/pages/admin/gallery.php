<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Administrar Galería
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/assets/css/ekko-lightbox.css">
<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header  white-text default-color">
                    Administrar Galería
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

                <?php
                function get_image($images, $image_gallery, $delete)
                {
                    foreach ($images as $image) {
                        if ($image['image_gallery'] == $image_gallery) {
                            if ($delete) {
                                return $image['image_id'];
                            } else {
                                return $image['image_path'];
                            }
                        }
                    }
                    return NULL;
                }

                function format_date($date)
                {
                    return substr($date, 8) . "/" . substr($date, 5, -3) . "/" . substr($date, 0, -6);
                }
                ?>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= (!session()->get('add_gallery') && !session()->get('edit_video')  && !session()->get('add_video') ? 'active' : null) ?>" id="tabOrdersCompleted" data-toggle="pill" href="#pillsOrdersCompleted" role="tab" aria-controls="pillsOrdersCompleted" aria-selected="true">Álbum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('add_gallery') ? 'active' : null) ?>" id="tabOrdersPending" data-toggle="pill" href="#pillsOrdersPending" role="tab" aria-controls="pillsOrdersPending" aria-selected="false">Agregar Álbumes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('edit_video') ? 'active' : null) ?>" id="tab_video_view" data-toggle="pill" href="#pills_video_list" role="tab" aria-controls="pills_video_list" aria-selected="false">Videos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (session()->get('add_video') ? 'active' : null) ?>" id="tab_video_add" data-toggle="pill" href="#pills_video_add" role="tab" aria-controls="pills_video_add" aria-selected="false">Agregar Videos</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabContentPills">
                        <div class="tab-pane fade <?= (!session()->get('add_gallery') && !session()->get('edit_video')  && !session()->get('add_video') ? 'show active' : null) ?>" id="pillsOrdersCompleted" role="tabpanel" aria-labelledby="tabOrdersCompleted">
                            <div class="table-responsive">
                                <table id="table_2" class="display table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Imagenes</th>
                                            <th>Título</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Agregar más imagenes</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($gallerys as $gallery) : ?>
                                            <?php $image_path = get_image($images, $gallery['gallery_id'], false) ?>
                                            <?php $image_id = get_image($images, $gallery['gallery_id'], true) ?>
                                            <tr>
                                                <td align="center">
                                                    <a href="/assets/img/gallery/<?= $image_path ?>" data-toggle="lightbox" data-gallery="gallery-<?= $gallery['gallery_id'] ?>" data-max-width="1000" data-title="<?= $gallery['gallery_title'] ?>" data-footer="<?= '<a href=\'#\' class=\'btn btn-danger py-2 px-3\' onclick=\'delete_image(' . $image_id  . ')\'><i class=\'fas fa-trash-alt\'></i></a>' ?>" data-max-width="600" data-max-height="600">
                                                        <img style="max-width: 100px;" class="card-img-top" src="/assets/img/gallery/<?= $image_path ?>" alt="Card image cap">
                                                    </a>
                                                </td>
                                                <th scope="row"> <?= $gallery['gallery_title'] ?></th>
                                                <td><?= format_date($gallery['gallery_date']) ?></td>
                                                <td><?= ($gallery['gallery_status'] == 0 ? 'Activo' : 'Inactivo') ?></td>
                                                <td>
                                                    <form action="/administrar-galeria" enctype="multipart/form-data" method="post">
                                                        <input type="hidden" name="from_to" value="image">
                                                        <input type="hidden" name="gallery_id" value="<?= $gallery['gallery_id'] ?>">
                                                        <input type="hidden" name="gallery_title" value="<?= $gallery['gallery_title'] ?>">
                                                        <div class="input-group input-group-sm">
                                                            <div class="custom-file">
                                                                <input type="file" name="gallery_img[]" class="custom-file-input" id="gallery_img" lang="es" multiple accept="image/*" aria-describedby="btn_add_images">
                                                                <label class="custom-file-label" for="gallery_img">Imagenes</label>
                                                            </div>
                                                            <div class="input-group-prepend">
                                                                <button type="submit" class="input-group-text" id="btn_add_images" data-toggle="tooltip" title="Subir imagenes"><i class="fas fa-cloud-upload-alt"></button></i>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button onclick='modal_edit_gallery(<?= json_encode($gallery) ?>)' data-toggle="modal" data-target="#modal_edit_gallery" type="button" class="btn btn-primary py-2 px-3"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                </td>
                                                <div style="display: none;">
                                                    <?php foreach ($images as $image) : ?>
                                                        <?php if ($image['image_gallery'] == $gallery['gallery_id'] && $image['image_path'] != $image_path) : ?>
                                                            <a href="/assets/img/gallery/<?= $image['image_path'] ?>" data-toggle="lightbox" data-gallery="gallery-<?= $image['image_gallery'] ?>" data-max-width="1000" data-title="<?= $gallery['gallery_title'] ?>" data-footer="<?= '<a href=\'#\' class=\'btn btn-danger py-2 px-3\'  onclick=\'delete_image(' . $image['image_id']  . ')\'><i class=\'fas fa-trash-alt\'></i></a>' ?>" data-max-width="600" data-max-height="600">
                                                                <div class="mask rgba-white-slight"></div>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Imagenes</th>
                                            <th>Título</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Agregar más imagenes</th>
                                            <th>Editar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('add_gallery') ? 'show active' : null) ?>" id="pillsOrdersPending" role="tabpanel" aria-labelledby="tabOrdersPending">
                            <form id="form-gallery" class="text-center p-2 px-4" action="/administrar-galeria" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <input type="hidden" name="from_to" value="gallery">
                                    <div class="col-md-9">
                                        <input type="text" name="gallery_title" class="form-control mb-4" maxlength="50" required placeholder="Titulo" value="<?= set_value('gallery_title') ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <input id="gallery_date" data-provide="datepicker" name="gallery_date" class="form-control mb-4" placeholder="Fecha" value="<?= set_value('gallery_date') ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label require class="text-left" for="gallery_description">Descripción</label>
                                            <textarea class="form-control rounded-0" maxlength="500" name="gallery_description" id="gallery_description" rows="3"><?= set_value('gallery_description') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mx-auto mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="gallery_img[]" class="custom-file-input" id="gallery_img" lang="es" multiple accept="image/*">
                                            <label class="custom-file-label" for="gallery_img">Seleccionar Imagenes</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="gallery_status" id="check_status_gallery" checked>
                                            <label class="custom-control-label" for="check_status_gallery">Activo (Las galerias inactivas no son visibles en la página)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mx-auto mb-2">
                                        <a data-toggle="modal" data-target="#modal_save_gallery" href="#" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('edit_video') ? 'show active' : null) ?>" id="pills_video_list" role="tabpanel" aria-labelledby="tab_video_view">
                            <div class="table-responsive">
                                <table id="table_1" class="display table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titulo</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
                                            <th>URL</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($videos as $video) : ?>
                                            <tr>
                                                <th scope="row"> <?= $video['video_title'] ?></th>
                                                <td><?= $video['video_description'] ?></td>
                                                <td><?= substr($video['video_date'], 8) . "/" . substr($video['video_date'], 5, -3) . "/" . substr($video['video_date'], 0, -6); ?></td>
                                                <td><a href="<?= $video['video_url'] ?>" target="_BLANK"><?= $video['video_url'] ?></a></td>
                                                <td><?= ($video['video_status'] == 0 ? 'Activo' : 'Inactivo') ?></td>
                                                <td>
                                                    <button onclick='modal_edit(<?= json_encode($video) ?>)' data-toggle="modal" data-target="#modal_edit" type="button" class="btn btn-primary py-2 px-3"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Titulo</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
                                            <th>URL</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (session()->get('add_video') ? 'show active' : null) ?>" id="pills_video_add" role="tabpanel" aria-labelledby="tab_video_add">
                            <form id="form-video" class="text-center p-2 px-4" action="/administrar-galeria" method="post">
                                <input type="hidden" name="from_to" value="video">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" name="video_title" class="form-control mb-4" maxlength="50" required placeholder="Título" value="<?= set_value('video_title') ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <input id="video_date" data-provide="datepicker" name="video_date" class="form-control mb-4" placeholder="Fecha" value="<?= set_value('video_date') ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <input type="url" name="video_url" class="form-control mb-4" required maxlength="500" placeholder="URL del video" value="<?= set_value('video_url') ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label require class="text-left" for="video_description">Descripción</label>
                                            <textarea class="form-control rounded-0" maxlength="500" name="video_description" id="video_description" rows="4"><?= set_value('video_description') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="video_status" id="check_status" <?= (session()->get('add_video') ? (set_value('video_status') ? 'checked' : null) : 'checked') ?>>
                                            <label class="custom-control-label" for="check_status">Activo (Los videos inactivos no son visibles en la galeria)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mx-auto mb-2">
                                        <a data-toggle="modal" data-target="#modal_save_video" href="#" class="btn btn-info btn-rounded waves-effect text-white btn-block">Agregar</a>
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
<div class="modal fade" id="modal_save_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <p class=" h5 mt-3 ">¿Desea Guardar la nueva galeria?</p>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="$('#form-gallery').submit()" class="btn btn-info btn-rounded waves-effect text-white">Guardar</a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moda Confirm Save -->
<div class="modal fade" id="modal_save_video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <p class=" h5 mt-3 ">¿Desea Guardar el nuevo video?</p>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="$('#form-video').submit()" class="btn btn-info btn-rounded waves-effect text-white">Guardar</a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Central Modal Edit Gallery -->
<div class="modal fade" id="modal_edit_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h5" id="exampleModalLongTitle">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="text-center p-2 px-4">
                    <input type="hidden" id="modal_gallery_id">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" id="modal_gallery_title" class="form-control mb-4" maxlength="50" required placeholder="Titulo" value="<?= set_value('gallery_title') ?>">
                        </div>

                        <div class="col-md-3">
                            <input id="modal_gallery_date" data-provide="datepicker" class="form-control mb-4" placeholder="Fecha" value="<?= set_value('gallery_date') ?>">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label require class="text-left" for="modal_gallery_description">Descripción</label>
                                <textarea class="form-control rounded-0" maxlength="500" id="modal_gallery_description" rows="3"><?= set_value('gallery_description') ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="modal_gallery_check_status" checked>
                                <label class="custom-control-label" for="modal_gallery_check_status">Activo (Las galerias inactivas no son visibles en la página)</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" id="error_update_gallery" style="display: none;" role="alert">
                        <div style="color: #ff3547;" id="errors_messages_gallery"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="row">
                    <div class=" col-md-6 ">
                        <a href="#" onclick="update_gallery()" class="btn btn-primary btn-rounded waves-effect text-white">Actualizar</a>
                    </div>
                    <div class=" col-md-6 ">
                        <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Central Modal Edit Video -->
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
                <form class="text-center p-2 px-4">
                    <input type="hidden" id="modal_id">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" id="modal_title" class="form-control mb-4" maxlength="50" required placeholder="Título">
                        </div>

                        <div class="col-md-3">
                            <input id="modal_date" data-provide="datepicker" id="video_date" class="form-control mb-4" placeholder="Fecha">
                        </div>

                        <div class="col-md-12">
                            <input type="url" id="modal_url" class="form-control mb-4" required maxlength="500" placeholder="URL del video">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label require class="text-left" for="modal_description">Descripción</label>
                                <textarea class="form-control rounded-0" maxlength="500" id="modal_description" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="modal_status">
                                <label class="custom-control-label" for="modal_status">Activo (Los videos inactivos no son visibles en la galeria)</label>
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
                        <a href="#" onclick="update_video()" class="btn btn-primary btn-rounded waves-effect text-white">Actualizar</a>
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
<script type="text/javascript" src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.es.min.js"></script>
<script>
    $('#gallery_date').datepicker({
        language: 'es'
    });

    $('#video_date').datepicker({
        language: 'es'
    });

    $('#modal_gallery_date').datepicker({
        language: 'es'
    });

    $('#modal_date').datepicker({
        language: 'es'
    });

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

    function modal_edit_gallery(gallery) {
        var gallery_date = gallery.gallery_date.substring(8, 10) + '/' + gallery.gallery_date.substring(5, 7) + '/' + gallery.gallery_date.substring(0, 4);

        $('#modal_gallery_id').val(gallery.gallery_id);
        $('#modal_gallery_title').val(gallery.gallery_title);
        $('#modal_gallery_date').val(gallery_date);
        $('#modal_gallery_description').val(gallery.gallery_description);

        if (gallery.gallery_status == 0) {
            $('#modal_gallery_check_status').prop("checked", "checked");
        } else {
            $('#modal_gallery_check_status').prop("checked", "");
        }
    }

    function modal_edit(video) {
        var video_date = video.video_date.substring(8, 10) + '/' + video.video_date.substring(5, 7) + '/' + video.video_date.substring(0, 4);

        $('#modal_id').val(video.video_id);
        $('#modal_title').val(video.video_title);
        $('#modal_date').val(video_date);
        $('#modal_url').val(video.video_url);
        $('#modal_description').val(video.video_description);

        if (video.video_status == 0) {
            $('#modal_status').prop("checked", "checked");
        } else {
            $('#modal_status').prop("checked", "");
        }
    }

    function update_gallery() {
        var from_to = 'gallery';
        var gallery_id = $('#modal_gallery_id').val();
        var gallery_title = $('#modal_gallery_title').val();
        var gallery_date = $('#modal_gallery_date').val();
        var gallery_description = $('#modal_gallery_description').val();
        var gallery_status = ($('#modal_gallery_check_status').prop("checked") ? 0 : 1);

        $('#messages').empty();
        $('#errors_messages_gallery').empty();

        $.ajax({
            type: "POST",
            url: "administrar-galeria",
            data: {
                from_to,
                gallery_id,
                gallery_title,
                gallery_date,
                gallery_description,
                gallery_status
            },
            success: function(o) {
                if (o.success) {
                    location.reload();
                } else {
                    $('#error_update_gallery').css('display', 'inline');
                    $('#errors_messages_gallery').empty();
                    $.each(o.validation, function(index, value) {
                        $('#errors_messages_gallery').append('<b>' + value + '<b><br>');
                    });
                }
            },
            dataType: "json"
        });
    }

    function update_video() {
        var from_to = 'video';
        var video_id = $('#modal_id').val();
        var video_title = $('#modal_title').val();
        var video_date = $('#modal_date').val();
        var video_url = $('#modal_url').val();
        var video_description = $('#modal_description').val();
        var video_status = ($('#modal_status').prop("checked") ? 0 : 1);

        $('#messages').empty();
        $('#errors_messages').empty();

        $.ajax({
            type: "POST",
            url: "administrar-galeria",
            data: {
                from_to,
                video_id,
                video_title,
                video_date,
                video_url,
                video_description,
                video_status
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

    function delete_image(image_id) {
        if (confirm('¿Esta seguro que desea eliminar la imagen seleccionada?')) {
            var from_to = 'delete_image';

            $.ajax({
                type: "POST",
                url: "administrar-galeria",
                data: {
                    from_to,
                    image_id
                },
                success: function(o) {
                    location.reload();
                },
                dataType: "json"
            });
        } else {
            console.log('Cancel');
        }
    }
</script>
<?= $this->endSection() ?>