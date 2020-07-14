<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Productos Polo - Galería
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="/assets/css/ekko-lightbox.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>

<section id="page-gallery">
    <div class="container py-5">
        <h1 class="text-center display-4 mx-auto font-weight-bold mb-4 pb-2 font-ds-bold">Galería</h1>

        <div class="row justify-content-center">
            <div class="col-md-2">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-photos-tab" data-toggle="pill" href="#pills-photos" role="tab" aria-controls="pills-photos" aria-selected="true">Fotos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-videos-tab" data-toggle="pill" href="#pills-videos" role="tab" aria-controls="pills-videos" aria-selected="false">Videos</a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="tab-content" id="pills-tabContent">
            <!--Tab Photos-->
            <div class="tab-pane fade show active" id="pills-photos" role="tabpanel" aria-labelledby="pills-photos-tab">
                <div class="row">
                    <?php foreach ($gallerys as $gallery) : ?>
                        <?php $image_path = get_image($images, $gallery['gallery_id'], 1) ?>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="view overlay">
                                    <img class="card-img-top" src="/assets/img/gallery/<?= $image_path ?>" alt="Card image cap">
                                    <a href="/assets/img/gallery/<?= $image_path ?>" data-toggle="lightbox" data-gallery="gallery-<?= $gallery['gallery_id'] ?>" data-max-width="1000" data-title="<?= $gallery['gallery_title'] ?>" data-footer="<?= format_date($gallery['gallery_date']) ?>" data-max-width="600" data-max-height="600">
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?= $gallery['gallery_title'] ?></h4>
                                    <p class="card-text"><?= $gallery['gallery_description'] ?></p>
                                </div>
                                <div class="amber darken-2 text-white card-footer p-0">
                                    <p class="text-right p-2 my-0"><i class="far fa-clock mr-2"></i><?= format_date($gallery['gallery_date'])  ?></p>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;">
                            <?php foreach ($images as $image) : ?>
                                <?php if ($image['image_gallery'] == $gallery['gallery_id'] && $image['image_path'] != $image_path) : ?>
                                    <a href="/assets/img/gallery/<?= $image['image_path'] ?>" data-toggle="lightbox" data-gallery="gallery-<?= $image['image_gallery'] ?>" data-max-width="1000" data-title="<?= $gallery['gallery_title'] ?>" data-footer="<?= format_date($gallery['gallery_date']) ?>" data-max-width="600" data-max-height="600">
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--./Tab Photos-->

            <!-- Tab Videos -->
            <div class="tab-pane fade" id="pills-videos" role="tabpanel" aria-labelledby="pills-videos-tab">
                <div class="row">
                    <?php foreach ($videos as $video) : ?>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="view overlay">
                                    <div class="card-img-top embed-responsive embed-responsive-4by3">
                                        <iframe class="embed-responsive-item" src="<?= $video['video_url'] ?>" allowfullscreen></iframe>
                                    </div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?= $video['video_title'] ?></h4>
                                    <p class="card-text"><?= $video['video_description'] ?></p>
                                </div>
                                <div class="amber darken-2 text-white card-footer p-0">
                                    <p class="text-right p-2 my-0"><i class="far fa-clock mr-2"></i><?= format_date($video['video_date']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- ./Tab Videos -->
        </div>
    </div>

</section>

<?php
function get_image($images, $image_gallery, $type)
{
    foreach ($images as $image) {
        if ($image['image_gallery'] == $image_gallery) {
            if ($type == 1) {
                return $image['image_path'];
            }
            return $image['image_title'];
        }
    }
    return NULL;
}

function format_date($date)
{
    return substr($date, 8) . "/" . substr($date, 5, -3) . "/" . substr($date, 0, -6);
}
?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/assets/js/ekko-lightbox.min.js"></script>

<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
<?= $this->endSection() ?>