<?php

namespace App\Controllers;

use App\Models\Contact_Model;
use App\Models\Region_Model;
use App\Models\User_Model;
use App\Models\View_Commune_Model;
use App\Models\View_Order_Model;

class Client_Controller extends BaseController
{
    public function index()
    {
        $region_model = new Region_Model();
        $commune_model = new View_Commune_Model();
        $contact_model = new Contact_Model();

        if ($this->request->getMethod() == 'post') {
            helper(['form']);
            $user_model = new User_Model();

            if ($this->request->getPost('update')) {
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
                    session()->setFlashdata('success', 'Actualización exitosa');

                    $user = $user_model->find(array_values(session('user'))[0]['user_id']);

                    $commune = $commune_model->where('commune_id', $user['user_commune'])
                        ->first();

                    $this->user_session($user, $commune);
                }
            } else if ($this->request->getPost('password')) {
                session()->setFlashdata('env', 'password');

                $rules = [
                    'user_password' => 'validate_user[user_email, user_password]',
                    'user_new_password' => 'required|min_length[8]|max_length[255]',
                    'user_confirm_password' => 'matches[user_new_password]',
                ];

                $errors = [
                    'user_password' => [
                        'validate_user' => 'Clave Incorrecta'
                    ],
                    'user_new_password' => [
                        'required' => 'Debe ingresar una nueva contraseña',
                        'min_length' => 'La contraseña debe tener un mínimo de 8 caracteres',
                        'max_length' => 'La contraseña debe tener un máximo de 225 caracteres',
                    ],
                    'user_confirm_password' => [
                        'matches' => 'Las contraseñas no coinciden'
                    ]
                ];

                if (!$this->validate($rules, $errors)) {
                    $data['validation'] = $this->validator;
                } else {

                    $update_user = [
                        'user_id' => array_values(session('user'))[0]['user_id'],
                        'user_password' => $this->request->getPost('user_new_password'),
                    ];

                    $user_model->save($update_user);

                    session()->setFlashdata('success', 'Contraseña cambiada con extio');
                }
            }
        }

        $data['sidebar'] = true;
        $data['contact'] = $contact_model->find(1);
        $data['regions'] = $region_model->findAll();
        $data['communes'] = $commune_model->findAll();

        return view('pages/client/profile', $data);
    }

    public function client_orders()
    {
        $contact_model = new Contact_Model();
        $order_model = new View_Order_Model();

        $data['sidebar'] = true;
        $data['orders'] = $order_model->where('order_user', array_values(session('user'))[0]['user_id'])
            ->orderBy('order_id', 'asc')
            ->findAll();
        $data['contact'] = $contact_model->find(1);

        return view('pages/client/orders', $data);
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
}
