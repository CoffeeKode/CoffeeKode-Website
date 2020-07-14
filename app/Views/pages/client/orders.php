<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Mis Pedidos
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="container tab-pane fade show">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header white-text default-color">
                    Mis Pedidos
                </div>

                <div class="card-body table-responsive">
                    <table id="table_1" class="display">
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
    });
</script>
<?= $this->endSection() ?>