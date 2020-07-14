<?php

namespace App\Models;

use CodeIgniter\Model;

class Image_Model extends Model
{
    protected $table = 'tbl_image';
    protected $primaryKey = 'image_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['image_title', 'image_path', 'image_gallery', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
