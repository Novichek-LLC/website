<?php

namespace App\Nova;

use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientProject extends Resource
{
    /**
     * @var class-string<\App\Models\ClientProject>
     */
    public static $model = \App\Models\ClientProject::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'title',
        'slug',
        'service_type',
        'status',
        'priority',
    ];

    public static function label(): string
    {
        return 'Проекты клиентов';
    }

    public static function singularLabel(): string
    {
        return 'Проект клиента';
    }

    /**
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Компания', 'company', ClientCompany::class)
                ->searchable()
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Менеджер', 'manager', User::class)
                ->nullable()
                ->searchable()
                ->sortable(),

            Text::make('Название', 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug', 'slug')
                ->sortable()
                ->rules('required', 'max:255', 'unique:client_projects,slug,{{resourceId}}')
                ->creationRules('unique:client_projects,slug')
                ->updateRules('unique:client_projects,slug,{{resourceId}}'),

            Text::make('Тип услуги', 'service_type')
                ->sortable()
                ->rules('nullable', 'max:255'),

            Select::make('Приоритет', 'priority')
                ->options([
                    'low' => 'Низкий',
                    'medium' => 'Средний',
                    'high' => 'Высокий',
                    'critical' => 'Критический',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required')
                ->default('medium'),

            Select::make('Статус', 'status')
                ->options([
                    'new' => 'Новый',
                    'in_progress' => 'В работе',
                    'waiting_client' => 'Ждёт клиента',
                    'review' => 'На проверке',
                    'done' => 'Завершён',
                    'paused' => 'На паузе',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required')
                ->default('new')
                ->hideFromIndex(),

            Badge::make('Статус', 'status')
                ->map([
                    'new' => 'info',
                    'in_progress' => 'warning',
                    'waiting_client' => 'danger',
                    'review' => 'warning',
                    'done' => 'success',
                    'paused' => 'danger',
                ])
                ->labels([
                    'new' => 'Новый',
                    'in_progress' => 'В работе',
                    'waiting_client' => 'Ждёт клиента',
                    'review' => 'На проверке',
                    'done' => 'Завершён',
                    'paused' => 'На паузе',
                ])
                ->onlyOnIndex(),

            Text::make('Описание', 'description')
                ->hideFromIndex()
                ->rules('nullable', 'max:5000'),

            Date::make('Дата старта', 'start_date')
                ->nullable()
                ->sortable(),

            Date::make('Дедлайн', 'deadline')
                ->nullable()
                ->sortable(),

            Currency::make('Бюджет', 'budget')
                ->currency($this->currency ?: 'RUB')
                ->sortable()
                ->rules('nullable', 'numeric'),

            Select::make('Валюта', 'currency')
                ->options([
                    'RUB' => 'RUB',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                ])
                ->displayUsingLabels()
                ->rules('required')
                ->default('RUB')
                ->hideFromIndex(),
        ];
    }

    /**
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}