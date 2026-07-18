<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimoniModel extends Model
{
    protected $table = 'testimoni';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'foto', 'ulasan', 'rating'];
}