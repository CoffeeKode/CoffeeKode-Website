<?php

namespace App\Models;

use CodeIgniter\Model;

class Page_Model extends Model
{
    protected $table = 'tbl_page';
    protected $primaryKey = 'page_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['page_title', 'page_slogan', 'page_about_us', 'page_about_us_img', 'page_our_product', 'page_our_product_img', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
