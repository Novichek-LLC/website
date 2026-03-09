<?php

namespace App\Nova\Metrics;

use App\Models\BlogPost;
use App\Models\CaseItem;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class PublishedContent extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->result(
            BlogPost::query()->where('is_published', true)->count()
            + CaseItem::query()->where('is_published', true)->count()
        );
    }

    public function name(): string
    {
        return 'Опубликованный контент';
    }
}
