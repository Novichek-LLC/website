<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientCompany extends Resource
{
    /**
     * @var class-string<\App\Models\ClientCompany>
     */
    public static $model = \App\Models\ClientCompany::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'slug',
        'email',
        'phone',
        'inn',
        'ogrn',
    ];

    public static function label(): string
    {
        return 'Компании клиентов';
    }

    public static function singularLabel(): string
    {
        return 'Компания клиента';
    }

    /**
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Название', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug', 'slug')
                ->sortable()
                ->rules('required', 'max:255', 'unique:client_companies,slug,{{resourceId}}')
                ->creationRules('unique:client_companies,slug')
                ->updateRules('unique:client_companies,slug,{{resourceId}}'),

            Text::make('Контактное лицо', 'contact_person')
                ->hideFromIndex()
                ->rules('nullable', 'max:255'),

            Text::make('Email', 'email')
                ->sortable()
                ->rules('nullable', 'email', 'max:255'),

            Text::make('Телефон', 'phone')
                ->sortable()
                ->rules('nullable', 'max:255'),

            Text::make('ИНН', 'inn')
                ->sortable()
                ->rules('nullable', 'max:255'),

            Text::make('КПП', 'kpp')
                ->hideFromIndex()
                ->rules('nullable', 'max:255'),

            Text::make('ОГРН', 'ogrn')
                ->sortable()
                ->rules('nullable', 'max:255'),

            Text::make('Адрес', 'address')
                ->hideFromIndex()
                ->rules('nullable', 'max:1000'),

            Text::make('Примечания', 'notes')
                ->hideFromIndex()
                ->rules('nullable', 'max:2000'),

            HasMany::make('Пользователи', 'users', User::class),
            HasMany::make('Проекты', 'projects', ClientProject::class),
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