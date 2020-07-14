<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contact_Model;
use App\Models\Format_Product_Model;

class Cart_Controller extends BaseController
{
    public function index()
    {
        $data['sidebar'] = null;
        $contact_model = new Contact_Model();
        $data['contact'] = $contact_model->find(1);

        if (!session('cart')) {
            return view('pages/product-shopping-cart', $data);
        }
        $format_product_model = new Format_Product_Model();

        $cart = array_values(session('cart'));
        for ($i = 0; $i < count($cart); $i++) {
            $formats_product = $format_product_model->find($cart[$i]['item_format_id']);

            if ($formats_product['format_id'] < $cart[$i]['item_format_id']) {
                $cart[$i]['item_format_stock'] = $formats_product['format_stock'];
            }
        }
        session()->set('cart', $cart);

        $data['items'] = array_values(session('cart'));
        $data['total'] = $this->total();

        return view('pages/product-shopping-cart', $data);
    }

    public function add_item()
    {
        $format_model = new Format_Product_Model();

        $format_id = $this->request->getPost('format_id');
        $quantity = $this->request->getPost('quantity');

        $format = $format_model->where('format_id', $format_id)
            ->first();

        $item = array(
            'item_format_id' => $format['format_id'],
            'item_img_path' => $format['format_img'],
            'item_format_title' => $format['format_title'],
            'item_format_weight' => $format['format_weight'],
            'item_format_price' => $format['format_price'],
            'item_format_product' => $format['format_product'],
            'item_format_stock' => $format['format_stock'],
            'item_quantity' => $quantity,
        );

        $session = session();

        $message = [];

        if ($session->has('cart')) {
            $index = $this->exists($format_id);
            $cart = array_values(session('cart'));
            if ($index == -1) {
                array_push($cart, $item);
                $message = [
                    'success' => true,
                ];
            } else {
                if (($cart[$index]['item_quantity'] + $quantity) <= $format['format_stock']) {
                    $cart[$index]['item_quantity'] += $quantity;
                    $message = [
                        'success' => true,
                    ];
                } else {
                    $cart[$index]['item_quantity'] = $format['format_stock'];
                    $diference = $format['format_stock'] - $cart[$index]['item_quantity'];
                    $message = [
                        'success' => false,
                        'error' => 'La suma del producto seleccionado y lo que tiene acumulado en el carrito de compras sobrepasa el stock, ' . ($diference > 0 ? 'solo se han agregado' . $diference . ' producto/s.' : 'no se ha agregado el producto.'),
                    ];
                }
            }
            $session->set('cart', $cart);
        } else {
            $cart = array($item);
            $session->set('cart', $cart);
            $message = [
                'success' => true,
            ];
        }
        $message['value'] = $this->total_items();

        return $this->response->setJSON($message);
    }

    public function update_item()
    {
        $format_id = $this->request->getPost('format_id');
        $quantity = $this->request->getPost('quantity');

        $cart = array_values(session('cart'));
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['item_format_id'] == $format_id) {
                $cart[$i]['item_quantity'] = $quantity;
            }
        }
        $session = session();
        $session->set('cart', $cart);
        echo json_encode('success');
    }

    public function remove_item()
    {
        $format_id = $this->request->getVar('format_id');
        $index = $this->exists($format_id);
        $cart = array_values(session('cart'));
        unset($cart[$index]);
        $session = session();
        $session->set('cart', $cart);
        return $this->response->redirect(base_url('comprar'));
    }

    private function exists($id)
    {
        $items = array_values(session('cart'));
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]['item_format_id'] == $id) {
                return $i;
            }
        }
        return -1;
    }

    private function total()
    {
        $s = 0;
        $items = array_values(session('cart'));
        foreach ($items as $item) {
            $s += $item['item_format_price'] * $item['item_quantity'];
        }

        return $s;
    }

    private function total_items()
    {
        $s = 0;
        $items = array_values(session('cart'));
        foreach ($items as $item) {
            $s += $item['item_quantity'];
        }

        return $s;
    }
}
