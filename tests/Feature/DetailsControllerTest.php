<?php

namespace Tests\Feature;

use App\Models\CurrentBid;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetailsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_adding_a_higher_bid()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $highestBid = CurrentBid::factory()->create([
            'product_id' => $product->id,
            'price' => 1000,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('addBidmargin'), [
            'product_id' => $product->id,
            'newPrice' => 1500,
        ]);

        $this->assertDatabaseHas('current_bids', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'price' => 1500,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Offer added!');
    }

    /** @test */
    public function it_prevents_adding_a_lower_or_equal_bid()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $highestBid = CurrentBid::factory()->create([
            'product_id' => $product->id,
            'price' => 1000,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('addBidmargin'), [
            'product_id' => $product->id,
            'newPrice' => 1000,
        ]);

        $this->assertDatabaseMissing('current_bids', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'price' => 1000,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Price is equal or less than the last offer price!');
    }
}
