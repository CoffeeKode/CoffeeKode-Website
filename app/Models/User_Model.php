<?php

namespace App\Models;

use CodeIgniter\Model;

class User_Model extends Model
{
    protected $table      = 'tbl_user';
    protected $primaryKey = 'user_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_rut', 'user_fullname', 'user_email', 'user_phone', 'user_address', 'user_password', 'user_commune', 'user_profile', 'updated_at', 'deleted_at'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        $data['data']['created_at'] = date('Y-m-d H:i:s');

        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['user_password']))
            $data['data']['user_password'] = password_hash($data['data']['user_password'], PASSWORD_DEFAULT);

        return $data;
    }
}
