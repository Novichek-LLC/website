<?php

namespace App\Nova\Metrics;

use App\Models\Lead;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class NewLeads extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Lead::class)->previous(30);
    }

    public function name(): string
    {
        return 'Новые лиды';
    }

    public function ranges(): array
    {
        return [30 => '30 Days', 60 => '60 Days', 365 => '365 Days'];
    }
}
