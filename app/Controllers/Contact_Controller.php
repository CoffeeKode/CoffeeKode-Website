<?php

namespace App\Controllers;

class Contact_Controller extends BaseController
{

    public function index()
    {
        $email = \Config\Services::email();

        $mail_to = 'lnmendez94@gmail.com';
        $name = $this->request->getVar('name');
        $mail_from = $this->request->getVar('email');
        $subject = 'Contacto Cliente: ' . $name;
        $message = $this->request->getVar('message');

        $email->setFrom($mail_from, $name);
        $email->setTo($mail_to);

        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            echo 'OK';
        } else {
            echo 'NO OK';
        }
    }
}
