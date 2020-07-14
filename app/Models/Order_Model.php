<?php

namespace App\Models;

use CodeIgniter\Model;

class Order_Model extends Model
{
    protected $table      = 'tbl_order';
    protected $primaryKey = 'order_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['order_date', 'order_amount', 'order_client_rut', 'order_client_fullname', 'order_client_email', 'order_client_phone', 'order_client_address', 'order_client_commune', 'order_user', 'order_store', 'order_status', 'updated_at', 'deleted_at'];
    // protected $beforeInsert = ['beforeInsert'];
    // protected $beforeUpdate = ['beforeUpdate'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // protected function beforeInsert(array $data)
    // {
    //     $data = $this->passwordHash($data);
    //     $data['data']['created_at'] = date('Y-m-d H:i:s');

    //     return $data;
    // }

    // protected function beforeUpdate(array $data)
    // {
    //     $data = $this->passwordHash($data);
    //     $data['data']['updated_at'] = date('Y-m-d H:i:s');
    //     return $data;
    // }
}
