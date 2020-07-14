<?php

namespace App\Controllers;

use App\Models\Contact_Model;
use App\Models\Format_Product_Model;
use App\Models\Product_Model;

class Producto extends BaseController
{

    public function detalle($product_path)
    {
        $product_model = new Product_Model();
        $contact_model = new Contact_Model();
        $format_product_model = new Format_Product_Model();

        $contact = $contact_model->find(1);
        $product = $product_model->where('product_path', $product_path)
            ->first();

        if ($product) {
            $format_default = $format_product_model->where('format_product', $product['product_id'])
                ->where('format_default', 1)
                ->first();
            $formats_product = $format_product_model->where('format_product', $product['product_id'])
                ->findAll();

            $data['sidebar'] = null;
            $data['contact'] = $contact;
            $data['product'] = $product;
            $data['format_default'] = $format_default;
            $data['formats_product'] = $formats_product;

            return view('pages/products-details', $data);
        }
        return $this->response->redirect(base_url(''));
    }

    //--------------------------------------------------------------------
}
