<?php

namespace App\Models;

use CodeIgniter\Model;

class Store_Model extends Model
{
    protected $table      = 'tbl_store';
    protected $primaryKey = 'store_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['store_name', 'store_phone', 'store_address', 'store_commune', 'store_status', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
