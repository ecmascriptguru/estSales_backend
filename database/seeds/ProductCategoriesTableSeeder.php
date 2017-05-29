<?php

use Illuminate\Database\Seeder;
use App\ProductCategory as Category;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Create root node
        $root = Category::firstOrCreate(['category_name' => 'root']);
        $book = Category::firstOrCreate([
            'parent_id' => $root->id,
            'category_name' => "Book"
        ]);
    }
}
