<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class BlogComment extends Resource
{
    public static $model = \App\Models\BlogComment::class;

    public static $title = 'author_name';

    public static $search = [
        'id',
        'author_name',
        'author_email',
        'content',
    ];

    public static function label()
    {
        return 'Комментарии блога';
    }

    public static function singularLabel()
    {
        return 'Комментарий блога';
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Статья', 'blogPost', BlogPost::class)
                ->sortable(),

            Text::make('Автор', 'author_name')
                ->sortable()
                ->rules('required', 'max:120'),

            Text::make('Email', 'author_email')
                ->hideFromIndex(),

            Select::make('Статус', 'status')
                ->options([
                    'pending' => 'На модерации',
                    'approved' => 'Одобрен',
                    'rejected' => 'Отклонён',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $value = $request->{$requestAttribute};
                    $model->{$attribute} = $value;
                    $model->approved_at = $value === 'approved' ? now() : null;
                }),

            Textarea::make('Комментарий', 'content')
                ->alwaysShow()
                ->rules('required'),

            Text::make('IP', 'ip_address')
                ->hideFromIndex(),

            Code::make('User Agent', 'user_agent')
                ->language('text')
                ->hideFromIndex(),

            DateTime::make('Одобрен', 'approved_at')
                ->exceptOnForms(),

            DateTime::make('Создан', 'created_at')
                ->exceptOnForms(),
        ];
    }
}