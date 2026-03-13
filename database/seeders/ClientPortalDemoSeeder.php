<?php

namespace Database\Seeders;

use App\Models\ClientCompany;
use App\Models\ClientProject;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientPortalDemoSeeder extends Seeder
{
    public function run(): void
    {
        $company = ClientCompany::updateOrCreate(
            ['slug' => 'novichek-client-demo'],
            [
                'name' => 'ООО "Тестовый клиент"',
                'contact_person' => 'Иван Петров',
                'email' => 'client@example.com',
                'phone' => '+7 (900) 123-45-67',
                'inn' => '7701234567',
                'kpp' => '770101001',
                'ogrn' => '1237700123456',
                'address' => 'г. Москва, ул. Тестовая, д. 1',
                'notes' => 'Демо-компания для проверки кабинета заказчика',
            ]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@novichek.su'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'role' => 'admin',
                'is_admin' => true,
                'client_company_id' => null,
            ]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Иван Петров',
                'password' => 'password',
                'role' => 'client',
                'is_admin' => false,
                'client_company_id' => $company->id,
            ]
        );

        ClientProject::updateOrCreate(
            ['slug' => 'vnedrenie-1c-demo'],
            [
                'client_company_id' => $company->id,
                'manager_id' => $admin->id,
                'title' => 'Внедрение 1С и автоматизация заявок',
                'service_type' => '1С / Автоматизация',
                'status' => 'in_progress',
                'priority' => 'high',
                'description' => 'Демо-проект для тестирования личного кабинета и панели Nova.',
                'start_date' => now()->subDays(7)->toDateString(),
                'deadline' => now()->addDays(21)->toDateString(),
                'budget' => 150000,
                'currency' => 'RUB',
            ]
        );

        ClientProject::updateOrCreate(
            ['slug' => 'sait-i-podderzhka-demo'],
            [
                'client_company_id' => $company->id,
                'manager_id' => $admin->id,
                'title' => 'Корпоративный сайт и сопровождение',
                'service_type' => 'Web / Support',
                'status' => 'review',
                'priority' => 'medium',
                'description' => 'Второй демо-проект для проверки списка проектов.',
                'start_date' => now()->subDays(14)->toDateString(),
                'deadline' => now()->addDays(10)->toDateString(),
                'budget' => 90000,
                'currency' => 'RUB',
            ]
        );
    }
}