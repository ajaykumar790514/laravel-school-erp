<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserDetails;

class UserDetailsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserDetails::create([
            'user_id' =>"1",
            'mobile' =>'9451293997',
            'qualification' =>'MCA',
            'address' =>'Unnao'
        ]);
    }
}
