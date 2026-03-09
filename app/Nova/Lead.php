<?php

namespace App\Nova;

use App\Nova\Actions\AssignLead;
use App\Nova\Actions\MarkLeadWon;
use App\Nova\Filters\LeadService;
use App\Nova\Filters\LeadStatus;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Lead extends Resource
{
    public static $model = \App\Models\Lead::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'email', 'phone', 'company', 'service'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Service', 'service')->sortable()->rules('required'),
            Text::make('Name', 'name')->sortable()->rules('required'),
            Text::make('Company', 'company')->hideFromIndex(),
            Text::make('Email', 'email')->sortable(),
            Text::make('Phone', 'phone')->sortable(),
            Text::make('Telegram', 'telegram')->hideFromIndex(),
            Textarea::make('Message', 'message')->alwaysShow(),
            Select::make('Status', 'status')->options([
                'new' => 'Новый',
                'in_progress' => 'В работе',
                'qualified' => 'Квалифицирован',
                'proposal' => 'КП',
                'won' => 'Успешно закрыт',
                'lost' => 'Потерян',
            ])->displayUsingLabels()->sortable(),
            Currency::make('Budget', 'budget')->currency('RUB')->nullable(),
            Text::make('Priority', 'priority')->sortable(),
            BelongsTo::make('Manager', 'manager', User::class)->nullable(),
            Textarea::make('Last Comment', 'last_comment')->hideFromIndex(),
            Code::make('Meta', 'meta')->json()->hideFromIndex(),
        ];
    }

    public function filters(Request $request): array
    {
        return [new LeadStatus, new LeadService];
    }

    public function actions(Request $request): array
    {
        return [new AssignLead, new MarkLeadWon];
    }
}
