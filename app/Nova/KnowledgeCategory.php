<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class KnowledgeCategory extends Resource
{
    public static $model = \App\Models\KnowledgeCategory::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'slug',
        'description',
    ];

    public static function label(): string
    {
        return 'Категории базы знаний';
    }

    public static function singularLabel(): string
    {
        return 'Категория базы знаний';
    }

    public static function group(): string
    {
        return 'Контент';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Название', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug', 'slug')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:knowledge_categories,slug')
                ->updateRules('unique:knowledge_categories,slug,{{resourceId}}'),

            Text::make('Описание', 'description')
                ->hideFromIndex()
                ->rules('nullable', 'max:1000'),

            Text::make('Иконка', 'icon')
                ->hideFromIndex()
                ->help('Например: book-open, cpu-chip, globe-alt')
                ->rules('nullable', 'max:255'),

            Number::make('Сортировка', 'sort_order')
                ->sortable()
                ->default(0)
                ->rules('required', 'integer', 'min:0'),

            Boolean::make('Активна', 'is_active')
                ->sortable()
                ->trueValue(1)
                ->falseValue(0),

            HasMany::make('Статьи', 'articles', KnowledgeArticle::class),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [];
    }

    public function filters(NovaRequest $request): array
    {
        return [];
    }

    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    public function actions(NovaRequest $request): array
    {
        return [];
    }
}