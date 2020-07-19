<?php

use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
            'email' => '123@qwe.com',
            'password' => \Hash::make(12345678),
        ]);
        DB::table('users')->insert([
            'email' => '456@asd.com',
            'password' => '87654321'
        ]);
        DB::table('users')->insert([
            'email' => '789@zxc.com',
            'password' => '87654333'
        ]);
        DB::table('departments')->insert([
            'name' => 'Терапевтическое отделение'
        ]);
        DB::table('departments')->insert([
            'name' => 'Хирургическое отделение'
        ]);
        DB::table('departments')->insert([
            'name' => 'Стоматологическое отделение'
        ]);
        DB::table('doctors')->insert([
            'name' => 'Иванов',
            'education' => 'БГМУ',
            'experience' => '3 года в ГУ "Поликлиника №8"',
            'department_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('doctors')->insert([
            'name' => 'Петров',
            'education' => 'БГМУ',
            'experience' => '1 год в ГУ "Поликлиника №4"',
            'department_id' => 2,
            'user_id' => 2,
        ]);
        DB::table('doctors')->insert([
            'name' => 'Николаев',
            'education' => 'БГМУ',
            'experience' => '2 года в ГУ "Поликлиника №3"',
            'department_id' => 3,
            'user_id' => 3,
        ]);
        DB::table('schedules')->insert([
            'start' => new \DateTime('2020-07-10 08:00'),
            'end' => new \DateTime('2020-07-10 13:00'),
            'num_tickets' => 12,
            'doctor_id' => 2,
        ]);
    }
}
