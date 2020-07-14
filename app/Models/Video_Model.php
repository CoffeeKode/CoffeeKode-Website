<?php

namespace App\Models;

use CodeIgniter\Model;

class Video_Model extends Model
{
    protected $table = 'tbl_video';
    protected $primaryKey = 'video_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['video_title', 'video_description', 'video_date', 'video_url', 'video_status', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
