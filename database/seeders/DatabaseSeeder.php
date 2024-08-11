<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VlBpartner;
use App\Models\VlOrder;
use App\Models\VlProduct;
use App\Models\VlProductCategory;
use App\Models\VlProductFamily;
use App\Models\VlProductLine;
use App\Models\VlProductSubLine;
use App\Models\VlUm;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     *  DOCUMENTACION 
     * 
     *  https://fakerphp.org/
     * 
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        #User::factory()->create([
        #    'name' => 'Test User',
        #    'email' => 'test@example.com',
        #]);
            
        User::factory(1000)->create();
        VlBpartner::factory(100)->create();
        VlOrder::factory(100)->create();
        //Creando Productos 
        VlProduct::factory(50)->create();        
         
        
    }
}
