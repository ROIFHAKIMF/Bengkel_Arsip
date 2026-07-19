<?php

namespace App\Models;

use CodeIgniter\Model;

class KonsultasiModel extends Model
{
    protected $table = 'konsultasi_paket';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_paket', 'harga', 'deskripsi'];
}