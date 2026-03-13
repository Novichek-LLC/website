<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SeedPremiumNews extends Command
{
    protected $signature = 'news:seed-premium
        {--table= : Таблица для записи (по умолчанию ищется автоматически)}
        {--count=168 : Сколько материалов создать}
        {--fresh : Перезаписать ранее созданные этим скриптом материалы}';

    protected $description = 'Создаёт premium-наполнение для новостей/блога/базы знаний одним запуском';

    public function handle(): int
    {
        $table = $this->option('table') ?: $this->detectTable();

        if (! $table) {
            $this->error('Не удалось определить таблицу. Укажите её явно: --table=blog_posts или --table=knowledge_articles');
            return self::FAILURE;
        }

        if (! Schema::hasTable($table)) {
            $this->error("Таблица {$table} не существует.");
            return self::FAILURE;
        }

        $count = max(1, (int) $this->option('count'));
        $columns = Schema::getColumnListing($table);

        $dataset = $this->buildDataset($count);
        $categoryMap = $this->syncKnowledgeCategoriesIfNeeded($table, $columns, $dataset);

        $rows = [];
        $slugs = [];

        foreach ($dataset as $index => $item) {
            $row = $this->buildRow(
                table: $table,
                columns: $columns,
                item: $item,
                index: $index,
                categoryMap: $categoryMap
            );

            if (! empty($row)) {
                $rows[] = $row;
                if (isset($row['slug'])) {
                    $slugs[] = $row['slug'];
                }
            }
        }

        if (empty($rows)) {
            $this->error('Не удалось собрать записи для вставки. Проверь структуру таблицы.');
            return self::FAILURE;
        }

        if ($this->option('fresh') && in_array('slug', $columns, true) && ! empty($slugs)) {
            DB::table($table)->whereIn('slug', $slugs)->delete();
            $this->warn('Старые записи с теми же slug удалены.');
        }

        $uniqueBy = in_array('slug', $columns, true)
            ? ['slug']
            : (in_array('title', $columns, true) ? ['title'] : null);

        if (! $uniqueBy) {
            $this->error('В таблице нет ни slug, ни title. Не могу безопасно выполнить upsert.');
            return self::FAILURE;
        }

        $updateColumns = array_values(array_diff(array_keys($rows[0]), $uniqueBy, ['created_at']));

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table($table)->upsert($chunk, $uniqueBy, $updateColumns);
        }

        $this->info("Готово. Загружено/обновлено: " . count($rows) . " материалов в таблицу {$table}.");

        return self::SUCCESS;
    }

    protected function detectTable(): ?string
    {
        foreach (['blog_posts', 'knowledge_articles', 'posts', 'articles', 'news_posts'] as $candidate) {
            if (Schema::hasTable($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    protected function buildDataset(int $count): array
    {
        $items = [];

        foreach ($this->themes() as $theme) {
            foreach ($this->angles() as $angle) {
                $items[] = [
                    'theme' => $theme,
                    'angle' => $angle,
                ];
            }
        }

        return array_slice($items, 0, min($count, count($items)));
    }

    protected function buildRow(string $table, array $columns, array $item, int $index, array $categoryMap = []): array
    {
        $theme = $item['theme'];
        $angle = $item['angle'];

        $title = sprintf($angle['title_pattern'], $theme['title_phrase']);
        $slug = Str::slug($title);
        $excerpt = $this->makeExcerpt($theme, $angle);
        $content = $this->makeContent($theme, $angle);
        $coverPath = $this->generateCover($slug, $theme, $angle, $title);

        $publishedAt = now()->copy()->subDays($index * 2);
        $readingTime = 6 + ($index % 8);

        $row = [];

        if (in_array('title', $columns, true)) {
            $row['title'] = $title;
        }

        if (in_array('slug', $columns, true)) {
            $row['slug'] = $slug;
        }

        if (in_array('excerpt', $columns, true)) {
            $row['excerpt'] = $excerpt;
        } elseif (in_array('summary', $columns, true)) {
            $row['summary'] = $excerpt;
        }

        if (in_array('content', $columns, true)) {
            $row['content'] = $content;
        } elseif (in_array('body', $columns, true)) {
            $row['body'] = $content;
        }

        if (in_array('category', $columns, true)) {
            $row['category'] = $theme['category_name'];
        }

        if (in_array('category_slug', $columns, true)) {
            $row['category_slug'] = $theme['category_slug'];
        }

        if (in_array('knowledge_category_id', $columns, true) && isset($categoryMap[$theme['category_slug']])) {
            $row['knowledge_category_id'] = $categoryMap[$theme['category_slug']];
        }

        if (in_array('badge', $columns, true)) {
            $row['badge'] = $angle['badge'];
        }

        if (in_array('label', $columns, true)) {
            $row['label'] = $angle['badge'];
        }

        if (in_array('type', $columns, true)) {
            $row['type'] = $angle['type'];
        }

        if (in_array('reading_time', $columns, true)) {
            $row['reading_time'] = $readingTime;
        }

        if (in_array('level', $columns, true)) {
            $row['level'] = $angle['level'];
        }

        if (in_array('is_featured', $columns, true)) {
            $row['is_featured'] = $index % 8 === 0;
        }

        if (in_array('featured', $columns, true)) {
            $row['featured'] = $index % 8 === 0;
        }

        if (in_array('is_published', $columns, true)) {
            $row['is_published'] = true;
        }

        if (in_array('status', $columns, true)) {
            $row['status'] = 'published';
        }

        if (in_array('published_at', $columns, true)) {
            $row['published_at'] = $publishedAt;
        }

        if (in_array('seo_title', $columns, true)) {
            $row['seo_title'] = $title . ' — NOVICHEK';
        }

        if (in_array('seo_description', $columns, true)) {
            $row['seo_description'] = Str::limit($excerpt, 155);
        }

        foreach (['cover_path', 'image_path', 'image', 'cover_url', 'cover_image'] as $coverColumn) {
            if (in_array($coverColumn, $columns, true)) {
                $row[$coverColumn] = $coverPath;
            }
        }

        if (in_array('icon', $columns, true)) {
            $row['icon'] = $theme['icon'];
        }

        if (in_array('created_at', $columns, true)) {
            $row['created_at'] = $publishedAt;
        }

        if (in_array('updated_at', $columns, true)) {
            $row['updated_at'] = now();
        }

        return $row;
    }

    protected function syncKnowledgeCategoriesIfNeeded(string $table, array $columns, array $dataset): array
    {
        if ($table !== 'knowledge_articles' || ! in_array('knowledge_category_id', $columns, true)) {
            return [];
        }

        if (! Schema::hasTable('knowledge_categories')) {
            return [];
        }

        $categoryDefs = [];

        foreach ($dataset as $item) {
            $theme = $item['theme'];
            $categoryDefs[$theme['category_slug']] = [
                'name' => $theme['category_name'],
                'slug' => $theme['category_slug'],
                'description' => $theme['category_description'],
                'icon' => $theme['icon'],
                'sort_order' => $theme['sort_order'],
                'is_active' => true,
            ];
        }

        foreach ($categoryDefs as $category) {
            DB::table('knowledge_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        return DB::table('knowledge_categories')
            ->whereIn('slug', array_keys($categoryDefs))
            ->pluck('id', 'slug')
            ->toArray();
    }

    protected function generateCover(string $slug, array $theme, array $angle, string $title): string
    {
        $dir = public_path('generated/news-covers');

        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $path = $dir . '/' . $slug . '.svg';
        $titleShort = $this->svgText(Str::limit($title, 42, ''));
        $themeShort = $this->svgText($theme['category_name']);
        $badgeShort = $this->svgText($angle['badge']);
        $brandShort = 'NOVICHEK';

        $svg = <<<SVG
<svg width="1600" height="900" viewBox="0 0 1600 900" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1600" y2="900" gradientUnits="userSpaceOnUse">
      <stop stop-color="{$theme['cover_from']}"/>
      <stop offset="1" stop-color="{$theme['cover_to']}"/>
    </linearGradient>
    <radialGradient id="glow" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(1360 110) rotate(144.425) scale(430 320)">
      <stop stop-color="white" stop-opacity="0.18"/>
      <stop offset="1" stop-color="white" stop-opacity="0"/>
    </radialGradient>
  </defs>

  <rect width="1600" height="900" rx="40" fill="url(#bg)"/>
  <rect width="1600" height="900" rx="40" fill="url(#glow)"/>

  <circle cx="1420" cy="130" r="220" fill="white" fill-opacity="0.06"/>
  <circle cx="150" cy="780" r="210" fill="white" fill-opacity="0.04"/>

  <rect x="80" y="70" width="154" height="154" rx="36" fill="white" fill-opacity="0.12"/>
  <text x="132" y="170" fill="white" font-size="74" font-family="Inter, Arial, sans-serif" font-weight="800">N</text>

  <rect x="80" y="280" width="220" height="52" rx="26" fill="white" fill-opacity="0.10"/>
  <text x="110" y="314" fill="white" font-size="24" font-family="Inter, Arial, sans-serif" font-weight="700">{$brandShort}</text>

  <rect x="80" y="360" width="280" height="48" rx="24" fill="white" fill-opacity="0.08"/>
  <text x="110" y="391" fill="white" font-size="22" font-family="Inter, Arial, sans-serif" font-weight="600">{$badgeShort}</text>

  <text x="80" y="500" fill="white" font-size="32" font-family="Inter, Arial, sans-serif" font-weight="600" opacity="0.88">{$themeShort}</text>
  <text x="80" y="600" fill="white" font-size="74" font-family="Inter, Arial, sans-serif" font-weight="800">{$titleShort}</text>

  <rect x="80" y="688" width="520" height="84" rx="24" fill="white" fill-opacity="0.08"/>
  <text x="112" y="742" fill="white" font-size="28" font-family="Inter, Arial, sans-serif" font-weight="500">Automation • Digital • Infrastructure</text>
</svg>
SVG;

        File::put($path, $svg);

        return '/generated/news-covers/' . $slug . '.svg';
    }

    protected function svgText(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    protected function makeExcerpt(array $theme, array $angle): string
    {
        return sprintf(
            '%s Материал для %s: где компании теряют деньги, как правильно подойти к внедрению и какой результат должен получить бизнес на выходе.',
            $angle['excerpt_open'],
            $theme['audience']
        );
    }

    protected function makeContent(array $theme, array $angle): string
    {
        $painList = $this->htmlList([
            "Разрозненные процессы вокруг направления «{$theme['title_phrase']}».",
            "Потери времени на ручные операции: {$theme['pains'][0]}.",
            "Слабая управляемость и риск ошибок: {$theme['pains'][1]}.",
            "Нет единой логики роста и контроля качества: {$theme['pains'][2]}.",
        ], 'ul');

        $stepList = $this->htmlList([
            "Провести аудит текущего состояния: понять, что уже работает, а что только имитирует работу.",
            "Собрать рабочую архитектуру решения: {$theme['stack'][0]}, {$theme['stack'][1]}, {$theme['stack'][2]}.",
            "Определить ответственных, роли и правила взаимодействия между бизнесом, операционной частью и техблоком.",
            "Запустить этапно и заранее заложить сопровождение, аналитику и развитие.",
        ], 'ol');

        $resultList = $this->htmlList([
            "Понятный и управляемый контур: {$theme['results'][0]}.",
            "Снижение ручной нагрузки и меньше точек отказа: {$theme['results'][1]}.",
            "Реальный бизнес-эффект вместо набора несвязанных действий: {$theme['results'][2]}.",
        ], 'ul');

        $table = <<<HTML
<table>
  <thead>
    <tr>
      <th>Блок</th>
      <th>Что часто есть сейчас</th>
      <th>Как должно быть</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Процессы</td>
      <td>{$theme['pains'][0]}</td>
      <td>{$theme['results'][0]}</td>
    </tr>
    <tr>
      <td>Управление</td>
      <td>{$theme['pains'][1]}</td>
      <td>{$theme['results'][1]}</td>
    </tr>
    <tr>
      <td>Рост</td>
      <td>{$theme['pains'][2]}</td>
      <td>{$theme['results'][2]}</td>
    </tr>
  </tbody>
</table>
HTML;

        $intro = sprintf(
            '%s В компаниях это направление почти никогда не работает в изоляции: оно связано с заявками, внутренними процессами, доступами, аналитикой и скоростью принятия решений.',
            $angle['lead']
        );

        $focus = sprintf(
            'Для темы «%s» важно не просто выбрать инструмент, а собрать систему, в которой технология, люди и регламент работают как единый контур.',
            $theme['title_phrase']
        );

        $management = sprintf(
            'Руководителю важно смотреть не на “наличие проекта”, а на то, насколько решение усиливает бизнес: %s, %s, %s.',
            mb_strtolower($theme['results'][0]),
            mb_strtolower($theme['results'][1]),
            mb_strtolower($theme['results'][2])
        );

        $quote = sprintf(
            '“Сильное решение по теме %s — это не набор действий ради галочки, а управляемая система, которая даёт бизнесу скорость, контроль и предсказуемость.”',
            $theme['category_name']
        );

        $ending = sprintf(
            'Команда NOVICHEK подходит к этой теме системно: от аудита и проектирования до запуска, интеграций, сопровождения и дальнейшего роста. Именно это позволяет не просто “сделать задачу”, а вывести направление %s на рабочий уровень компании.',
            mb_strtolower($theme['title_phrase'])
        );

        return <<<HTML
<h2>{$angle['section_title']}</h2>
<p>{$intro}</p>
<p>{$focus}</p>

<h2>Где бизнес обычно теряет деньги и время</h2>
{$painList}

<h2>Практический подход к задаче</h2>
{$stepList}

<h2>Что важно видеть руководителю</h2>
<p>{$management}</p>
{$table}

<blockquote>{$quote}</blockquote>

<h2>Какой результат должен быть на выходе</h2>
{$resultList}

<h2>Почему здесь важна системная команда</h2>
<p>{$ending}</p>
<p>Когда тема связана с несколькими блоками сразу — например, учётом, сайтом, CRM, интеграциями, инфраструктурой и сопровождением — критично, чтобы все части проекта были собраны в одну логику. Тогда компания получает не разрозненный набор услуг, а рабочую систему с понятной ответственностью и прогнозируемым результатом.</p>
HTML;
    }

    protected function htmlList(array $items, string $type = 'ul'): string
    {
        $tag = $type === 'ol' ? 'ol' : 'ul';
        $html = "<{$tag}>";

        foreach ($items as $item) {
            $html .= "<li>{$item}</li>";
        }

        $html .= "</{$tag}>";

        return $html;
    }

    protected function themes(): array
    {
        return [
            [
                'category_name' => '1С и автоматизация',
                'category_slug' => '1c-automation',
                'category_description' => 'Материалы по внедрению 1С, учёту, автоматизации и управляемости бизнеса.',
                'title_phrase' => '1С и автоматизация учёта',
                'audience' => 'руководителей, бухгалтерии и операционных команд',
                'pains' => ['ручные операции и дублирование данных', 'ошибки в документах и отчётах', 'потеря управляемости при росте компании'],
                'results' => ['прозрачный учёт и понятные процессы', 'снижение ручной нагрузки', 'нормальную основу для роста и аналитики'],
                'stack' => ['1С', 'CRM', 'регламенты и роли'],
                'icon' => 'circle-stack',
                'cover_from' => '#454CEE',
                'cover_to' => '#1E3A8A',
                'sort_order' => 10,
            ],
            [
                'category_name' => 'Маркировка и retail-процессы',
                'category_slug' => 'marking-retail',
                'category_description' => 'Практика запуска маркировки, учёта и retail-процессов без хаоса.',
                'title_phrase' => 'маркировка товаров',
                'audience' => 'ритейла, e-commerce и операционных подразделений',
                'pains' => ['потеря контроля на складе и в учёте', 'ошибки при вводе и выбытии товара', 'ручная и нервная работа команды'],
                'results' => ['понятный и дисциплинированный процесс', 'снижение количества ошибок', 'стабильную работу учёта и операционного блока'],
                'stack' => ['учётную систему', 'рабочие процессы склада', 'связь с продажами и документами'],
                'icon' => 'qr-code',
                'cover_from' => '#2563EB',
                'cover_to' => '#0F766E',
                'sort_order' => 20,
            ],
            [
                'category_name' => 'Сайты и digital-система',
                'category_slug' => 'sites-digital',
                'category_description' => 'Сайты, UX, лидогенерация, структура и digital-система бизнеса.',
                'title_phrase' => 'корпоративный сайт и digital-система',
                'audience' => 'собственников бизнеса, маркетинга и digital-команд',
                'pains' => ['слабая структура и непонятное позиционирование', 'плохая конверсия в заявки', 'разрыв между сайтом, CRM и обработкой обращений'],
                'results' => ['понятный маршрут пользователя', 'лучшее качество заявок', 'рабочую связку сайта с остальными системами'],
                'stack' => ['сайт', 'аналитику и формы', 'CRM и внутренние сценарии обработки'],
                'icon' => 'globe-alt',
                'cover_from' => '#7C3AED',
                'cover_to' => '#0EA5E9',
                'sort_order' => 30,
            ],
            [
                'category_name' => 'Чат-боты и автоматизация',
                'category_slug' => 'bots-automation',
                'category_description' => 'Боты, уведомления, сценарии, CRM-логика и автоматизация рутинных действий.',
                'title_phrase' => 'чат-боты и автоматизация',
                'audience' => 'продаж, сервиса и внутренних команд',
                'pains' => ['потеря заявок и задержки в ответах', 'ручная рутина и повторяющиеся действия', 'непрозрачные сценарии коммуникации'],
                'results' => ['быстрые и понятные сценарии общения', 'освобождение команды от рутины', 'лучшую управляемость клиентского пути'],
                'stack' => ['боты', 'CRM-сценарии', 'уведомления и аналитику'],
                'icon' => 'chat-bubble-bottom-center-text',
                'cover_from' => '#4338CA',
                'cover_to' => '#0891B2',
                'sort_order' => 40,
            ],
            [
                'category_name' => 'VPN и инфраструктура',
                'category_slug' => 'vpn-infrastructure',
                'category_description' => 'Безопасность, доступы, удалённая работа, роли и базовая инфраструктура.',
                'title_phrase' => 'VPN и инфраструктура компании',
                'audience' => 'руководителей, IT-блока и распределённых команд',
                'pains' => ['неуправляемые доступы и риски безопасности', 'хаос в удалённой работе', 'нестабильная база для роста сервисов'],
                'results' => ['контролируемый доступ к системам', 'стабильную удалённую работу', 'инфраструктурный фундамент для развития'],
                'stack' => ['VPN', 'ролевую модель доступа', 'резервирование и базовую защиту'],
                'icon' => 'shield-check',
                'cover_from' => '#1D4ED8',
                'cover_to' => '#0F766E',
                'sort_order' => 50,
            ],
            [
                'category_name' => 'Дизайн и UX',
                'category_slug' => 'design-ux',
                'category_description' => 'UX/UI, визуальная система, интерфейсы и коммуникация бренда.',
                'title_phrase' => 'дизайн и UX-система',
                'audience' => 'digital-команд, маркетинга и product-направления',
                'pains' => ['визуальная разрозненность и слабая подача', 'неудобные интерфейсы', 'сложность масштабирования продукта'],
                'results' => ['понятную визуальную систему', 'рост удобства и доверия', 'устойчивую основу для продукта и контента'],
                'stack' => ['UX-логику', 'визуальный язык', 'компонентный подход'],
                'icon' => 'paint-brush',
                'cover_from' => '#9333EA',
                'cover_to' => '#2563EB',
                'sort_order' => 60,
            ],
            [
                'category_name' => 'Сопровождение и интеграции',
                'category_slug' => 'support-integrations',
                'category_description' => 'Пострелизное сопровождение, связка систем и работа без провалов между подрядчиками.',
                'title_phrase' => 'сопровождение и интеграции',
                'audience' => 'компаний, которым важна системность и развитие после запуска',
                'pains' => ['провалы после релиза', 'несвязанные системы и подрядчики', 'дорогие доработки без общей архитектуры'],
                'results' => ['единый контур развития', 'быстрые доработки без хаоса', 'стабильность и предсказуемость изменений'],
                'stack' => ['интеграции', 'сопровождение', 'регулярную аналитику и развитие'],
                'icon' => 'lifebuoy',
                'cover_from' => '#4F46E5',
                'cover_to' => '#0F766E',
                'sort_order' => 70,
            ],
            [
                'category_name' => 'Музыкальная дистрибуция',
                'category_slug' => 'music-distribution',
                'category_description' => 'Релизы, цифровая упаковка, сопровождение музыкальных проектов и системная работа с дистрибуцией.',
                'title_phrase' => 'музыкальная дистрибуция и релизы',
                'audience' => 'артистов, продюсеров и музыкальных команд',
                'pains' => ['хаос в выпуске релизов', 'слабая упаковка контента', 'отсутствие системного продвижения каталога'],
                'results' => ['аккуратный и профессиональный релизный контур', 'лучшее качество упаковки', 'устойчивую основу для развития каталога'],
                'stack' => ['дистрибуцию', 'метаданные и упаковку', 'сопровождение релизного цикла'],
                'icon' => 'musical-note',
                'cover_from' => '#BE185D',
                'cover_to' => '#7C3AED',
                'sort_order' => 80,
            ],
            [
                'category_name' => 'Игровые серверы Minecraft',
                'category_slug' => 'minecraft-servers',
                'category_description' => 'Запуск, сопровождение, ядра, плагины, онлайн и стабильность Minecraft-серверов.',
                'title_phrase' => 'Minecraft-сервер и его инфраструктура',
                'audience' => 'владельцев игровых проектов и серверных команд',
                'pains' => ['просадки производительности и лаги', 'хаос в плагинах и ядрах', 'слабое сопровождение сообщества и инфраструктуры'],
                'results' => ['стабильный сервер под рост онлайна', 'понятный стек и правила доработок', 'сильную основу для проекта и сообщества'],
                'stack' => ['ядро сервера', 'модификации и плагины', 'хостинг и сопровождение'],
                'icon' => 'cpu-chip',
                'cover_from' => '#059669',
                'cover_to' => '#2563EB',
                'sort_order' => 90,
            ],
            [
                'category_name' => 'Игровые серверы Rust',
                'category_slug' => 'rust-servers',
                'category_description' => 'Rust-серверы, wipe-цикл, производительность, плагины и сопровождение проекта.',
                'title_phrase' => 'Rust-сервер и его стабильность',
                'audience' => 'владельцев игровых серверов и liveops-команд',
                'pains' => ['нестабильность wipe-цикла и производительности', 'ошибки в конфигурации и плагинах', 'слабая управляемость игрового проекта'],
                'results' => ['предсказуемую инфраструктуру сервера', 'меньше аварий и лишних ручных действий', 'понятную модель развития проекта'],
                'stack' => ['конфигурацию Rust', 'плагины и модерацию', 'сопровождение и технический регламент'],
                'icon' => 'cpu-chip',
                'cover_from' => '#EA580C',
                'cover_to' => '#B91C1C',
                'sort_order' => 100,
            ],
            [
                'category_name' => 'Retail и e-commerce',
                'category_slug' => 'retail-ecommerce',
                'category_description' => 'Процессы продаж, учёт, digital и операционная система для торговли.',
                'title_phrase' => 'retail и e-commerce процессы',
                'audience' => 'ритейла, e-commerce и операционного менеджмента',
                'pains' => ['разрыв между онлайн- и офлайн-контуром', 'ошибки в обработке заказов', 'плохая связка продаж, склада и учёта'],
                'results' => ['единый маршрут заказа', 'лучшую операционную дисциплину', 'рост стабильности и качества сервиса'],
                'stack' => ['сайт или витрину', 'учёт и обработку заказов', 'аналитику и интеграции'],
                'icon' => 'briefcase',
                'cover_from' => '#2563EB',
                'cover_to' => '#7C3AED',
                'sort_order' => 110,
            ],
            [
                'category_name' => 'Клиентский портал и B2B-сервисы',
                'category_slug' => 'client-portal-b2b',
                'category_description' => 'Кабинеты клиентов, проекты, документы, статусы и сервисная коммуникация.',
                'title_phrase' => 'клиентский кабинет и B2B-сервис',
                'audience' => 'B2B-компаний, сервиса и проектных команд',
                'pains' => ['непрозрачность статусов для клиента', 'хаос в документах и коммуникации', 'слишком высокая нагрузка на менеджеров'],
                'results' => ['понятный портал для заказчика', 'меньше ручных уточнений', 'более зрелый уровень сервиса компании'],
                'stack' => ['личный кабинет', 'статусы проектов и документы', 'уведомления и сервисную логику'],
                'icon' => 'building-office-2',
                'cover_from' => '#4F46E5',
                'cover_to' => '#0EA5E9',
                'sort_order' => 120,
            ],
            [
                'category_name' => 'Аналитика и управленческая отчётность',
                'category_slug' => 'analytics-reporting',
                'category_description' => 'Дашборды, отчётность, метрики и прозрачность для управленческих решений.',
                'title_phrase' => 'аналитика и управленческая отчётность',
                'audience' => 'собственников, руководителей и аналитических функций',
                'pains' => ['отсутствие прозрачной картины по цифрам', 'ручные отчёты и задержки', 'непонятная экономика процессов'],
                'results' => ['ясную картину по метрикам', 'быстрые управленческие решения', 'понимание эффективности по направлениям'],
                'stack' => ['источники данных', 'дашборды', 'регулярную управленческую отчётность'],
                'icon' => 'book-open',
                'cover_from' => '#0284C7',
                'cover_to' => '#4338CA',
                'sort_order' => 130,
            ],
            [
                'category_name' => 'Пескоструйные работы',
                'category_slug' => 'sandblast-works',
                'category_description' => 'Подход к пескоструйным работам как к сервису с регламентом, качеством и управляемостью.',
                'title_phrase' => 'пескоструйные работы как сервис',
                'audience' => 'производственных и сервисных компаний',
                'pains' => ['нестабильное качество работ', 'непрозрачные сроки и контроль', 'разрыв между производством и клиентским сервисом'],
                'results' => ['предсказуемый уровень качества', 'понятную организацию процесса', 'более сильную сервисную модель для клиента'],
                'stack' => ['регламент работ', 'контроль качества', 'сервисную и проектную логику'],
                'icon' => 'wrench-screwdriver',
                'cover_from' => '#334155',
                'cover_to' => '#0F766E',
                'sort_order' => 140,
            ],
        ];
    }

    protected function angles(): array
    {
        return [
            [
                'title_pattern' => 'Как подготовить %s к запуску без хаоса',
                'badge' => 'Стратегия',
                'type' => 'Статья',
                'level' => 'base',
                'section_title' => 'С чего должен начинаться запуск',
                'lead' => 'Запуск проекта чаще всего срывается не из-за инструмента, а из-за неготовых процессов и ожиданий команды.',
                'excerpt_open' => 'Разбираем, как подойти к запуску системно.',
            ],
            [
                'title_pattern' => '7 типовых ошибок при работе с направлением «%s»',
                'badge' => 'Разбор',
                'type' => 'Разбор',
                'level' => 'base',
                'section_title' => 'Почему компании делают одни и те же ошибки',
                'lead' => 'Большинство ошибок повторяются: бизнес спешит, запускает инструмент без архитектуры и получает дорогую переделку.',
                'excerpt_open' => 'Показываем типовые ошибки и объясняем, как их не повторить.',
            ],
            [
                'title_pattern' => 'Чек-лист: как правильно запустить %s',
                'badge' => 'Чек-лист',
                'type' => 'Инструкция',
                'level' => 'base',
                'section_title' => 'Практический чек-лист перед запуском',
                'lead' => 'Когда у компании нет чек-листа, запуск превращается в набор хаотичных действий с непредсказуемым результатом.',
                'excerpt_open' => 'Пошаговый материал для тех, кто хочет запустить направление без провалов.',
            ],
            [
                'title_pattern' => 'Как бизнесу окупается %s',
                'badge' => 'Экономика',
                'type' => 'Статья',
                'level' => 'middle',
                'section_title' => 'Где в этой теме лежит экономика',
                'lead' => 'Окупаемость здесь редко проявляется “в лоб” — обычно она складывается из снижения потерь, ускорения процессов и роста управляемости.',
                'excerpt_open' => 'Разбираем, где у направления появляется реальная экономика для компании.',
            ],
            [
                'title_pattern' => 'Архитектура решения: как собирать %s правильно',
                'badge' => 'Архитектура',
                'type' => 'Разбор',
                'level' => 'advanced',
                'section_title' => 'Почему архитектура важнее отдельных инструментов',
                'lead' => 'Когда компания покупает отдельные куски решения без общей схемы, она платит дважды: на старте и на переделке.',
                'excerpt_open' => 'Показываем, как собирать архитектуру решения на зрелом уровне.',
            ],
            [
                'title_pattern' => 'Риски и безопасность: что важно знать про %s',
                'badge' => 'Риски',
                'type' => 'Статья',
                'level' => 'middle',
                'section_title' => 'Где здесь находятся реальные риски',
                'lead' => 'У любой технологической или сервисной инициативы есть риски: операционные, организационные, инфраструктурные и репутационные.',
                'excerpt_open' => 'Разбираем риски, которые руководитель не должен игнорировать.',
            ],
            [
                'title_pattern' => 'Как связать %s с остальными системами компании',
                'badge' => 'Интеграции',
                'type' => 'Инструкция',
                'level' => 'middle',
                'section_title' => 'Почему интеграции определяют зрелость проекта',
                'lead' => 'Пока решение живёт отдельно от остального бизнеса, команда продолжает вручную соединять куски процесса.',
                'excerpt_open' => 'Материал о том, как правильно встроить направление в общую систему компании.',
            ],
            [
                'title_pattern' => 'Почему %s требует сопровождения, а не только запуска',
                'badge' => 'Сопровождение',
                'type' => 'Статья',
                'level' => 'middle',
                'section_title' => 'Что происходит после старта',
                'lead' => 'Самая дорогая иллюзия — думать, что после релиза работа заканчивается. На практике всё только начинается.',
                'excerpt_open' => 'Объясняем, почему сопровождение влияет на итоговый результат не меньше запуска.',
            ],
            [
                'title_pattern' => 'Как масштабировать %s без потери качества',
                'badge' => 'Масштабирование',
                'type' => 'Разбор',
                'level' => 'advanced',
                'section_title' => 'Что ломается при росте',
                'lead' => 'Почти любое решение неплохо работает “на малом объёме”, но начинает трещать, когда бизнес растёт.',
                'excerpt_open' => 'Разбираем, как подготовить направление к росту нагрузки и масштаба.',
            ],
            [
                'title_pattern' => 'Что руководителю нужно знать про %s до старта проекта',
                'badge' => 'Для руководителя',
                'type' => 'Статья',
                'level' => 'base',
                'section_title' => 'Взгляд собственника и руководителя',
                'lead' => 'У руководителя одна ключевая задача — понимать не детали инструмента, а логику результата и контроля.',
                'excerpt_open' => 'Материал для руководителя: на что смотреть до запуска и что требовать от команды.',
            ],
            [
                'title_pattern' => 'Практический сценарий: как компания усиливает %s',
                'badge' => 'Практика',
                'type' => 'Разбор',
                'level' => 'middle',
                'section_title' => 'Как это выглядит на практике',
                'lead' => 'Хорошие решения хорошо видны в реальных сценариях: там заметно, где компания экономит время, деньги и нервы.',
                'excerpt_open' => 'Показываем практический сценарий внедрения и развития направления.',
            ],
            [
                'title_pattern' => 'FAQ: частые вопросы бизнеса по теме «%s»',
                'badge' => 'FAQ',
                'type' => 'FAQ',
                'level' => 'base',
                'section_title' => 'Частые вопросы, которые задают до старта',
                'lead' => 'Почти каждый проект начинается с одних и тех же вопросов: сколько это длится, как контролировать результат и что будет после запуска.',
                'excerpt_open' => 'Собрали ответы на вопросы, которые чаще всего задают заказчики.',
            ],
        ];
    }
}