<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Administrar Pedidos
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
                    Administración de Pedidos
                </div>

                <div id="messages" class="col-8 mt-2 mx-auto text-center">
                    <?php if (session()->get('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->get('success') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tabOrdersCompleted" data-toggle="pill" href="#pillsOrdersCompleted" role="tab" aria-controls="pillsOrdersCompleted" aria-selected="true">Realizados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabOrdersPending" data-toggle="pill" href="#pillsOrdersPending" role="tab" aria-controls="pillsOrdersPending" aria-selected="false">Pendientes</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabContentPills">
                        <div class="tab-pane fade show active" id="pillsOrdersCompleted" role="tabpanel" aria-labelledby="tabOrdersCompleted">
                            <div class="table-responsive">
                                <table id="table_1" class="display table-hover">
                                    <thead>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Tipo Envio</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order) : ?>
                                            <?php if ($order['order_status'] == 3) : ?>
                                                <tr>
                                                    <th scope="row"><a href="<?= base_url('orden/detalle/' . $order['order_id']) ?>" target="_BLANK" class="text-info"><?= $order['order_id'] ?></a></th>
                                                    <?php $month = substr($order['order_date'], 5, -3) ?>
                                                    <td><?= substr($order['order_date'], 8) . "/" . substr($order['order_date'], 5, -3) . "/" . substr($order['order_date'], 0, -6); ?></td>
                                                    <td>$<?= number_format($order['order_amount'], 0, '', '.') ?></td>
                                                    <td><?= ($order['order_store'] == 1 ? 'Envío a domicilio' : 'Retiro en tienda') ?></td>
                                                    <td><?= ucwords(mb_strtolower($order['status_name'])) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Tipo Envio</th>
                                            <th>Estado</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pillsOrdersPending" role="tabpanel" aria-labelledby="tabOrdersPending">
                            <div class="table-responsive text-nowrap">
                                <table id="table_2" class="display table-hover">
                                    <thead>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Tipo Envio</th>
                                            <th>Estado</th>
                                            <th>Cambiar Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order) : ?>
                                            <?php if ($order['order_status'] != 3) : ?>
                                                <tr>
                                                    <th scope="row"><a href="<?= base_url('orden/detalle/' . $order['order_id']) ?>" target="_BLANK" class="text-info"><?= $order['order_id'] ?></a></th>
                                                    <?php $month = substr($order['order_date'], 5, -3) ?>
                                                    <td><?= substr($order['order_date'], 8) . "/" . substr($order['order_date'], 5, -3) . "/" . substr($order['order_date'], 0, -6); ?></td>
                                                    <td>$<?= number_format($order['order_amount'], 0, '', '.') ?></td>
                                                    <td><?= ($order['order_store'] == 1 ? 'Envío a domicilio' : 'Retiro en tienda') ?></td>
                                                    <td id="status-<?= $order['order_id'] ?>"><?= ucwords(mb_strtolower($order['status_name'])) ?></td>
                                                    <td><a data-toggle="modal" data-target="#modal_status" href="#" onclick="load_status(<?= $order['order_id'] ?>, <?= $order['order_status'] ?>)"><i class="fas fa-sync-alt"></i> Cambiar Estado</a></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Tipo Envio</th>
                                            <th>Estado</th>
                                            <th>Cambiar Estado</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moda Change Password -->
<div class="modal fade" id="modal_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="status_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <div class="md-form mb-1">
                            <input style="display: none;" name="order_id" id="order_id">
                            <select name="order_status" id="order_status" class="custom-select mb-1">
                                <option disabled>Selecciona un estado</option>
                                <?php foreach ($status as $stus) : ?>
                                    <option value="<?= $stus['status_id'] ?>"><?= $stus['status_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <div class="row">
                        <div class=" col-md-6 ">
                            <a href="#" onclick="change_status()" class="btn btn-cyan btn-rounded waves-effect text-white">Cambiar</a>
                        </div>
                        <div class=" col-md-6 ">
                            <a href="#" data-dismiss="modal" class="btn btn-outline-info btn-rounded waves-effect">Cancelar</a>

                        </div>
                    </div>
                </div>
            </form>
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

    function load_status(order, status) {
        document.getElementById("status_title").innerHTML = 'Cambiar Estado de orden #' + order;
        $("#order_id").val(order);
        $("#order_status").val(status);
    }

    function change_status() {
        var order_id = $("#order_id").val();
        var order_status = $("#order_status").val();
        var status_name = $("#order_status option:selected").text();

        $.ajax({
            type: "POST",
            url: "change_status",
            data: {
                order_id,
                order_status,
            },
            success: function(o) {
                if (o.success) {
                    if (order_status == 3) {
                        location.reload();
                    } else {
                        $('#modal_status').modal('hide');
                        $('#status-' + order_id).empty();
                        $('#status-' + order_id).append(status_name);
                        $('#messages').empty();
                        $('#messages').append("<div class='alert alert-success' role='alert'>Orden #" + order_id + " cambiada a \"" + status_name + "\"</div>");

                    }
                }
            },
            dataType: "json"
        });
    }
</script>
<?= $this->endSection() ?>