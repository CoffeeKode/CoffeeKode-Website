<?php

namespace App\Models;

use CodeIgniter\Model;

class Order_Detail_Model extends Model
{
    protected $table      = 'tbl_order_detail';
    protected $primaryKey = ['detail_order', 'detail_format'];

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['detail_order', 'detail_format', 'detail_format_title', 'detail_format_weight', 'detail_format_quantity', 'detail_format_amount', 'updated_at', 'deleted_at'];
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
