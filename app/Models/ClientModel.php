<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'client'; // atau 'clients', sesuaikan dengan nama tabel kamu
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'gambar', 'deskripsi'];
}
