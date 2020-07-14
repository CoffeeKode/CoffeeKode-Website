<?php

namespace App\Validation;

use App\Models\User_Model;

class User_Rules
{
    public function validate_user(string $str, string $field, array $data)
    {
        $user_model = new User_Model();
        $user = $user_model->where('user_email', $data['user_email'])
            ->first();

        if (!$user)
            return false;
        return password_verify($data['user_password'], $user['user_password']);
    }
}
