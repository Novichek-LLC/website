<?php

namespace Database\Seeders;

use App\Models\KnowledgeArticle;
use App\Models\KnowledgeCategory;
use Illuminate\Database\Seeder;

class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => '1С и автоматизация',
                'slug' => '1c-automation',
                'description' => 'Материалы по внедрению 1С, учёту, бизнес-процессам и автоматизации.',
                'icon' => 'circle-stack',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Сайты и digital',
                'slug' => 'sites-digital',
                'description' => 'Статьи про сайты, UX, заявки, контент и digital-систему бизнеса.',
                'icon' => 'globe-alt',
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Инфраструктура и VPN',
                'slug' => 'infrastructure-vpn',
                'description' => 'Доступы, безопасность, удалённая работа и инфраструктурные решения.',
                'icon' => 'shield-check',
                'sort_order' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Игровые серверы',
                'slug' => 'game-servers',
                'description' => 'Материалы по Minecraft, Rust, стабильности, модификациям и запуску серверов.',
                'icon' => 'cpu-chip',
                'sort_order' => 40,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = KnowledgeCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            $this->seedArticles($category);
        }
    }

    protected function seedArticles(KnowledgeCategory $category): void
    {
        $articles = match ($category->slug) {
            '1c-automation' => [
                [
                    'title' => 'Когда бизнесу действительно нужна автоматизация',
                    'slug' => 'kogda-biznesu-deystvitelno-nuzhna-avtomatizaciya',
                    'excerpt' => 'Разбираем признаки хаоса в процессах, из-за которых компания теряет время, деньги и управляемость.',
                    'content' => '<h2>С чего начинается потребность в автоматизации</h2><p>Обычно бизнес приходит к автоматизации не потому, что “так модно”, а потому что процессы перестают масштабироваться вручную.</p><h2>Признаки проблемы</h2><ul><li>Заявки теряются между каналами</li><li>Учёт ведётся в таблицах и мессенджерах</li><li>Нет единого ответственного контура</li></ul><h2>Что даёт автоматизация</h2><p>Автоматизация снижает операционный хаос, ускоряет работу команды и делает систему предсказуемой.</p>',
                    'level' => 'base',
                    'reading_time' => 6,
                    'is_featured' => true,
                ],
                [
                    'title' => 'Как подготовить 1С к росту компании',
                    'slug' => 'kak-podgotovit-1c-k-rostu-kompanii',
                    'excerpt' => 'Что проверить в конфигурации, правах, процессах и интеграциях, если компания начинает расти.',
                    'content' => '<h2>Почему 1С перестаёт справляться</h2><p>Чаще всего проблема не в самой платформе, а в хаотичной настройке, правах и ручных обходных сценариях.</p><h2>На что смотреть</h2><ul><li>Роли и права</li><li>Регламенты работы</li><li>Интеграции</li><li>Резервирование и обновления</li></ul>',
                    'level' => 'middle',
                    'reading_time' => 8,
                    'is_featured' => false,
                ],
            ],
            'sites-digital' => [
                [
                    'title' => 'Почему сайт не продаёт: 7 типовых причин',
                    'slug' => 'pochemu-sait-ne-prodaet-7-tipovyh-prichin',
                    'excerpt' => 'Самые частые ошибки корпоративных сайтов, которые мешают получать заявки и доверие.',
                    'content' => '<h2>Проблема не всегда в дизайне</h2><p>Часто сайт выглядит “нормально”, но не отвечает на вопросы клиента и не ведёт к действию.</p><h2>Типовые причины</h2><ol><li>Непонятное позиционирование</li><li>Слабая структура</li><li>Нет сильного оффера</li><li>Формы не мотивируют оставить заявку</li></ol>',
                    'level' => 'base',
                    'reading_time' => 7,
                    'is_featured' => true,
                ],
                [
                    'title' => 'Как собрать сайт в систему продаж, а не просто витрину',
                    'slug' => 'kak-sobrat-sait-v-sistemu-prodazh-a-ne-prosto-vitrinu',
                    'excerpt' => 'Структура сильного сайта: оффер, сегменты, доверие, точки захвата и связка с CRM.',
                    'content' => '<h2>Сайт как часть системы</h2><p>Хороший сайт не существует отдельно — он связан с заявками, аналитикой, CRM и процессом обработки обращения.</p><h2>Что важно</h2><ul><li>Чёткий маршрут пользователя</li><li>Сильные точки захвата</li><li>Понятная сегментация услуг</li></ul>',
                    'level' => 'middle',
                    'reading_time' => 9,
                    'is_featured' => false,
                ],
            ],
            'infrastructure-vpn' => [
                [
                    'title' => 'Когда компании нужен VPN и защищённый удалённый доступ',
                    'slug' => 'kogda-kompanii-nuzhen-vpn-i-zaschishchennyy-udalennyy-dostup',
                    'excerpt' => 'Разбираем, когда без VPN уже опасно: удалёнка, филиалы, доступ к внутренним системам и конфиденциальные данные.',
                    'content' => '<h2>VPN — это не про “поставить галочку”</h2><p>Это часть инфраструктурной политики доступа и безопасности.</p><h2>Где особенно нужен VPN</h2><ul><li>Удалённые сотрудники</li><li>Доступ к 1С и внутренним сервисам</li><li>Филиальная работа</li><li>Защита административных панелей</li></ul>',
                    'level' => 'base',
                    'reading_time' => 6,
                    'is_featured' => true,
                ],
                [
                    'title' => 'Базовая схема безопасной инфраструктуры для малого бизнеса',
                    'slug' => 'bazovaya-shema-bezopasnoy-infrastruktury-dlya-malogo-biznesa',
                    'excerpt' => 'Минимум, который должен быть у компании: резервные копии, роли, доступы, сегментация и контроль.',
                    'content' => '<h2>Безопасность начинается с дисциплины</h2><p>Даже небольшой бизнес должен иметь базовые правила работы с доступами и резервными копиями.</p>',
                    'level' => 'middle',
                    'reading_time' => 8,
                    'is_featured' => false,
                ],
            ],
            'game-servers' => [
                [
                    'title' => 'Как выбрать основу для игрового сервера Minecraft',
                    'slug' => 'kak-vybrat-osnovu-dlya-igrovogo-servera-minecraft',
                    'excerpt' => 'Paper, Purpur, Fabric, Forge — что выбрать под онлайн, плагины, моды и производительность.',
                    'content' => '<h2>Основа сервера определяет почти всё</h2><p>От ядра зависит производительность, совместимость, модификации и удобство поддержки.</p><h2>Базовые варианты</h2><ul><li>Paper — баланс производительности и плагинов</li><li>Purpur — расширенная кастомизация</li><li>Fabric — лёгкие моды</li><li>Forge — тяжёлые сборки</li></ul>',
                    'level' => 'base',
                    'reading_time' => 7,
                    'is_featured' => true,
                ],
                [
                    'title' => 'Что важно для стабильного Rust-сервера',
                    'slug' => 'chto-vazhno-dlya-stabilnogo-rust-servera',
                    'excerpt' => 'Процессор, память, античит, карты, wipe-цикл и сопровождение Rust-сервера.',
                    'content' => '<h2>Rust чувствителен к инфраструктуре</h2><p>Здесь важна не только мощность, но и постоянное сопровождение: wipe, плагины, модерация, обновления.</p>',
                    'level' => 'middle',
                    'reading_time' => 8,
                    'is_featured' => false,
                ],
            ],
            default => [],
        };

        foreach ($articles as $articleData) {
            KnowledgeArticle::updateOrCreate(
                ['slug' => $articleData['slug']],
                array_merge($articleData, [
                    'knowledge_category_id' => $category->id,
                    'is_published' => true,
                    'published_at' => now(),
                    'seo_title' => $articleData['title'],
                    'seo_description' => $articleData['excerpt'],
                ])
            );
        }
    }
}