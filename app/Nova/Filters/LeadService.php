<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class LeadService extends Filter
{
    public $name = 'Направление';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('service', $value);
    }

    public function options(Request $request): array
    {
        return [
            '1С' => '1c',
            'Маркировка' => 'marking',
            'Музыкальная дистрибуция' => 'music',
            'Пескоструй' => 'sandblast',
            'VPN' => 'vpn',
            'Дизайн' => 'design',
            'Сайты' => 'sites',
            'Чат-боты' => 'bots',
            'Автоматизация' => 'automation',
        ];
    }
}
