<?php

namespace App\Models;

use CodeIgniter\Model;

class Contact_Model extends Model
{
    protected $table = 'tbl_contact';
    protected $primaryKey = 'contact_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['contact_address', 'contact_number', 'contact_mail', 'contact_facebook', 'contact_instagram', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
