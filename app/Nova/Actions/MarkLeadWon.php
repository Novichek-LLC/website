<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MarkLeadWon extends Action
{
    use InteractsWithQueue, Queueable;

    public function name(): string
    {
        return 'Отметить как выигранный';
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $lead) {
            $lead->update(['status' => 'won']);
        }

        return Action::message('Сделка закрыта успешно');
    }

    public function fields(\Laravel\Nova\Http\Requests\NovaRequest $request): array
    {
        return [];
    }
}
