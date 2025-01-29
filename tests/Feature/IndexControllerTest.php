<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase; // Testdan oldin va keyin bazani tozalaydi

    /** @test */
    public function it_displays_index_page_with_products()
    {
        $products = Product::factory()->count(3)->create(); // 3 ta mahsulot yaratamiz

        $response = $this->get(route('index'));

        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas('products', function ($productsFromView) use ($products) {
            return $productsFromView->pluck('id')->toArray() === $products->pluck('id')->toArray();
        });
    }
}
