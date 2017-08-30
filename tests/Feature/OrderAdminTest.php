<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\Models\Order;
use App\Models\Product;
use App\User;

class OrderAdminTest extends TestCase
{
      use DatabaseMigrations;

      protected function setUp()
      {
          parent::setUp();
          Artisan::call('migrate');
          Artisan::call('db:seed');
      }

      /**
       * @group order_admin
       */
      public function test_non_admin_cannot_access_orders_panel()
      {
          $user = User::find(4);
          $response = $this->get('/admin/orders')
              ->assertRedirect('/login');

          $this->actingAs($user)
              ->get('/admin/orders')
              ->assertSessionHas('error', 'Akses tidak diizinkan');
      }

      /**
       * @group order_admin
       */
      public function test_admin_can_access_orders_panel()
      {
          $user = User::find(2);

          $this->actingAs($user)
              ->get('/admin/orders')
              ->assertSee('Orders');
      }

      /**
       * @group order_admin
       */
      public function test_admin_can_view_order()
      {
          $user = User::find(2);
          $order = $this->seedOrder();

          $this->actingAs($user)
              ->get('/admin/orders/'.$order->order_no)
              ->assertSee('Detail Order');
      }

      /**
       * @group order_admin
       */
      public function test_admin_can_update_status_order()
      {
          $user = User::find(2);
          $order = $this->seedOrder();
          $postData = [
            'status' => 2
          ];
          $this->actingAs($user)
              ->put('/admin/orders/'.$order->id, $postData)
              ->assertSessionHas('success', 'Perubahan disimpan');
      }

      private function seedOrder()
      {
          $product = factory(Product::class)->create();
          $order = factory(Order::class)->create([
            'product_id' => $product->id
          ]);
          return $order;
      }
}
