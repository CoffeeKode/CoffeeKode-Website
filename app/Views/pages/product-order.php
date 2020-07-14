<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas polo
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<section class="bg-blue-grey">
    <h1 class="pt-5 h1-responsive text-center font-weight-bold mb-4">Orden de Compra #<?= $order['order_id'] ?></h1>


    <div class="container mx-auto pb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-success col-md-8 mx-auto mb-4" style="text-align: center;" role="alert">
                    <?php if (session()->get('success')) : ?>
                        <b> <?= session()->get('success') ?></b>
                    <?php else : ?>
                        <b><em>Estado Actual: <?= $order['status_name'] ?></em></b>
                    <?php endif; ?>
                </div>
            </div>

            <!--Datos del comprador-->
            <div class="col-md-5 card">

                <h3 class="h3 mb-3 pl-4 mt-4">Información del comprador</h3>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <p class="mb-1"><strong>Rut:</strong> <?= $order['order_client_rut'] ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Nombre-->
                        </p>
                    </li>
                    <li class="list-group-item">
                        <p class="mb-1"><strong>Nombre:</strong> <?= $order['order_client_fullname'] ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Nombre-->
                        </p>
                    </li>
                    <li class="list-group-item">
                        <p class="mb-1"><strong>Correo electrónico:</strong> <?= $order['order_client_email'] ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte E-mail -->
                        </p>
                    </li>
                    <li class="list-group-item">
                        <p class="mb-1"><strong>Teléfono:</strong> <?= $order['order_client_phone'] ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Teléfono-->
                        </p>
                    </li>
                </ul>

            </div>
            <!-- ./Datos del comprador-->
            <!--Datos del envio-->
            <div class="col-md-5 card">

                <h3 class="h3 mb-3 pl-4 mt-4">Información de envío</h3>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <p class="mb-1"><strong>Tipo de envío: </strong><?= ($order['order_store'] == 1 ? 'Envio a domicilio' : 'Retiro en tienda') ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Tipo de envío-->
                        </p>
                    </li>
                    <li class="list-group-item">
                        <p class="mb-1"><strong><?= ($order['order_store'] == 1 ? 'Region' : 'Tienda') ?>: </strong><?= ($order['order_store'] == 1 ? $order['client_region_name'] : $order['store_name']) ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Región-->
                        </p>
                    </li>
                    <li class="list-group-item">
                        <p class="mb-1"><strong><?= ($order['order_store'] == 1 ? 'Comuna' : 'Dirección') ?>: </strong><?= ($order['order_store'] == 1 ? $order['client_commune_name'] : $order['store_address'] . ", " . $order['store_commune_name'] . ", " . $order['store_region_name']) ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Comuna-->
                        </p>
                    </li>
                    <li class="list-group-item">
                        <p class="mb-1"><strong><?= ($order['order_store'] == 1 ? 'Dirección' : 'Teléfono Contacto:') ?> </strong><?= ($order['order_store'] == 1 ? $order['order_client_address'] : $order['store_phone']) ?></p>
                        <p class="mb-0 text-muted">
                            <!--Inserte Dirección-->
                        </p>
                    </li>
                </ul>
            </div>

            <div class="col-md-10 card">
                <!--Datos de la compra-->
                <h3 class="h3 mb-3 pl-4 mt-4">Detalle de compra</h3>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table table-striped">

                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>Ítem</th>
                                <th>Producto</th>
                                <th>Formato</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <!--Table head-->

                        <!--Table body-->
                        <tbody>
                            <?php $num = 1; ?>
                            <?php foreach ($order_details as $detail) : ?>
                                <tr>
                                    <td><b><?= $num++ ?></b></td>
                                    <td><?= $detail['detail_format_title']; ?></td>
                                    <td><?= $detail['detail_format_weight']; ?></td>
                                    <td>$<?= number_format($detail['detail_format_amount'], 0, '', '.'); ?></td>
                                    <td><?= $detail['detail_format_quantity']; ?></td>
                                    <td>$<?= number_format(($detail['detail_format_amount'] * $detail['detail_format_quantity']), 0, '', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align: right;"><b>Total:</b></th>
                                <th><b>$<?= number_format($order['order_amount'], 0, '', '.'); ?></b></th>
                            </tr>
                        </tfoot>

                        <!--Table body-->


                    </table>
                    <!--Table-->
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>