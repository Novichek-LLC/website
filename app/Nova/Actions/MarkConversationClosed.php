<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MarkConversationClosed extends Action
{
    use InteractsWithQueue, Queueable;

    public function name(): string
    {
        return 'Закрыть диалог';
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $conversation) {
            $conversation->update(['status' => 'closed']);
        }

        return Action::message('Диалоги закрыты');
    }

    public function fields(\Laravel\Nova\Http\Requests\NovaRequest $request): array
    {
        return [];
    }
}
