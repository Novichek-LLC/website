<?php

namespace App\Nova;

use App\Nova\Actions\MarkConversationClosed;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Code;

class ChatConversation extends Resource
{
    public static $model = \App\Models\ChatConversation::class;
    public static $title = 'uuid';
    public static $search = ['id', 'uuid', 'visitor_name', 'visitor_email', 'visitor_phone', 'status'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('UUID', 'uuid')->onlyOnDetail(),
            Text::make('Visitor Name', 'visitor_name')->sortable(),
            Text::make('Visitor Email', 'visitor_email')->sortable(),
            Text::make('Visitor Phone', 'visitor_phone')->hideFromIndex(),
            Text::make('Status', 'status')->sortable(),
            DateTime::make('Last Message At', 'last_message_at')->sortable(),
            BelongsTo::make('Admin', 'admin', User::class)->nullable(),
            Code::make('Meta', 'meta')->json()->hideFromIndex(),
            HasMany::make('Messages', 'messages', ChatMessage::class),
        ];
    }

    public function actions(Request $request): array
    {
        return [new MarkConversationClosed];
    }
}
