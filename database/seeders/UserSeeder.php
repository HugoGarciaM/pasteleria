<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p=new Person();
        $p->ci=7329034;
        $p->name='cristian abalos';
        $p->save();

        $u=new User([
            'person_ci'=>7329034,
            // 'name'=>'cristian',
            // 'surname'=>'abalos',
            'role'=>1,
            'email' => 'cristianmanuel007@gmail.com',
            'password'=>'12345678'
        ]);
        $u->save();
    }
}
