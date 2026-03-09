<?php
namespace App\Notifications;
use App\Channels\TelegramChannel; use App\Models\Lead; use Illuminate\Bus\Queueable; use Illuminate\Notifications\Messages\MailMessage; use Illuminate\Notifications\Notification;
class LeadCreatedNotification extends Notification { use Queueable; public function __construct(public Lead $lead) {} public function via(object $notifiable): array { $channels = ['mail']; if (config('services.telegram.bot_token') && config('services.telegram.chat_id')) { $channels[] = TelegramChannel::class; } return $channels; } public function toMail(object $notifiable): MailMessage { return (new MailMessage())->subject('Новый лид с сайта — '.$this->lead->service)->greeting('Поступила новая заявка')->line('Услуга: '.$this->lead->service)->line('Имя: '.$this->lead->name)->line('Телефон: '.($this->lead->phone ?: 'не указан'))->line('Email: '.($this->lead->email ?: 'не указан'))->line('Сообщение: '.$this->lead->message)->action('Открыть CRM', url('/admin')); } public function toTelegram(object $notifiable): array { return ['text' => "Новый лид
"."Услуга: {$this->lead->service}
"."Имя: {$this->lead->name}
"."Телефон: ".($this->lead->phone ?: '—')."
"."Email: ".($this->lead->email ?: '—')."
"."Сообщение: {$this->lead->message}",]; } }
