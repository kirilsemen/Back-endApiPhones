<?php

namespace Tests\Unit;

use App\Models\Phones;
use Tests\TestCase;

class PhoneTest extends TestCase
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
    public function it_will_create_phone()
    {
        $phone = Phones::query()->create([
            'model' => 'Samsung S20',
            'price' => 120.5,
            'quantity'=> 5
        ]);

        $this->assertDatabaseHas('phones', [
            'id' => $phone->id
        ]);
    }

    /** @test */
    public function it_will_update_phone()
    {
        $phone = $this->makeDummyRuleObject(2);

        $phone->update([
            'quantity' => 3
        ]);

        $this->assertDatabaseHas('phones', [
            'id' => $phone->id,
            'quantity' => 3
        ]);
    }

    /** @test */
    public function it_will_delete_phone()
    {
        $phone = Phones::find(2);

        $phone->delete();

        $this->assertSoftDeleted('phones', [
            'id' => $phone->id,
        ]);
    }

    /** @test */
    public function it_will_restore_phone()
    {
        $phone = Phones::withTrashed()->find(2);

        $phone->restore();

        $this->assertDatabaseHas('phones', [
            'id' => $phone->id,
        ]);
    }
}
