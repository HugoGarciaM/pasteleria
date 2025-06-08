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
        $p->ci=7381803;
        $p->name='monzerrat arroyo';
        $p->save();

        $u=new User([
            'person_ci'=>7381803,
            // 'name'=>'cristian',
            // 'surname'=>'abalos',
            'role'=>1,
            'email' => 'admin@pasteleria.com',
            'password'=>'12345678'
        ]);
        $u->save();


        $p1=new Person();
        $p1->ci=7329035;
        $p1->name='example';
        $p1->save();

        $u1=new User([
            'person_ci'=>7329035,
            // 'name'=>'cristian',
            // 'surname'=>'abalos',
            'role'=>3,
            'email' => 'example@example.com',
            'password'=>'12345678'
        ]);
        $u1->save();
    }
}
