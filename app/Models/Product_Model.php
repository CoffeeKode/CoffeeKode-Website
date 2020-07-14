<?php namespace App\Models;

use CodeIgniter\Model;

class Product_Model extends Model
{
    protected $table = 'tbl_product';
    protected $primaryKey = 'product_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['product_title', 'product_description', 'product_bg', 'product_path', 'product_status', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
