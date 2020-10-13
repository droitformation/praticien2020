<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        $this->call(ParentCategorieTableSeeder::class);
        $this->call(SubCategoriesTableSeeder::class);
        $this->call(RoleTableSeeder::class);
    }
}
