<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 5;
    const ROLE_SUPERADMIN = 7;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role as string.
     *
     * @param  integer  $value
     * @return string
     */
    public function getRoleAttribute(int $value) :string
    {
        $result = '';
        switch ($value) {
            case self::ROLE_SUPERADMIN :
                $result = 'super';
                break;
            case self::ROLE_ADMIN :
                $result = 'admin';
                break;
            case self::ROLE_USER :
                $result = 'user';
                break;
        }
        return $result;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     *
     * @return bool
     */
    public function isAdministrator() :bool
    {
        return in_array($this->role, ['super', 'admin']);
    }
}
