<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Enums\Status;
use App\Enums\Type_transaction;
use App\Models\Person;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssingDeliveryTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_assign_delivery_post(): void
    {
        $person = Person::create([
            'name' => 'cris',
            'ci' => 12345
        ]);
        $user = new User();
        $user->person_ci = $person->ci;
        $user->email = 'cris@gmail.com';
        $user->password = '12345678';
        $user->role = Role::PERSONAL;
        $user->status = true;
        $user->save();

        $person1 = Person::create([
            'name' => 'cliente',
            'ci' => 123456
        ]);
        $user1 = new User();
        $user1->person_ci = $person1->ci;
        $user1->email = 'cliente@gmail.com';
        $user1->password = '12345678';
        $user1->role = Role::CUSTOMERS;
        $user1->status = true;
        $user1->save();

        $transaction = new Transaction();
        $transaction->customer = $user1->id;
        $transaction->seller = $user->id;
        $transaction->lat = 11.3534;
        $transaction->long = -22.323;
        $transaction->total = 100;
        $transaction->status = Status::ENABLE;
        $transaction->type = Type_transaction::ONLINE;
        $transaction->save();
        $this->actingAs($user)->post(route('personal.sale.assignDelivery'),[
            'id_transaction' => $transaction->id,
            'id_delivery' => $user->id
        ]);

        $this->assertDatabaseHas('users',[
            'id' => $user->id
        ]);
    }
}
