<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'wa_number'      => '6282242502468',
            'instagram_link' => 'https://www.instagram.com/bengkel.arsip/',
            'facebook_link'  => 'https://www.facebook.com/bengkel.arsip/',
            'email_link'   => 'https://www.youtube.com/@bengkelarsip3676',
        ];

        $this->db->table('social_media')->insert($data);
    }
}