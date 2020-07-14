<?php

namespace App\Controllers;

use App\Models\Contact_Model;
use App\Models\Order_Detail_Model;
use App\Models\View_Order_Model;

class Orden extends BaseController
{

    public function detalle($order_id)
    {
        $order_model = new View_Order_Model();
        $order_detail_model = new Order_Detail_Model();
        $contact_model = new Contact_Model();

        $order = $order_model->find($order_id);
        $user_id = (session('user') ? array_values(session('user'))[0]['user_id'] : 0);
        $user_profile = (session('user') ? array_values(session('user'))[0]['user_profile'] : null);

        if ($order) {
            $data['sidebar'] = null;
            $data['from'] = 'order';
            $data['contact'] = $contact_model->find(1);

            if ($order['order_user'] == $user_id || $order['order_user'] == null || $user_profile == 1) {
                $data['order'] = $order;
                $data['order_details'] = $order_detail_model->where('detail_order', $order['order_id'])
                    ->findAll();

                return view('pages/product-order', $data);
            } else {
                return redirect()->to(base_url('ingresar'));
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    //--------------------------------------------------------------------
}
