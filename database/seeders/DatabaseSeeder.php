<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([UserSeeder::class, BlogPostSeeder::class, CaseSeeder::class, LeadSeeder::class, ClientPortalDemoSeeder::class, KnowledgeBaseSeeder::class]);
    }
}
