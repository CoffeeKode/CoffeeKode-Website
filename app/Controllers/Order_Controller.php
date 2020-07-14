<?php

namespace App\Controllers;

use App\Models\Contact_Model;
use App\Models\Format_Product_Model;
use App\Models\Order_Detail_Model;
use App\Models\Order_Model;
use App\Models\Region_Model;
use App\Models\View_Commune_Model;
use App\Models\View_Store_Model;

class Order_Controller extends BaseController
{

    public function index()
    {
        helper(['form']);

        if(!session()->get('cart')) {
            return redirect()->to(base_url('comprar'));
        }

        $region_model = new Region_Model();
        $commune_model = new View_Commune_Model();
        $contact_model = new Contact_Model();
        $store_model = new View_Store_Model();

        if ($this->request->getMethod() == 'post') {

            $order_model = new Order_Model();
            $order_detail_model = new Order_Detail_Model();

            $date = date("Y/m/d");
            $radio_option = $this->request->getPost('radio_option');

            $rules = [
                'order_client_rut' => 'required|max_length[10]',
                'order_client_fullname' => 'required|min_length[4]|max_length[100]',
                'order_client_email' => 'required|max_length[255]|valid_email',
                'order_client_phone' => 'required|min_length[9]|max_length[9]',
            ];

            $errors = [
                'order_client_rut' => [
                    'required' => 'Debe ingresar un rut',
                    'max_length' => 'El rut debe tener el formato 12345678-9',
                ],
                'order_client_fullname' => [
                    'required' => 'Debe ingresar su nombre',
                    'min_length' => 'El nombre debe tener un mínimo de 4 caracteres',
                    'max_length' => 'El nombre debe tener un máximo de 100 caracteres',
                ],
                'order_client_email' => [
                    'required' => 'Debe ingresar un correo',
                    'max_length' => 'El correo debe tener un máximo de 255 caracteres',
                    'valid_email' => 'El correo no es valido',
                ],
                'order_client_phone' => [
                    'required' => 'Debe ingresar numero télefonico',
                    'min_length' => 'El numero telefónico debe tener 9 dígitos',
                    'max_length' => 'El numero telefónico debe tener 9 dígitos',
                ],
            ];

            if ($radio_option == 'delivery') {
                $rules['order_client_commune'] = 'required';
                $rules['order_client_address'] = 'required|min_length[4]|max_length[255]';
                $errors['order_client_commune'] = [
                    'required' => 'Debe seleccionar una comuna',
                ];
                $errors['order_client_address'] = [
                    'required' => 'Debe ingresar su dirección',
                    'min_length' => 'La dirección debe tener un mínimo de 4 caracteres',
                    'max_length' => 'La dirección debe tener un máximo de 255 caracteres',
                ];
            } else {
                $rules['order_store'] = 'required';
                $errors['order_store'] = [
                    'required' => 'Debe seleccionar una tienda',
                ];
            }

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {
                $format_product_model = new Format_Product_Model();

                $cart = array_values(session('cart'));
                for ($i = 0; $i < count($cart); $i++) {
                    $formats_product = $format_product_model->find($cart[$i]['item_format_id']);

                    if ($formats_product['format_stock'] < $cart[$i]['item_quantity']) {
                        $cart[$i]['item_quantity'] = $formats_product['format_stock'];
                        session()->set('cart', $cart);
                        session()->setFlashdata('error', 'Lo sentimos, nuestro stock del producto ' . $cart[$i]['item_format_title'] . " se ha actualizado a un máximo de  " . $formats_product['format_stock'] . " unidades.<br> Por favor vuelve a revisar tu carrito de compras para continuar con tu orden.");
                        return redirect()->to('comprar');
                    }
                }

                $new_order = [
                    'order_date' => $date,
                    'order_amount' => $this->request->getPost('order_amount'),
                    'order_client_rut' => $this->request->getPost('order_client_rut'),
                    'order_client_fullname' => $this->request->getPost('order_client_fullname'),
                    'order_client_email' => $this->request->getPost('order_client_email'),
                    'order_client_phone' => $this->request->getPost('order_client_phone'),
                    'order_client_address' => ($radio_option == 'delivery' ? $this->request->getPost('order_client_address') : null),
                    'order_client_commune' => ($radio_option == 'delivery' ? $this->request->getPost('order_client_commune') : null),
                    'order_user' => (session('user') ? array_values(session('user'))[0]['user_id'] : null),
                    'order_store' => ($radio_option == 'store' ? $this->request->getPost('order_store') : 1),
                    'order_status' => 1,
                ];

                $order_id = $order_model->insert($new_order);

                $cart = array_values(session('cart'));
                $message_table = "";
                for ($i = 0; $i < count($cart); $i++) {
                    $n = 0;
                    $new_order_detail = [
                        'detail_order' => $order_id,
                        'detail_format' => $cart[$i]['item_format_id'],
                        'detail_format_title' => $cart[$i]['item_format_title'],
                        'detail_format_weight' => $cart[$i]['item_format_weight'],
                        'detail_format_quantity' => $cart[$i]['item_quantity'],
                        'detail_format_amount' => $cart[$i]['item_format_price'],
                    ];
                    $message_table .= "<tr>";
                    $message_table .= "<td>" . $n++ . "</td>";
                    $message_table .= "<td>" . $cart[$i]['item_format_title'] . "</td>";
                    $message_table .= "<td>" . $cart[$i]['item_format_weight'] . "</td>";
                    $message_table .= "<td>$" . number_format($cart[$i]['item_format_price'], 0, '', '.') . "</td>";
                    $message_table .= "<td>" . $cart[$i]['item_quantity'] . "</td>";
                    $message_table .= "<td>$" . number_format(($cart[$i]['item_format_price'] * $cart[$i]['item_quantity']), 0, '', '.') . "</td>";
                    $message_table .= "</tr>";
                    $order_detail_model->insert($new_order_detail);
                }

                if ($radio_option == 'delivery') {
                    $commune = $commune_model->find($this->request->getPost('order_client_commune'));
                    $region = $region_model->find($commune['province_region']);
                } else {
                    $store = $store_model->find($this->request->getPost('order_store'));
                }

                $message = "";
                $message .= "<link rel='stylesheet' href='" . base_url('/assets/css/bootstrap.min.css') . "'>'";
                $message .= "<link rel='stylesheet' href='" . base_url('/assets/css/mdb.min.css') . "'>";
                $message .= "<link rel='stylesheet' href='" . base_url('/assets/css/style.css') . "'>";
                $message .= "<h1 class='pt-5 h1-responsive text-center font-weight-bold mb-4'>Orden de Compra <a href='" . base_url('orden/detalle/' . $order_id) . "' target='_BLANK'>#$order_id</a></h1>';";
                $message .= "<div class='container mx-auto pb-5'>";
                $message .= "<div class='row d-flex justify-content-center'>";
                $message .= "<div class='col-md-5 card'>";
                $message .= "<h3 class='h3 mb-3 pl-4 mt-4'>Información del comprador</h3>";
                $message .= "<ul class='list-group list-group-flush'>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'><b>Rut:</b> " . $this->request->getPost('order_client_rut') . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'><b>Nombre:</b> " . $this->request->getPost('order_client_fullname') . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'><b>Correo:</b> " . $this->request->getPost('order_client_email') . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'><b>Celular:</b> " . $this->request->getPost('order_client_phone') . "<br></p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "</ul>";
                $message .= "</div>";
                $message .= "<div class='col-md-5 card'>";
                $message .= "<h3 class='h3 mb-3 pl-4 mt-4'>Información de envío</h3>";
                $message .= "<ul class='list-group list-group-flush'>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'><b>Tipo de envío: </b>" . ($radio_option == 'store' ? 'Retiro en tienda' : 'Envio a domicilio') . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'>" . ($radio_option == 'store' ? '<b>Tienda: </b>' . $store['store_name'] : '<b>Region: </b>' . $region['region_name'])  . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'>" . ($radio_option == 'store' ? '<b>Dirección: </b>' . $store['store_address'] . ', ' . $store['commune_name'] . ', ' . $store['region_name'] : '<b>Comuna: </b>' . $commune['commune_name'])  . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "<li class='list-group-item'>";
                $message .= "<p class='mb-1'>" . ($radio_option == 'store' ? '<b>Teléfono Contacto: </b>' . $store['store_phone'] : '<b>Dirección: </b>' . $this->request->getPost('order_client_address')) . "</p>";
                $message .= "<p class='mb-0 text-muted'></p>";
                $message .= "</li>";
                $message .= "</ul>";
                $message .= "</div>";
                $message .= "<div class='col-md-10 card'>";
                $message .= "<h3 class='h3 mb-3 pl-4 mt-4'>Detalle de compra</h3>";
                $message .= "<div class='table-responsive text-nowrap'>";
                $message .= "<table class='table table-striped'>";
                $message .= "<thead>";
                $message .= "<tr>";
                $message .= "<th>Ítem</th>";
                $message .= "<th>Producto</th>";
                $message .= "<th>Formato</th>";
                $message .= "<th>Precio Unitario</th>";
                $message .= "<th>Cantidad</th>";
                $message .= "<th>Total</th>";
                $message .= "</tr>";
                $message .= "</thead>";
                $message .= "<tbody>";
                $message .= $message_table;
                $message .= "</tbody>";
                $message .= "<tfoot>";
                $message .= "<tr>";
                $message .= "<th colspan='5' style='text-align: right;'><b>Total:</b></th>";
                $message .= "<th><b>" . number_format($this->total(), 0, '', '.') . "</b></th>";
                $message .= "</tr>";
                $message .= "</tfoot>";
                $message .= "</table>";
                $message .= "</div>";
                $message .= "</div>";
                $message .= "</div>";
                $message .= "</div>";

                $email = \Config\Services::email();

                $mail_to = 'lnmendez94@gmail.com';
                $name = $this->request->getPost('order_client_fullname');
                $mail_from = $this->request->getPost('order_client_email');
                $subject = 'Orden de compra:  #' .  $order_id;

                $config['mailType'] = 'html';

                $email->initialize($config);

                $email->setFrom($mail_from, $name);
                $email->setTo($mail_to);

                $email->setSubject($subject);
                $email->setMessage($message);

                $email->send();

                session()->remove('cart');
                session()->setFlashdata('success', 'Tu pedido esta siendo procesado, pronto nos comunicaremos contigo');
                return redirect()->to('orden/detalle/' . $order_id);
            }
        }

        $data['sidebar'] = null;
        $data['regions'] = $region_model->findAll();
        $data['communes'] = $commune_model->findAll();
        $data['stores'] = $store_model->findAll();
        $data['contact'] = $contact_model->find(1);
        $data['items'] = array_values(session('cart'));
        $data['total'] = $this->total();

        return view('pages/confirm-order', $data);
    }

    //--------------------------------------------------------------------

    private function total()
    {
        $s = 0;
        $items = array_values(session('cart'));
        foreach ($items as $item) {
            $s += $item['item_format_price'] * $item['item_quantity'];
        }

        return $s;
    }
}
