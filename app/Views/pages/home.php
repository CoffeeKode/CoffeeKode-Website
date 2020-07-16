<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
<?= $page['page_title']; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="/assets/css/ekko-lightbox.css">
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>

<!-- Full Page Intro -->
<div id="home" class="view bg">
	<!-- Mask & flexbox options-->
	<div class="mask rgba-black-light d-flex align-items-center">
		<!-- Content -->
		<div class="container">
			<!--Grid row-->
			<div class="row">
				<!--Grid column-->
				<div class="mt-5 mt-md-0 col col-md-12 mb-4 text-white text-center">
					<h1 class="display-1 h1-reponsive font-weight-bold mb-0 pt-md-5 pt-2 wow fadeInDown font-ds-bold" data-wow-delay="0.3s"><strong><?= $page['page_title']; ?></strong></h1>
					<hr class="hr-light my-4 wow fadeInDown" data-wow-delay="0.4s">
					<h5 class="mb-4 wow fadeInDown display-4 font-ds-bold" data-wow-delay="0.4s">
						<strong><?= $page['page_slogan']; ?></strong>
					</h5>
					<a data-scroll href="#products" class="btn btn-outline-white btn-rounded waves-effect wow fadeInDown" data-wow-delay="0.4s">
						<h4 class="font-ds-bold text-capitalize">Conócenos</h4>
					</a>
				</div>
				<!--Grid column-->
			</div>
			<!--Grid row-->
		</div>
		<!-- Content -->
	</div>
	<!-- Mask & flexbox options-->
</div>
<!--/.Full Page Intro -->

<!-- Products -->
<section id="products" class="bg-blue-grey">
	<div class="container-fluid py-5">

		<h2 class="font-weight-bold text-center font-ds-bold display-4">Nuestros productos</h2>

		<div class="row">
			<div class="col-md-3">

			</div>
		</div>

		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 mt-5 mx-5 justify-content-center h-100">

			<!-- Product Card -->
			<?php foreach ($products as $product) : ?>
				<div class="card-container text-center">
					<div class="card-flip">
						<!-- Honey Card Front -->
						<div class="card front <?= $product['product_bg'] ?>">
							<div class="card-block text-center h-100">
								<div class="card-image h-100">
									<!-- Content -->
									<div class="rounded text-white text-center d-flex rgba-black-strong py-5 px-4 h-100">
										<div>
											<h3 class="card-title pt-2 amber-text"><strong><?= $product['product_title'] ?></strong></h3>
											<p><?= $product['product_description'] ?></p>
										</div>
									</div>
									<!--/.Card Content -->
								</div>
							</div>
						</div>
						<!-- /.Honey Card Front -->
						<?php foreach ($format_product as $format) : ?>
							<?php if ($product['product_id'] == $format['format_product']) : ?>


								<!-- Honey Card Back -->
								<div class="card back">
									<div class="card-block">

										<!-- Card image -->
										<div class="view overlay">
											<img class="card-img-top img-fluid" src="/assets/img/products/<?= $format['format_img']; ?>" alt="Card image cap">
											<a href="/carro-compras">
												<div class="mask rgba-white-slight"></div>
											</a>
										</div>
										<!--./Card image -->

										<!-- Card content -->
										<div class="card-body ">

											<!-- Title -->
											<h4 class="card-title"><?= $format['format_title']; ?></h4>
											<span class="badge green mb-2">100% Natural</span>

											<!-- Text -->
											<div class="card-footer pb-0 bg-white ">
												<div class="row mb-0 justify-content-center">
													<span><strong>$<?= number_format($format['format_price'], 0, '', '.'); ?></strong></span>
													<span class="pl-2 grey-text">
														<small>
															<s>$<?= number_format($format['format_old_price'], 0, '', '.'); ?></s>
														</small>
													</span>
												</div>
											</div>
											<div class="text-center">
												<a href="<?= base_url('producto/detalle/' . $product['product_path']) ?>" type="button" class="btn btn-amber btn-md waves-effect btn-sm  float-center"><strong>Comprar
													</strong><i class="fas fa-cart-plus"></i></a>
											</div>

										</div>

									</div>
								</div>
								<!-- /.Honey Card Back -->
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
			<!-- /.Product Card -->

		</div>
	</div>
</section>
<!--/.Products -->

<!--Services-->
<section id="services" class="py-5 px-2 container-fluid">
	<h2 class="font-weight-bold text-center font-ds-bold display-4">Servicios</h2>

	<section>
		<div class="container">
			<div class="row">

				<div class="col-md-6">
					<!-- Card -->
					<div class="card card-cascade wider reverse">

						<div class="view view-cascade overlay">
							<div class="card-img-top">
								<img src="../assets/img/services/serviceBeekeeping.jpg" class="rounded img-fluid" alt="">
							</div>
						</div>

						<!-- Card content -->
						<div class="card-body card-body-cascade text-center">

							<!-- Title -->
							<h4 class="card-title"><strong>Apicultura</strong></h4>
							<!-- Subtitle -->
							<h6 class="font-weight-bold amber-text py-2">Descripción</h6>
							<!-- Text -->
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem perspiciatis
								voluptatum a, quo nobis, non commodi quia repellendus sequi nulla voluptatem dicta reprehenderit, placeat
								laborum ut beatae ullam suscipit veniam.
							</p>

						</div>

					</div>
					<!-- Card -->
				</div>

				<div class="col-md-6">
					<!-- Card -->
					<div class="card card-cascade wider reverse">


						<div class="view view-cascade overlay">
							<div class="card-img-top ">
								<img src="../assets/img/services/servicePollinition.jpg" class="rounded img-fluid" alt="">
							</div>
						</div>
						<!-- Card image 
						<div class="view view-cascade overlay">
							<div class="card-img-top embed-responsive embed-responsive-4by3">
								<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/hfy0XvTfkBw" allowfullscreen></iframe>
							</div>
						</div>
-->
						<!-- Card content -->
						<div class="card-body card-body-cascade text-center">

							<!-- Title -->
							<h4 class="card-title"><strong>Polinización</strong></h4>
							<!-- Subtitle -->
							<h6 class="font-weight-bold green-text py-2">Descripcion</h6>
							<!-- Text -->
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem perspiciatis
								voluptatum a, quo nobis, non commod i quia repellendus sequi nulla voluptatem dicta reprehenderit, placeat
								laborum ut beatae ullam suscipit veniam.
							</p>

						</div>

					</div>
					<!-- Card -->
				</div>

			</div>
		</div>

	</section>

</section>
<!-- ./Services-->

<!-- AboutUs -->
<section id="about-us">
	<div class="container p-5">

		<div class="row">

			<div class="col-lg-8">
				<h2 class="wow fadeInDown font-weight-bold font-ds-bold display-4 text-center mb-3">¿Quienes Somos?</h2>
			</div>
			<!--Text About Us-->
			<div class="col-lg-8 align-self-center">

				<p class="wow fadeInLeft text-muted text-center "><?= $page['page_about_us']; ?></p>
			</div>


			<!--Img About Us-->
			<div class="col-md-4 px-0 align-self-center d-none d-lg-inline">
				<div class="wow fadeInRight view rounded z-depth-1-half ">
					<img src="assets/img/about/<?= $page['page_about_us_img']; ?>" alt="" class="img-fluid" alt="">
				</div>
			</div>

		</div>

		<div class="row mt-5">
			<div class="col-lg-10">
				<h3 class="wow fadeInDown font-weight-bold font-ds-bold display-4 text-center text-lg-right pr-md-4 ">Nuestra Miel</h3>
			</div>
			<!--Img vission-->
			<div class="col-md-4 px-0 d-none d-lg-inline">
				<div class="wow fadeInLeft view overlay z-depth-1-half">
					<img src="assets/img/about/<?= $page['page_our_product_img']; ?>" alt="" class="img-fluid" alt="">
				</div>
			</div>

			<!--Text vission-->
			<div class="col-lg-8 align-self-center">

				<p class="wow fadeInRight text-muted text-center"><?= $page['page_our_product']; ?></p>
			</div>

		</div>

	</div>

</section>
<!-- /.AboutUs -->

<!-- Our Team -->
<section id="team">
	<div class="container py-5 ">
		<section class="p-md-3 mx-md-5 text-center text-lg-left">
			<h1 class="text-center display-4 mx-auto font-weight-bold mb-4 pb-2 font-ds-bold">Nuestro equipo</h1>
			<div class="row">
				<div class="wow fadeInDown col-lg-4">
					<div class="p-4">
						<div class="avatar w-100 white d-flex justify-content-center align-items-center">
							<img src="assets/img/team/<?= $team['team_img_1'] ?>" class="img-fluid rounded-circle z-depth-1" />
						</div>
						<div class="text-center mt-3">
							<h6 class="font-weight-bold pt-2"><?= $team['team_title_1'] ?></h6>
							<p class="text-muted">
								<small><i><?= $team['team_description_1'] ?></i></small>
							</p>
						</div>
					</div>
				</div>

				<div class="wow fadeIn col-lg-4">
					<div class="p-4">
						<div class="avatar w-100 white d-flex justify-content-center align-items-center">
							<img src="assets/img/team/<?= $team['team_img_2'] ?>" class="img-fluid rounded-circle z-depth-1" />
						</div>
						<div class="text-center mt-3">
							<h6 class="font-weight-bold pt-2"><?= $team['team_title_2'] ?></h6>
							<p class="text-muted">
								<small><i><?= $team['team_description_2'] ?></i></small>
							</p>
						</div>
					</div>
				</div>
				<div class="wow fadeInUp col-lg-4">
					<div class="p-4">
						<div class="avatar w-100 white d-flex justify-content-center align-items-center">
							<img src="assets/img/team/<?= $team['team_img_3'] ?>" class="img-fluid rounded-circle z-depth-1" />
						</div>
						<div class="text-center mt-3">
							<h6 class="font-weight-bold pt-2"><?= $team['team_title_3'] ?></h6>
							<p class="text-muted">
								<small><i><?= $team['team_description_3'] ?></i></small>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</section>
<!-- /.Our Team -->

<!-- Services -->

<!-- Gallery -->
<section id="gallery" class="container py-5">
	<h1 class="text-center display-4 mx-auto font-weight-bold mb-4 pb-2 font-ds-bold">Galería</h1>

	<div class="row">
		<?php $n = 1;
		foreach ($gallerys as $gallery) : ?>
			<?php if ($n <= 3) : ?>
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
							<p class="text-right p-2 my-0"><i class="far fa-clock mr-2"></i><?= format_date($gallery['gallery_date']) ?></p>
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
			<?php $n++;
			endif; ?>
		<?php endforeach; ?>
	</div>

	<div class="col-md-4 mx-auto">
		<a href="<?= base_url('pagina-galeria') ?>" class="mt-3 btn btn-rounded btn-block btn-outline-amber-1 waves-effect">
			Ver más <i class="ml-1 fas fa-plus"></i></i></a>
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

<!-- Contact -->
<section id="contact" class="bg-blue-grey wow fadeIn" data-wow-delay="0.3s">
	<div class="container py-5">
		<h1 class="text-center display-4 mx-auto font-weight-bold mb-4 pb-2 font-ds-bold">Contactanos</h1>

		<div class="row border border-light">
			<!-- Form contact -->
			<div class="col-md-8 bg-white">
				<form class="text-center p-5" action="#!">

					<h3 class="font-weight-bold dark-grey-text mt-0"><i class="fas fa-envelope pr-2 mr-1"></i>Escríbenos</h3>

					<!-- Name -->
					<input type="text" id="name" class="form-control mb-4" placeholder="Nombre">

					<!-- Email -->
					<input type="email" id="email" class="form-control mb-4" placeholder="Correo electrónico">

					<!-- Message -->
					<div class="form-group">
						<textarea class="form-control rounded-0" id="message" rows="3" placeholder="Mensaje"></textarea>
					</div>

					<!-- Send button -->
					<div class="col-md-8 mx-auto">
						<a href="#!" onclick="send_mail()" class="mt-5 btn btn-amber btn-rounded btn-block waves-effect">
							Enviar <i class="fas fa-paper-plane"></i></a>
					</div>

				</form>
			</div>
			<div class="col-md-4 amber accent-4 text-white text-center pt-5">

				<h3 class="font-weight-bold text-white mt-0 mb-3">Información de contacto</h3>

				<!--Content-->
				<h5 class="font-weight-bold">Dirección</h5>
				<p class="mb-3"><?= $contact['contact_address'] ?></p>

				<h5 class="font-weight-bold">Teléfono</h5>
				<p class="mb-3"><?= $contact['contact_number'] ?></p>

				<h5 class="font-weight-bold">Correo electrónico</h5>
				<p class="mb-3"><?= $contact['contact_mail'] ?></p>

				<img src="/assets/img/colmena-bar.png" class="img-fluid" alt="">


			</div>
			<!--/.Form contact -->
		</div>
	</div>
</section>
<!--/.Contact-->

<!-- Button go back to Top -->
<a data-scroll class="back-top-btn" href="#navbar"><i class="fas fa-arrow-up"></i></a>

<!-- Social Bar -->
<div class="icon-bar">
	<a href="https://es-la.facebook.com/ColmenasPolo/" class="facebook"><i class="fab fa-facebook-f"></i></a>
	<a href="https://instagram.com/colmenas_polo?igshid=24r72gozofr8" class="instagram"><i class="fab fa-instagram"></i></a>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/assets/js/smooth-scroll.polyfills.min.js"></script>
<script src="/assets/js/ekko-lightbox.min.js"></script>


<script>
	var scroll = new SmoothScroll('a[href*="#"]', {
		speed: 1000,
		speedAsDuration: true
	});

	function send_mail() {
		var name = $('#name').val();
		var email = $('#email').val();
		var message = $('#message').val();

		if (name == "" || email == "" || message == "") {
			alert('Debe llenar todos los campos para enviar un correo');
		}

		$.ajax({
			type: "POST",
			url: "send_mail",
			data: {
				name,
				email,
				message,
			},
			success: function(o) {
				if (o == 'OK') {
					alert('Su correo ha sido enviado');
				} else {
					alert('No se ha podido enviar su correo, intente mas tarde :(');
				}
			},
			dataType: "json"
		});
	}
	$(document).on('click', '[data-toggle="lightbox"]', function(event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	});
</script>



<?= $this->endSection() ?>