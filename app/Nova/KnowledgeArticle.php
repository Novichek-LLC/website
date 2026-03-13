<?php

namespace App\Nova;

use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class KnowledgeArticle extends Resource
{
    public static $model = \App\Models\KnowledgeArticle::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'title',
        'slug',
        'excerpt',
        'seo_title',
        'seo_description',
    ];

    public static function label(): string
    {
        return 'Статьи базы знаний';
    }

    public static function singularLabel(): string
    {
        return 'Статья базы знаний';
    }

    public static function group(): string
    {
        return 'Контент';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Категория', 'category', KnowledgeCategory::class)
                ->searchable()
                ->sortable()
                ->rules('required'),

            Text::make('Заголовок', 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug', 'slug')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:knowledge_articles,slug')
                ->updateRules('unique:knowledge_articles,slug,{{resourceId}}'),

            Text::make('Краткое описание', 'excerpt')
                ->hideFromIndex()
                ->rules('nullable', 'max:1000'),

            Trix::make('Содержимое', 'content')
                ->alwaysShow()
                ->rules('nullable'),

            Select::make('Уровень', 'level')
                ->options([
                    'base' => 'Базовый',
                    'middle' => 'Средний',
                    'advanced' => 'Продвинутый',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->default('base')
                ->rules('required'),

            Badge::make('Уровень', 'level')
                ->map([
                    'base' => 'info',
                    'middle' => 'warning',
                    'advanced' => 'danger',
                ])
                ->labels([
                    'base' => 'Базовый',
                    'middle' => 'Средний',
                    'advanced' => 'Продвинутый',
                ])
                ->onlyOnIndex(),

            Number::make('Время чтения, мин', 'reading_time')
                ->sortable()
                ->default(5)
                ->rules('required', 'integer', 'min:1'),

            Boolean::make('Избранная', 'is_featured')
                ->sortable()
                ->trueValue(1)
                ->falseValue(0),

            Boolean::make('Опубликована', 'is_published')
                ->sortable()
                ->trueValue(1)
                ->falseValue(0),

            DateTime::make('Дата публикации', 'published_at')
                ->sortable()
                ->nullable(),

            Text::make('SEO title', 'seo_title')
                ->hideFromIndex()
                ->rules('nullable', 'max:255'),

            Text::make('SEO description', 'seo_description')
                ->hideFromIndex()
                ->rules('nullable', 'max:1000'),
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