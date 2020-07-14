<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Productos Polo - <?= $product['product_title'] ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<section class="text-center p-5 my-2 ">
  <!-- Section heading -->
  <h1 class="h1-responsive font-weight-bold mb-4"><?= $product['product_title'] ?></h1>

  <!--row-->
  <div class="row">
    <?php foreach ($formats_product as $format) : ?>
      <div <?= (!$format['format_default'] == 1 ? "style='display: none'" : null) ?> id="img-<?= $format['format_id']; ?>" class="col-lg-6  hide-dynamic">
        <img class="img-fluid img-change" src="/assets/img/products/<?= $format['format_img']; ?>" accesskey="/assets/img/products/<?= $format['format_img']; ?>" alt="/assets/img/products/<?= $format['format_gif']; ?>">
      </div>
    <?php endforeach; ?>

    <div class="col-lg-5 text-center text-lg-left">
      <?php foreach ($formats_product as $format) : ?>
        <?php if ($format['format_default'] == 1) : ?>
          <input style="display: none;" id="max-format-default" value="<?= $format['format_stock'] ?>">
        <?php endif; ?>
      <?php endforeach; ?>

      <?php foreach ($formats_product as $format) : ?>
        <input style="display: none;" id="max-fotmat-<?= $format['format_id'] ?>" value="<?= $format['format_stock'] ?>">
        <div class="hide-dynamic" id="head-<?= $format['format_id'] ?>" style="display: <?= (!$format['format_default'] == 1 ? 'none' : null) ?>;">
          <h2 class="h2-responsive text-center text-lg-left mt-3 mt-lg-0 mb-1 ml-xl-0 ml-4"><?= $format['format_title'] ?></h2>
          <h3 class="h3-responsive text-center text-lg-left mb-2 ml-xl-0 ml-4">
            <span class="red-text font-weight-bold">
              <strong>$<?= number_format($format['format_price'], 0, '', '.') ?></strong>
            </span>
            <span class="grey-text">
              <small>
                <s>$<?= number_format($format['format_old_price'], 0, '', '.') ?></s>
              </small>
            </span>
          </h3>
          <strong>Disponible: </strong><?= $format['format_stock'] ?> unidades</p>
        </div>
      <?php endforeach; ?>

      <div class="font-weight-normal">
        <p class="ml-xl-0 ml-4"><?= $product['product_description'] ?></p>
        <div class="mt-3">
          <p class="grey-text">Formato</p>
          <div class="row text-center text-lg-left pl-md-3">
            <?php foreach ($formats_product as $format) : ?>
              <div class="col-lg-3">
                <input onclick="load_format(<?= $format['format_id']; ?>)" class="form-check-input" name="group100" type="radio" id="radio-<?= $format['format_id']; ?>" <?= ($format['format_default'] == 1 ? 'checked' : null) ?>>
                <label for="radio-<?= $format['format_id']; ?>" class="form-check-label dark-grey-text"><?= $format['format_weight']; ?></label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <p class="mt-3 grey-text">Cantidad:</p>
        <div class="row justify-content-center">

          <div class="col-5 col-lg-4">
            <div class="input-group mt-2 text-center text-md-left">
              <div class="input-group-prepend">
                <button onclick="new_quantity(-1)" class="quantity-left-minus btn-number btn btn-sm btn-outline-amber-1 m-0 px-2 z-depth-0 waves-effect"><i class="fas fa-minus"></i></button>
              </div>
              <input type="text" id="quantity_format" name="quantity" class="text-center form-control input-number" value="1">
              <div class="input-group-prepend">
                <button onclick="new_quantity(1)" class="btn btn-sm btn-outline-amber-1 m-0 px-2 z-depth-0 waves-effect quantity-right-plus btn-number"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>

          <div class="col-8 col-lg-8 text-center text-lg-left">
            <input type="text" name="format_id" id="format_id" style="display: none;" value="<?= $format_default['format_id']; ?>">
            <button type="button" onclick="add_item()" id="btn_add_item" data-target="#modal_shopping_cart_success" class="btn btn-md btn-amber btn-rounded waves-effect mt-3 mt-md-2">
              <i class="fas fa-cart-plus mr-2" aria-hidden="true"></i> Agregar a la bolsa</button>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--/.row-->

  <!-- Central Modal Medium Success -->
  <div class="modal fade " id="modal_shopping_cart_success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-amber modal-dialog-centered modal-md" role="document">
      <!--Content-->
      <div class="modal-content">


        <!--Body-->
        <div class="modal-body ">
          <div class="text-center">
            <i class="fas fa-check fa-4x mb-3 animated zoomIn amber-text"></i>
            <p class="h5">Su producto fue agregado exitosamente</p>
          </div>
        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <a href="<?= base_url('comprar') ?>" class="btn btn-green btn-rounded waves-effect text-white">Ir a la bolsa<i class="ml-2 fas fa-shopping-bag text-white"></i></a>
          <a href="<?= base_url('#products') ?>" class="btn btn-outline-green btn-rounded waves-effect">Seguir comprando</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!-- Central Modal Medium Success-->

</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(function() {
    $(".img-change").hover(
      function() {
        $(this).attr("src", $(this).attr('alt'));
      },
      function() {
        $(this).attr("src", $(this).attr('accesskey'));
      }
    );
  });

  function new_quantity(value) {
    var quantity = $('#quantity_format').val();
    var max_quantity = ($("#quantity_format").prop('max') ? $("#quantity_format").prop('max') : $('#max-format-default').val());
    var new_quantity = parseInt(quantity) + parseInt(value);

    if (new_quantity > 0 && new_quantity <= max_quantity) {
      $('#quantity_format').val(new_quantity);
    }

  }

  function load_format(id) {
    $("#quantity_format").prop('max', $('#max-fotmat-' + id).val());
    $("#quantity_format").val(1);
    $('#format_id').val(id);
    $('.hide-dynamic').hide();
    $("#head-" + id).css("display", "");
    $("#img-" + id).css("display", "");
  }

  function add_item() {
    var format_id = $('#format_id').val();
    var quantity = $('#quantity_format').val();
    var carrito = ($('#carrito_value').text().replace(/\n/g, '').replace(/ /g, '') == '' ? 0 : $('#carrito_value').text());

    $.ajax({
      type: "POST",
      url: "/add_item",
      dataType: "json",
      data: {
        format_id: format_id,
        quantity: quantity,
      },
      success: function(o) {
        console.log(o);
        if (o.success) {
          $('#modal_shopping_cart_success').modal('show');
        } else {
          alert(o.error);
        }
        $('#carrito_value').text(o.value);
      }
    });
  }
</script>

<?= $this->endSection() ?>