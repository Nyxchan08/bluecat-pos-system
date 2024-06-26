<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'birth_date',
        'gender_id',
        'address',
        'contact_number',
        'email_address',
        'username',
        'password',
        'user_image',
        'role', 
    ];
    protected $hidden = ['password'];

    // Define relationships
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if the user is a regular user.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->role === 'user';
    }
}
