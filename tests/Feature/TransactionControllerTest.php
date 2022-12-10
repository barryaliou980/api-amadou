<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $this->withoutAuthorization();
    }

    public function withoutAuthorization()
    {
        Gate::before(function () {
            return true;
        });

        return $this;
    }

    public function testUserCanGetAllTransaction()
    {
        $student = Student::factory()->create();
        Transaction::factory()->create(['student_id' => $student->id]);
        $response = $this->getJson(route('transactions.index'));
        $response->assertSuccessful();
    }

    public function testUserCanCreateTransaction()
    {
        $student = Student::factory()->create();
        $transaction = [
            'transaction_name' => 'vista',
            'date' => '2022-12-06',
            'student_id' => $student->id,
        ];
        $response = $this->postJson(route('transactions.store'), $transaction);
        $response->assertSuccessful();
    }

    public function testUserCanGetATransaction()
    {
        $student = Student::factory()->create();
        $transactions = Transaction::factory()->create(['student_id' => $student->id]);
        $response = $this->getJson(route('transactions.show', ['transaction' => $transactions]));
        $response->assertSuccessful();
    }

    public function testUserCanUpdateTransaction()
    {
        $student = Student::factory()->create();
        $transactions = Transaction::factory()->create(['student_id' => $student->id]);
        $playload = [
            'transaction_name' => 'updatevista',
            'date' => '2022-12-08',
            'student_id' => $student->id,
        ];
        $response = $this->putJson(route('transactions.update', ['transaction' => $transactions]), $playload);
        $response->assertSuccessful();
    }

    public function testUserCanDeleteTransaction()
    {
        $student = Student::factory()->create();
        $transactions = Transaction::factory()->create(['student_id' => $student->id]);
        $response = $this->deleteJson(route('transactions.destroy', ['transaction' => $transactions]));
        $response->assertSuccessful();
    }
}
