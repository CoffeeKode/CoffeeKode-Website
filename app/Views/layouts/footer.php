    <!-- Footer -->
    <footer class="page-footer font-small elegant-color-dark pt-4 border-top border-warning">

        <!-- Footer Links -->
        <div class="container-fluid text-center text-md-left px-5">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-md-3 mt-md-0 mt-3">

                    <!-- Content -->
                    <h5 class="amber-text text-uppercase">Encuéntranos en</h5>
                    <p><?= $contact['contact_address'] ?></p>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none pb-3">

                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">

                    <!-- Links -->
                    <h5 class="amber-text text-uppercase">Escríbenos a</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="#!"><?= $contact['contact_mail'] ?></a>
                        </li>

                    </ul>

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">

                    <!-- Links -->
                    <h5 class="amber-text text-uppercase">Llámanos a</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="#!"><?= $contact['contact_number'] ?></a>
                        </li>

                    </ul>

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">

                    <!-- Links -->
                    <h5 class="amber-text text-uppercase">Síguenos en</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="<?= $contact['contact_facebook'] ?>" target="_BLANK" class="text-white d-inline-block align-top"><i style="color: #3b5998;" class="fab fa-facebook fa-lg mr-2"></i>Colmenas polo</a>
                        </li>
                        <li>
                            <a href="<?= $contact['contact_instagram'] ?>" target="_BLANK" class="mt-2 text-white d-inline-block align-top"><i style="color: #dd2a7b;" class="fab fa-instagram fa-lg mr-2"></i>Colmenas_polo</a>
                        </li>

                    </ul>

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Desarrollado por:
            <a href="www.coffeekode.cl"> CoffeeKode.cl</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->