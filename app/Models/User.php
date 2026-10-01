<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPasswordTrait, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'avatar',
        'role',
        'alamat',
        'no_hp',
        'kontak',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_otp_code',
        'email_otp_expires_at',
        'email_otp_sent_at',
        'email_otp_attempts',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_otp_expires_at' => 'datetime',
        'email_otp_sent_at' => 'datetime',
        'kontak' => 'array',
    ];

    public function barangHilangs()
    {
        return $this->hasMany(BarangHilang::class);
    }

    public function orangHilangs()
    {
        return $this->hasMany(OrangHilang::class);
    }

    public function hewanHilangs()
    {
        return $this->hasMany(HewanHilang::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Kolom database untuk nomor telepon/WhatsApp bernama "no_hp".
     * Accessor & mutator ini membuat penggunaannya konsisten sebagai "phone"
     * (dipakai di form Pengaturan Akun maupun saat mengambil kontak penemu).
     */
    public function getPhoneAttribute(): ?string
    {
        return $this->attributes['no_hp'] ?? null;
    }

    public function setPhoneAttribute($value): void
    {
        $this->attributes['no_hp'] = $value;
    }

    /**
     * Kirim notifikasi verifikasi email.
     *
     * Kita override agar memakai alur OTP milik InfoHilang (bukan link
     * verifikasi bawaan Laravel). Dipakai oleh event `Registered`
     * (lihat App\Providers\EventServiceProvider) maupun pemanggilan manual.
     */
    public function sendEmailVerificationNotification(): void
    {
        if ($this->hasVerifiedEmail()) {
            return;
        }

        app(\App\Services\EmailOtpService::class)->send($this);
    }
}
