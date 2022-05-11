<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $oauth_clients = array(
            array('id' => '1','user_id' => NULL,'name' => 'Laravel Password Grant Client','secret' => 'iQcrTGiRmjym24B94UNzTGubmig8jaKec2a3U1vt','provider' => 'users','redirect' => 'http://localhost','personal_access_client' => '0','password_client' => '1','revoked' => '0','created_at' => '2022-04-25 09:55:41','updated_at' => '2022-04-25 09:55:41')
          );
        DB::table('oauth_clients')
            ->insert($oauth_clients);
    }
}
