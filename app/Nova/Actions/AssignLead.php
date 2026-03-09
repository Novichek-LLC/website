<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class AssignLead extends Action
{
    use InteractsWithQueue, Queueable;

    public function name(): string
    {
        return 'Назначить менеджера';
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $lead) {
            $lead->update(['assigned_to' => $fields->assigned_to]);
        }

        return Action::message('Менеджер назначен');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Manager', 'assigned_to')
                ->options(\App\Models\User::query()->pluck('name', 'id')->all())
                ->rules('required'),
        ];
    }
}
