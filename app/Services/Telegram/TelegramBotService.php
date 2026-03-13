<?php

namespace App\Services\Telegram;

use App\Models\TelegramSupportTicket;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotService
{
    private const SUPPORT_FLOW_PREFIX = 'telegram_support_flow:';

    public function handleUpdate(array $update): void
    {
        $message = Arr::get($update, 'message');
        $callbackQuery = Arr::get($update, 'callback_query');

        if ($message) {
            $this->handleMessage($message);
            return;
        }

        if ($callbackQuery) {
            $this->handleCallbackQuery($callbackQuery);
        }
    }

    protected function handleMessage(array $message): void
    {
        $chatId = Arr::get($message, 'chat.id');
        $text = trim((string) Arr::get($message, 'text', ''));
        $firstName = (string) Arr::get($message, 'from.first_name', '');
        $userId = Arr::get($message, 'from.id');

        if (! $chatId || ! $userId) {
            return;
        }

        if ($text === '/start') {
            $this->clearSupportFlow($userId);

            $this->sendMessage(
                chatId: $chatId,
                text: $this->startText($firstName),
                replyMarkup: $this->mainKeyboard()
            );
            return;
        }

        if (in_array($text, ['/help', 'Помощь', 'help'], true)) {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->helpText(),
                replyMarkup: $this->helpKeyboard()
            );
            return;
        }

        if (in_array($text, ['/site', 'Сайт'], true)) {
            $this->sendMessage(
                chatId: $chatId,
                text: 'Откройте официальный сайт ООО «НОВИЧЁК» по кнопке ниже.',
                replyMarkup: $this->siteKeyboard()
            );
            return;
        }

        if (in_array($text, ['/support', 'Поддержка'], true)) {
            $this->startSupportFlow($chatId, $userId);
            return;
        }

        if (in_array($text, ['/tickets', 'Мои заявки'], true)) {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->ticketsText($userId),
                replyMarkup: $this->ticketsKeyboard()
            );
            return;
        }

        if (in_array($text, ['/cancel', 'Отмена'], true)) {
            $this->clearSupportFlow($userId);

            $this->sendMessage(
                chatId: $chatId,
                text: 'Текущий сценарий отменён. Выберите следующее действие.',
                replyMarkup: $this->mainKeyboard()
            );
            return;
        }

        if ($this->handleSupportFlowMessage($message)) {
            return;
        }

        $this->sendMessage(
            chatId: $chatId,
            text: 'Я не понял запрос. Используйте меню ниже или команды /start, /help, /support, /tickets.',
            replyMarkup: $this->mainKeyboard()
        );
    }

    protected function handleCallbackQuery(array $callbackQuery): void
    {
        $callbackId = Arr::get($callbackQuery, 'id');
        $chatId = Arr::get($callbackQuery, 'message.chat.id');
        $fromId = Arr::get($callbackQuery, 'from.id');
        $data = (string) Arr::get($callbackQuery, 'data', '');

        if ($callbackId) {
            $this->answerCallbackQuery($callbackId);
        }

        if (! $chatId || ! $fromId) {
            return;
        }

        if ($data === 'help') {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->helpText(),
                replyMarkup: $this->helpKeyboard()
            );
            return;
        }

        if ($data === 'support_start') {
            $this->startSupportFlow($chatId, $fromId);
            return;
        }

        if ($data === 'tickets') {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->ticketsText($fromId),
                replyMarkup: $this->ticketsKeyboard()
            );
            return;
        }

        if ($data === 'faq_services') {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->faqServicesText(),
                replyMarkup: $this->helpKeyboard()
            );
            return;
        }

        if ($data === 'faq_contacts') {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->faqContactsText(),
                replyMarkup: $this->helpKeyboard()
            );
            return;
        }

        if ($data === 'faq_statuses') {
            $this->sendMessage(
                chatId: $chatId,
                text: $this->faqStatusesText(),
                replyMarkup: $this->helpKeyboard()
            );
            return;
        }

        if ($data === 'cancel_support') {
            $this->clearSupportFlow($fromId);

            $this->sendMessage(
                chatId: $chatId,
                text: 'Создание заявки отменено.',
                replyMarkup: $this->mainKeyboard()
            );
            return;
        }

        if ($data === 'back_home') {
            $this->sendMessage(
                chatId: $chatId,
                text: 'Главное меню бота.',
                replyMarkup: $this->mainKeyboard()
            );
            return;
        }
    }

    protected function handleSupportFlowMessage(array $message): bool
    {
        $userId = Arr::get($message, 'from.id');
        $chatId = Arr::get($message, 'chat.id');
        $text = trim((string) Arr::get($message, 'text', ''));

        if (! $userId || ! $chatId) {
            return false;
        }

        $flow = $this->getSupportFlow($userId);

        if (! $flow) {
            return false;
        }

        if (($flow['step'] ?? null) === 'await_subject') {
            if ($text === '') {
                $this->sendMessage(
                    chatId: $chatId,
                    text: 'Введите тему заявки одним сообщением.',
                    replyMarkup: $this->cancelKeyboard()
                );
                return true;
            }

            $flow['subject'] = mb_substr($text, 0, 255);
            $flow['step'] = 'await_message';
            $this->putSupportFlow($userId, $flow);

            $this->sendMessage(
                chatId: $chatId,
                text: 'Теперь кратко опишите проблему или запрос.',
                replyMarkup: $this->cancelKeyboard()
            );
            return true;
        }

        if (($flow['step'] ?? null) === 'await_message') {
            if ($text === '') {
                $this->sendMessage(
                    chatId: $chatId,
                    text: 'Описание не должно быть пустым. Отправьте текст заявки.',
                    replyMarkup: $this->cancelKeyboard()
                );
                return true;
            }

            $ticket = $this->createTicket($message, $flow['subject'], $text);
            $this->clearSupportFlow($userId);

            $this->sendMessage(
                chatId: $chatId,
                text: "Заявка #{$ticket->id} создана. Статус: {$ticket->status}.",
                replyMarkup: $this->afterTicketKeyboard()
            );

            $this->notifyAdminAboutTicket($ticket);

            return true;
        }

        return false;
    }

    protected function startSupportFlow(int|string $chatId, int|string $userId): void
    {
        $this->putSupportFlow($userId, [
            'step' => 'await_subject',
        ]);

        $this->sendMessage(
            chatId: $chatId,
            text: 'Создаём новую заявку. Сначала отправьте тему заявки одним сообщением.',
            replyMarkup: $this->cancelKeyboard()
        );
    }

    protected function createTicket(array $message, string $subject, string $body): TelegramSupportTicket
    {
        return TelegramSupportTicket::query()->create([
            'telegram_user_id' => (int) Arr::get($message, 'from.id'),
            'telegram_chat_id' => (string) Arr::get($message, 'chat.id'),
            'telegram_username' => Arr::get($message, 'from.username'),
            'first_name' => Arr::get($message, 'from.first_name'),
            'last_name' => Arr::get($message, 'from.last_name'),
            'subject' => $subject,
            'message' => $body,
            'status' => 'new',
        ]);
    }

    protected function ticketsText(int|string $userId): string
    {
        $tickets = TelegramSupportTicket::query()
            ->where('telegram_user_id', $userId)
            ->latest('id')
            ->limit(5)
            ->get();

        if ($tickets->isEmpty()) {
            return 'У вас пока нет заявок. Нажмите «Поддержка», чтобы создать первую.';
        }

        $lines = ['Ваши последние заявки:'];

        foreach ($tickets as $ticket) {
            $lines[] = "#{$ticket->id} — {$ticket->subject} [{$ticket->status}]";
        }

        return implode("\n", $lines);
    }

    protected function notifyAdminAboutTicket(TelegramSupportTicket $ticket): void
    {
        $adminChatId = config('services.telegram.admin_chat_id');

        if (! $adminChatId) {
            return;
        }

        $fullName = trim(($ticket->first_name ?? '').' '.($ticket->last_name ?? ''));
        $fullName = $fullName !== '' ? e($fullName) : 'Не указано';
        $username = $ticket->telegram_username ? '@'.e($ticket->telegram_username) : 'не указан';
        $subject = e($ticket->subject);
        $message = e($ticket->message);

        $text = "<b>Новая заявка</b>\n"
            . "ID: #{$ticket->id}\n"
            . "Пользователь: {$fullName}\n"
            . "Username: {$username}\n"
            . "Тема: {$subject}\n"
            . "Сообщение: {$message}";

        $this->sendMessage($adminChatId, $text);
    }

    public function setWebhook(): array
    {
        $url = rtrim(config('app.url'), '/') . '/api/telegram/webhook';

        return $this->request()->post('setWebhook', [
            'url' => $url,
            'secret_token' => config('services.telegram.webhook_secret'),
            'allowed_updates' => ['message', 'callback_query'],
        ])->json();
    }

    public function deleteWebhook(): array
    {
        return $this->request()->post('deleteWebhook')->json();
    }

    public function setCommands(): array
    {
        return $this->request()->post('setMyCommands', [
            'commands' => [
                ['command' => 'start', 'description' => 'Главное меню'],
                ['command' => 'help', 'description' => 'Помощь и FAQ'],
                ['command' => 'site', 'description' => 'Открыть сайт'],
                ['command' => 'support', 'description' => 'Создать заявку'],
                ['command' => 'tickets', 'description' => 'Мои заявки'],
                ['command' => 'cancel', 'description' => 'Отмена действия'],
            ],
        ])->json();
    }

    public function sendMessage(int|string $chatId, string $text, ?array $replyMarkup = null): array
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => false,
        ];

        if ($replyMarkup) {
            $payload['reply_markup'] = $replyMarkup;
        }

        $response = $this->request()->post('sendMessage', $payload);

        if ($response->failed()) {
            Log::error('telegram.send_message_failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->json();
    }

    protected function answerCallbackQuery(string $callbackId): array
    {
        return $this->request()->post('answerCallbackQuery', [
            'callback_query_id' => $callbackId,
        ])->json();
    }

    protected function request(): PendingRequest
    {
        $token = config('services.telegram.bot_token');

        return Http::baseUrl("https://api.telegram.org/bot{$token}/")
            ->acceptJson()
            ->asJson()
            ->timeout(15);
    }

    protected function startText(string $firstName): string
    {
        $name = $firstName !== '' ? e($firstName) : 'пользователь';

        return "Здравствуйте, {$name}!\n\n"
            . "Это официальный бот ООО «НОВИЧЁК». Здесь вы можете открыть сайт, получить быструю справку, создать заявку в поддержку и посмотреть свои последние обращения.";
    }

    protected function helpText(): string
    {
        return "Доступные команды:\n"
            . "/start — главное меню\n"
            . "/help — помощь и FAQ\n"
            . "/site — открыть сайт\n"
            . "/support — создать заявку\n"
            . "/tickets — мои заявки\n"
            . "/cancel — отменить текущее действие";
    }

    protected function faqServicesText(): string
    {
        return "Раздел услуг можно заполнить вашими реальными направлениями: разработка, сопровождение, интеграции, цифровые сервисы и поддержка клиентов.";
    }

    protected function faqContactsText(): string
    {
        return "Контакты лучше подтягивать из настроек сайта или отдельной таблицы: телефон, email, адрес, график работы.";
    }

    protected function faqStatusesText(): string
    {
        return "После создания заявки пользователь получает номер обращения. Далее можно вывести статусы: new, in_progress, done, closed.";
    }

    protected function mainKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Открыть сайт',
                        'url' => config('services.telegram.site_url'),
                    ],
                ],
                [
                    [
                        'text' => 'Поддержка',
                        'callback_data' => 'support_start',
                    ],
                    [
                        'text' => 'Мои заявки',
                        'callback_data' => 'tickets',
                    ],
                ],
                [
                    [
                        'text' => 'Помощь / FAQ',
                        'callback_data' => 'help',
                    ],
                ],
            ],
        ];
    }

    protected function helpKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Услуги',
                        'callback_data' => 'faq_services',
                    ],
                    [
                        'text' => 'Контакты',
                        'callback_data' => 'faq_contacts',
                    ],
                ],
                [
                    [
                        'text' => 'Статусы заявок',
                        'callback_data' => 'faq_statuses',
                    ],
                ],
                [
                    [
                        'text' => 'Назад',
                        'callback_data' => 'back_home',
                    ],
                ],
            ],
        ];
    }

    protected function siteKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Перейти на сайт',
                        'url' => config('services.telegram.site_url'),
                    ],
                ],
                [
                    [
                        'text' => 'Назад',
                        'callback_data' => 'back_home',
                    ],
                ],
            ],
        ];
    }

    protected function cancelKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Отменить создание заявки',
                        'callback_data' => 'cancel_support',
                    ],
                ],
            ],
        ];
    }

    protected function ticketsKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Создать новую заявку',
                        'callback_data' => 'support_start',
                    ],
                ],
                [
                    [
                        'text' => 'Назад',
                        'callback_data' => 'back_home',
                    ],
                ],
            ],
        ];
    }

    protected function afterTicketKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Мои заявки',
                        'callback_data' => 'tickets',
                    ],
                ],
                [
                    [
                        'text' => 'Главное меню',
                        'callback_data' => 'back_home',
                    ],
                ],
            ],
        ];
    }

    protected function supportFlowKey(int|string $userId): string
    {
        return self::SUPPORT_FLOW_PREFIX.$userId;
    }

    protected function getSupportFlow(int|string $userId): ?array
    {
        return Cache::get($this->supportFlowKey($userId));
    }

    protected function putSupportFlow(int|string $userId, array $payload): void
    {
        Cache::put($this->supportFlowKey($userId), $payload, now()->addMinutes(30));
    }

    protected function clearSupportFlow(int|string $userId): void
    {
        Cache::forget($this->supportFlowKey($userId));
    }
}