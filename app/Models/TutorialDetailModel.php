<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorialDetailModel extends Model
{
    protected $table      = 'tutorial_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tutorial_id',
        'text',
        'tutor_order',
        'status',
        'url',
        'image',
        'code',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}
