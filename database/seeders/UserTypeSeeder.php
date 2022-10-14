<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserTypeSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('user_types')->truncate();

        DB::table('user_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title' => 'Super User',
                    'code' => '1',
                    'parent_id' => null,
                    'row_status' => 1,
                    'default_role_id' => '1'
                ),
            1 =>
                array(
                    'id' => 2,
                    'title' => 'LRMS Admin',
                    'code' => '2',
                    'parent_id' => null,
                    'row_status' => 1,
                    'default_role_id' => '2'
                ),
            2 =>
                array(
                    'id' => 3,
                    'title' => 'Acland',
                    'code' => '3',
                    'parent_id' => null,
                    'row_status' => 1,
                    'default_role_id' => '7'
                ),
            3 =>
                array(
                    'id' => 4,
                    'title' => 'uno',
                    'parent_id' => null,
                    'code' => '4',
                    'row_status' => 1,
                    'default_role_id' => '6'
                ),
            4 =>
                array(
                    'id' => 5,
                    'title' => 'DC',
                    'parent_id' => null,
                    'code' => '5',
                    'row_status' => 1,
                    'default_role_id' => '9'
                ),
            5 =>
                array(
                    'id' => 6,
                    'title' => 'Landless',
                    'parent_id' => null,
                    'code' => '6',
                    'row_status' => 1,
                    'default_role_id' => '4'
                ),
            6 =>
                array(
                    'id' => 7,
                    'title' => 'Tofsil',
                    'parent_id' => null,
                    'code' => '7',
                    'row_status' => 1,
                    'default_role_id' => '11'
                ),
            7 =>
                array(
                    'id' => 8,
                    'title' => 'Acland Office Assistant',
                    'parent_id' => 3,
                    'code' => '8',
                    'row_status' => 1,
                    'default_role_id' => '8'
                ),
            8 =>
                array(
                    'id' => 9,
                    'title' => 'Kanungo',
                    'parent_id' => 3,
                    'code' => '9',
                    'row_status' => 1,
                    'default_role_id' => '8'
                ),
            9 =>
                array(
                    'id' => 10,
                    'title' => 'Mutation Assistant',
                    'parent_id' => 7,
                    'code' => '10',
                    'row_status' => 1,
                    'default_role_id' => '11'
                ),
            10 =>
                array(
                    'id' => 11,
                    'title' => 'Surveyor',
                    'parent_id' => 7,
                    'code' => '11',
                    'row_status' => 1,
                    'default_role_id' => '12'
                ),
        ));


        DB::table('users')->truncate();

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'user_type_id' => 1,
            'role_id' => 1,
            'row_status' => 1,
            'password' => Hash::make('password')
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
