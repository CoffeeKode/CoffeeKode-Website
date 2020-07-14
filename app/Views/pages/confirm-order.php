<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Confirmar Orden de Compra
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .errors li {
        list-style: none;
        width: 100%;
        text-align: center;
    }

    .errors ul {
        padding-left: 0;
        margin-bottom: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<section class="container py-5">
    <h1 class=" text-center h1-responsive font-weight-bold mb-4">Confirmar Orden de Compra</h1>

    <form action="/confirmar-orden" method="post" class="row d-flex justify-content-center">
        <?php if (isset($validation)) : ?>
            <div class="col-md-8 mx-auto">
                <div class="alert alert-danger mb-4" role="alert">
                    <?= $validation->listErrors() ?>
                </div>
            </div>
        <?php endif; ?>
        <!--Login Guest-->
        <div class="col-md-5 card">
            <div class="text-center pt-5 p-4" action="/invited" method="post">
                <p class="h4 mb-4">Datos del Cliente</p>
                <!-- Rut -->
                <input type="text" name="order_client_rut" id="rut" class="form-control mb-4" placeholder="Rut" required value="<?= (session()->get('invited_rut') ? session()->get('invited_rut') : (session('user') ? array_values(session('user'))[0]['user_rut'] : null)) ?>" oninput="checkRut(this)">
                <!-- Name -->
                <input type="text" name="order_client_fullname" class="form-control mb-4" placeholder="Nombre" required value="<?= (session()->get('invited_name') ? session()->get('invited_name') : (session('user') ? ucwords(mb_strtolower(array_values(session('user'))[0]['user_fullname'])) : null)) ?>">
                <!-- E-mail -->
                <input type="email" name="order_client_email" class="form-control mb-4" placeholder="Correo Electrónico" required value="<?= (session()->get('invited_email') ? session()->get('invited_email') : (session('user') ? array_values(session('user'))[0]['user_email'] : null)) ?>">
                <!-- Phone number -->
                <input type="tel" name="order_client_phone" class="form-control mb-4" placeholder="Numero telefonico" required value="<?= (session()->get('invited_phone') ? session()->get('invited_phone') : (session('user') ? array_values(session('user'))[0]['user_phone'] : null)) ?>">
            </div>
        </div>
        <!--./Login Guest-->

        <div class="col-md-5 card">
            <div class="text-center pt-5 p-4" action="/invited" method="post">
                <p class="h4 mb-4">Datos de Envío</p>
                <div>
                    <div class="form-check form-check-inline">
                        <input onclick="load_option(1)" class="form-check-input" type="radio" name="radio_option" <?= (set_value('radio_option') ? (set_value('radio_option') == 'store' ? 'checked' : null) : 'checked') ?> id="inlineRadio1" value="store">
                        <label class="form-check-label" for="inlineRadio1">Retiro en Tienda</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input onclick="load_option(2)" class="form-check-input" type="radio" name="radio_option" <?= (set_value('radio_option') ? (set_value('radio_option') == 'delivery' ? 'checked' : null) : null) ?> id="inlineRadio2" value="delivery">
                        <label class="form-check-label" for="inlineRadio2">Envio a Domicilio</label>
                    </div>
                </div>
                <div class="mt-4">
                    <div id="div_store" <?= (set_value('radio_option') ? (set_value('radio_option') != 'store' ? "style='display: none;'" : null) : null) ?>>
                        <select name="order_store" id="select_store" class="custom-select mb-4" onchange="load_store()">
                            <?php foreach ($stores as $store) : ?>
                                <option <?= (set_value('order_store') ? (set_value('order_store') == $store['store_id'] ? 'selected' : null) : ($store['store_id'] == 1 ? 'selected disabled' : null)) ?> value="<?= $store['store_id'] ?>"><?= ($store['store_id'] != 1 ? $store['store_name'] . " - " . $store['commune_name'] : $store['store_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <table id="table_store" <?= (!set_value('order_store') ? "style='display: none;'" : null) ?> class="table">
                            <tbody style="text-align: left;">
                                <tr>
                                    <th scope="row"><b>Dirección:</b></th>
                                    <td id="store_address"><?= set_value('field_address') ?></td>
                                    <input style="display: none;" name="field_address" id="field_address" value="<?= set_value('field_address') ?>">
                                </tr>
                                <tr>
                                    <th style="text-align: left;" scope="row"><b>Telefono Contacto:</b></th>
                                    <td id="store_phone"><?= set_value('field_phone') ?></td>
                                    <input style="display: none;" name="field_phone" id="field_phone" value="<?= set_value('field_phone') ?>">
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="div_delivery" <?= (set_value('radio_option') ? (set_value('radio_option') != 'delivery' ? "style='display: none;'" : null) : "style='display: none;'") ?>>
                        <select name="select_region" id="select_region" class="custom-select mb-4" onchange="load_commune()">
                            <option disabled <?= (!session('user') && !set_value('select_region') ? 'selected' : null) ?>>Selecciona tu region</option>
                            <?php foreach ($regions as $region) : ?>
                                <option <?= (set_value('select_region') ? (set_value('select_region') == $region['region_id'] ? 'selected' : null) : (session('user') ? ($region['region_id'] == array_values(session('user'))[0]['user_region'] ? 'selected' : null) : null)) ?> value="<?= $region['region_id'] ?>"><?= $region['region_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="order_client_commune" id="select_commune" class="custom-select mb-4">
                            <option disabled <?= (!session('user') && !set_value('order_client_commune') ? 'selected' : null) ?>>Selecciona tu comuna</option>
                            <?php foreach ($communes as $commune) : ?>
                                <?php if ($commune['province_region'] == (set_value('select_region') ? set_value('select_region') : (session('user') ? array_values(session('user'))[0]['user_region'] : null))) : ?>
                                    <option <?= (set_value('order_client_commune') ? (set_value('order_client_commune') == $commune['commune_id'] ? 'selected' : null) : (session('user') ? ($commune['commune_id'] == array_values(session('user'))[0]['user_commune'] ? 'selected' : null) : null)) ?> value="<?= $commune['commune_id'] ?>"><?= $commune['commune_name'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <input type="address" name="order_client_address" id="delivery_address" class="form-control mb-4" placeholder="Domicilio" value="<?= (set_value('order_client_address') ? set_value('order_client_address') : (session('user') ? array_values(session('user'))[0]['user_address'] : null)) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10 card">
            <!--Datos de la compra-->
            <div class="text-center pt-5 p-4" action="/invited" method="post">

                <p class="h4 mb-4">Detalle de la Compra</p>
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
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td><b><?= $num++ ?></b></td>
                                    <td><?= $item['item_format_title']; ?></td>
                                    <td><?= $item['item_format_weight']; ?></td>
                                    <td>$<?= number_format($item['item_format_price'], 0, '', '.'); ?></td>
                                    <td><?= $item['item_quantity']; ?></td>
                                    <td>$<?= number_format(($item['item_format_price'] * $item['item_quantity']), 0, '', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align: right;"><b>Total:</b></th>
                                <th><b>$<?= number_format($total, 0, '', '.'); ?></b></th>
                                <input style="display: none;" name="order_amount" value="<?= $total ?>">
                            </tr>
                        </tfoot>

                        <!--Table body-->
                    </table>
                    <!--Table-->
                </div>
            </div>
        </div>
        <div class="mx-auto mt-2">
            <a href="<?= base_url('comprar') ?>" class="btn btn-rounded btn-outline-amber waves-effect"><i class="fas fa-angle-double-left mr-2"></i> Volver al Carrito</a>
        </div>
        <div class="mx-auto mt-2">
            <button type="submit" class="btn btn-amber btn-rounded waves-effect">Confirmar Compra <i class="fas fa-angle-double-right ml-2"></i></button>
        </div>
    </form>


</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/assets/vendor/jquery.rut/jquery.rut.js"></script>

<script>
    $(document).ready(function() {
        $("input#rut").rut({
            formatOn: 'keyup',
            minimumLength: 8,
            validateOn: 'change keyup',
            useThousandsSeparator: false
        });
    });

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

    function load_store() {
        var store_id = $('#select_store').val();

        if (store_id != 1) {
            $("#table_store").css("display", "");
        } else {
            $("#table_store").css("display", "none");

        }

        $.getJSON('get_store', function(result) {
            $.each(result, function(index, value) {
                if (store_id == value.store_id) {
                    document.getElementById("store_address").innerHTML = value.store_address + " - " + value.commune_name;
                    $('#field_address').val(value.store_address + " - " + value.commune_name);
                    document.getElementById("store_phone").innerHTML = value.store_phone;
                    $('#field_phone').val(value.store_phone);
                }
            });
        });
    }

    function load_option(num) {

        if (num == 1) {
            $("#div_store").css("display", "");
            $("#div_delivery").css("display", "none");
            $("#delivery_address").prop('required', false);
        } else {
            $("#div_store").css("display", "none");
            $("#div_delivery").css("display", "");
            $("#delivery_address").prop('required', true);
        }
    }

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

    // -----------------------------------------------------------------------------
</script>
<?= $this->endSection() ?>