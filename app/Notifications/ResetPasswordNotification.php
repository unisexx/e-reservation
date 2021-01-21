<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::getFromJson('แจ้งเตือนการรีเซ็ตรหัสผ่าน'))
            ->greeting('สวัสดี')
            ->line('คุณได้รับอีเมลฉบับนี้เนื่องจากเราได้รับคำขอรีเซ็ตรหัสผ่านสำหรับบัญชีของคุณ')
            ->action(Lang::getFromJson('รีเซ็ตรหัสผ่าน'), url(config('app.url') . route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line(Lang::getFromJson('ลิ้งค์รีเซ็ตรหัสผ่านนี้จะหมดอายุใจ :count นาที', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::getFromJson('หากคุณไม่ได้ขอรีเซ็ตรหัสผ่านก็ไม่ต้องดำเนินการใดๆ เพิ่มเติม'));
    }
}
