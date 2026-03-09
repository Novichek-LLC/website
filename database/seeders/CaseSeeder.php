<?php
namespace Database\Seeders;
use App\Models\CaseItem;
use Illuminate\Database\Seeder;
class CaseSeeder extends Seeder { public function run(): void { CaseItem::factory()->count(6)->create(); } }
