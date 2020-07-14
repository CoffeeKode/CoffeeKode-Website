<?php

namespace App\Controllers;

use App\Models\Contact_Model;
use App\Models\Format_Product_Model;
use App\Models\Gallery_Model;
use App\Models\Image_Model;
use App\Models\Page_Model;
use App\Models\Product_Model;
use App\Models\Team_Model;
use App\Models\User_Model;
use App\Models\Video_Model;
use App\Models\View_Commune_Model;

class Home_Controller extends BaseController
{

	public function index()
	{
		$page_model = new Page_Model();
		$contact_model = new Contact_Model();
		$product_model = new Product_Model();
		$team_model = new Team_Model();
		$format_product_model = new Format_Product_Model();
		$gallery_model = new Gallery_Model();
		$image_model = new Image_Model();

		$data['sidebar'] = null;
		$data['page'] = $page_model->find(1);
		$data['team'] = $team_model->find(1);
		$data['contact'] = $contact_model->find(1);
		$data['products'] = $product_model->where('product_status', 0)
			->findAll();
		$data['format_product'] = $format_product_model->where('format_default', 1)
			->findAll();
		$data['gallerys'] = $gallery_model->where('gallery_status', 0)
			->findAll();
		$data['images'] = $image_model->findAll();

		return view('pages/home', $data);
	}

	public function confirm_client()
	{

		if (session()->get('user')) {
			return redirect()->to('/confirmar-orden');
		}

		helper(['form']);

		$user_model = new User_Model();
		$commune_model = new View_Commune_Model();
		$contact_model = new Contact_Model();

		$data['contact'] = $contact_model->find(1);
		$data['sidebar'] = false;


		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('from') == 'login') {
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

					return redirect()->to('/confirmar-orden');
				}
			} else if ($this->request->getVar('from') == 'invited') {
				$rules = [
					'invited_rut' => 'required|max_length[10]',
					'invited_name' => 'required|min_length[4]|max_length[100]',
					'invited_email' => 'required|max_length[255]|valid_email',
					'invited_phone' => 'required|min_length[9]|max_length[9]',
				];

				$errors = [
					'invited_rut' => [
						'required' => 'Debe ingresar un rut',
						'max_length' => 'El rut debe tener el formato 12345678-9',
					],
					'invited_name' => [
						'required' => 'Debe ingresar un nombre',
						'min_length' => 'El nombre debe tener un mínimo de 4 caracteres',
						'max_length' => 'El nombre debe tener un máximo de 100 caracteres',
					],
					'invited_email' => [
						'required' => 'Debe ingresar un correo',
						'max_length' => 'El correo debe tener un máximo de 255 caracteres',
						'valid_email' => 'El correo no es valido',
					],
					'invited_phone' => [
						'required' => 'Debe ingresar un numero de teléfono',
						'min_length' => 'El numero telefónico debe tener 9 dígitos',
						'max_length' => 'El numero telefónico debe tener 9 dígitos',
					],
				];

				if (!$this->validate($rules, $errors)) {
					$data['validation'] = $this->validator;
				} else {
					$invited = [
						'invited_rut' => $this->request->getVar('invited_rut'),
						'invited_name' => $this->request->getVar('invited_name'),
						'invited_email' => $this->request->getVar('invited_email'),
						'invited_phone' => $this->request->getVar('invited_phone'),
					];

					session()->set($invited);
					return redirect()->to('/confirmar-orden');
				}
			}
		}

		return view('pages/login', $data);
	}

	public function recover_password()
	{
		helper(['form']);

		$contact_model = new Contact_Model();
		$user_model = new User_Model();

		if ($this->request->getMethod() == 'post') {
			$rules = [
				'recover_email' => 'required|valid_email',
			];

			$errors = [
				'recover_email' => [
					'required' => 'Debe ingresar un correo',
					'valid_email' => 'El correo no es valido'
				],
			];
			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {

				$user = $user_model->where('user_email', $this->request->getVar('recover_email'))
					->first();
				if ($user) {

					$password = $this->generateRandomString();

					$new_password = [
						'user_id' => $user['user_id'],
						'user_password' => $password,
					];

					$user_model->save($new_password);

					$email = \Config\Services::email();

					$mail_to = $user['user_email'];
					$name = $user['user_fullname'];
					$mail_from = 'recuperacion@colmenaspolo.cl';
					$subject = 'Solicitud de recuperación de contraseña';
					$message = "";
					$message .= "<link rel='stylesheet' href='" . base_url('/assets/css/bootstrap.min.css') . "'>";
					$message .= "Hola " . ucwords(mb_strtolower($name)) . "<br><br>";
					$message .= "Hemos recibido tu solicitud de recuperación de contraseña<br><br>";
					$message .= "Tu nueva contraseña es: <br><b>$password</b><br><br>";
					$message .= "Te recomendamos cambiar la contraseña una vez que ingreses a la colmena.";
					$message .= "<br><br>";
					$message .= "Saludos cordiales.<br>";
					$message .= "Colmenas Polo";

					$config['mailType'] = 'html';
					$email->initialize($config);

					$email->setFrom($mail_from, $name);
					$email->setTo($mail_to);

					$email->setSubject($subject);
					$email->setMessage($message);

					$email->send();

					session()->setFlashdata('success_recover', 'Se ha envido un correo de recuperación a <b>' . $this->request->getVar('recover_email') . '</b> con las indicaciones para recuperar su contraseña');
				} else {
					session()->setFlashdata('notfound_recover', 'El correo no esta asociado a ningun usuario ingresa <b><a href="http://ln.colmenaspolo.cl/registro-usuario">aquí</a></b> para registrarte');
				}
				return redirect()->to(base_url('recuperar-contrasena'));
			}
		}

		$data['sidebar'] = false;
		$data['contact'] = $contact_model->find(1);
		return view('pages/recover-password', $data);
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

	public function page_gallery()
	{
		$contact_model = new Contact_Model();
		$gallery_model = new Gallery_Model();
		$image_model = new Image_Model();
		$video_model = new Video_Model();

		$data['contact'] = $contact_model->find(1);
		$data['sidebar'] = false;
		$data['gallerys'] = $gallery_model->where('gallery_status', 0)
			->findAll();
		$data['images'] = $image_model->findAll();
		$data['videos'] = $video_model->where('video_status', 0)
			->findAll();

		return view('pages/gallery', $data);
	}

	//--------------------------------------------------------------------

	private function generateRandomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
