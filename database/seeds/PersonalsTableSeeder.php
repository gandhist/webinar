<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PersonalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 200; $i++){
 
            // insert data ke table pegawai menggunakan Faker
          DB::table('personal')->insert([
              'id' => $i+2,
              'nama' => $faker->name,
              'no_hp' => $faker->phoneNumber,
              'email' => $faker->email,
              'pekerjaan' => $faker->jobTitle,
              'instansi' => $faker->company,
              'alamat' => $faker->address,
              'foto' => 'sample_foto_'.$i,
          ]);

      }
    }
}
