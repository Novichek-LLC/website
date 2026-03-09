<?php
namespace App\Enums;
enum LeadStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case QUALIFIED = 'qualified';
    case PROPOSAL = 'proposal';
    case WON = 'won';
    case LOST = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Новый',
            self::IN_PROGRESS => 'В работе',
            self::QUALIFIED => 'Квалифицирован',
            self::PROPOSAL => 'КП отправлено',
            self::WON => 'Успешно закрыт',
            self::LOST => 'Потерян',
        };
    }
}
