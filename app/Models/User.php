<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'infix',
        'last_name',
        'phone_number',
        'address',
        'zip_code',
        'role_id',
        'email',
        'email_verified_at',
        'password_hash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return the password for the authentication system.
     * Laravel's Authenticatable expects a "password" attribute by default.
     * Our DB column is `password_hash`, so expose it here.
     */
    public function getAuthPassword()
    {
        return $this->password_hash ?? $this->password;
    }

    /**
     * Optional mutator: allow assigning to $user->password and have it
     * hashed into the `password_hash` column.
     */
    public function setPasswordAttribute($value)
    {
        if ($value === null) {
            $this->attributes['password_hash'] = null;
            return;
        }

        // If it's already a bcrypt hash, store as-is; otherwise hash it.
        if (is_string($value) && str_starts_with($value, '$2y$')) {
            $this->attributes['password_hash'] = $value;
        } else {
            $this->attributes['password_hash'] = \Illuminate\Support\Facades\Hash::make($value);
        }
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function graveUsers(): HasMany
    {
        return $this->hasMany(GraveUsers::class, 'user_id');
    }
}
