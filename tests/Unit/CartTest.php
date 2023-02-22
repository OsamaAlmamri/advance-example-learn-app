<?php

namespace Tests\Unit;

use App\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public $cart;

    public function setUp(): void
    {
        $cart = new Cart;

        $item = array(
            'id' => 'sku_123ABC',
            'qty' => 1,
            'price' => 39.95,
            'name' => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        );

        $cart->insert($item);
        $this->cart = $cart;
        $this->assertCount(1, $this->cart->getItems());
    }

    public function testWeCanAddAnItemToTheCart()
    {
        $this->assertCount(1, $this->cart->getItems());
    }
//

    /** @test */
    public function TestWeCanCountItem()
    {
        $this->assertEquals(1, $this->cart->count());
    }
//

    /** @test */
    public function TestWeCanCalculateTheTotalAmount()
    {
        $this->assertEquals(39.95, $this->cart->total());
    }
}
