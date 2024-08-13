<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'level',
        'phone_no',
        'jamb_no',
        'form_no',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the desks for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desks(): HasMany
    {
        return $this->hasMany(Desk::class, 'staff_id', 'id');
    }

    /**
     * Get the clearance_request associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clearance_request(): HasOne
    {
        return $this->hasOne(ClearanceRequest::class, 'student_id');
    }
}
