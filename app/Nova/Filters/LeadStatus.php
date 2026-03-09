<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class LeadStatus extends Filter
{
    public $name = 'Статус лида';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('status', $value);
    }

    public function options(Request $request): array
    {
        return [
            'Новый' => 'new',
            'В работе' => 'in_progress',
            'Квалифицирован' => 'qualified',
            'КП' => 'proposal',
            'Успешно закрыт' => 'won',
            'Потерян' => 'lost',
        ];
    }
}
