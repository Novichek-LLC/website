<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Text;

class ChatMessage extends Resource
{
    public static $model = \App\Models\ChatMessage::class;
    public static $title = 'id';
    public static $search = ['id', 'message', 'sender_type'];

    public static $globallySearchable = false;

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Conversation', 'conversation', ChatConversation::class),
            Text::make('Sender Type', 'sender_type')->sortable(),
            Textarea::make('Message', 'message')->alwaysShow(),
            Boolean::make('Read', 'is_read')->sortable(),
            Code::make('Attachments', 'attachments')->json()->hideFromIndex(),
        ];
    }
}
