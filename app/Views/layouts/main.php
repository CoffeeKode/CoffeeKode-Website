<!DOCTYPE html>
<html lang="es-cl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $this->renderSection('page_title'); ?></title>

    <!-- MDB icon -->
    <link rel="icon" href="/assets/img/icon.png" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/fontawesome-free-5.13.0/css/all.min.css">
    <!-- Fonst Css-->
    <link rel="stylesheet" href="/assets/css/font-custom.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="/assets/css/mdb.min.css">
    <!-- Your custom styles  -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/social-bar.css">
    <link rel="stylesheet" href="/assets/css/input-number.css">
    <?= ($sidebar ? '<link rel="stylesheet" href="/assets/css/simple-sidebar.css">' : null); ?>

    <?= $this->renderSection('css'); ?>
</head>

<body>
    <?= ($sidebar ? $this->include('layouts/sidebar') : null); ?>
    <?= $this->include('layouts/navbar'); ?>
    <main>
        <?= $this->renderSection('page_content'); ?>
    </main>
    <?= ($sidebar ? $this->include('layouts/close_sidebar') : null); ?>
    <?= $this->include('layouts/footer'); ?>


    <!-- Central Modal LogOut -->
    <div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-md" role="document">
            <!--Content-->
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h5" id="exampleModalLongTitle">Cerrar sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-exclamation-circle fa-4x animated zoomIn text-danger"></i>
                        <p class="h5 mt-3">Esta seguro de abandonar esta pagina</p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= base_url('/logout') ?>" class="btn btn-red btn-rounded waves-effect text-white">
                            <i class="mr-2 fas fa-sign-out-alt text-white "></i>Salir
                                
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" data-dismiss="modal" class="btn btn-outline-green btn-rounded waves-effect">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- ./Central Modal LogOut-->

    <!-- jQuery -->
    <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/assets/js/mdb.min.js"></script>
    <!-- Your custom scripts (optional) -->
    <script type="text/javascript" src="/assets/js/custom.js"></script>
    <?= ($sidebar ? ' <script type="text/javascript" src="/assets/js/sidebar.js"></script>' : null); ?>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>