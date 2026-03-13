<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class MarkConversationRead extends Action
{
    use Queueable;

    public function name(): string
    {
        return 'Отметить как прочитанное';
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $conversation) {
            $conversation->markGuestMessagesAsRead();
        }

        return Action::message('Сообщения отмечены как прочитанные');
    }

    public function fields(NovaRequest $request): array
    {
        return [];
    }
}