<?php

namespace App\Models;

use CodeIgniter\Model;

class Gallery_Model extends Model
{
    protected $table = 'tbl_gallery';
    protected $primaryKey = 'gallery_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['gallery_title', 'gallery_description', 'gallery_date', 'gallery_status', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
