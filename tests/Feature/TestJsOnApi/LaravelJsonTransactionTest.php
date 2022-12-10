<?php

namespace Tests\Feature\TestJsOnApi;

use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase;

class LaravelJsonTransactionTest extends TestCase
{
    use MakesJsonApiRequests;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $this->withoutAuthorization();
        $this->student = Student::factory()->create();
    }

    public function withoutAuthorization()
    {
        Gate::before(function () {
            return true;
        });

        return $this;
    }

    public function testJsonUserReadsAllTransaction()
    {
        $transaction = Transaction::factory(2)->create(['student_id' => $this->student->id]);


        $response = $this->jsonApi()
            ->expects("transactions")
            ->get('api/v1/transactions');

        $response->assertStatus(200);
        $response->assertFetchedMany($transaction);
    }

    public function testJsonUserCreatesATransaction()
    {
        $data = [
            "type" => "transactions",
            "attributes" => [
                "transaction_name" => "pareil",
                "date" => "2018-01-01T12:00Z",
            ],
            "relationships" => [
                "student" => [
                    "data" => [
                        "type" => "students",
                        "id" => (string)$this->student->id,
                    ],
                ],
            ],
        ];

        $response = $this
            ->jsonApi()
            ->withData($data)
            ->post('api/v1/transactions');

        $response->assertStatus(201);
    }

    public function testJsonUserCanGetATransaction()
    {
        $student = Student::factory()->create();
        $transactions = Transaction::factory()->create(['student_id' => $student->id]);
        $response = $this
            ->jsonApi()
            ->expects('transactions')
            ->get('api/v1/transactions/' . $transactions->id);

        $response->assertStatus(200);
    }

    public function testJsonUserUpdateATransaction()
    {
        $transaction = Transaction::factory()->create(['student_id' => $this->student->id]);

        $data = [
            "type" => "transactions",
            "id" => (string)$transaction->id,
            "attributes" => [
                "transaction_name" => "pareil",
                "date" => "2018-01-01T12:00Z",
            ],
            "relationships" => [
                "student" => [
                    "data" => [
                        "type" => "students",
                        "id" => (string)$this->student->id,
                    ],
                ],
            ],
        ];

        $response = $this
            ->jsonApi()
            ->withData($data)
            ->patch('api/v1/transactions/' . $transaction->id);

        $response->assertStatus(200);
    }

    public function testJsonUserCanDeleteTransaction()
    {
        $student = Student::factory()->create();
        $transactions = Transaction::factory()->create(['student_id' => $student->id]);

        $response = $this
            ->jsonApi()
            ->delete('/api/v1/transactions/' . $transactions->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('transactions', [
            'id' => $transactions->id,
        ]);
    }
}
