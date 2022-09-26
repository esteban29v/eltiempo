<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_product()
    {
        $token = env('BEARER_TOKEN_API_TEST');

        $data = [
            'name' => 'Test Product Name',
            'description' => 'Test Product Description',
            'price' => 9999.99,
            'in_stock' => 100,
        ];
        
        $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
            ])
            ->post('/api/product', $data);

        $response->assertStatus(200);

        $product = Product::where('name', $data['name'])->first();

        $this->assertEquals($data['name'], $product->name);
        $this->assertEquals($data['description'], $product->description);
        $this->assertEquals($data['price'], $product->price);
        $this->assertEquals($data['in_stock'], $product->in_stock);
        $this->assertEquals($product->active_for_sale, true);

    }
}
