<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramBotService;
use Illuminate\Console\Command;

class TelegramDeleteWebhookCommand extends Command
{
    protected $signature = 'telegram:delete-webhook';
    protected $description = 'Delete Telegram webhook';

    public function handle(TelegramBotService $telegram): int
    {
        $result = $telegram->deleteWebhook();

        $this->info(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return self::SUCCESS;
    }
}