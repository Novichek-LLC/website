<?php
namespace App\Notifications;
use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class NewLeadNotification extends Notification
{
    use Queueable;
    public function __construct(public Lead $lead) {}
    public function via(object $notifiable): array { return ['mail','database']; }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject('Новая заявка: '.$this->lead->service)->line('Имя: '.$this->lead->name)->line('Сообщение: '.($this->lead->message ?: '—'))->action('Открыть админку', url('/admin/dashboard'));
    }
    public function toArray(object $notifiable): array { return ['lead_id' => $this->lead->id, 'service' => $this->lead->service]; }
}
