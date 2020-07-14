<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Productos Polo - Miel 100% Natural
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<section class="mt-2 pt-3">
    <?php if (session('cart')) : ?>
        <h2 class="h2-responsive text-center font-ds-bold">Nuestros productos</h2>
        <section>
            <div class="container-fluid px-4 table-wrapper-scroll-y my-custom-scrollbar mb-5">
                <!-- Shopping Cart table -->
                <?php if (session()->get('error')) : ?>
                    <div class="alert alert-danger col-md-10 mx-auto mb-4" style="text-align: center;" role="alert">
                        <b> <?= session()->get('error') ?></b>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table  table-striped mb-0">
                        <!-- Table head -->
                        <thead>
                            <tr>
                                <th>
                                    <!--Img-->
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Producto</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Formato</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Precio</strong>
                                </th>
                                <th class="font-weight-bold text-center">
                                    <strong>Cantidad</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Total</strong>
                                </th>
                                <th>
                                    <!--Btn Delete-->
                                </th>
                            </tr>
                        </thead>
                        <!-- Table head -->
                        <!-- Table body -->
                        <tbody>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <th scope="row" class="col-3">
                                        <img src="/assets/img/products/<?= $item['item_img_path']; ?>" alt="" class="img-fluid z-depth-0">
                                    </th>
                                    <td>
                                        <h5><strong><?= $item['item_format_title']; ?></strong></h5>
                                        <!-- <p class="text-muted">Colmenas Polo</p> -->
                                    </td>
                                    <td><?= $item['item_format_weight']; ?></td>
                                    <td>$<?= number_format($item['item_format_price'], 0, '', '.'); ?></td>
                                    <th class="px-0 mt-0 col-1">
                                        <div id="item-<?= $item['item_format_id'] ?>" class="input-group">
                                            <div class="input-group-prepend">
                                                <button onclick="change_quantity(-1, <?= $item['item_format_id'] ?>)" class="quantity-left-minus btn-number btn btn-md btn-outline-amber-1 m-0 px-2 z-depth-0 waves-effect" type="button" data-type="minus" id="button-addon1"><i class="fas fa-minus"></i></button>
                                            </div>
                                            <input style="display: none;" id="old-quantity-<?= $item['item_format_id'] ?>" value="<?= $item['item_quantity']; ?>">
                                            <input style="display: none;" id="max-quantity-<?= $item['item_format_id'] ?>" value="<?= $item['item_format_stock']; ?>">
                                            <input type="text" id="quantity-<?= $item['item_format_id'] ?>" name="quantity" onchange="change_quantity(0, <?= $item['item_format_id'] ?>)" class="form-control input-number text-center px-0 mx-0" value="<?= $item['item_quantity']; ?>">
                                            <div class="input-group-prepend">
                                                <button onclick="change_quantity(1, <?= $item['item_format_id'] ?>)" class="btn btn-md btn-outline-amber-1 m-0 px-2 z-depth-0 waves-effect quantity-right-plus btn-number" type="button" data-type="plus"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </th>
                                    <input type="text" id="price-<?= $item['item_format_id'] ?>" style="display: none;" value="<?= $item['item_format_price']; ?>">
                                    <td class="font-weight-bold"><strong id="total_item-<?= $item['item_format_id'] ?>">$<?= number_format(($item['item_format_price'] * $item['item_quantity']), 0, '', '.'); ?></strong></td>
                                    <td>
                                        <form action="/remove_item" method="post">
                                            <input type="text" name="format_id" style="display: none;" value="<?= $item['item_format_id']; ?>">
                                            <button type="submit" class="btn btn-md btn-danger m-0" data-toggle="tooltip" data-placement="top">
                                                <i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="1"></td>
                                <td>
                                    <h4 class="mt-2">
                                        <strong>Total</strong>
                                    </h4>
                                </td>
                                <td colspan="2" class="text-right">
                                    <h4 class="mt-2">
                                        <input type="text" id="total_cart_input" style="display: none;" value="<?= $total ?>">
                                        <strong id="total_cart">$<?= number_format($total, 0, '', '.') ?></strong>
                                    </h4>
                                </td>
                                <td colspan="3" class="mr-auto">
                                    <a href="<?= base_url('confirmar-cliente') ?>" class="btn btn-amber btn-rounded waves-effect">Completar compra</a>
                                </td>
                            </tr>
                            <!-- Fourth row -->


                        </tbody>
                        <!-- Table body -->
                    </table>
                </div>
                <!-- Shopping Cart table -->
            </div>
        </section>
    <?php else : ?>
        <div class="container py-0 my-0 hv-100">
            <div class="row d-flex justify-content-center">

                <div class="col-md-12">
                    <h2 class="h2-responsive font-ds-bold text-center">Tu Bolsa de Compras está vacía.</h2>
                    <a href="<?= base_url('#products') ?>">
                        <h3 class="h3-responsive font-ds-bold mt-3 text-center">Agrega productos ahora</h3>
                    </a>
                </div>

                <div class="col-4">
                    <img src="/assets/img/bag-sad.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    <?php endif; ?>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function change_quantity(value, ref) {
        var quantity = parseInt($('#quantity-' + ref).val()) + parseInt(value);
        var max_quantity = $('#max-quantity-' + ref).val();
        if (quantity > 0 && quantity <= max_quantity) {
            var old_quantity = $('#old-quantity-' + ref).val();
            var total = parseInt($('#price-' + ref).val()) * parseInt(quantity)
            var orginal_total = $('#total_item-' + ref).text().replace(/\./g, "").replace(/\$/g, "");
            var total_cart = parseInt($('#total_cart_input').val());
            var carrito = $('#carrito_value').text();
            var cart_quantity = parseInt(carrito) + parseInt(quantity) - parseInt(old_quantity);

            if (parseInt(total) > parseInt(orginal_total)) {
                total_cart += parseInt($('#price-' + ref).val());
            } else if (parseInt(total) < parseInt(orginal_total)) {
                total_cart -= parseInt($('#price-' + ref).val());
            }

            $('#carrito_value').text(cart_quantity);
            $('#old-quantity-' + ref).val(quantity);
            $('#quantity-' + ref).val(quantity);
            $('#total_cart_input').val(total_cart);
            $('#total_item-' + ref).text(formatNumber.new(total, "$"));
            $('#total_cart').text(formatNumber.new(total_cart, "$"));

            $.ajax({
                type: "POST",
                url: "update_item",
                data: {
                    format_id: ref,
                    quantity: quantity,
                },
                success: function(o) {

                },
                dataType: "json"
            });
        }
    }

    var formatNumber = {
        separador: ".",
        sepDecimal: ',',
        formatear: function(num) {
            num += '';
            var splitStr = num.split('.');
            var splitLeft = splitStr[0];
            var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
            var regx = /(\d+)(\d{3})/;
            while (regx.test(splitLeft)) {
                splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
            }
            return this.simbol + splitLeft + splitRight;
        },
        new: function(num, simbol) {
            this.simbol = simbol || '';
            return this.formatear(num);
        }
    }
</script>
<?= $this->endSection() ?>