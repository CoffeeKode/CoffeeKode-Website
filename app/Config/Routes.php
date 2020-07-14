<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

# Router Setup
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home_Controller');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

# Page Routes
$routes->get('/', 'Home_Controller::index');
$routes->get('detalle-producto', 'Home_Controller::products_details');
$routes->match(['get', 'post'], 'confirmar-cliente', 'Home_Controller::confirm_client');
$routes->match(['get', 'post'], 'recuperar-contrasena', 'Home_Controller::recover_password');
$routes->get('pagina-galeria', 'Home_Controller::page_gallery');

# Cart Routes
$routes->get('comprar', 'Cart_Controller::index');
$routes->post('add_item', 'Cart_Controller::add_item');
$routes->post('update_item', 'Cart_Controller::update_item');
$routes->post('remove_item', 'Cart_Controller::remove_item');

# Order Routes
$routes->match(['get', 'post'], 'confirmar-orden', 'Order_Controller::index');

# User Routes
$routes->match(['get', 'post'], 'ingresar', 'User_Controller::index', ['filter' => 'no_auth']);
$routes->get('logout', 'User_Controller::logout');
$routes->match(['get', 'post'], 'registro-usuario', 'User_Controller::register_user', ['filter' => 'no_auth']);
$routes->match(['get', 'post'], 'change_password', 'User_Controller::change_password'); // MAKE FILTER JUST AUTH

#Client Routes
$routes->match(['get', 'post'], 'mi-perfil', 'Client_Controller::index', ['filter' => 'auth_client']);
$routes->match(['get', 'post'], 'mis-pedidos', 'Client_Controller::client_orders', ['filter' => 'auth_client']);

# Admin Routes
$routes->match(['get', 'post'], 'mi-cuenta', 'Admin_Controller::index', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'administrar-pedidos', 'Admin_Controller::admin_orders', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'administrar-usuarios', 'Admin_Controller::admin_users', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'administrar-productos', 'Admin_Controller::admin_products', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'administrar-web', 'Admin_Controller::admin_page', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'administrar-tiendas', 'Admin_Controller::admin_store', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'administrar-galeria', 'Admin_Controller::admin_gallery', ['filter' => 'auth_admin']);


$routes->match(['get', 'post'], 'change_status', 'Admin_Controller::change_status', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'update_admin', 'Admin_Controller::update_admin', ['filter' => 'auth_admin']);
$routes->match(['get', 'post'], 'delete_admin', 'Admin_Controller::delete_admin', ['filter' => 'auth_admin']);

# Another System Routes
$routes->post('send_mail', 'Contact_Controller::index');
$routes->get('get_commune', 'Commune_Controller::index');
$routes->get('get_store', 'Store_Controller::index');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
