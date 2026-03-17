<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            [
                'id' => 10,
                'username' => 'Erwan',
                'email' => 'manager@kla.com',
                'profile_photo' => 'profile_photos/ve865QgXorGdqfNsTFpl83nisUP7EApAYS5GAkZQ.png',
                'password' => '$2y$12$0Ypedt0nyMy371c/MnmNgOfI1v9GzVA9cQPNmG1QO98bLhu9jZ8jK',
                'role' => 'MASTER',
                'branch_id' => null,
                'created_at' => '2025-10-20 14:50:43',
                'updated_at' => '2026-01-11 04:28:02',
            ],

            [
                'id' => 11,
                'username' => 'Yogi-CE@smg',
                'email' => 'ce@klasmg.com',
                'profile_photo' => 'profile_photos/9wOiNp8kFkKdDt0aBal5ElrIHkDMmWndto8O9Go6.png',
                'password' => '$2y$12$3Yxb9y8WLjRvf9g9uw.AR..1qp/5C32N7U2H/fTHcT9YSXOkBssbO',
                'role' => 'CE',
                'branch_id' => 1,
                'created_at' => '2025-10-21 14:23:51',
                'updated_at' => '2026-01-06 18:56:32',
            ],

            [
                'id' => 12,
                'username' => 'Maulida-CM',
                'email' => 'cm@klamail.com',
                'profile_photo' => 'profile_photos/DeejX9GmWYzutEVdDCnisswrtp3NuMfHw60zqcYj.png',
                'password' => '$2y$12$YTr3Tu.bcO5GPxuZWHhIJu7WWrXyvZ/5uywyRQrfde3tqBBG.XixO',
                'role' => 'CM',
                'branch_id' => null,
                'created_at' => '2025-10-21 14:27:59',
                'updated_at' => '2026-01-11 05:58:43',
            ],

            [
                'id' => 14,
                'username' => 'Budi-CE@tgl',
                'email' => 'ce@klatgl.com',
                'profile_photo' => 'profile_photos/8Ccm4yXCfifOeZVw4Qcn5J4TZeI69cgD4VUrunwA.jpg',
                'password' => '$2y$12$0bnL9z9WeSMP.N5.nLlwruu6Z6dACaEldLieq94HpBQZiYVphdLO6',
                'role' => 'CE',
                'branch_id' => 3,
                'created_at' => '2025-10-31 12:34:48',
                'updated_at' => '2026-01-11 06:03:56',
            ],

            [
                'id' => 15,
                'username' => 'Agus-CE@slw',
                'email' => 'ce@klaslw.com',
                'profile_photo' => 'profile_photos/Cug27yKF3xbbwBsnKc6LxW5QkdChFOTBOij224S2.png',
                'password' => '$2y$12$1bT.bwAYanbDeGgHHBS/Cuslxyz5iM5L5KNJiJSqyT0dXgShoQ1Qq',
                'role' => 'CE',
                'branch_id' => 2,
                'created_at' => '2025-10-31 12:36:45',
                'updated_at' => '2025-12-27 01:11:47',
            ],

            [
                'id' => 16,
                'username' => 'Albert-CE@kdr',
                'email' => 'ce@klakdr.com',
                'profile_photo' => 'profile_photos/pWOP1hyJy8ooIdEec4fg7SvkwotU3YPjFHF9ZdJr.png',
                'password' => '$2y$12$q3iu7LTngeN.7gQi5YUqZughBrs4sKTnFabaGyoH13.dA/JidVJbC',
                'role' => 'CE',
                'branch_id' => 5,
                'created_at' => '2025-10-31 12:41:34',
                'updated_at' => '2026-01-06 20:07:41',
            ],

            [
                'id' => 17,
                'username' => 'Kevin-CE@pkl',
                'email' => 'ce@klapkl.com',
                'profile_photo' => 'profile_photos/id1DrgqxPDyntS4ikmNRljR7g4HhHEXHDwJ8AuL9.png',
                'password' => '$2y$12$HmWSR3Prg5JqptRqnkGGyuv1eZApIpnZqE5Yvq5Iv3UVZtFxTevNG',
                'role' => 'CE',
                'branch_id' => 4,
                'created_at' => '2025-10-31 12:42:43',
                'updated_at' => '2026-01-05 03:35:28',
            ],

             [
                'id' => 18,
                'username' => 'ayu',
                'email' => 'ayu@infokom.putra.com',
                'password' => '$2y$12$lM47oogX5IYdCABFQ1a9leK8lhi9NkWaV4S5.wZIpidVUzCVcUYJm',
                'role' => 'CS',
                'branch_id' => 1,   
            ],

        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );
        }
    }
}