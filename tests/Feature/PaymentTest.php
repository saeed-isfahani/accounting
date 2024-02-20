<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private $payment;

    public function setUp(): void
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');
    }

    /**
     * A basic feature test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * check currency datatype
     */
    public function test_save_payment_should_get_validation_error_if_currency_is_not_string(): void
    {
        $response = $this->post(route('payments.store'),[
            'currency' => 123,
            'amount' => 500,
            'rate' => 55000
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The currency field must be a string.'
        ]);
    }

    /**
     * check amount datatype
     */
    public function test_save_payment_should_get_validation_error_if_amount_is_not_number(): void
    {
        $response = $this->post(route('payments.store'),[
            'currency' => 'dollar',
            'amount' => '!500@',
            'rate' => 55000
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The amount field must have 0-2 decimal places.'
        ]);
    }

    /**
     * check rate datatype
     */
    public function test_save_payment_should_get_validation_error_if_rate_is_not_number(): void
    {
        $response = $this->post(route('payments.store'),[
            'currency' => 'dollar',
            'amount' => 500,
            'rate' => '!55000@'
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The rate field must be an integer.'
        ]);
    }

    /**
     * payment list should return 200 code and a list of payments
     */
    public function test_payment_list_should_return_ok_with_success_message(): void
    {
        $this->payment = Payment::factory()->count(10)->create();

        $response = $this->get(route('payments.list'));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => __('payments.messages.payment_list_found_successfully')
        ]);
    }

    /**
     * currency list should return 200 code and a list of currencies with details
     */
    public function test_currency_list_should_return_ok_with_list_of_currencies(): void
    {
        $this->payment = Payment::factory()->count(10)->create();

        $response = $this->get(route('currencies.list'));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => __('currencies.messages.currency_list_found_successfully')
        ]);
    }

    /**
     * currency list should return 200 code and a list of currencies with exact value that came in the task for checking currectness of calculating avg
     */
    public function test_currency_list_should_return_ok_with_exact_avg_rate(): void
    {
        $this->post(route('payments.store'),[
            'currency' => 'dollar',
            'amount' => 1000,
            'rate' => 500000
        ]);

        $this->post(route('payments.store'),[
            'currency' => 'dollar',
            'amount' => 600,
            'rate' => 550000
        ]);

        $response = $this->get(route('currencies.list'));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'avg_rate' => 518750
        ]);
    }
}
