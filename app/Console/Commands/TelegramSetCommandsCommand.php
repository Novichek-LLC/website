<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramBotService;
use Illuminate\Console\Command;

class TelegramSetCommandsCommand extends Command
{
    protected $signature = 'telegram:set-commands';
    protected $description = 'Register Telegram bot commands';

    public function handle(TelegramBotService $telegram): int
    {
        $result = $telegram->setCommands();

        $this->info(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return self::SUCCESS;
    }
}