<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class PublishedState extends BooleanFilter
{
    public $name = 'Состояние публикации';

    public function apply(Request $request, $query, $value)
    {
        if (($value['published'] ?? false) && !($value['draft'] ?? false)) {
            return $query->where('is_published', true);
        }

        if (($value['draft'] ?? false) && !($value['published'] ?? false)) {
            return $query->where('is_published', false);
        }

        return $query;
    }

    public function options(Request $request): array
    {
        return [
            'Published' => 'published',
            'Draft' => 'draft',
        ];
    }
}
