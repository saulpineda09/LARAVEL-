<?php
//se modidfica el archivo Pest.php para agregar el trait RefreshDatabase
use App\Models\Product;

test('example', function () {

    Product::factory()->count(15)->create();

    $response = $this->getJson('/api/product?per_page=5&page=0');

    $response
        ->assertStatus(200)
        ->assertJsonCount(5, 'data');

    $data = $response->json('data');
    expect(count($data))->toBe(5);
});
