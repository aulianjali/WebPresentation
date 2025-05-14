<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorialMasterModel extends Model
{
    protected $table = 'tutorial_masters';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'judul', 'creator_email', 'url_presentation', 'url_finished'];
    protected $useTimestamps = true; 
}
