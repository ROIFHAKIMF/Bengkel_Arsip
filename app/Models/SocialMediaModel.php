<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaModel extends Model
{
    protected $table = 'social_media';
    protected $primaryKey = 'id';
    protected $allowedFields = ['wa_number', 'instagram', 'facebook', 'youtube', 'email'];
}