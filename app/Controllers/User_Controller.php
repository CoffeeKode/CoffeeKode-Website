<?php

namespace App\Controllers;

use App\Models\View_Commune_Model;
use App\Models\Contact_Model;
use App\Models\Region_Model;
use App\Models\User_Model;

class User_Controller extends BaseController
{
    public function index()
    {
        helper(['form']);
        $user_model = new User_Model();
        $commune_model = new View_Commune_Model();
        $contact_model = new Contact_Model();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'user_email' => 'required|valid_email',
                'user_password' => 'required|min_length[8]|max_length[255]|validate_user[user_mail, user_password]',
            ];

            $errors = [
                'user_email' => [
                    'required' => 'Debe ingresar un correo',
                    'valid_email' => 'El correo no es valido'
                ],
                'user_password' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'La contraseña debe tener un mínimo 8 caracteres',
                    'max_length' => 'La contraseña debe tener un máximo 225 caracteres',
                    'validate_user' => 'Correo o Contraseña no coincide'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation_user'] = $this->validator;
            } else {
                $user = $user_model->where('user_email', $this->request->getVar('user_email'))
                    ->first();

                $commune = $commune_model->where('commune_id', $user['user_commune'])
                    ->first();

                $invited = ['invited_rut', 'invited_name', 'invited_email', 'invited_phone'];
                session()->remove($invited);
                $this->user_session($user, $commune);

                return redirect()->to('/');
            }
        }

        $data['contact'] = $contact_model->find(1);
        $data['sidebar'] = false;
        $data['from'] = 'ingresar';

        return view('pages/login', $data);
    }

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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function register_user()
    {
        $data = [];
        helper(['form']);

        $contact_model = new Contact_Model();
        $region_model = new Region_Model();
        $commune_model = new View_Commune_Model();
        $user_model = new User_Model();

        if ($this->request->getMethod() == 'post') {
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
                    'required' => 'De ingresar su nombre',
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
                    'user_profile' => 2,
                    'user_password' => $this->request->getPost('user_password'),
                ];

                $user_model->insert($new_user);

                session()->setFlashdata('success', 'Tu registro ha sido exitoso');
                return redirect()->to('/registro-usuario');
            }
        }
        $data['contact'] = $contact_model->find(1);
        $data['regions'] = $region_model->findAll();
        $data['communes'] = $commune_model->findAll();
        $data['sidebar'] = false;

        return view('pages/register-user', $data);
    }

    public function change_password()
    {
        $user_model = new User_Model();

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
            $data['success'] = false;
            $data['validation'] = $this->validator->getErrors();
            return $this->response->setJSON($data);
        } else {

            $update_user = [
                'user_id' => array_values(session('user'))[0]['user_id'],
                'user_password' => $this->request->getPost('user_new_password'),
            ];

            $user_model->save($update_user);

            $data['success'] = true;
            return $this->response->setJSON($data);
        }
    }
}
