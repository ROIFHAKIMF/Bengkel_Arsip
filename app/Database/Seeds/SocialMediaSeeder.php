<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'wa_number' => '6282242502468',
            'instagram' => 'https://www.instagram.com/bengkel.arsip/',
            'facebook'  => 'https://www.facebook.com/bengkel.arsip/',
            'youtube'   => 'https://www.youtube.com/@bengkelarsip3676',
            'email'     => 'bengkelarsip@gmail.com',
        ];

        $this->db->table('social_media')->insert($data);
    }
}