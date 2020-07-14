<?php

namespace App\Models;

use CodeIgniter\Model;

class Team_Model extends Model
{
    protected $table = 'tbl_team';
    protected $primaryKey = 'team_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['team_title_1', 'team_title_2', 'team_title_3', 'team_description_1', 'team_description_2', 'team_description_3', 'team_img_1', 'team_img_2', 'team_img_3', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
