<?php

use app\Helpers\AppConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('users')->insert([
            'username' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@timo.net',
            'account_type' => AppConstants::$ROLE_CODE_ADMIN,
            'password' => bcrypt('123456'),
            'staff_category' => "Not Applicable",
        ]);

    }
}
