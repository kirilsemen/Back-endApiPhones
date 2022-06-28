<?php

namespace Tests\Unit;

use App\Models\Orders;
use App\Models\Phones;
use Tests\TestCase;

class UserTest extends TestCase
{
    private function makeDummyRuleObject(int $id)
    {
        $phone = new Phones();

        $phone->id = $id;
        $phone->model = 'Samsung S21';
        $phone->price = 120.5;
        $phone->quantity = 5;

        return $phone;
    }

    /** @test */
    public function it_will_get_phones()
    {
        $response = $this->get('/api/v1/phones');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_will_create_order()
    {
        $phone = $this->makeDummyRuleObject(1);
        $response = $this->post('/api/v1/phones', [
            'phone_id' => $phone->id,
            'user_id' => '1',
            'amount' => '3',
            'total_price' => $phone->total_price * 3,
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_will_fail_cause_order_quantity_is_greater_than_phone_quantity()
    {
        $phone = $this->makeDummyRuleObject(1);
        $response = $this->post('/api/v1/phones', [
            'phone_id' => $phone->id,
            'user_id' => '1',
            'amount' => '6',
            'total_price' => $phone->total_price * 6,
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_will_receive_orders()
    {
        $response = $this->get('/api/v1/orders');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_will_receive_order_by_id()
    {
        $order = new Orders([
            'user_id' => 1,
            'phone_id' => 1,
            'amount'=> 2,
            'status' => 'complete',
            'total_price' => 100
        ]);
        $response = $this->get('/api/v1/orders' . $order->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_will_not_receive_order_cause_it_does_not_exists()
    {
        $response = $this->get('/api/v1/orders/5');

        $response->assertStatus(404);
    }
}
