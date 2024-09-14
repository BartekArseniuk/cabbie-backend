<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'pesel',
        'bank_name',
        'bank_account_number',
        'role',
        'password',
        'verification_token',
        'verification_token_created_at',
        'is_first_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verification_token_created_at' => 'datetime',
    ];

    public function surveyAnswers()
    {
        return $this->hasOne(SurveyAnswer::class);
    }
}