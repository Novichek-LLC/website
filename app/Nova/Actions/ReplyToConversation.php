<?php

namespace App\Nova\Actions;

use App\Events\ChatMessageSent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class ReplyToConversation extends Action
{
    use Queueable;

    public function name(): string
    {
        return 'Ответить клиенту';
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $conversation) {
            $message = $conversation->messages()->create([
                'sender_type' => 'admin',
                'sender_id' => Auth::id(),
                'message' => $fields->message,
                'is_read' => true,
            ]);

            $conversation->update([
                'status' => $fields->status ?: 'in_progress',
                'assigned_to' => Auth::id(),
                'last_message_at' => now(),
            ]);

            $conversation->markGuestMessagesAsRead();

            broadcast(new ChatMessageSent($message))->toOthers();
        }

        return Action::message('Ответ отправлен');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Textarea::make('Сообщение', 'message')
                ->rules('required', 'string', 'max:5000')
                ->alwaysShow(),

            Select::make('Статус', 'status')
                ->options([
                    'open' => 'Открыт',
                    'in_progress' => 'В работе',
                    'closed' => 'Закрыт',
                ])
                ->displayUsingLabels()
                ->default('in_progress'),
        ];
    }
}