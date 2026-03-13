<?php

namespace App\Nova;

use App\Nova\Filters\PublishedState;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;

class BlogPost extends Resource
{
    public static $model = \App\Models\BlogPost::class;
    public static $title = 'title';
    public static $search = ['id', 'title', 'slug', 'excerpt'];

    public static function label()
    {
        return 'Блог';
    }

    public static function singularLabel()
    {
        return 'Пост блога';
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Заголовок', 'title')
                ->rules('required', 'max:255')
                ->sortable(),

            Slug::make('Slug', 'slug')
                ->from('Заголовок')
                ->rules('required', 'max:255')
                ->creationRules('unique:blog_posts,slug')
                ->updateRules('unique:blog_posts,slug,{{resourceId}}')
                ->sortable(),

            Textarea::make('Краткое описание', 'excerpt')
                ->hideFromIndex()
                ->alwaysShow(),

            Select::make('Плашка', 'badge_label')
                ->options([
                    'Статья' => 'Статья',
                    'Гайд' => 'Гайд',
                    'Разбор' => 'Разбор',
                    'Новости' => 'Новости',
                    'Кейс' => 'Кейс',
                    'Обзор' => 'Обзор',
                ])
                ->displayUsingLabels()
                ->nullable()
                ->help('Если оставить пустым, сайт сам подставит плашку по содержанию.'),

            Select::make('Визуальная тема', 'visual_theme')
                ->options([
                    'auto' => 'Авто по описанию',
                    'automation' => 'Автоматизация',
                    'accounting' => '1С / Учёт',
                    'marking' => 'Маркировка',
                    'web' => 'Сайты / Digital',
                    'infrastructure' => 'Инфраструктура / VPN',
                    'games' => 'Игровые серверы',
                    'music' => 'Музыка / Дистрибуция',
                    'design' => 'Дизайн',
                ])
                ->displayUsingLabels()
                ->default('auto')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $value = $request->{$requestAttribute};
                    $model->{$attribute} = $value === 'auto' ? null : $value;
                })
                ->help('Если выбрать авто, сайт сам подберёт визуальную тему по тексту статьи.'),

            Image::make('Обложка', 'cover_path')
                ->disk('public')
                ->path('blog')
                ->prunable()
                ->nullable()
                ->help('Если не загружать вручную, сайт покажет автоматически сгенерированную обложку.'),

            Trix::make('Контент', 'content')
                ->rules('required'),

            Boolean::make('Опубликован', 'is_published')->sortable(),

            DateTime::make('Дата публикации', 'published_at')
                ->nullable()
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    if ($request->boolean('is_published')) {
                        $model->{$attribute} = $request->{$requestAttribute} ?: ($model->{$attribute} ?? now());
                    } else {
                        $model->{$attribute} = null;
                    }
                })
                ->sortable(),

            Text::make('SEO Title', 'seo_title')->hideFromIndex(),
            Textarea::make('SEO Description', 'seo_description')->hideFromIndex()->alwaysShow(),
            Text::make('SEO Keywords', 'seo_keywords')->hideFromIndex(),
        ];
    }

    public function filters(Request $request): array
    {
        return [new PublishedState];
    }
}