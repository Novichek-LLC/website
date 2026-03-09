<?php

namespace App\Nova\Metrics;

use App\Models\ChatConversation;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class OpenConversations extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->result(ChatConversation::query()->where('status', 'open')->count());
    }

    public function name(): string
    {
        return 'Открытые диалоги';
    }
}
