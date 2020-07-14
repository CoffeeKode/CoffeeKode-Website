<?php

namespace App\Controllers;

use App\Models\Contact_Model;
use App\Models\Format_Product_Model;
use App\Models\Gallery_Model;
use App\Models\Image_Model;
use App\Models\Order_Model;
use App\Models\Page_Model;
use App\Models\Product_Model;
use App\Models\Region_Model;
use App\Models\Status_Model;
use App\Models\Store_Model;
use App\Models\Team_Model;
use App\Models\User_Model;
use App\Models\Video_Model;
use App\Models\View_Commune_Model;
use App\Models\View_Order_Model;
use App\Models\View_Store_Model;

class Admin_Controller extends BaseController
{
    public function index()
    {
        helper(['form']);

        $region_model = new Region_Model();
        $commune_model = new View_Commune_Model();
        $contact_model = new Contact_Model();
        $user_model = new User_Model();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'user_fullname' => 'required|min_length[4]|max_length[100]',
                'user_phone' => 'required|min_length[9]|max_length[9]',
                'user_address' => 'required|min_length[4]|max_length[255]',
                'user_commune' => 'required',
            ];

            $errors = [
                'user_fullname' => [
                    'required' => 'De ingresar su nombre',
                    'min_length' => 'El nombre debe tener un mínimo de 4 caracteres',
                    'max_length' => 'El nombre debe tener un máximo de 100 caracteres',
                ],
                'user_phone' => [
                    'required' => 'De ingresar su nombre',
                    'min_length' => 'El numero telefónico debe tener 9 dígitos',
                    'max_length' => 'El numero telefónico debe tener 9 dígitos',
                ],
                'user_address' => [
                    'required' => 'De ingresar su dirección',
                    'min_length' => 'La dirección debe tener un mínimo de 4 caracteres',
                    'max_length' => 'La dirección debe tener un máximo de 255 caracteres',
                ],
                'user_commune' => [
                    'required' => 'Debe seleccionar una comuna',
                ],
            ];

            if ($this->request->getPost('user_email') != array_values(session('user'))[0]['user_email']) {
                $rules['user_email'] = 'required|max_length[255]|valid_email|is_unique[tbl_user.user_email]';
                $errors['user_email'] = [
                    'required' => 'Debe ingresar un correo',
                    'max_length' => 'El correo debe tener un máximo de 255 caracteres',
                    'valid_email' => 'El correo no es valido',
                    'is_unique' => 'El correo ingresado ya se encuentra registrado',
                ];
            }

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {
                $update_user = [
                    'user_id' => array_values(session('user'))[0]['user_id'],
                    'user_fullname' => $this->request->getPost('user_fullname'),
                    'user_email' => $this->request->getPost('user_email'),
                    'user_phone' => $this->request->getPost('user_phone'),
                    'user_address' => $this->request->getPost('user_address'),
                    'user_commune' => $this->request->getVar('user_commune'),
                ];

                if ($this->request->getPost('user_email') != array_values(session('user'))[0]['user_email']) {
                    $update_user['user_email'] = $this->request->getPost('user_email');
                }

                $user_model->save($update_user);

                $user = $user_model->find(array_values(session('user'))[0]['user_id']);
                $commune = $commune_model->where('commune_id', $user['user_commune'])
                    ->first();

                $this->user_session($user, $commune);

                session()->setFlashdata('success', 'Actualización exitosa');
                return redirect()->to('/mi-cuenta');
            }
        }

        $data['sidebar'] = true;
        $data['contact'] = $contact_model->find(1);
        $data['regions'] = $region_model->findAll();
        $data['communes'] = $commune_model->findAll();

        return view('pages/admin/profile', $data);
    }

    public function change_status()
    {
        $order_model = new Order_Model();

        $update_status = [
            'order_id' => $this->request->getPost('order_id'),
            'order_status' => $this->request->getPost('order_status'),
        ];

        $order_model->save($update_status);

        if ($this->request->getPost('order_status') == 3) {
            session()->setFlashdata('success', 'Orden #' . $this->request->getPost('order_id') . ' cambiada a "Completada"');
        }

        $data['success'] = true;
        return $this->response->setJSON($data);
    }

    public function admin_orders()
    {
        $contact_model = new Contact_Model();
        $order_model = new View_Order_Model();
        $status_model = new Status_Model();

        $data['sidebar'] = true;
        $data['contact'] = $contact_model->find(1);
        $data['status'] = $status_model->findAll();
        $data['orders'] = $order_model->orderBy('order_id', 'asc')
            ->findAll();

        return view('pages/admin/orders', $data);
    }

    public function admin_users()
    {
        helper(['form']);

        $region_model = new Region_Model();
        $commune_model = new View_Commune_Model();
        $contact_model = new Contact_Model();
        $user_model = new User_Model();

        if ($this->request->getMethod() == 'post') {
            session()->setFlashdata('add_admin', 'true');
            $rules = [
                'user_rut' => 'required|max_length[10]|is_unique[tbl_user.user_rut]',
                'user_fullname' => 'required|min_length[4]|max_length[100]',
                'user_email' => 'required|max_length[255]|valid_email|is_unique[tbl_user.user_email]',
                'user_phone' => 'required|min_length[9]|max_length[9]',
                'user_address' => 'required|min_length[4]|max_length[255]',
                'user_commune' => 'required',
                'user_password' => 'required|min_length[8]|max_length[255]',
                'user_password_repeat' => 'matches[user_password]',
            ];

            $errors = [
                'user_rut' => [
                    'required' => 'Debe ingresar un rut',
                    'max_length' => 'El rut debe tener el formato 12345678-9',
                    'is_unique' => 'El rut ingresado ya se encuentra registrado',
                ],
                'user_fullname' => [
                    'required' => 'Debe ingresar un nombre',
                    'min_length' => 'El nombre debe tener un mínimo de 4 caracteres',
                    'max_length' => 'El nombre debe tener un máximo de 100 caracteres',
                ],
                'user_email' => [
                    'required' => 'Debe ingresar un correo',
                    'max_length' => 'El correo debe tener un máximo de 255 caracteres',
                    'valid_email' => 'El correo no es valido',
                    'is_unique' => 'El correo ingresado ya se encuentra registrado',
                ],
                'user_phone' => [
                    'required' => 'Debe ingresar un numero de teléfono',
                    'min_length' => 'El numero telefónico debe tener 9 dígitos',
                    'max_length' => 'El numero telefónico debe tener 9 dígitos',
                ],
                'user_address' => [
                    'required' => 'Debe ingresar una dirección',
                    'min_length' => 'La dirección debe tener un mínimo de 4 caracteres',
                    'max_length' => 'La dirección debe tener un máximo de 255 caracteres',
                ],
                'user_commune' => [
                    'required' => 'Debe seleccionar una comuna',
                ],
                'user_password' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'La contraseña debe tener un mínimo de 8 caracteres',
                    'max_length' => 'La contraseña debe tener un máximo de 225 caracteres',
                ],
                'user_password_repeat' => [
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {
                $new_user = [
                    'user_rut' => $this->request->getPost('user_rut'),
                    'user_fullname' => $this->request->getPost('user_fullname'),
                    'user_email' => $this->request->getPost('user_email'),
                    'user_phone' => $this->request->getPost('user_phone'),
                    'user_address' => $this->request->getPost('user_address'),
                    'user_commune' => $this->request->getVar('user_commune'),
                    'user_profile' => 1,
                    'user_password' => $this->request->getPost('user_password'),
                ];

                $user_model->insert($new_user);

                session()->setFlashdata('success', 'El usuario <b>"' . $this->request->getPost('user_rut') . '"</b> ha sido registrado');
                return redirect()->to('/administrar-usuarios');
            }
        }

        $data['sidebar'] = true;
        $data['users'] = $user_model->findAll();
        $data['contact'] = $contact_model->find(1);
        $data['regions'] = $region_model->findAll();
        $data['communes'] = $commune_model->findAll();

        return view('pages/admin/users', $data);
    }

    public function update_admin()
    {
        $user_model = new User_Model();
        session()->setFlashdata('update_admin', 'true');

        $rules = [
            'user_fullname' => 'required|min_length[4]|max_length[100]',
            'user_phone' => 'required|min_length[9]|max_length[9]',
            'user_address' => 'required|min_length[4]|max_length[255]',
            'user_commune' => 'required',
        ];

        $errors = [
            'user_fullname' => [
                'required' => 'Debe ingresar un nombre',
                'min_length' => 'El nombre debe tener un mínimo de 4 caracteres',
                'max_length' => 'El nombre debe tener un máximo de 100 caracteres',
            ],
            'user_phone' => [
                'required' => 'Debe ingresar un numero de teléfono',
                'min_length' => 'El numero telefónico debe tener 9 dígitos',
                'max_length' => 'El numero telefónico debe tener 9 dígitos',
            ],
            'user_address' => [
                'required' => 'De ingresar un dirección',
                'min_length' => 'La dirección debe tener un mínimo de 4 caracteres',
                'max_length' => 'La dirección debe tener un máximo de 255 caracteres',
            ],
            'user_commune' => [
                'required' => 'Debe seleccionar una comuna',
            ],
        ];

        $user = $user_model->find($this->request->getPost('user_id'));

        if ($this->request->getPost('user_email') != $user['user_email']) {
            $rules['user_email'] = 'required|max_length[255]|valid_email|is_unique[tbl_user.user_email]';
            $errors['user_email'] = [
                'required' => 'Debe ingresar un correo',
                'max_length' => 'El correo debe tener un máximo de 255 caracteres',
                'valid_email' => 'El correo no es valido',
                'is_unique' => 'El correo ingresado ya se encuentra registrado',
            ];
        }

        if (!$this->validate($rules, $errors)) {
            $data['success'] = false;
            $data['validation'] = $this->validator->getErrors();
            return $this->response->setJSON($data);
        } else {
            $update_user = [
                'user_id' => $this->request->getPost('user_id'),
                'user_fullname' => $this->request->getPost('user_fullname'),
                'user_email' => $this->request->getPost('user_email'),
                'user_phone' => $this->request->getPost('user_phone'),
                'user_address' => $this->request->getPost('user_address'),
                'user_commune' => $this->request->getVar('user_commune'),
                'user_profile' => $this->request->getVar('user_profile'),
            ];

            session()->setFlashdata('success', 'Administrador <b>"' . $user['user_rut'] . '"</b> fue actualizado');
            $user_model->save($update_user);

            $data['success'] = true;
            return $this->response->setJSON($data);
        }
    }

    public function admin_products()
    {
        $contact_model = new Contact_Model();
        $product_model = new Product_Model();
        $formats_model = new Format_Product_Model();

        if ($this->request->getMethod() == 'post') {
            $is_update = ($this->request->getPost('format_id') ? true : false);

            $rules = [
                'format_title' => 'required|min_length[4]|max_length[255]',
                'format_description' => 'required|min_length[4]|max_length[255]',
                'format_weight' => 'required|min_length[4]|max_length[255]',
                'format_price' => 'required|numeric|max_length[11]',
                'format_old_price' => 'required|numeric|max_length[11]',
                'format_stock' => 'required|numeric|max_length[11]',
                'format_product' => 'required',
            ];

            $error = [
                'format_title' => [
                    'required' => 'Debe ingresar un Nombre',
                    'min_length' => 'El nombre debe tener 4 caracteres como mínimo',
                    'max_length' => 'El nombre debe tener 30 caracteres como máximo',
                ],
                'format_description' => [
                    'required' => 'Debe ingresar una Descripción',
                    'min_length' => 'La Descripción debe tener 4 caracteres como mínimo',
                    'max_length' => 'La Descripción debe tener 255 caracteres como máximo',
                ],
                'format_weight' => [
                    'required' => 'Debe ingresar un Formato',
                    'min_length' => 'El Formato debe tener 4 caracteres como mínimo',
                    'max_length' => 'El Formato debe tener 30 caracteres como máximo',
                ],
                'format_img' => [
                    'uploaded' => 'Debe selecciónar una imagen',
                    'max_size' => 'La imagen no debe pesar mas de 2 mb',
                    'is_image' => 'Debe seleccionar un archivo en formato png, jpg o jpge para la imagen',
                ],
                'format_gif' => [
                    'uploaded' => 'Debe selecciónar un gif',
                    'max_size' => 'El gif no debe pesar mas de 20 mb',
                    'ext_in' => 'Debe seleccionar un archivo en formato gif para el gif',
                ],
                'format_price' => [
                    'required' => 'Debe ingresar un Precio con Descuento',
                    'numeric' => 'El Precio con descuento debe ser numerico',
                    'max_length' => 'El Precio condescuento no pude exceder de los 11 dígitos',
                ],
                'format_old_price' => [
                    'required' => 'Debe ingresar un Precio Normal',
                    'numeric' => 'El Precio Normal debe ser numerico',
                    'max_length' => 'El Normal no pude exceder de los 11 dígitos',
                ],
                'format_stock' => [
                    'required' => 'Debe ingresar un Stock',
                    'numeric' => 'El Stock debe ser numerico',
                    'max_length' => 'El Stock no pude exceder de los 11 dígitos',
                ],
                'format_product' => [
                    'required' => 'Debe seleccionar una Familia de Productos',
                ],
            ];

            if (!$is_update) {
                $rules['format_img'] = 'uploaded[format_img]|max_size[format_img, 2048]|is_image[format_img]';
                $rules['format_gif'] = 'uploaded[format_gif]|max_size[format_gif, 20480]|ext_in[format_gif,gif]';
                session()->setFlashdata('add_product', 'true');
            }

            if ($is_update && $this->request->getFile('format_img')->isValid())
                $rules['format_img'] = 'uploaded[format_img]|max_size[format_img, 2048]|is_image[format_img]';


            if ($is_update && $this->request->getFile('format_gif')->isValid())
                $rules['format_gif'] = 'uploaded[format_gif]|max_size[format_gif, 20480]|ext_in[format_gif,gif]';


            if (!$this->validate($rules, $error)) {
                if ($is_update) {
                    $data['success'] = false;
                    $data['validation'] = $this->validator->getErrors();
                    return $this->response->setJSON($data);
                } else {
                    $data['validation'] = $this->validator;
                }
            } else {
                $new_format = [
                    'format_title' => $this->request->getPost('format_title'),
                    'format_description' => $this->request->getPost('format_description'),
                    'format_weight' => $this->request->getPost('format_weight'),
                    'format_price' => $this->request->getPost('format_price'),
                    'format_old_price' => $this->request->getPost('format_old_price'),
                    'format_stock' => $this->request->getPost('format_stock'),
                    'format_product' => $this->request->getPost('format_product'),
                    'format_default' => 0,
                    'format_status' => ($this->request->getPost('format_status') ? 0 : 1),
                ];

                if ($is_update)
                    $new_format['format_id'] = $this->request->getPost('format_id');

                if ($this->request->getFile('format_img')) {
                    $format_img = $this->request->getFile('format_img');
                    if ($format_img->isValid() && !$format_img->hasMoved()) {
                        $format_img->move('./assets/img/products/');
                        $new_format['format_img'] = $format_img->getName();
                    }
                }

                if ($this->request->getFile('format_gif')) {
                    $format_gif = $this->request->getFile('format_gif');
                    if ($format_gif->isValid() && !$format_gif->hasMoved()) {
                        $format_gif->move('./assets/img/products/');
                        $new_format['format_gif'] = $format_gif->getName();
                    }
                }

                session()->setFlashdata('success', 'El formato <b>"' . $this->request->getPost('format_title') . '"</b> ha sido ' . ($is_update ? 'actualizado' : 'agregado'));
                $formats_model->save($new_format);

                if ($is_update) {
                    $data['success'] = true;
                    return $this->response->setJSON($data);
                } else {
                    return redirect()->to('/administrar-productos');
                }
            }
        }

        $data['sidebar'] = true;
        $data['contact'] = $contact_model->find(1);
        $data['products'] = $product_model->findAll();
        $data['formats'] = $formats_model->findAll();

        return view('pages/admin/products', $data);
    }

    public function admin_store()
    {
        helper(['form']);

        $contact_model = new Contact_Model();
        $store_model = new Store_Model();
        $view_store_model = new View_Store_Model();
        $region_model = new Region_Model();
        $commune_model = new View_Commune_Model();

        if ($this->request->getMethod() == 'post') {
            $is_update = ($this->request->getPost('store_id') ? true : false);

            if (!$is_update) {
                session()->setFlashdata('add_store', 'true');
            }

            $rules = [
                'store_name' => 'required|min_length[4]|max_length[50]',
                'store_phone' => 'required|min_length[9]|max_length[9]',
                'store_address' => 'required|min_length[4]|max_length[100]',
                'store_commune' => 'required',
            ];

            $error = [
                'store_name' => [
                    'required' => 'Debe ingresar un nombre',
                    'min_length' => 'El nombre debe tener un mínimo de 4 caracteres',
                    'max_length' => 'El nombre debe tener un máximo de 50 caracteres',
                ],
                'store_phone' => [
                    'required' => 'Debe ingresar un numero de teléfono',
                    'min_length' => 'El numero telefónico debe tener 9 dígitos',
                    'max_length' => 'El numero telefónico debe tener 9 dígitos',
                ],
                'store_address' => [
                    'required' => 'Debe ingresar una dirección',
                    'min_length' => 'La dirección debe tener un mínimo de 4 caracteres',
                    'max_length' => 'La dirección debe tener un máximo de 100 caracteres',
                ],
                'store_commune' => [
                    'required' => 'Debe seleccionar una comuna',
                ],
            ];

            if (!$this->validate($rules, $error)) {
                if ($is_update) {
                    $data['success'] = false;
                    $data['validation'] = $this->validator->getErrors();
                    return $this->response->setJSON($data);
                } else {
                    $data['validation'] = $this->validator;
                }
            } else {
                $new_store = [
                    'store_name' => $this->request->getPost('store_name'),
                    'store_phone' => $this->request->getPost('store_phone'),
                    'store_address' => $this->request->getPost('store_address'),
                    'store_commune' => $this->request->getPost('store_commune'),
                    'store_status' => ($this->request->getPost('store_status') ? 0 : 1),
                ];

                if ($is_update)
                    $new_store['store_id'] = $this->request->getPost('store_id');

                session()->setFlashdata('success', 'La tienda <b>"' . $this->request->getPost('store_name') . '"</b> ha sido ' . ($is_update ? 'actualizada' : 'agregada'));
                $store_model->save($new_store);

                if ($is_update) {
                    $data['success'] = true;
                    return $this->response->setJSON($data);
                } else {
                    return redirect()->to('/administrar-tiendas');
                }
            }
        }

        $data['sidebar'] = true;
        $data['regions'] = $region_model->findAll();
        $data['contact'] = $contact_model->find(1);
        $data['store'] = $view_store_model->findAll();
        $data['communs'] = $commune_model->findAll();

        return view('pages/admin/store', $data);
    }

    public function admin_page()
    {
        helper(['form']);

        $contact_model = new Contact_Model();
        $product_model = new Product_Model();
        $order_model = new View_Order_Model();
        $page_model = new Page_Model();
        $team_model = new Team_Model();

        if ($this->request->getMethod() == 'post') {
            $from_to = $this->request->getPost('from_to');
            if ($from_to == 'add_product') {
                $is_update = ($this->request->getPost('product_id') ? true : false);

                if (!$is_update) {
                    session()->setFlashdata('add_product', 'true');
                }

                $rules = [
                    'product_title' => 'required|min_length[4]|max_length[50]',
                    'product_description' => 'required|min_length[4]|max_length[1000]',
                    'product_bg' => 'required',
                ];

                $error = [
                    'product_title' => [
                        'required' => 'Debe ingresar un título',
                        'min_length' => 'El título debe tener un mínimo de 4 caracteres',
                        'max_length' => 'El título debe tener un máximo de 50 caracteres',
                    ],
                    'product_description' => [
                        'required' => 'Debe ingresar una descripción',
                        'min_length' => 'La descripción debe tener un mínimo de 4 caracteres',
                        'max_length' => 'La descripción debe tener un máximo de 1000 caracteres',
                    ],
                    'product_bg' => [
                        'required' => 'Debe seleccionar un color',
                    ],
                ];

                if (!$this->validate($rules, $error)) {
                    if ($is_update) {
                        $data['success'] = false;
                        $data['validation'] = $this->validator->getErrors();
                        return $this->response->setJSON($data);
                    } else {
                        $data['validation'] = $this->validator;
                    }
                } else {
                    $new_product = [
                        'product_title' => $this->request->getPost('product_title'),
                        'product_description' => $this->request->getPost('product_description'),
                        'product_bg' => $this->request->getPost('product_bg'),
                        'product_path' => $this->generate_path($this->request->getPost('product_title')),
                        'product_status' => $this->request->getPost('product_status'),
                    ];

                    if ($is_update)
                        $new_product['product_id'] = $this->request->getPost('product_id');

                    session()->setFlashdata('success', 'El producto <b>"' . $this->request->getPost('product_title') . '"</b> ha sido ' . ($is_update ? 'actualizado' : 'agregado'));
                    $product_model->save($new_product);

                    if ($is_update) {
                        $data['success'] = true;
                        return $this->response->setJSON($data);
                    } else {
                        return redirect()->to('/administrar-web');
                    }
                }
            } else if ($from_to == 'add_about') {
                session()->setFlashdata('update_about', 'true');

                $rules = [
                    'page_about_us' => 'required|min_length[4]|max_length[1000]',
                    'page_our_product' => 'required|min_length[4]|max_length[1000]',
                ];

                if ($this->request->getFile('page_about_us_img')->isValid())
                    $rules['page_about_us_img'] = 'uploaded[page_about_us_img]|max_size[page_about_us_img, 2048]|is_image[page_about_us_img]';

                if ($this->request->getFile('page_our_product_img')->isValid())
                    $rules['page_our_product_img'] = 'uploaded[page_our_product_img]|max_size[page_our_product_img, 2048]|is_image[page_our_product_img]';

                $error = [
                    'page_title' => [
                        'required' => 'Debe ingresar un Título',
                        'min_length' => 'El Título debe tener 4 caracteres como mínimo',
                        'max_length' => 'El Título debe tener 30 caracteres como máximo',
                    ],
                    'page_slogan' => [
                        'required' => 'Debe ingresar un eslogan',
                        'min_length' => 'El eslogan debe tener 4 caracteres como mínimo',
                        'max_length' => 'El eslogan debe tener 30 caracteres como máximo',
                    ],
                    'page_about_us' => [
                        'required' => 'Debe ingresar una descripción para "quienes somos"',
                        'min_length' => 'La descripción para "quienes somos" debe tener 4 caracteres como mínimo',
                        'max_length' => 'La descripción para "quienes somos" debe tener 30 caracteres como máximo',
                    ],
                    'page_our_product' => [
                        'required' => 'Debe ingresar una descripción para "nuestra miel"',
                        'min_length' => 'La descripción para "nuestra miel" debe tener 4 caracteres como mínimo',
                        'max_length' => 'La descripción para "nuestra miel" nombre debe tener 30 caracteres como máximo',
                    ],
                    'page_about_us_img' => [
                        'uploaded' => 'Debe selecciónar una imagen para "quienes somos"',
                        'max_size' => 'La imagen para "quienes somos" no debe pesar mas de 2 mb',
                        'is_image' => 'Debe seleccionar un archivo en formato png, jpg o jpge para la imagen de "quienes somos"',
                    ],
                    'page_our_product_img' => [
                        'uploaded' => 'Debe selecciónar una imagen para "nuestra miel"',
                        'max_size' => 'La imagen para "nuestra miel" no debe pesar mas de 2 mb',
                        'is_image' => 'Debe seleccionar un archivo en formato png, jpg o jpge para la imagen de para "nuestra miel"',
                    ],
                ];

                if (!$this->validate($rules, $error)) {
                    $data['validation'] = $this->validator;
                } else {
                    $new_page = [
                        'page_id' => 1,
                        'page_about_us' => $this->request->getPost('page_about_us'),
                        'page_our_product' => $this->request->getPost('page_our_product'),
                    ];

                    if ($this->request->getFile('page_about_us_img')) {
                        $page_about_us_img = $this->request->getFile('page_about_us_img');
                        if ($page_about_us_img->isValid() && !$page_about_us_img->hasMoved()) {
                            $page_about_us_img->move('./assets/img/about/');
                            $new_page['page_about_us_img'] = $page_about_us_img->getName();
                        }
                    }

                    if ($this->request->getFile('page_our_product_img')) {
                        $page_our_product_img = $this->request->getFile('page_our_product_img');
                        if ($page_our_product_img->isValid() && !$page_our_product_img->hasMoved()) {
                            $page_our_product_img->move('./assets/img/about/');
                            $new_page['page_our_product_img'] = $page_our_product_img->getName();
                        }
                    }

                    session()->setFlashdata('success', 'La sección <b>Nosotros</b> ha sido actualizada');

                    $page_model->save($new_page);

                    return redirect()->to('/administrar-web');
                }
            } else if ($from_to == 'add_team') {
                session()->setFlashdata('update_team', 'true');

                $rules = [
                    'team_title_1' => 'required|min_length[4]|max_length[50]',
                    'team_title_2' => 'required|min_length[4]|max_length[50]',
                    'team_title_3' => 'required|min_length[4]|max_length[50]',
                    'team_description_1' => 'required|min_length[4]|max_length[1000]',
                    'team_description_2' => 'required|min_length[4]|max_length[1000]',
                    'team_description_3' => 'required|min_length[4]|max_length[1000]',
                ];

                if ($this->request->getFile('team_img_1')->isValid())
                    $rules['team_img_1'] = 'uploaded[team_img_1]|max_size[team_img_1, 2048]|is_image[team_img_1]';

                if ($this->request->getFile('team_img_1')->isValid())
                    $rules['team_img_2'] = 'uploaded[team_img_2]|max_size[team_img_2, 2048]|is_image[team_img_2]';

                if ($this->request->getFile('team_img_1')->isValid())
                    $rules['team_img_3'] = 'uploaded[team_img_3]|max_size[team_img_3, 2048]|is_image[team_img_3]';

                $error = [
                    'team_title_1' => [
                        'required' => 'Debe ingresar un nombre para el primer integrante',
                        'min_length' => 'El nombre para el primer integrante debe tener 4 caracteres como mínimo',
                        'max_length' => 'El nombre para el primer integrante debe tener 50 caracteres como máximo',
                    ],
                    'team_title_2' => [
                        'required' => 'Debe ingresar un nombre para el segundo integrante',
                        'min_length' => 'El nombre para el segundo integrante debe tener 4 caracteres como mínimo',
                        'max_length' => 'El nombre para el segundo integrante debe tener 50 caracteres como máximo',
                    ],
                    'team_title_3' => [
                        'required' => 'Debe ingresar un nombre para el tercer integrante',
                        'min_length' => 'El nombre para el tercer integrante debe tener 4 caracteres como mínimo',
                        'max_length' => 'El nombre para el tercer integrante debe tener 50 caracteres como máximo',
                    ],
                    'team_description_1' => [
                        'required' => 'Debe ingresar una descripción para el primer integrante',
                        'min_length' => 'La descripción para el primer integrante debe tener 4 caracteres como mínimo',
                        'max_length' => 'La descripción para el primer integrante debe tener 1000 caracteres como máximo',
                    ],
                    'team_description_2' => [
                        'required' => 'Debe ingresar una descripción para el segundo integrante',
                        'min_length' => 'La descripción para el segundo integrante debe tener 4 caracteres como mínimo',
                        'max_length' => 'La descripción para el segundo integrante debe tener 1000 caracteres como máximo',
                    ],
                    'team_description_3' => [
                        'required' => 'Debe ingresar una descripción para el tercer integrante',
                        'min_length' => 'La descripción para el tercer integrante debe tener 4 caracteres como mínimo',
                        'max_length' => 'La descripción para el tercer integrante debe tener 1000 caracteres como máximo',
                    ],
                    'team_img_1' => [
                        'uploaded' => 'Debe selecciónar una imagen para el primer integrante',
                        'max_size' => 'La imagen para el primer integrante no debe pesar mas de 2 mb',
                        'is_image' => 'Debe seleccionar un archivo en formato png, jpg o jpge para la imagen del primer integrante',
                    ],
                    'team_img_2' => [
                        'uploaded' => 'Debe selecciónar una imagen para el segundo integrante',
                        'max_size' => 'La imagen para el segundo integrante no debe pesar mas de 2 mb',
                        'is_image' => 'Debe seleccionar un archivo en formato png, jpg o jpge para la imagen del segundo integrante',
                    ],
                    'team_img_3' => [
                        'uploaded' => 'Debe selecciónar una imagen para el tercer integrante',
                        'max_size' => 'La imagen para el tercer integrante no debe pesar mas de 2 mb',
                        'is_image' => 'Debe seleccionar un archivo en formato png, jpg o jpge para la imagen del tercer integrante',
                    ],
                ];

                if (!$this->validate($rules, $error)) {
                    $data['validation'] = $this->validator;
                } else {
                    $new_team = [
                        'team_id' => 1,
                        'team_title_1' => $this->request->getPost('team_title_1'),
                        'team_title_2' => $this->request->getPost('team_title_2'),
                        'team_title_3' => $this->request->getPost('team_title_3'),
                        'team_description_1' => $this->request->getPost('team_description_1'),
                        'team_description_2' => $this->request->getPost('team_description_2'),
                        'team_description_3' => $this->request->getPost('team_description_3'),
                    ];

                    if ($this->request->getFile('team_img_1')) {
                        $team_img_1 = $this->request->getFile('team_img_1');
                        if ($team_img_1->isValid() && !$team_img_1->hasMoved()) {
                            $team_img_1->move('./assets/img/team/');
                            $new_team['team_img_1'] = $team_img_1->getName();
                        }
                    }

                    if ($this->request->getFile('team_img_2')) {
                        $team_img_2 = $this->request->getFile('team_img_2');
                        if ($team_img_2->isValid() && !$team_img_2->hasMoved()) {
                            $team_img_2->move('./assets/img/team/');
                            $new_team['team_img_2'] = $team_img_2->getName();
                        }
                    }

                    if ($this->request->getFile('team_img_3')) {
                        $team_img_3 = $this->request->getFile('team_img_3');
                        if ($team_img_3->isValid() && !$team_img_3->hasMoved()) {
                            $team_img_3->move('./assets/img/team/');
                            $new_team['team_img_3'] = $team_img_3->getName();
                        }
                    }

                    session()->setFlashdata('success', 'La sección <b>Equipo</b> ha sido actualizado');

                    $team_model->save($new_team);

                    return redirect()->to('/administrar-web');
                }
            } else if ($from_to == 'add_contact') {
                session()->setFlashdata('update_contact', 'true');

                $rules = [
                    'contact_address' => 'required|min_length[4]|max_length[1000]',
                    'contact_number' => 'required|min_length[4]|max_length[1000]',
                    'contact_mail' => 'required|min_length[4]|max_length[1000]|valid_email',
                    'contact_facebook' => 'required|min_length[4]|max_length[1000]',
                    'contact_instagram' => 'required|min_length[4]|max_length[1000]',
                ];

                $error = [
                    'contact_address' => [
                        'required' => 'Debe ingresar una dirección integrante',
                        'min_length' => 'La dirección debe tener 4 caracteres como mínimo',
                        'max_length' => 'La dirección debe tener 1000 caracteres como máximo',
                    ],
                    'contact_number' => [
                        'required' => 'Debe ingresar un numero de contacto integrante',
                        'min_length' => 'El numero de contacto debe tener 4 caracteres como mínimo',
                        'max_length' => 'El numero de contacto debe tener 1000 caracteres como máximo',
                    ],
                    'contact_mail' => [
                        'required' => 'Debe ingresar un correo integrante',
                        'min_length' => 'El correo debe tener 4 caracteres como mínimo',
                        'max_length' => 'El correo debe tener 1000 caracteres como máximo',
                        'valid_email' => 'Debe ingresar un correo valido'
                    ],
                    'contact_facebook' => [
                        'required' => 'Debe ingresar una cuenta de facebook',
                        'min_length' => 'La cuenta de facebook debe tener 4 caracteres como mínimo',
                        'max_length' => 'La cuenta de facebook debe tener 1000 caracteres como máximo',
                    ],
                    'contact_instagram' => [
                        'required' => 'Debe ingresar una cuenta de instragram',
                        'min_length' => 'La cuenta de instragram debe tener 4 caracteres como mínimo',
                        'max_length' => 'La cuenta de instragram debe tener 1000 caracteres como máximo',
                    ],
                ];

                if (!$this->validate($rules, $error)) {
                    $data['validation'] = $this->validator;
                } else {
                    $new_contact = [
                        'contact_id' => 1,
                        'contact_address' => $this->request->getPost('contact_address'),
                        'contact_number' => $this->request->getPost('contact_number'),
                        'contact_mail' => $this->request->getPost('contact_mail'),
                        'contact_facebook' => $this->request->getPost('contact_facebook'),
                        'contact_instagram' => $this->request->getPost('contact_instagram'),
                    ];

                    session()->setFlashdata('success', 'La sección <b>Contacto</b> ha sido actualizada');

                    $contact_model->save($new_contact);

                    return redirect()->to('/administrar-web');
                }
            }
        }

        $data['sidebar'] = true;
        $data['contact'] = $contact_model->find(1);
        $data['products'] = $product_model->findAll();
        $data['pages'] = $page_model->find(1);
        $data['team'] = $team_model->find(1);
        $data['orders'] = $order_model->orderBy('order_id', 'asc')
            ->findAll();

        return view('pages/admin/page', $data);
    }

    //----------------------------------------------------------------------------------------------------

    // EN DEPERURACIÓN...

    public function admin_gallery()
    {
        helper(['form']);

        $contact_model = new Contact_Model();
        $gallery_model = new Gallery_Model();
        $image_model = new Image_Model();
        $video_model = new Video_Model();

        if ($this->request->getMethod() == 'post') {
            $from_to = $this->request->getPost('from_to');
            if ($from_to == 'gallery') {
                $is_update = ($this->request->getPost('gallery_id') ? true : false);

                if ($is_update) {
                    session()->setFlashdata('edit_gallery', 'true');
                } else {
                    session()->setFlashdata('add_gallery', 'true');
                }

                $rules = [
                    'gallery_title' => 'required|min_length[4]|max_length[50]',
                    'gallery_date' => 'required|validate_date[gallery_date]',
                    'gallery_description' => 'required|min_length[4]|max_length[500]',
                ];

                if (!$is_update) {
                    $rules['gallery_img'] = 'uploaded[gallery_img.0]|max_size[gallery_img, 2048]|is_image[gallery_img]';
                }

                $error = [
                    'gallery_title' => [
                        'required' => 'Debe ingresar un título',
                        'min_length' => 'El título debe tener un mínimo de 4 caracteres',
                        'max_length' => 'El título debe tener un máximo de 50 caracteres',
                    ],
                    'gallery_date' => [
                        'required' => 'Debe ingresar una fecha',
                        'validate_date' => 'El formato de la fecha no es valido (debe ingresar: dd/mm/aaaa)',
                    ],
                    'gallery_description' => [
                        'required' => 'Debe ingresar una descripción',
                        'max_length' => 'La descripción debe tener un máximo de 500 caracteres',
                    ],
                    'gallery_img' => [
                        'uploaded' => 'Debe selecciónar imagenes para la galeria',
                        'max_size' => 'Las imaganes para la galeria no debe pesar mas de 2 mb',
                        'is_image' => 'Debe seleccionar un archivos en formato imagen para la galeria',
                    ],
                ];

                if (!$this->validate($rules, $error)) {
                    if ($is_update) {
                        $data['success'] = false;
                        $data['validation'] = $this->validator->getErrors();
                        return $this->response->setJSON($data);
                    } else {
                        $data['validation'] = $this->validator;
                    }
                } else {
                    $gallery_date = $this->request->getPost('gallery_date');
                    $gallery_date =  substr($gallery_date, -4) . "/" . substr($gallery_date, -7, 2) . "/" . substr($gallery_date, -10, 2);

                    $new_gallery = [
                        'gallery_title' => $this->request->getPost('gallery_title'),
                        'gallery_date' => $gallery_date,
                        'gallery_description' => $this->request->getPost('gallery_description'),
                        'gallery_status' => ($is_update ? $this->request->getPost('gallery_status') : ($this->request->getPost('gallery_status') == 'on' ? 0 : 1)),
                    ];

                    session()->setFlashdata('success', 'La galeria <b>"' . $this->request->getPost('gallery_title') . '"</b> ha sido ' . ($is_update ? 'actualizado' : 'agregado'));

                    if ($is_update) {
                        $new_gallery['gallery_id'] = $this->request->getPost('gallery_id');
                        $gallery_model->save($new_gallery);

                        $data['success'] = true;
                        return $this->response->setJSON($data);
                    } else {
                        $gallery_id = $gallery_model->insert($new_gallery);

                        if ($this->request->getFiles()) {
                            $images = $this->request->getFiles();
                            foreach ($images['gallery_img'] as $image) {
                                if ($image->isValid() && !$image->hasMoved()) {
                                    $image->move('./assets/img/gallery/');
                                    $new_image = [
                                        'image_path' => $image->getName(),
                                        'image_gallery' => ($is_update ? $this->request->getPost('gallery_id') : $gallery_id),
                                    ];

                                    $image_model->insert($new_image);
                                }
                            }
                        }

                        return redirect()->to(base_url('administrar-galeria'));
                    }
                }
            } else if ($from_to == 'image') {
                $rules['gallery_img'] = 'uploaded[gallery_img.0]|max_size[gallery_img, 2048]|is_image[gallery_img]';

                $error['gallery_img'] = [
                    'uploaded' => 'Debe selecciónar imagenes para la galeria',
                    'max_size' => 'Las imaganes para la galeria no debe pesar mas de 2 mb',
                    'is_image' => 'Debe seleccionar un archivos en formato imagen para la galeria',
                ];

                if (!$this->validate($rules, $error)) {
                    $data['validation'] = $this->validator;
                } else {
                    if ($this->request->getFiles()) {
                        $images = $this->request->getFiles();
                        foreach ($images['gallery_img'] as $image) {
                            if ($image->isValid() && !$image->hasMoved()) {
                                $image->move('./assets/img/gallery/');
                                $new_image = [
                                    'image_path' => $image->getName(),
                                    'image_gallery' => $this->request->getPost('gallery_id'),
                                ];

                                $image_model->insert($new_image);
                            }
                        }
                    }
                    session()->setFlashdata('success', 'Las imagenes han sido agregadas a la galeria <b>"' . $this->request->getPost('gallery_title') . '"</b>');
                    return redirect()->to(base_url('administrar-galeria'));
                }
            } else if ($from_to == 'video') {
                $is_update = ($this->request->getPost('video_id') ? true : false);

                if ($is_update) {
                    session()->setFlashdata('edit_video', 'true');
                } else {
                    session()->setFlashdata('add_video', 'true');
                }

                $rules = [
                    'video_title' => 'required|min_length[4]|max_length[50]',
                    'video_date' => 'required|validate_date[video_date]',
                    'video_url' => 'required|max_length[500]|validate_video[video_url]',
                    'video_description' => 'required|min_length[4]|max_length[500]',
                ];

                $error = [
                    'video_title' => [
                        'required' => 'Debe ingresar un título',
                        'min_length' => 'El título debe tener un mínimo de 4 caracteres',
                        'max_length' => 'El título debe tener un máximo de 50 caracteres',
                    ],
                    'video_date' => [
                        'required' => 'Debe ingresar una fecha',
                        'validate_date' => 'El formato de la fecha no es valido (debe ingresar: dd/mm/aaaa)',
                    ],
                    'video_url' => [
                        'required' => 'Debe ingresar una url',
                        'min_length' => 'La url debe tener un mínimo de 4 caracteres',
                        'max_length' => 'La url debe tener un máximo de 500 caracteres',
                        'validate_video' => 'Debe ingresar una url de youtube (https://www.youtube.com/...)'
                    ],
                    'video_description' => [
                        'required' => 'Debe ingresar una descripción',
                        'max_length' => 'La descripción debe tener un máximo de 500 caracteres',
                    ],
                ];

                if (!$this->validate($rules, $error)) {
                    if ($is_update) {
                        $data['success'] = false;
                        $data['validation'] = $this->validator->getErrors();
                        return $this->response->setJSON($data);
                    } else {
                        $data['validation'] = $this->validator;
                    }
                } else {
                    $video_date = $this->request->getPost('video_date');
                    $video_date =  substr($video_date, -4) . "/" . substr($video_date, -7, 2) . "/" . substr($video_date, -10, 2);

                    $new_video = [
                        'video_title' => $this->request->getPost('video_title'),
                        'video_description' => $this->request->getPost('video_description'),
                        'video_date' => $video_date,
                        'video_url' => str_replace('watch?v=', 'embed/', $this->request->getPost('video_url')),
                        'video_status' => ($is_update ? $this->request->getPost('video_status') : ($this->request->getPost('video_status') == 'on' ? 0 : 1)),
                    ];

                    if ($is_update)
                        $new_video['video_id'] = $this->request->getPost('video_id');

                    session()->setFlashdata('success', 'El video <b>"' . $this->request->getPost('video_title') . '"</b> ha sido ' . ($is_update ? 'actualizado' : 'agregado'));
                    $video_model->save($new_video);

                    if ($is_update) {
                        $data['success'] = true;
                        return $this->response->setJSON($data);
                    } else {
                        return redirect()->to(base_url('administrar-galeria'));
                    }
                }
            } else if ($from_to == 'delete_image') {
                $image_id = $this->request->getPost('image_id');

                $image = $image_model->find($image_id);
                $gallery = $gallery_model->find($image['image_gallery']);

                $count_images = $image_model->where('image_gallery', $gallery['gallery_id'])
                    ->countAllResults();

                $image_model->delete($image_id);

                if ($count_images == 1) {
                    $gallery_model->delete($gallery['gallery_id']);
                    session()->setFlashdata('success', 'La galeria <b>' . $gallery['gallery_title'] . '</b> ha sido eliminada satisfactoriamente');
                } else {
                    session()->setFlashdata('success', 'La imagen de la galeria <b>' . $gallery['gallery_title'] . '</b> ha sido eliminada satisfactoriamente');
                }

                $data['success'] = true;
                return $this->response->setJSON($data);
            }
        }

        $data['sidebar'] = true;
        $data['contact'] = $contact_model->find(1);
        $data['gallerys'] = $gallery_model->findAll();
        $data['images'] = $image_model->findAll();
        $data['videos'] = $video_model->findAll();

        return view('pages/admin/gallery', $data);
    }

    //--------------------------------------------------------------------

    private function user_session($user, $commune)
    {
        $data = [
            'user_id' => $user['user_id'],
            'user_rut' => $user['user_rut'],
            'user_fullname' => $user['user_fullname'],
            'user_email' => $user['user_email'],
            'user_phone' => $user['user_phone'],
            'user_address' => $user['user_address'],
            'user_profile' => $user['user_profile'],
            'user_commune' => $commune['commune_id'],
            'user_region' => $commune['province_region'],
            'user_loggedin' => true
        ];

        $user = array($data);
        session()->set('user', $user);
        return true;
    }

    private function generate_path($string)
    {
        $string = preg_replace('/[^a-z0-9\s\-]/i', '', $string);
        $string = preg_replace('/\s/', '-', $string);
        $string = preg_replace('/\-\-+/', '-', $string);
        $string = strtolower(trim($string, '-'));

        return $string;
    }
}
