<?php

// =================== User Model ===================
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'address',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new class($token, $this->email) extends Notification
        {
            public function __construct(
                protected string $token,
                protected string $email,
            ) {}

            public function via(object $notifiable): array
            {
                return ['mail'];
            }

            public function toMail(object $notifiable): MailMessage
            {
                return (new MailMessage)
                    ->subject('AMV Password Reset Request')
                    ->greeting('Hello from AMV,')
                    ->line('AMV - Amdavadi Misal Vadapav has received a request to reset the password for your account.')
                    ->line('Please click the button below to set a new password and regain access to your account.')
                    ->line('For your security, this password reset link will expire in 60 minutes.')
                    ->action('Reset Your Password', URL::route('password.reset', [
                        'token' => $this->token,
                        'email' => $this->email,
                    ]))
                    ->line('If you did not make this request, you can safely ignore this email. Your account will remain secure.')
                    ->salutation('Warm regards,'.PHP_EOL.'AMV - Amdavadi Misal Vadapav');
            }
        });
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
