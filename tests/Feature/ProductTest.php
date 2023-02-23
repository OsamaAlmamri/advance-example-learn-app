<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::create([
            'name' => 'Car',
            'price' => 100
        ]);
    }

    public function test_user_can_list_products()
    {
        $response = $this->get('/products');

        $response->assertStatus(200)
            ->assertSee('Car');
    }

    public function test_user_can_see_product_details()
    {
        $response = $this->get('/products/' . $this->product->id);

        $response->assertStatus(200)
            ->assertSee('Car')
            ->assertSee('100');
    }


    public function test_a_product_can_belongs_to_a_category()
    {
        // arrange
        $product = Product::factory(1)->createOne();
        $category = Category::factory(1)->createOne();

        // to ensure that the DB does not has row with this conditions
        // assert
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'category_id' => $category->id,
        ]);

        // set category to product
        //act
        $product->setCategory($category);

        // to ensure that the DB has row with this conditions
        // assert
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'category_id' => $category->id,
        ]);
    }

}
