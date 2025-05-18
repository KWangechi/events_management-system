<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Create a default organization
        $newOrg = Organization::factory()->create([
            'name' => 'Default Organization',
            'slug' => 'default-organization',
        ]);


        // Create a user with the default organization
        User::factory()->create([
            'name' => 'Default User',
            'email' => 'defaultuser@example.com',
            'role' => User::ROLE['super_admin'],
            'organization_id' => $newOrg->id,
        ]);

        // Create 3 organizations and 2 users for each organization
        Organization::factory(3)->create()->each(function ($organization) {
            User::factory(2)->create();
        });
    }
}
