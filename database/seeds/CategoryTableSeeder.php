<?php

use CodeDelivery\Models\Category;
use CodeDelivery\Models\Product;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 5)->create()->each(function($u) {
            for($i=0; $i<=5; $i++) {
                $u->products()->save(factory(Product::class)->make());
            }
        });
    }
}
