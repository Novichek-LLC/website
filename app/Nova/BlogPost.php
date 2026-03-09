<?php

namespace App\Nova;

use App\Nova\Filters\PublishedState;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;

class BlogPost extends Resource
{
    public static $model = \App\Models\BlogPost::class;
    public static $title = 'title';
    public static $search = ['id', 'title', 'slug', 'excerpt'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Title', 'title')->rules('required', 'max:255')->sortable(),
            Slug::make('Slug', 'slug')->from('Title')->rules('required', 'max:255')->sortable(),
            Textarea::make('Excerpt', 'excerpt')->hideFromIndex(),
            Trix::make('Content', 'content')->rules('required'),
            Image::make('Cover', 'cover_path')->disk('public')->path('blog')->prunable(),
            Boolean::make('Published', 'is_published')->sortable(),
            DateTime::make('Published At', 'published_at')->nullable()->sortable(),
            Text::make('SEO Title', 'seo_title')->hideFromIndex(),
            Textarea::make('SEO Description', 'seo_description')->hideFromIndex(),
            Text::make('SEO Keywords', 'seo_keywords')->hideFromIndex(),
        ];
    }

    public function filters(Request $request): array
    {
        return [new PublishedState];
    }
}
