<?php

namespace App\Models\Patient;

use App\Models\CloseContact\CloseContact;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Device\UserDevice;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationTemplate;
use Illuminate\Contracts\Auth\CanResetPassword;

class Patient extends Model implements CanResetPassword
{
    use Notifiable, HasApiTokens;

    protected $guard = 'patient';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat'
    ];

    /**
     * * Patient has one device
     */
    public function userDevice()
    {
        return $this->hasOne(UserDevice::class);
    }

    /**
     * * Patient belongs to many NotificationTemplate using Notification pivot
     */
    public function notificationTemplate()
    {
        return $this->belongsToMany(NotificationTemplate::class)->using(Notification::class)->withTimestamps();
    }


    /**
     * * Patient has many close contact
     */
    public function closeContacts()
    {
        return $this->hasMany(CloseContact::class);
    }
}
