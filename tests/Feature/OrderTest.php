<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;
use Faker\Factory;
use App\Models\Order;
use App\Models\Product;
use App\Jobs\NewOrderJob;
use App\Mail\orders\OrderCompleteToCustomer;
use App\Mail\orders\OrderCompleteToAdmin;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group order
     */
    public function test_user_can_accses_about_page()
    {
        $uri = '/tentang-negeri-para-pemimpi';
        // $this->get($uri)
        //     ->assertResponseStatus(200);
        $response = $this->get($uri);
        $response->assertStatus(200);
    }
    /**
     * @group order
     */
    public function test_user_cannot_submit_order_if_product_not_available()
    {
        $postData = $this->postData(5);
        Bus::fake();
        $response = $this->get('/tentang-negeri-para-pemimpi');
        $response->assertStatus(200);
        $response = $this->json('post','/order', $postData);
        $response->assertStatus(422);
    }
    /**
     * @group order
     */
    public function test_user_can_submit_order_if_product_available()
    {
        $postData = $this->postData(1);
        Bus::fake();
        $response = $this->get('/tentang-negeri-para-pemimpi');
        $response->assertStatus(200);
        $response = $this->json('post','/order', $postData);
        $response->assertStatus(200);
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create([
          'product_id' => $product->id
        ]);
        Bus::assertDispatched(NewOrderJob::class);
    }
    /**
     * @group order
     */
    public function test_customer_can_complete_order()
    {
        Mail::fake();
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create([
          'product_id' => $product->id
        ]);
        $response = $this->get('order/'.$order->email.'/'.$order->code);
        $response->assertSessionHas('success', 'Terimakasih atas verifikasi anda');

    }

    private function postData($product_id)
    {
        $faker = Factory::create();
        $postData = [
          'order_no' => uniqid(),
          'product_id' => $product_id,
          'name' => $faker->name,
          'email' => $faker->unique()->safeEmail,
          'phone' => $faker->e164PhoneNumber,
          'qty' => rand(1,5),
          'lat' => $faker->latitude,
          'lng' => $faker->longitude,
          'location' => $faker->city,
          'status' => 1,
          'code' => str_random(60),
          'address' => $faker->address
        ];
        return $postData;
    }
}
