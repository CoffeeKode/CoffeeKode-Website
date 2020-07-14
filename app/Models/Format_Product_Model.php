<?php

namespace App\Models;

use CodeIgniter\Model;

class Format_Product_Model extends Model
{
    protected $table = 'tbl_product_format';
    protected $primaryKey = 'format_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['format_title', 'format_description', 'format_weight', 'format_img', 'format_gif', 'format_price', 'format_old_price', 'format_stock',  'format_default',  'format_product', 'format_status', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
