<?php

namespace Tests\Feature;

use App\Models\BiddingHistory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase; // Testdan oldin va keyin bazani tozalaydi

    /** @test */
    public function it_displays_home_page_with_user_products_and_bidding_history()
    {
        $user = User::factory()->create(); // Foydalanuvchi yaratamiz
        $this->actingAs($user); // Uni tizimga kiritamiz

        // Ushbu foydalanuvchi yaratgan mahsulotlar
        $myProducts = Product::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        // Ushbu foydalanuvchining qatnashgan bidding tarixi
        $biddingHistory = BiddingHistory::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('myproducts', function ($products) use ($myProducts) {
            return $products->pluck('id')->toArray() === $myProducts->pluck('id')->toArray();
        });
        $response->assertViewHas('myproductBid', function ($bids) use ($biddingHistory) {
            return $bids->pluck('id')->toArray() === $biddingHistory->pluck('id')->toArray();
        });
    }

    /** @test */
    public function it_redirects_guests_to_login()
    {
        $response = $this->get(route('home'));

        $response->assertRedirect(route('login'));
    }
}
