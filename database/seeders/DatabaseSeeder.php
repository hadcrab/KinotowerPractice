<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Gender;
use App\Models\Country;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);


        Gender::factory()->create([ 'name' => 'Male']);
        Gender::factory()->create([ 'name' => 'Female']);

        Country::factory()->create([ 'name' => 'United States']);
        Country::factory()->create([ 'name' => 'Israel']);
        Country::factory()->create([ 'name' => 'Japan']);
        Country::factory()->create([ 'name' => 'Kazakhstan']);
        Country::factory()->create([ 'name' => 'China']);
        Country::factory()->create([ 'name' => 'Ukraine']);


        Category::factory()->create([ 'name' => 'Anime']);
        Category::factory()->create([ 'name' => 'Action']);
        Category::factory()->create([ 'name' => 'Adventure']);
        Category::factory()->create([ 'name' => 'Thriller']);
        Category::factory()->create([ 'name' => 'Science']);
        Category::factory()->create([ 'name' => 'Comedy']);
        Category::factory()->create([ 'name' => 'Sport']);
        Category::factory()->create([ 'name' => 'Drama']);
        Category::factory()->create([ 'name' => 'Horror']);

        Admin::factory()->create([
            'username' => 'Maksim',
            'email' => 'max@max.max',
            'password' => Hash::make('123456')
        ]);















    }
}
