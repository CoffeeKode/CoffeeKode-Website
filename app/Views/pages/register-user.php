<?= $this->extend('layouts/main'); ?>

<?= $this->section('page_title') ?>
Colmenas Polo - Nuevo Usuario
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

<section class="bg-blue-grey">

    <div class="container py-5">
        <!-- Register section-->
        <div class="row d-flex justify-content-center ">
            <div class="col-md-8 card">
                <form class="text-center p-5" action="registro-usuario" method="post">
                    <?php if (session()->get('success')) : ?>
                        <div class="alert alert-success mb-4" role="alert">
                            <?= session()->get('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger mb-4" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <p class="h4 mb-4">Registrar</p>

                    <!-- Rut -->
                    <input type="text" id="rut" name="user_rut" class="form-control mb-4" required placeholder="Rut" value="<?= set_value('user_rut') ?>" oninput="checkRut(this)">

                    <!-- Full Name -->
                    <input type="text" name="user_fullname" class="form-control mb-4" maxlength="100" required placeholder="Nombres" value="<?= set_value('user_fullname') ?>">

                    <!-- E-mail -->
                    <input type="email" name="user_email" class="form-control mb-4" required maxlength="255" placeholder="Correo electronico" value="<?= set_value('user_email') ?>">

                    <!-- Phone number -->
                    <input type="tel" name="user_phone" class="form-control mb-4" required maxlength="9" placeholder="Numero telefonico" value="<?= set_value('user_phone') ?>">

                    <!-- Select Region -->
                    <select id="select_region" class="custom-select mb-4" onchange="load_commune()">
                        <option disabled selected>Selecciona tu region</option>
                        <?php foreach ($regions as $region) : ?>
                            <option value="<?= $region['region_id'] ?>"><?= $region['region_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- ./Select Comuna -->

                    <!-- Select Comuna -->
                    <select name="user_commune" id="select_commune" class="custom-select mb-4">
                    </select>
                    <!-- ./Select Comuna -->

                    <!-- Address -->
                    <input type="address" name="user_address" class="form-control mb-4" required maxlength="255" placeholder="Domicilio" value="<?= set_value('user_address') ?>">
                    <!-- ./ Address -->

                    <!-- Password -->
                    <input type="password" name="user_password" class="form-control" required maxlength="255" placeholder="Contraseña" aria-describedby="password_help">
                    <small id="password_help" class="form-text text-muted mb-4">
                        Como minimo 8 caracteres
                    </small>

                    <!-- Repeat Password -->
                    <input type="password" name="user_password_repeat" class="form-control" required maxlength="255" placeholder="Repetir Contraseña" aria-describedby="defaultRegisterFormPasswordHelpBlock">

                    <!-- Sign up button -->

                    <button class="col-md-8 mt-3 btn btn-amber btn-rounded waves-effect" type="submit">Registrar</button>

                    <!-- <hr> -->

                    <!-- Terms of service -->
                    <!-- <p>By clicking
                        <em>Sign up</em> you agree to our
                        <a href="" target="_blank">terms of service</a> -->

                </form>
            </div>
        </div>
    </div>
    </div>
    <!--/.Register Tab-->

    </div>

</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/assets/vendor/jquery.rut/jquery.rut.js"></script>

<script>
    $(document).ready(function() {
        load_commune();

        $("input#rut").rut({
            formatOn: 'keyup',
            minimumLength: 8,
            validateOn: 'change keyup',
            useThousandsSeparator: false
        });
    });

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
</script>
<?= $this->endSection() ?>